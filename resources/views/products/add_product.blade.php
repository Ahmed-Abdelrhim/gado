@extends('layouts.app')

@section('style')
<style type="text/css">
    .selectize-input{
        min-height: 38px !important
    }
	.img img{
		width:150px;
		height:150px;
		margin-right:20px;
		margin-top:20px;
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

	<div class="card card-primary card-outline">
		{{--  <div class="card-header">
			<h5 class="m-0" style="display: inline;">إضافة منتج جديد</h5>
		</div>  --}}

		<div class="card-body">
			<form action="{{route('storeproducts')}}" method="post" enctype="multipart/form-data">
				<div class="row">
					{{csrf_field()}}

					{{-- card image --}}
					<div class="col-sm-4" style="margin-top: 10px">
						<div class="from-group">
							<label class="text-primary">صورة الكارت : <span class="text-primary">*</span></label>
							<input type="file" name="card_image" class="form-control" accept="image/*">
						</div>
					</div>

					{{-- name ar --}}
					<div class="col-sm-4" style="margin-top: 10px">
						<div class="from-group">
							<label class="text-primary">الإسم بالعربية : <span class="text-danger">*</span></label>
							<input type="text" name="name_ar" class="form-control" value="{{old('name_ar')}}" placeholder="الإسم بالعربية" required="">
						</div>
					</div>

					{{-- name en --}}
					<div class="col-sm-4" style="margin-top: 10px">
						<div class="from-group">
							<label class="text-primary">الإسم بالإنجليزية : <span class="text-danger">*</span></label>
							<input type="text" name="name_en" class="form-control" value="{{old('name_en')}}" placeholder="الإسم بالإنجليزية" required="">
						</div>
					</div>

					{{-- old price --}}
					<div class="col-sm-2" style="margin-top: 10px">
						<div class="from-group">
							<label class="text-primary">السعر : <span class="text-danger">*</span></label>
							<input type="number" name="price" class="form-control" value="{{old('price')}}" step="0.01" required="">
						</div>
					</div>

					{{-- new price --}}
					<div class="col-sm-2" style="margin-top: 10px">
						<div class="from-group">
							<label class="text-primary">السعر بعدالخصم : </label>
							<input type="number" name="price_discount" class="form-control" value="{{old('price_discount')}}" step="0.01" required="">
						</div>
					</div>

					{{-- dealler price --}}
					<div class="col-sm-2" style="margin-top: 10px">
						<div class="from-group">
							<label class="text-primary">سعر التاجر : <span class="text-primary">*</span></label>
							<input type="number" name="dealer_price" class="form-control" value="{{old('dealer_price')}}" step="0.01" required="">
						</div>
					</div>

					{{-- stock --}}
					<div class="col-sm-2" style="margin-top: 10px">
						<div class="from-group">
							<label class="text-primary">العدد : <span class="text-danger">*</span></label>
							<input type="number" name="stock" class="form-control" value="{{old('stock')}}" required="">
						</div>
					</div>

					{{-- categories --}}
					<div class="col-sm-4" style="margin-top: 10px">
						<div class="from-group">
							<label class="text-primary">الأقسام : <span class="text-danger">*</span></label>
							<select class="form-control" id="select-gear" name="categories[]" multiple>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name_ar }}</option>
                                @endforeach
							</select>
						</div>
					</div>

					
                   

                    {{--  discription  --}}
                    <div class="col-sm-12">
                        <hr>
                        <div class="row">
                            <div class="col-sm-6">
                                <label class="text-primary">وصف المنتج بالعربية  : <span class="text-primary">*</span></label>
                                <textarea class="form-control"  name="des_ar" id="editor1" rows="10" cols="80" required></textarea>
                            </div>
                            <div class="col-sm-6">
                                <label class="text-primary">وصف المنتج بالإنجليزية  : <span class="text-primary">*</span></label>
                                <textarea class="form-control"  name="des_en" id="editor1" rows="10" cols="80" required></textarea>
                            </div>
                        </div>
                    </div>
					{{-- images --}} 
					<div class="col-sm-12"style="margin-top: 20px;">
						<div class="card-header">
						<label class="text-primary">صور المعرض : <span class="text-danger">*</span></label>
							<div class="btn btn-primary" style="float: left;height:36px;padding:3px;">
							
							<input type="file" name="galary[]" id="gallery1"  style="display: none;" accept="image/*" multiple>
							<label  style="cursor: pointer;font-size:14px;width: 100%;height: 100%;" onclick="ChooseAvatar1()" id="avatar1">  إضافة صور  <i class="fas fa-camera"></i></label>
							</div>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-sm-12 marbo img">
									<h5 class="m-0" style="display: inline; text-align: center;">قائمة صور  </h5>
									<div class="gallery1">
									
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-sm-12 marbo"  style="margin-top: 20px">
							<label class="text-primary"> مواصفات المنتج: <span class="text-danger">*</span></label>
							<div class="row preparation">

								<div class="col-sm-12">
									<div class="row">
										<div class="col-sm-2" style="padding: 0 15px 0 3px">
											<input type="text" name="type_name_ar[]" class="form-control" placeholder="الاسم بالعربي" required>
										</div>

										<div class="col-sm-2" style="padding: 0 15px 0 3px">
											<input type="text" name="type_name_en[]" class="form-control" placeholder="الاسم بالإنجليزي" required>
										</div>

										<div class="col-sm-3" style="padding: 0 15px 0 3px">
											<input type="text" name="type_value_ar[]" class="form-control" placeholder="القيمة بالعربي" required>
										</div>
										<div class="col-sm-3" style="padding: 0 15px 0 3px">
											<input type="text" name="type_value_en[]" class="form-control" placeholder="القيمة بالإنجليزي" required>
										</div>

										{{--  <div class="col-sm-1" style="padding: 0 0 0 1px">
											<button type="button" class="btn btn-danger btn-block" disabled>
												<i class="fas fa-minus-circle"></i>
											</button>
										</div>  --}}
										<div class="col-sm-1" style="padding: 0 2px 0px 0px;">
											<button type="button" class="btn btn-primary btn-block add_preparation">
												<i class="fas fa-plus"></i>
											</button>
										</div>
									</div>
								</div>

							</div>
						</div>

					{{-- submit --}}
					<div class="col-sm-4 offset-3" style="margin-top: 20px">
						<button class="btn btn-outline-primary btn-block store">حفظ</button>
					</div>

				</div>
			</form>
		</div>
	</div>

