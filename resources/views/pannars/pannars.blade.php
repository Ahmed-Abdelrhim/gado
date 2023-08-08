@extends('layouts.app')

@section('content')
	<div class="row">
		<div class="col-sm-12">
          <div class="card card-primary card-outline">
            {{--  <div class="card-header">
              <h5 class="m-0" style="display: inline;">قائمة البنارات</h5>
            </div>  --}}
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                  {{--  <th>#</th>  --}}
                  <th>الصوره</th>
                  <th>الإسم</th>
  
                  <th>التحكم</th>
                </tr>
                </thead>
                <tbody>
                @foreach($pannars as $key => $value)
	                <tr>
	                  {{--  <td>{{$key+1}}</td>  --}}
	                  <td> <img src="{{asset('uploads/panners/'.$value->image)}}" alt="" style="width: 50px"> </td>
	                  <td>{{$value->name_ar}}</td>


	                  <td>
                      <a href="{{route('editpannars',$value->id)}}" class="btn btn-primary btn-sm " type="submit"> <i class="fas fa-edit"></i></a>
                      <a href="{{route('DeletePannar',$value->id)}}" class="btn btn-danger btn-sm delete"> <i class="fas fa-trash"></i></a>
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