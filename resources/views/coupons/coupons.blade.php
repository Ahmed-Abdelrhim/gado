@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12">
          <div class="card card-primary card-outline">
            <div class="card-header">
              {{--  <h5 class="m-0" style="display: inline;">قائمة الكوبونات </h5>  --}}
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-primary" style="float: right;">
                    إضافة كوبون 
                     <i class="fas fa-plus"></i>
                </button>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>الكود</th>
                  <th>الإستخدامات</th>
                  <th>النوع</th>
                  <th>الخصم</th>
                  <th>المبلغ</th>
                  <th>تاريخ الإنتهاء</th>
                  <th>تاريخ الإنشاء</th>
                  <th>التحكم</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($coupons as $key => $c)
                    <tr>
                      <td>{{$key + 1}}</td>
                      <td>{{$c->code}}</td>
                      <td>{{$c->total_uses_number}}</td>
                      <td>@if($c->type == 'percent') نسبه مئويه@elseif($c->type == 'currency') عمله @endif</td>
                      <td>{{$c->discount}} @if($c->type == 'percent') %@elseif($c->type == 'currency') جنية @endif</td>
                      <td>{{$c->total_amount}} جنية</td>
                      <td>{{$c->end_date}}</td>
                      <td>{{Date::parse($c->created_at)->format('h:m / Y-m-d')}}</td>
                      <td>
                        <div class="btn-group">
                          <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                          </button>
                          <div class="dropdown-menu" role="menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(68px, 38px, 0px);">
                            <a class="dropdown-item openEditmodal"
                            href="#"
                            data-toggle="modal" 
                            data-target="#modal-update"
                            data-id                = "{{$c->id}}" 
                            data-name              = "{{$c->name}}" 
                            data-code              = "{{$c->code}}" 
                            data-type              = "{{$c->type}}" 
                            data-discount          = "{{$c->discount}}" 
                            data-total_uses_number = "{{$c->total_uses_number}}" 
                            data-user_uses_number  = "{{$c->user_uses_number}}"
                            data-total_amount      = "{{$c->total_amount}}"
                            data-end_date          = "{{$c->end_date}}"
                            >تعديل</a>
                            <a class="dropdown-item delete" href="{{ route('deletecoupon',$c->id) }}">حذف</a>
                          </div>
                        </div>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
        </div>

      {{-- add area modal --}}
      <div class="modal fade" id="modal-primary">
        <div class="modal-dialog">
          <div class="modal-content bg-primary">
            <div class="modal-header">
              <h4 class="modal-title">إضافة كوبون جديد</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <form action="{{ route('storecoupon') }}" enctype='multipart/form-data' method="post">
                {{csrf_field()}}
                  <div class="row">

                    <div class="col-sm-12">
                      <div class="row">
                        <div class="col-sm-6">
                          <label> إسم الكوبون</label>
                          <input type="text" name="name" class="form-control" style="margin-bottom: 10px" required="" >
                        </div>
                        <div class="col-sm-6">
                          <label>الكود</label>
                          <input type="text" name="code" class="form-control" style="margin-bottom: 10px" required="" >
                        </div>
                      </div>
                    </div>
          
                    <div class="col-sm-12">
                      <div class="row">
                        <div class="col-sm-6">
                          <label> إجمالي عدد الإستخدامات</label>
                          <input type="number" name="total_uses_number" class="form-control" style="margin-bottom: 10px" required="" >
                        </div>
                        <div class="col-sm-6">
                          <label>عدد الإستخدام للعضو</label>
                          <input type="number" name="user_uses_number" class="form-control" value="1" style="margin-bottom: 10px" required="" >
                        </div>
                      </div>
                    </div>
                    
                    <div class="col-sm-12">
                      <div class="row">
          
                        <div class="col-sm-6">
                          <label> إجمالي المبلغ لإستخدام الكوبون</label>
                          <input type="number" name="total_amount" class="form-control" style="margin-bottom: 10px"  maxlength="190" step=".01">
                        </div>
          
                        <div class="col-sm-6">
                          <label>تاريخ الإنتهاء</label>
                          <input type="date" name="end_date" class="form-control" id="datepicker" style="margin-bottom: 10px"  maxlength="190">
                        </div>
                      </div>
                    </div>
          
                    <div class="col-sm-12">
                      <div class="row">
          
                        <div class="col-sm-6">
                          <label>الخصم</label>
                          <input type="number" name="discount" class="form-control" style="margin-bottom: 10px" required="" step=".01">
                        </div>
          
                        <div class="col-sm-6">
                          <label>نوع الخصم</label>
                          <select name="type" class="form-control">
                            <option value="percent">نسبه مئويه</option>
                            <option value="currency">عمله</option>
                          </select>
                        </div>
                    
                      </div>
                    </div>

                  </div>
                <button type="submit" id="add" style="display: none;"></button>
              </form>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-outline-light add">حفظ</button>
              <button type="button" class="btn btn-outline-light" data-dismiss="modal">إغلاق</button>
            </div>
          </div>
        </div>
      </div>

      {{-- update area modal --}}
      <div class="modal fade" id="modal-update">
        <div class="modal-dialog">
          <div class="modal-content bg-info">
            <div class="modal-header">
              <h4 class="modal-title">تعديل كوبون : <span class="item_name"></span></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <form action="{{ route('updatecoupon') }}" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <input type="hidden" name="id" value="">
                    <div class="row">

                      <div class="col-sm-12">
                        <div class="row">
                          <div class="col-sm-6">
                            <label> إسم الكوبون</label>
                            <input type="text" name="edit_name" class="form-control" style="margin-bottom: 10px" required="" >
                          </div>
                          <div class="col-sm-6">
                            <label>الكود</label>
                            <input type="text" name="edit_code" class="form-control" style="margin-bottom: 10px" required="" >
                          </div>
                        </div>
                      </div>
            
                      <div class="col-sm-12">
                        <div class="row">
                          <div class="col-sm-6">
                            <label> إجمالي عدد الإستخدامات</label>
                            <input type="number" name="edit_total_uses_number" class="form-control" style="margin-bottom: 10px" required="" >
                          </div>
                          <div class="col-sm-6">
                            <label>عدد الإستخدام للعضو</label>
                            <input type="number" name="edit_user_uses_number" value="1" class="form-control" style="margin-bottom: 10px" required="" >
                          </div>
                        </div>
                      </div>
            
                      <div class="col-sm-12">
                        <div class="row">
            
                          <div class="col-sm-6">
                            <label> إجمالي المبلغ لإستخدام الكوبون</label>
                            <input type="number" name="edit_total_amount" class="form-control" style="margin-bottom: 10px"  maxlength="190" step=".01">
                          </div>
            
                          <div class="col-sm-6">
                            <label>تاريخ الإنتهاء</label>
                            <input type="date" name="edit_end_date" class="form-control" id="editdatepicker" style="margin-bottom: 10px" required="">
                          </div>
                        </div>
                      </div>
            
                      <div class="col-sm-12">
                        <div class="row">
                          <div class="col-sm-6">
                            <label>الخصم</label>
                            <input type="number" name="edit_discount" class="form-control" style="margin-bottom: 10px" required="" step=".01">
                          </div>
            
                          <div class="col-sm-6">
                            <label>نوع الخصم</label>
                            <select name="edit_type" id="edit_type" class="form-control">
                              <option value="percent">نسبه مئويه</option>
                              <option value="currency">عمله</option>
                            </select>
                          </div>
            
                        </div>
                      </div>

                    </div>

                    <button type="submit" id="update" style="display: none;"></button>
              </form>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-outline-light update">تحديث</button>
              <button type="button" class="btn btn-outline-light" data-dismiss="modal">إغلاق</button>
            </div>
          </div>
        </div>
      </div>

    </div>