@endsection

@section('script')
    <script>
        var option = {
        language: 'ar',
        uiColor: '#9AB8F3'
        }
    CKEDITOR.replace( 'des_ar',option );
    CKEDITOR.replace( 'des_en',option );

        // store product
        $('.store').on('click',function(){
            var galary = document.getElementById("galary");
            if ('files' in galary) {
                if(galary.files.length == 0) {
                    toastr.error('يجب إختيار صور المعرض')
                }
            }
        })

			
	
	function ChooseAvatar1(){$("input[name='galary[]']").click()}	
		
	$(function() {
	    // Multiple images preview in browser
	    var imagesPreview = function(input, placeToInsertImagePreview) {

	        if (input.files) {
	            var filesAmount = input.files.length;

	            for (i = 0; i < filesAmount; i++) {
	                var reader = new FileReader();

	                reader.onload = function(event) {
	                    $($.parseHTML('<img class="img-fluid mb-2  bounceIn">')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
	                }

	                reader.readAsDataURL(input.files[i]);
	            }
	        }

	    };

	    $('#gallery1').on('change', function() {
	        imagesPreview(this, 'div.gallery1');
	    });
	});

	$(document).on('click','.add_preparation',function(){
	
		$('.preparation').append(
			`
			<div class="col-sm-12 father${Date.now()}" style="margin-top:10px">
				<div class="row">
					<div class="col-sm-2" style="padding: 0 15px 0 3px">
						<input type="text" name="type_name_ar[]" class="form-control" placeholder="الاسم بالعربي" required>
					</div>

					<div class="col-sm-2" style="padding: 0 15px 0 3px">
						<input type="text" name="type_name_en[]" class="form-control" placeholder="الاسم بالإنجليزي" required>
					</div>

					<div class="col-sm-3" style="padding: 0 15px 0 3px">
						<input type="text" name="type_value_ar[]" class="form-control" placeholder="القيمة بالعربي" required>
					</div>
					<div class="col-sm-3" style="padding: 0 15px 0 3px">
						<input type="text" name="type_value_en[]" class="form-control" placeholder="القيمة بالإنجليزي" required>
					</div>


					

					<div class="col-sm-1" style="padding: 0 0 0 1px">
						<button type="button" class="btn btn-danger btn-block remove_quantiti" data-code="${Date.now()}">
							<i class="fas fa-minus-circle"></i>
						</button>
					</div>
				</div>
			</div>
			`
		);
	})

	$(document).on('click','.remove_preparation',function(){
		var cla = '.father'+$(this).data('code');
		$(cla).remove();
	})
	$(document).on('click','.remove_quantiti',function(){
		var cla = '.father'+$(this).data('code');
		$(cla).remove();
	})
    </script>
@endsection


