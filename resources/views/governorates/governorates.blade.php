@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12">
          <div class="card card-primary card-outline">
            <div class="card-header">
              {{--  <h5 class="m-0" style="display: inline;">قائمة المحافظات </h5>  --}}
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-primary" style="float: right;">
                    إضافة محافظه 
                     <i class="fas fa-plus"></i>
                </button>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                  <th>الإسم بالعربية</th>
                  <th>الإسم بالإنجليزية</th>
                  <th>رسوم الشحن</th>}
                  <th>التحكم</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $key => $d)
                    <tr>
                      <td>{{$d->name_ar}}</td>
                      <td>{{$d->name_en}}</td>
                      <td>{{$d->shipping_fee}}</td>
                      <td style="line-height: 65px">
                        <a href           = "" 
                        class             = "btn btn-info btn-sm edit"
                        data-toggle       = "modal"
                        data-target       = "#modal-update"
                        data-id           = "{{$d->id}}"
                        data-name_ar      = "{{$d->name_ar}}"
                        data-name_en      = "{{$d->name_en}}"
                        data-division_id  = "{{$d->shipping_fee}}"
                       
                        > <i class="fas fa-edit"></i></a>
                        <a href="{{ route('deletegovernorates',$d->id) }}"  class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i></a>
                      </td>
                    </tr>
                @endforeach
                </tfoot>
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
              <h4 class="modal-title">إضافة محافظه جديد</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <form action="{{ route('storegovernorates') }}" enctype='multipart/form-data' method="post">
                {{csrf_field()}}
                <div class="row">

                  <div class="col-sm-12">
                    <label>الإسم بالعربية </label> <span class="text-danger">*</span>
                    <input type="text" name="name_ar" class="form-control" placeholder=" الإسم بالعربية  " required="" maxlength="190" style="margin-bottom: 10px">
                  </div>

                  <div class="col-sm-12">
                    <label>الإسم بالإنجليزية </label> <span class="text-danger">*</span>
                    <input type="text" name="name_en" class="form-control" placeholder=" الإسم بالإنجليزية  " maxlength="190" style="margin-bottom: 10px">
                  </div>

                  <div class="col-sm-12">
                    <label>رسوم الشحن  </label> <span class="text-danger">*</span>
                      <input type="text" name="shipping_fee" class="form-control" placeholder=" رسوم الشحن   " maxlength="190" style="margin-bottom: 10px">
                  </div>

                  </div>
                <button type="submit" id="submit" style="display: none;"></button>
              </form>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-outline-light save">حفظ</button>
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
              <h4 class="modal-title">تعديل محافظه  : <span class="item_name"></span></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <form action="{{ route('updategovernorates') }}" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <input type="hidden" name="edit_id" value="">
                    <div class="row">

                      <div class="col-sm-12">
                        <label>الإسم </label> <span class="text-danger">*</span>
                        <input type="text" name="edit_name_ar" class="form-control"  required="" maxlength="190" style="margin-bottom: 10px">
                      </div>

                      <div class="col-sm-12">
                        <label>الإسم بالإنجليزية </label> <span class="text-danger">*</span>
                        <input type="text" name="edit_name_en" class="form-control" maxlength="190" style="margin-bottom: 10px">
                      </div>

                      <div class="col-sm-12">
                        <label>رسوم الشحن </label> <span class="text-danger">*</span>
                          <input type="text" name="edit_shipping_fee" class="form-control" placeholder=" رسوم الشحن   " maxlength="190" style="margin-bottom: 10px">
                    
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
function ChooseAvatar(){$("input[name='image']").click()}
	var loadAvatar = function(event) {
		var output = document.getElementById('avatar');
		output.src = URL.createObjectURL(event.target.files[0]);
	};

  function ChooseAvatar1(){$("input[name='edit_image']").click()}
      var loadAvatar1 = function(event) {
        var output = document.getElementById('avatar1');
        output.src = URL.createObjectURL(event.target.files[0]);
      };
  $('.save').on('click',function(){
    $('#submit').click();
  })

  $('.edit').on('click',function(){
      var id          = $(this).data('id')
      var name_ar     = $(this).data('name_ar')
      var name_en     = $(this).data('name_en')
      var shipping_fee = $(this).data('shipping_fee')
    
      $('.item_name')                   .text(name_ar)
      $("input[name='edit_id']")        .val(id)
      $("input[name='edit_name_ar']")   .val(name_ar)
      $("input[name='edit_name_en']")   .val(name_en)
         $("input[name='edit_shipping_fee']")   .val(shipping_fee)
   
  })

  $('.update').on('click',function(){
      $('#update').click();
  })
</script>
@endsection

