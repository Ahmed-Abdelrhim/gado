@extends('layouts.app')

@section('style')

    <style type="text/css">
        #avatar {
            width: 100%;
            height: 300px;
        }

        #avatar:hover {
            width: 100%;
            height: 300px;
            cursor: pointer;
        }

        .marbo {
            margin-bottom: 10px
        }

        .img img {
            width: 150px;
            height: 150px;
            margin-right: 20px;
            margin-top: 20px;
        }

        #gallery-photo-add {
            display: inline-block;
            position: absolute;
            z-index: 1;
            width: 100%;
            height: 50px;
            top: 0;
            left: 0;
            opacity: 0;
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card card-primary card-outline">

            <div class="card-header">
                <h5 class="m-0" style="display: inline;">تعديل الطلب <i class="fas fa-exclamation-circle"
                                                                        style="cursor: pointer;color:#FFC107"
                                                                        data-toggle="modal"
                                                                        data-target="#modal-secondary"></i></h5>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                    {{-- orders --}}
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-content-below-product-tab" data-toggle="pill"
                           href="#custom-content-below-product" role="tab" aria-controls="custom-content-below-product"
                           aria-selected="true">تفاصيل الطلب</a>
                    </li>
                    {{-- products --}}
                    <li class="nav-item">
                        <a class="nav-link" id="custom-content-below-company-tab" data-toggle="pill"
                           href="#custom-content-below-company" role="tab" aria-controls="custom-content-below-company"
                           aria-selected="false">المنتجات</a>
                    </li>
                </ul>
            </div>
            <div class="tab-content" id="custom-content-below-tabContent">
                {{-- orders --}}
                <div class="tab-pane fade show active" id="custom-content-below-product" role="tabpanel"
                     aria-labelledby="custom-content-below-product-tab">
                    <div class="card-body">
                        <form action="{{route('Updateorders')}}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="{{ $ord->id }}">
                            {{csrf_field()}}
                            <div class="row">
                                {{--@if(count($ord->Order_info) == 1)--}}
                                <div class="col-sm-6 marbo" style="margin-top: 10px">
                                    <ul class="list-group">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            الاسم الاول

                                            <span class="badge badge-primary badge-pill">{{(!empty($ord->Order_info))? $ord->Order_info->name_first : null}}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            الاسم التاني
                                            <span class="badge badge-primary badge-pill">{{(!empty($ord->Order_info))? $ord->Order_info->name_last : null}}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            البريد
                                            <span class="badge badge-primary badge-pill">{{(!empty($ord->Order_info))? $ord->Order_info->email : null}}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            الكود
                                            <span class="badge badge-primary badge-pill">{{(!empty($ord->Order_info))? $ord->Order_info->email_code : null}}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            العنوان
                                            <span class="badge badge-primary badge-pill">{{(!empty($ord->Order_info))? $ord->Order_info->address : null}}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            المحافظه

                                            <span class="badge badge-primary badge-pill">{{(isset($ord->Order_info) && $ord->Order_info->governorate_id != null) ? \App\Governorate::find($ord->Order_info->governorate_id)->name_ar : '-'}}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            الموبيل
                                            <span class="badge badge-primary badge-pill">{{(!empty($ord->Order_info))? $ord->Order_info->phone : null}}</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            اخري :
                                            {{(!empty($ord->Order_info))? $ord->Order_info->desc : null}}
                                        </li>
                                    </ul>

                                </div>
                                {{--@endif--}}
                                <div class="col-sm-6 marbo" style="margin-top: 10px">

                                    <ul class="list-group">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            اجمالي المنتجات
                                            <span class="badge badge-primary badge-pill">{{ $ord->total }} جنيه</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            الخصم
                                            <span class="badge badge-primary badge-pill">{{ $setting->tax_rate }} جنيه</span>
                                        </li>
                                        @php


                                            if($ord->shipping != ""  ){
                                                  $shipping = $ord->shipping;
                                            } else {
                                                if(!empty($ord->Order_info->governorate_id )) {
                                                $shipping = (isset($ord->Order_info)  && $ord->Order_info->governorate_id != null) ? \App\Governorate::find($ord->Order_info->governorate_id)->shipping_fee : 0 ;
                                                } else {
                                                    $shipping = $setting->dilivary;
                                                }
                                            }
                                        @endphp
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            الشحن
                                            <span class="badge badge-primary badge-pill">{{ $shipping }} جنيه</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            الاجمالي الكلي
                                            <span class="badge badge-primary badge-pill">{{ ($ord->total + $shipping) - $setting->tax_rate}} جنيه</span>
                                        </li>
                                    </ul>

                                </div>

                                <div class="col-sm-12">
                                    <div class="row">


                                        {{--  @if($ord->status == 2) --}}
                                        {{-- type --}}
                                        <div class="col-sm-6" style="margin-top: 10px">
                                            <div class="from-group">
                                                <label class="text-primary">ألنوع : <span
                                                            class="text-danger">*</span></label>
                                                <select required class="form-control" id="select-gear" name="status">
                                                    <option value="" disabled selected>إختيار</option>
                                                    <option value="1" disabled @if($ord->status == '1') selected @endif>
                                                        اكمال الطلب
                                                    </option>
                                                    <option value="2" @if($ord->status == '2') selected @endif>جارى
                                                        التجهيز
                                                    </option>
                                                    <option value="3" @if($ord->status == '3') selected @endif>في
                                                        الطريق
                                                    </option>
                                                    <option value="4" @if($ord->status == '4') selected @endif>تم
                                                        استلامها
                                                    </option>

                                                </select>
                                            </div>
                                        </div>

                                        @if($ord->pay_type == 2)
                                            @if($ord->pay_status != 2)
                                                {{-- type --}}
                                                <div class="col-sm-6" style="margin-top: 10px">
                                                    <div class="from-group">
                                                        <label class="text-primary">تأكيد الدفع : <span
                                                                    class="text-danger">*</span></label>
                                                        <select required class="form-control" id="select-gear"
                                                                name="pay_status">
                                                            <option value="" disabled selected>إختيار</option>
                                                            <option value="1"
                                                                    @if($ord->pay_status == '1') selected @endif> لم يتم
                                                                الدفع
                                                            </option>
                                                            <option value="2"
                                                                    @if($ord->pay_status == '2') selected @endif>تم
                                                                الدفع
                                                            </option>

                                                        </select>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif

                                        <div class="col-sm-6" style="margin-top: 10px">
                                            <button style="width: 100%; margin-left: auto; margin-top:30px; margin-right: auto; "
                                                    type="submit" class="btn btn-outline-primary btn-block">إضافة
                                            </button>
                                        </div>
                                        {{-- @endif --}}
                                    </div>


                                </div>
                        </form>
                    </div>

                </div>
            </div>
            {{-- product --}}
            <div class="tab-pane fade" id="custom-content-below-company" role="tabpanel"
                 aria-labelledby="custom-content-below-company-tab">
                <div class="col-sm-12" style="margin-top: 10px">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-header">
                                <h5 class="m-0" style="display: inline;"> تفاصيل الطلب <i
                                            class="fas fa-exclamation-circle" style="cursor: pointer;color:#FFC107"
                                            data-toggle="modal" data-target="#modal-secondary"></i></h5>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="card card-primary card-outline">
                                {{--  <div class="card-header">
                                  <h5 class="m-0" style="display: inline;">قائمة الطلبات</h5>
                                </div>  --}}
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-hover table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>الإسم</th>
                                            <th>سعر العميل</th>
                                            <th>سعر التاجر</th>
                                            <th>سعر قبل الخصم</th>

                                            <th>العدد</th>
                                            <th>العدد المتبقى</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($ord->OrderProducts as $key => $val)
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>

                                                    {{$val->Product->name_ar}}
                                                </td>
                                                <td>{{$val->Product->price_discount}}</td>
                                                <td>{{$val->Product->dealer_price }}</td>
                                                <td>{{ $val->Product->price}}</td>
                                                <td>{{$val->count}}</td>
                                                <td>{{ $val->Product->stock}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        var option = {
            language: 'ar',
            uiColor: '#9AB8F3'
        }
        CKEDITOR.replace('des_ar', option);
        CKEDITOR.replace('des_en', option);

        //edit image
        function ChooseAvatar() {
            $("input[name='image']").click()
        }

        var loadAvatar = function (event) {
            var output = document.getElementById('avatar');
            output.src = URL.createObjectURL(event.target.files[0]);
        };




    </script>
@endsection


