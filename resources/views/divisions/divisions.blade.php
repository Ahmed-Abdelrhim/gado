@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12">
          <div class="card card-primary card-outline">
            <div class="card-header">
              {{--  <h5 class="m-0" style="display: inline;">قائمة التصنيفات </h5>  --}}
                {{--  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-primary" style="float: right;">
                    إضافة فئة 
                     <i class="fas fa-plus"></i>
                </button>  --}}
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                  <th>الصورة</th>
                  <th>الإسم بالعربية</th>
                  <th>الإسم بالإنجليزية</th>
                  {{-- <th>التاريخ</th> --}}
                  <th>التحكم</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $key => $d)
                    <tr>
                      <td> <img src="{{ asset('uploads/divisions_images/'.$d->image) }}" alt="" style="width: 100px"> </td>
                      <td>{{$d->name_ar}}</td>
                      <td>{{$d->name_en}}</td>
                      {{-- <td> <span class="badge badge-success">{{Date::parse($d->created_at)->diffForHumans()}}</span></td> --}}
                      <td style="line-height: 65px">
                        <a href       = "" 
                        class         = "btn btn-info btn-sm edit"
                        data-toggle   = "modal"
                        data-target   = "#modal-update"
                        data-id       = "{{$d->id}}"
                        data-name_ar  = "{{$d->name_ar}}"
                        data-name_en  = "{{$d->name_en}}"
                        > <i class="fas fa-edit"></i></a>
                        {{--  <a href="{{ route('deletedivisions',$d->id) }}"  class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i></a>  --}}
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
              <h4 class="modal-title">إضافة فئة جديدة</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <form action="{{ route('storedivisions') }}" enctype='multipart/form-data' method="post">
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
                    <label>الصورة </label> <span class="text-danger">*</span>
                    <input type="file" name="image" class="form-control" accept="image/*" required>
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
              <h4 class="modal-title">تعديل فئة : <span class="item_name"></span></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <form action="{{ route('updatedivisions') }}" method="post" enctype="multipart/form-data">
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
                        <label>الصورة </label> <span class="text-primary">*</span>
                        <input type="file" name="edit_image" class="form-control" accept="image/*">
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

  $('.save').on('click',function(){
    $('#submit').click();
  })

  $('.edit').on('click',function(){
      var id       = $(this).data('id')
      var name_ar     = $(this).data('name_ar')
      var name_en     = $(this).data('name_en')
    
      $('.item_name')                .text(name_ar)
      $("input[name='edit_id']")     .val(id)
      $("input[name='edit_name_ar']")   .val(name_ar)
      $("input[name='edit_name_en']")   .val(name_en)
  })

  $('.update').on('click',function(){
      $('#update').click();
  })
</script>
@endsection

