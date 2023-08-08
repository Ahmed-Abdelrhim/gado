@extends('layouts.app')

@section('style')
<style type="text/css">
	#avatar{
		width: 150px;
	}
	#avatar:hover{
		width: 150px;
		cursor: pointer;
	}
</style>
@endsection

@section('content')
	<div class="card card-primary card-outline">
	{{--  <div class="card-header">
		<h6 class="m-0" style="display: inline;">تعديل مشرف <span class="text-primary"> {{$data->name}} </span></h6>
	</div>  --}}
		<div class="row">
			{{-- user info --}}
			<div class="col-sm-3" style="margin-top: 15px">
				<div class="card card-primary card-outline">
					<div class="card-body box-profile">
					<div class="text-center">
						<img class="profile-user-img img-fluid img-circle" src="{{asset('uploads/dealers/avatar/'.$data->avatar)}}" alt="User profile picture">
					</div>

					<h3 class="profile-username text-center">{{$data->name}}</h3>

					<ul class="list-group list-group-unbordered mb-3">
						<li class="list-group-item">
						<b>تاريخ التسجيل</b> <a class="float-right text-primary">{{Date::parse($data->created_at)->diffForHumans()}}</a>
						</li>
						
						<li class="list-group-item">
						<b> عدد الطلبات</b> <a class="float-right text-primary">{{count($data->Orders)}}</a>
						</li>
					</ul>
					</div>
					<!-- /.card-body -->
				</div>
			</div>

			<div class="col-sm-9">
				<div class="card-body">
					<form action="{{route('updatedealers')}}" method="post" enctype="multipart/form-data">
						<div class="row">
							{{csrf_field()}}
							<input type="hidden" name="id" value="{{$data->id}}">
							
							{{-- avatar --}}
							<div class="col-sm-6" style="margin-top: 10px">
								<div class="from-group">
									<label class="text-primary">إختيار صورة <span class="text-primary"> * </span></label>
									<input type="file" name="avatar" accept="image/*" class="form-control">
								</div>
							</div>

							{{-- name --}}
							<div class="col-sm-6" style="margin-top: 10px">
								<div class="from-group">
									<label class="text-primary"> الإسم : <span class="text-danger">*</span></label>
									<input type="text" name="name" class="form-control" value="{{$data->name}}" placeholder="الإسم" required="">
								</div>
							</div>

							{{-- email --}}
							<div class="col-sm-6" style="margin-top: 10px">
								<div class="from-group">
									<label class="text-primary">البريد الإلكتروني : <span class="text-primary">*</span></label>
									<input type="email" name="email" class="form-control" value="{{$data->email}}" placeholder="البريد الإلكتروني" >
								</div>
							</div>

							{{-- phone --}}
							<div class="col-sm-6" style="margin-top: 10px">
								<div class="from-group">
									<label class="text-primary">الجوال : <span class="text-danger">*</span></label>
									<input type="text" name="phone" class="form-control" value="{{$data->phone}}" required>
								</div>
							</div>

							{{-- password --}}
							<div class="col-sm-6" style="margin-top: 10px">
								<div class="from-group">
									<label class="text-primary">كلمة المرور : <span class="text-danger">*</span></label>
									<input type="text" name="password" class="form-control" value="" placeholder="كلمة المرور" >
								</div>
							</div>

							{{-- active --}}
							<div class="col-sm-6" style="margin-top: 10px">
								<div class="from-group">
									<label class="text-primary">الحالة : <span class="text-danger">*</span></label>
									<select class="form-control" name="active" id="active">
										<option value="1" @if($data->active == 1) selected @endif>نشط</option>
										<option value="0" @if($data->active == 0) selected @endif>حظر</option>
									</select>
								</div>
							</div>

							{{-- phone --}}
							<div class="col-sm-6" style="margin-top: 10px">
								<div class="from-group">
									<label class="text-primary">السجل التجاري : <span class="text-danger">*</span></label>
									<input type="text" name="commercial_registration_num" class="form-control" value="{{$data->commercial_registration_num}}" required>
								</div>
							</div>

							{{-- phone --}}
							<div class="col-sm-6" style="margin-top: 10px">
								<div class="from-group">
									<label class="text-primary">الرقم الضريبي : <span class="text-danger">*</span></label>
									<input type="text" name="tax_card_num" class="form-control" value="{{$data->tax_card_num}}" required>
								</div>
							</div>

							{{-- submit --}}
							<div class="col-sm-4 offset-3" style="margin-top: 20px">
								<button class="btn btn-outline-primary btn-block">حفظ</button>
							</div>
						</div>
					</form>
				</div>
			</div>

		</div>
	</div>
@endsection

@section('script')
<script type="text/javascript">
	function ChooseAvatar(){$("input[name='avatar']").click()}
	var loadAvatar = function(event) {
		var output = document.getElementById('avatar');
		output.src = URL.createObjectURL(event.target.files[0]);
	};
</script>
@endsection


