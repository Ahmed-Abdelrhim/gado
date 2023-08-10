@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-primary card-outline">
                {{--  <div class="card-header">
                  <h5 class="m-0" style="display: inline;">قائمة المشرفين</h5>
                </div>  --}}
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-hover table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>الصوره</th>
                            <th>الإسم</th>
                            <th>الجوال</th>
                            <th>الحاله</th>
                            <th>التحكم</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $key => $value)
                            <tr>
                                <td>{{$key+1}}</td>
                                {{-- <td>{{$value->avatar}}</td> --}}
                                <td>
                                    <img alt="Avatar" class="table-avatar" src="{{asset('uploads/customers/avatar/'.$value->avatar)}}"
                                         style="border-radius: 50px;width:50px;"></td>
                                <td>{{$value->name}}</td>
                                <td>{{$value->phone}}</td>
                                <td>@if($value->active == 1)
                                        <span class=" badge badge-success">نشط</span>
                                    @else
                                        <span class=" badge badge-danger">حظر</span>
                                    @endif</td>
                                {{-- </td> --}}
                                <td>
                                    <a href="{{route('editcustomers',$value->id)}}" class="btn btn-primary btn-sm "
                                       type="submit"> <i class="fas fa-edit"></i></a>
                                    <a href="{{route('deletecustomers',$value->id)}}"
                                       class="btn btn-danger btn-sm delete"> <i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script type="text/javascript">

    </script>
@endsection