@endsection

@section('script')
  <script type="text/javascript"> 

    //open edit modal
    $(document).on('click','.openEditmodal',function(){

      //get valus 
      var id                 = $(this).data('id')
      var name               = $(this).data('name')
      var code               = $(this).data('code')
      var type               = $(this).data('type')
      var total_uses_number  = $(this).data('total_uses_number')
      var user_uses_number   = $(this).data('user_uses_number')
      var total_amount       = $(this).data('total_amount')
      var discount           = $(this).data('discount')
      var end_date           = $(this).data('end_date')


      //set values in modal inputs
      $("input[name='id']")                     .val(id)
      $("input[name='edit_name']")              .val(name)
      $("input[name='edit_code']")              .val(code)
      $("input[name='edit_total_uses_number']") .val(total_uses_number)
      $("input[name='edit_user_uses_number']")  .val(user_uses_number)
      $("input[name='edit_discount']")          .val(discount)
      $("input[name='edit_total_amount']")      .val(total_amount)
      $("input[name='edit_end_date']")          .val(end_date)
      $('.item_name')                           .text(name)

      //select type
      $('#edit_type option').each(function(){
        if($(this).val() === type)
        {
          $(this).attr('selected','')
        }
      });

    })

    //check date
    $('.update').on('click',function(e){
      var  date = $("input[name='edit_end_date']").val()
      if(date < "{{$current}}")
      {
        e.preventDefault();
        alert('يجب إختيار تاريخ إنتهاء حديث !')
      }else{
        $('#update').click()
      }
    })

    //check date
    $('.add').on('click',function(e){
      var  date = $("input[name='end_date']").val()
      if(date < "{{$current}}")
      {
        e.preventDefault();
        alert('يجب إختيار تاريخ إنتهاء حديث !')
      }else{
        $('#add').click()
      }
    })
    


  </script>
@endsection

