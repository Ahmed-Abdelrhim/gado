@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-primary card-outline">
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-hover table-striped"
                           data-url="{{ route('get.expired.products') }}">
                        <thead>
                        <tr>
                            {{--  <th>#</th>  --}}
                            <th>ID</th>
                            <th>الصوره</th>
                            <th>الإسم</th>
                            <th>السعر</th>
                            <th>سعر التاجر</th>
                            <th>العدد</th>
                            <th>Pay Count</th>
                            <th>تاريخ الإنشاء</th>
                            <th>التحكم</th>
                        </tr>
                        </thead>
                        {{--                        <tbody>--}}
                        {{--                        @foreach($data as $key => $value)--}}
                        {{--                            <tr>--}}
                        {{--                                --}}{{--  <td>{{$key+1}}</td>  --}}
                        {{--                                <td><img src="{{ $value->card_image }}" alt="" style="width: 100px"></td>--}}
                        {{--                                <td>{{$value->name_ar}}</td>--}}
                        {{--                                <td>{{$value->price_discount}}</td>--}}
                        {{--                                <td>{{$value->stock}}</td>--}}

                        {{--                                <td>--}}
                        {{--                                    <a href="{{route('editproducts',$value->id)}}" class="btn btn-primary btn-sm "--}}
                        {{--                                       type="submit"> <i class="fas fa-edit"></i></a>--}}
                        {{--                                    <a href="{{route('DeleteProduct',$value->id)}}"--}}
                        {{--                                       class="btn btn-danger btn-sm delete"> <i class="fas fa-trash"></i></a>--}}
                        {{--                                </td>--}}
                        {{--                            </tr>--}}
                        {{--                        @endforeach--}}
                        {{--                        </tbody>--}}
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
@endsection

@section('script')
    {{--    <script type="text/javascript">--}}
    {{--    </script>--}}
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script>
        console.log("JSON.stringify");
        $('#example1').DataTable({
        processing : true,
        serverSide : true,
        ajax : {
            url : $('#example1').attr('data-url'),
        },
        columns : [
        {data : 'id', name : 'id'},
        {data : 'image', name : 'image'},
        {data : 'name_ar', name : 'name_ar'},
        {data : 'price', name : 'price'},
        {data : 'dealer_price', name : 'dealer_price'},
        {data : 'stock', name : 'stock'},
        {data : 'pay_count', name : 'pay_count'},
        {data : 'created_at', name : 'created_at'},
        {data : 'action', name : 'action'},
        ],
        "ordering" : false
        });

    </script>
@endsection