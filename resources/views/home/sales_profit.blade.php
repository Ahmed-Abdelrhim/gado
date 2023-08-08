@extends('layouts.app')

@section('content')
	<div class="row">
		<div class="col-sm-12">
          <div class="card card-primary card-outline">
            <div class="card-header">
                <div class="row">

                    <div class="col-sm-6">
                      <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>
          
                        <div class="info-box-content">
                          <span class="info-box-text">إجمالي عدد الطلبات المُباعة</span>
                          <span class="info-box-number">
                            {{ count($orders) }}
                            <small>طلب</small>
                          </span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                    </div>

                    <div class="col-sm-6">
                      <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>
          
                        <div class="info-box-content">
                          <span class="info-box-text">إجمالي قيمة المبيعات</span>
                          <span class="info-box-number">
                            {{ $sum }}
                              <small>جنيه</small>
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                    </div>
          
                   
                    <div class="col-sm-12">
                      <form action="{{route('Storedatesales')}}" method="get" style="width:100%">
                      {{csrf_field()}}
                        <div class="row">
                          <div class="col-sm-10">
                            <input type="date" required name="date" max="{{ $now }}" placeholder="إختيار تاريخ" class="form-control">
                          </div>
                        
                          <div class="col-sm-2">
                            <button type="submit" class="btn btn-block btn-success">تصفية</button>
                          </div>
                        </div>
                    </form>
                  </div>
                </div>
             </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example11" class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>الرقم</th>
                  <th>التاريخ</th>
                  <th>العميل</th>
                  <th>قيمة الطلب</th>
                </tr>
                </thead>
                <tbody>
                  @if(count($orders) > 0)
                    @foreach($orders as $key => $order)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td><a href="{{ route('editorders',$order->id) }}">{{ $order->id }}</a></td>
                            <td>{{ $order->created_at }}</td>
                            <td>
                            @if($order->Order_inf() != null)
                              {{ $order->Order_inf()->name_first }}
                            @endif
                            </td>
                           
                            <td>{{ $order->total }} جنيه</td>
                        </tr>
                    @endforeach
                    @endif
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