@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-primary card-outline">
                {{--  <div class="card-header">
                  <h5 class="m-0" style="display: inline;">قائمة الطلبات</h5>

                </div>  --}}
                @if(auth()->user()->role == 1)
                    <a href="{{route('Deleteorders')}}" style="width: 10%;margin:15px"
                       class="btn btn-danger btn-sm delete"> حذف الكل<i class="fas fa-trash"></i></a>
                @endif
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-hover table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>رقم الشحنة</th>
                            {{--                                <th> أسم المنتج</th>    --}}
                            <th>السعر</th>
                            <th>الحالة</th>
                            <th>نوع الدفع</th>
                            <th>التاريخ</th>

                            <th>التحكم</th>
                        </tr>
                        </thead>
                        <tfoot>
                        @foreach($Orders as $key => $value)
                            <tr>
                                <td>
                                    {{$key + 1 }}
                                </td>

                                <td>
                                    {{$value->id}}
                                </td>

                                {{--                                    <td>--}}
                                {{--                                        @if(count($value->OrderProducts) > 1)--}}
                                {{--                                            @foreach($value->OrderProducts as $productKey => $product)--}}
                                {{--                                                --}}{{-- @php $colors = array('#dc3545','#007bff','#28a745'); $random = array_rand($colors,1); @endphp  --}}
                                {{--                                                <span>--}}
                                {{--                                                    ( {{ $productKey + 1 }} )--}}
                                {{--                                                    {{ $product->product->name_ar }}--}}
                                {{--                                                </span>--}}
                                {{--                                                <br/>--}}
                                {{--                                            @endforeach--}}
                                {{--                                        @else--}}
                                {{--                                            {{ $value->OrderProducts[0]->product->name_ar }}--}}
                                {{--                                        @endif--}}
                                {{--                                    </td>--}}

                                <td>
                                    {{$value->total}}
                                </td>

                                <td>
                                    @if($value->status == 1)
                                        <span class="badge badge-danger">اكمال الطلب</span>
                                    @endif
                                    @if($value->status == 2)
                                        <span class="badge badge-orange">جارى التجهيز</span>
                                    @endif
                                    @if($value->status == 3)
                                        <span class="badge badge-orange">في الطريق</span>
                                    @endif
                                    @if($value->status == 4)
                                        <span class="badge badge-success">تم استلامها</span>
                                    @endif
                                </td>
                                <td>
                                    @if($value->pay_type == 1)
                                        <span class="badge badge">عند الإستلام</span>

                                    @endif
                                    @if($value->pay_type == 2)
                                        <span class="badge badge"> دفع إلكترونى</span>
                                        @if($value->pay_status == 1)
                                            <span class="badge badge-danger">  لم يتم الدفع</span>
                                        @endif
                                        @if($value->pay_status == 2)
                                            <span class="badge badge-success"> تم الدفع </span>
                                        @endif
                                    @endif

                                </td>
                                <td>
                                    <!-- <span class="badge badge-success">{ {Date::parse($value->created_at)->diffForHumans()} }</span> -->
                                    <span class="badge badge-success">{{ \Illuminate\Support\Carbon::parse($value->created_at)->format('d-M-Y') }}</span>
                                </td>

                                <td>
                                    <a href="{{route('editorders',$value->id)}}" class="btn btn-primary btn-sm "
                                       type="submit"> <i class="fas fa-edit"></i></a>
                                    <a href="{{route('Deleteorder',$value->id)}}" class="btn btn-danger btn-sm delete">
                                        <i class="fas fa-trash"></i></a>
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