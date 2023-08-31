<?php

use App\Http\Controllers\CustomersController;
use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\front\HomeController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/sms',function (){
   return  send_mobile_sms("201151263677", "1000");
});
Route::get('/', function () {


//    Artisan::call('down --secret="testing-only" --redirect=/maintenance ');



//    dd($this->app->isDownForMaintenance());
//
//    if ($this->app->isDownForMaintenance()){
//        return "Under Maintenance";
//
//    }else{
        return view('welcome');
//    }
//    Artisan::call('down --redirect=/maintenance ');

});

Route::get('maintenance', function (){
    return "Under Maintenance";
});

Route::group(['middleware' => ['role','auth'],'prefix'=>'admin'], function() {

	#------------------------------- start of HomeController -----------------------------#

	Route::get('/home',[
		'uses'  =>'HomeController@index',
		'as'    =>'home',
		'icon'  =>'<i class="nav-icon fas fa-home"></i>',
		'title' =>'الرئيسيه'
	]);

	Route::get('/sales',[
		'uses'  =>'HomeController@Orders',
		'as'    =>'Orderssales',
		'icon'  =>'<i class="nav-icon fas fa-poll"></i>',
		'title' =>'الماليات',
		'child'   =>[
			'Storedatesales'
		]
	]);

    # store date
	Route::get('store-date-sales',[
		'uses'=>'HomeController@Storedate',
		'as'  =>'Storedatesales',
		'title'=>' تغير الوقت'
	]);

	#------------------------------- end of HomeController -----------------------------#

	#------------------------------- start of inboxController -----------------------------#

	# inbox
	Route::get('inbox',[
		'uses'    =>'inboxController@Index',
		'as'      =>'inbox',
		'title'   =>'الرسائل',
		'subTitle'=>'الرسائل الواردة',
		'icon'    =>' <i class="fas fa-envelope"></i> ',
		'subIcon' =>' <i class="fas fa-envelope"></i> ',
		'child'   =>[
			'viewmessage',
			'deletemessage',
		]
	]);

	# view message
	Route::get('view-message/{id}',[
		'uses'=>'inboxController@View',
		'as'  =>'viewmessage',
		'title'=>'عرض رسالة'
	]);

	# delete message
	Route::post('delete-message',[
		'uses'=>'inboxController@Delete',
		'as'  =>'deletemessage',
		'title'=>'حذف رسالة'
	]);


	Route::get('emails',[
		'uses'    =>'emailController@Index',
		'as'      =>'emails',
		'title'   =>'النشرة البريدية',
		'subTitle'=>'النشرة البريدية',
		'icon'    =>' <i class="fas fa-envelope"></i> ',
		'subIcon' =>' <i class="fas fa-envelope"></i> ',
		
	]);



	#------------------------------- end of inboxController -----------------------------#
	
	

	#------------------------------- start of SupervisorsController -----------------------------#

	# users
	Route::get('supervisors',[
		'uses' =>'SupervisorsController@Index',
		'as'   =>'supervisors',
		'title'=>'المشرفين',
		'subTitle'=>'المشرفين',
		'icon' =>'<i class="fas fa-user-secret"></i>',
		'subIcon' =>'<i class="fas fa-user-secret"></i>',
		'child'=>[
			'supervisorspage',
			'storesupervisor',
			'deletesupervisor',
			'edittsupervisors',
			'updatesupervisor',
		]
	]);

	# add user
	Route::get('add-supervisor-page',[
		'uses'=>'SupervisorsController@AddSupervisorPage',
		'as'  =>'supervisorspage',
		'icon' =>'<i class="fas fa-plus"></i>',
		'title'=>'إضافة مشرف',
		'hasFather'=>true,
		'q_a'=>true
	]);

	# store user
	Route::post('store-supervisor',[
		'uses'=>'SupervisorsController@StoreSupervisor',
		'as'  =>'storesupervisor',
		'title'=>'حفظ المشرف'
	]);

	# edit user
	Route::get('edit-supervisor/{id}',[
		'uses'=>'SupervisorsController@EditSupervisor',
		'as'  =>'edittsupervisors',
		'title'=>'تعديل مشرف'
	]);

	# update user
	Route::post('update-supervisor',[
		'uses'=>'SupervisorsController@UpdateSupervisor',
		'as'  =>'updatesupervisor',
		'title'=>'تحديث مشرف'
	]);

	# delete user
	Route::get('delete-supervisor/{id}',[
		'uses'=>'SupervisorsController@DeleteSupervisor',
		'as'  =>'deletesupervisor',
		'title'=>'حذف مشرف'
	]);

	#------------------------------- end of SupervisorsController -----------------------------#


	#------------------------------- start of CustomersController -----------------------------#

	# customers
	Route::get('customers',[
		 'uses'=>'CustomersController@Index',
		 // 'uses' => [CustomersController::class,'Index'],
		'as'  =>'customers',
		'icon' =>'<i class="fas fa-user"></i>',
		'subIcon' =>'<i class="fas fa-user"></i>',
		'title'=>'العملاء',
		'subTitle'=>'العملاء',
		'q_a'=>true,
		'child'=>[
			'editcustomers',
			'deletecustomers',
			'updatecustomers',
		]
	]);

	# edit customers
	Route::get('edit-customers/{id}',[
		'uses'=>'CustomersController@Edit',
		'as'  =>'editcustomers',
		'title'=>'تعديل عميل'
	]);

	# update customers
	Route::post('update-customers',[
		'uses'=>'CustomersController@Update',
		'as'  =>'updatecustomers',
		'title'=>'تحديث عميل'
	]);

	# delete customers
	Route::get('delete-customers/{id}',[
		'uses'=>'CustomersController@Delete',
		'as'  =>'deletecustomers',
		'title'=>'حذف عميل'
	]);

	#------------------------------- end of CustomersController -----------------------------#

	#------------------------------- start of DealersController -----------------------------#

	# dealers
	Route::get('dealers',[
		'uses'=>'DealersController@Index',
		'as'  =>'dealers',
		'icon' =>'<i class="fas fa-user-cog"></i>',
		'subIcon' =>'<i class="fas fa-user-cog"></i>',
		'title'=>'التجار',
		'subTitle'=>'التجار',
		'q_a'=>true,
		'child'=>[
			'editdealers',
			'updatedealers',
			'deletedealers',
		]
	]);

	# edit dealers
	Route::get('edit-dealers/{id}',[
		'uses'=>'DealersController@Edit',
		'as'  =>'editdealers',
		'title'=>'تعديل تاجر'
	]);

	# update dealers
	Route::post('update-dealers',[
		'uses'=>'DealersController@Update',
		'as'  =>'updatedealers',
		'title'=>'تحديث تاجر'
	]);

	# delete dealers
	Route::get('delete-dealers/{id}',[
		'uses'=>'DealersController@Delete',
		'as'  =>'deletedealers',
		'title'=>'حذف تاجر'
	]);

	#------------------------------- end of DealersController -----------------------------#

	#------------------------------- start of DivisionsController -----------------------------#

	# divisions
	Route::get('divisions',[
		'uses' =>'DivisionsController@Index',
		'as'   =>'divisions',
		'title'=>'الفئات',
		'subTitle'=>'الفئات',
		'icon' =>'<i class="fas fa-braille"></i>',
		'subIcon' =>'<i class="fas fa-braille"></i>',
		'q_a'=>true,
		'child'=>[
			'storedivisions',
			'updatedivisions',
			'deletedivisions',
		]
	]);

	# store divisions
	Route::post('store-divisions',[
		'uses'=>'DivisionsController@Store',
		'as'  =>'storedivisions',
		'title'=>'إضافة فئة'
	]);

	# update divisions
	Route::post('update-divisions',[
		'uses'=>'DivisionsController@Update',
		'as'  =>'updatedivisions',
		'title'=>'تحديث فئة '
	]);

	# delete divisions
	Route::get('delete-divisions/{id}',[
		'uses'=>'DivisionsController@Delete',
		'as'  =>'deletedivisions',
		'title'=>'حذف فئة '
	]);

	

	#------------------------------- end of DivisionsController -----------------------------#


	#------------------------------- start of CategoriesController -----------------------------#

	# categories
	Route::get('categories',[
		'uses' =>'CategoriesController@Index',
		'as'   =>'categories',
		'title'=>'الأقسام',
		'subTitle'=>'الأقسام',
		'icon' =>'<i class="fas fa-shapes"></i>',
		'subIcon' =>'<i class="fas fa-shapes"></i>',
		'q_a'=>true,
		'child'=>[
			'storecategories',
			'updatecategories',
			'deletecategories',
		]
	]);

	# store categories
	Route::post('store-categories',[
		'uses'=>'CategoriesController@Store',
		'as'  =>'storecategories',
		'title'=>'إضافة تصنيف'
	]);

	# update categories
	Route::post('update-categories',[
		'uses'=>'CategoriesController@Update',
		'as'  =>'updatecategories',
		'title'=>'تحديث تصنيف '
	]);

	# delete categories
	Route::get('delete-categories/{id}',[
		'uses'=>'CategoriesController@Delete',
		'as'  =>'deletecategories',
		'title'=>'حذف تصنيف '
	]);

	#------------------------------- end of CategoriesController -----------------------------#
	

		#------------------------------- start of GovernoratesController -----------------------------#

	# governorates
	Route::get('governorates',[
		'uses' =>'GovernoratesController@Index',
		'as'   =>'governorates',
		'title'=>'المحافظات',
		'subTitle'=>'المحافظات',
		'icon' =>'<i class="fas fa-shapes"></i>',
		'subIcon' =>'<i class="fas fa-shapes"></i>',
		'q_a'=>true,
		'child'=>[
			'storegovernorates',
			'updategovernorates',
			'deletegovernorates',
		]
	]);

	# store governorates
	Route::post('store-governorates',[
		'uses'=>'GovernoratesController@Store',
		'as'  =>'storegovernorates',
		'title'=>'إضافة محافظه'
	]);

	# update governorates
	Route::post('update-governorates',[
		'uses'=>'GovernoratesController@Update',
		'as'  =>'updategovernorates',
		'title'=>'تحديث محافظه '
	]);

	# delete governorates
	Route::get('delete-governorates/{id}',[
		'uses'=>'GovernoratesController@Delete',
		'as'  =>'deletegovernorates',
		'title'=>'حذف محافظه '
	]);

	#------------------------------- end of GovernoratesController -----------------------------#
	



	#------------------------------- start of ProductsController -----------------------------#

	# products
	Route::get('products',[
		'uses' =>'ProductsController@Index',
		'as'   =>'products',
		'title'=>'المنتجات',
		'subTitle'=>'المنتجات',
		'icon' =>'<i class="fas fa-tags"></i>',
		'subIcon' =>'<i class="fas fa-tags"></i>',
		'q_a'=>true,
		'child'=>[
			'addproducts',
			'storeproducts',
			'editproducts',
			'updateproducts',
			'DeleteImageproduct',
			'DeleteProduct'
		]
	]);

	# add product
	Route::get('add-product',[
		'uses' =>'ProductsController@Add',
		'as'   =>'addproducts',
		'title'=>'إضافة منتج',
		'icon' =>'<i class="fas fa-plus"></i>',
		'q_a'=>true,
		'hasFather'=>true,
	]);


        # expired products
        //    Route::get('/expiredProducts',[
        //        'uses'  => 'ProductsController@expiredProducts',
        //        'as'    =>'expiredProducts',
        //        'title' =>'المنتجات المنتهية',
        //        'icon' =>'<i class="fas fa-minus-circle"></i>',
        //        'q_a'=>true,
        //        'hasFather'=>true,
        //    ]);;

        Route::get('/expired/products',[
            // 'uses'  => 'front\HomeController@expiredProducts',
            'uses'  => 'ProductsController@expiredProducts',
            'as'    =>'expiredProducts',
            'title' =>'المنتجات المنتهية',
            'icon' => ' <i class="fas fa-tags"></i> ',
        ]);

        Route::get('get/expired/products',[ProductsController::class,'getExpiredProducts'])->name('get.expired.products');


    # store product
	Route::post('store-product',[
		'uses' =>'ProductsController@Store',
		'as'   =>'storeproducts',
		'title'=>'حفظ منتج',
	]);

	# edit product
	Route::get('edit-product/{id}',[
		'uses' =>'ProductsController@Edit',
		'as'   =>'editproducts',
		'title'=>'تعديل منتج',
	]);

	# update product
	Route::post('update-product',[
		'uses' =>'ProductsController@Update',
		'as'   =>'updateproducts',
		'title'=>'تحديث منتج',
	]);

	# delete image
	Route::post('delete-product-image',[
		'uses'=>'ProductsController@DeleteImage',
		'as'  =>'DeleteImageproduct',
		'title'=>'حذف صور منتج '
	]);
	# delete product
	Route::get('delete-product/{id}',[
		'uses'=>'ProductsController@DeleteProduct',
		'as'  =>'DeleteProduct',
		'title'=>'حذف  منتج '
	]);

	#------------------------------- end of ProductsController -----------------------------#

#------------------------------- start Of PannersController ----------------------------#
	# pannars
	Route::get('pannars',[
		'uses' =>'PannersController@pannars',
		'as'   =>'pannars',
		'title'=>'البنارات',
		'subTitle'=>'البنارات',
		'icon' =>'<i class="fas fa-flag"></i>',
		'subIcon' =>'<i class="fas fa-flag"></i>',
		'q_a'=>true,
		'child'=>[
			'addpannars',
			'StorePannar',
			'editpannars',
			'UpdatePannar',
			'DeletePannar'
		]
	]);

	# add pannars
	Route::get('add-pannars',[
		'uses' =>'PannersController@Add',
		'as'   =>'addpannars',
		'title'=>'إضافة بانر',
		'icon' =>'<i class="fas fa-plus"></i>',
		'q_a'=>true,
		'hasFather'=>true,
	]);

	# store pannars
	Route::post('store-pannars',[
		'uses' =>'PannersController@StorePannar',
		'as'   =>'StorePannar',
		'title'=>'حفظ بانر',
	]);

	# edit pannars
	Route::get('edit-pannars/{id}',[
		'uses' =>'PannersController@Edit',
		'as'   =>'editpannars',
		'title'=>'تعديل بانر',
	]);

	# update pannars
	Route::post('update-pannars',[
		'uses' =>'PannersController@UpdatePannar',
		'as'   =>'UpdatePannar',
		'title'=>'تحديث بانر',
	]);

	# delete pannars
	Route::get('delete-pannars/{id}',[
		'uses'=>'PannersController@DeletePannar',
		'as'  =>'DeletePannar',
		'title'=>'حذف صور بانر '
	]);

#------------------------------- end Of PannersController ----------------------------#
#------------------------------- start Of ordersController ----------------------------#
	# orders
	Route::get('orders',[
		'uses' =>'ordersController@orders',
		'as'   =>'orders',
		'title'=>'الطلبات',
		'subTitle'=>'الطلبات',
		'icon' =>'<i class="fas fa-cart-arrow-down"></i>',
		'subIcon' =>'<i class="fas fa-cart-arrow-down"></i>',
		'q_a'=>true,
		'child'=>[
	
			'editorders',
			'Updateorders',
			'Deleteorder',
			'Deleteorders'

		]
	]);



	# edit orders
	Route::get('edit-order/{id}',[
		'uses' =>'ordersController@Edit',
		'as'   =>'editorders',
		'title'=>'تعديل طلب',
	]);

	# update orders
	Route::post('update-order',[
		'uses' =>'ordersController@Updateorders',
		'as'   =>'Updateorders',
		'title'=>'تحديث طلب',
	]);

	# delete orders 
	Route::get('delete-order/{id}',[
		'uses'=>'ordersController@Deleteorder',
		'as'  =>'Deleteorder',
		'title'=>'حذف طلب'
	]);
	# delete orders 
	Route::get('delete-orders',[
		'uses'=>'ordersController@Deleteorders',
		'as'  =>'Deleteorders',
		'title'=>'حذف الطلبات'
	]);



#------------------------------- end Of ordersController ----------------------------#

	#------------------------------- start Of CouponsController ----------------------------#

	# coupons 
	Route::get('coupons',[
		'uses'    =>'CouponsController@Coupons',
		'as'      =>'couponspage',
		'title'   =>'الكوبونات',
		'subTitle'   =>'الكوبونات',
		'icon'    =>'<i class="fas fa-gem"></i>',
		'subIcon'  =>'<i class="fas fa-gem"></i>',
		'child'=>[
			'storecoupon',
			'deletecoupon',
			'updatecoupon',
		]
	]);

	# store coupon
	Route::post('store-coupon',[
		'uses' =>'CouponsController@StoreCoupon',
		'as'   =>'storecoupon',
		'title'=>'حفظ كوبون'
	]);

	# delete coupon
	Route::get('delete-coupon/{id}',[
		'uses' =>'CouponsController@DeleteCoupon',
		'as'   =>'deletecoupon',
		'title'=>'حذف كوبون'
	]);

	# update coupon
	Route::post('update-coupon',[
		'uses' =>'CouponsController@UpdateCoupon',
		'as'   =>'updatecoupon',
		'title'=>'تحديث كوبون'
	]);

	#------------------------------- end Of CouponsController ----------------------------#

	#------------------------------- start of PermissionsController -----------------------------#

	# permissions
	Route::get('permissions',[
		'uses' =>'PermissionsController@Index',
		'as'   =>'permissions',
		'title'=>'الصلاحيات',
		'subTitle'=>'الصلاحيات',
		'icon' =>'<i class="fas fa-biohazard"></i>',
		'subIcon' =>'<i class="fas fa-biohazard"></i>',
		'child'=>[
			'addrolepage',
			'addpermission',
			'editpermission',
			'editrolepage',
			'updatepermission',
			'deletepermission',
		]
	]);

	# add role page
	Route::get('add-role-page',[
		'uses'=>'PermissionsController@AddRolePage',
		'as'  =>'addrolepage',
		'icon' =>'<i class="fas fa-plus"></i>',
		'title'=>'إضافة صلاحيه',
		'hasFather'=>true
	]);

	# add role (ajax)
	Route::post('add-permission',[
		'uses'=>'PermissionsController@Add',
		'as'  =>'addpermission',
		'title'=>'حفظ صلاحيه'
	]);

	# edit permission
	Route::get('edit-permission/{id}',[
		'uses'  =>'PermissionsController@EditRole',
		'as'    =>'editrolepage',
		'title' =>'تعديل صلاحيه'
	]);

	# update role (ajax)
	Route::post('update-permission',[
		'uses'=>'PermissionsController@Update',
		'as'  =>'updatepermission',
		'title'=>'تحديث صلاحيه'
	]);

	# delete role 
	Route::post('delete-permission',[
		'uses'=>'PermissionsController@Delete',
		'as'  =>'deletepermission',
		'title'=>'حذف صلاحيه'
	]);

	#------------------------------- end of PermissionsController -----------------------------#

	#------------------------------- start of ReportsController -----------------------------#
	# supervisor reports
	Route::get('supervisors-reports',[
		'uses'  =>'ReportsController@Index',
		'as'    =>'supervisorsresports',
		'icon'  =>'<i class="fas fa-clipboard"></i>',
		'subIcon'  =>'<i class="fas fa-clipboard"></i>',
		'title' =>'التقارير',
		'subTitle' =>'تقارير المشرفين',
		'child' =>[
			'deletereport',
			'deleteallreports',
			'reports'
		]
	]);

	# reports
	Route::get('reports/{id?}',[
		'uses'=>'ReportsController@Reports',
		'as'  =>'reports',
		'title'=>'قائمة التقارير'
	]);


	# delete all reports
	Route::post('delete-all-reports',[
		'uses'=>'ReportsController@DeleteAllReports',
		'as'  =>'deleteallreports',
		'title'=>'حذف جميع التقارير'
	]);

	# delete report
	Route::post('delete-report',[
		'uses'=>'ReportsController@DeleteReport',
		'as'  =>'deletereport',
		'title'=>'حذف تقرير'
	]);

	#------------------------------- end of ReportsController -----------------------------#

	#------------------------------- start of SettingController -----------------------------#

	# setting
	Route::get('setting',[
		'uses' =>'SettingController@Index',
		'as'   =>'setting',
		'title'=>'الإعدادات',
		'icon' =>'<i class="fas fa-cog"></i>',
		'child'=>[
			'updatemainsetting',
			'updatecopyrigth',
			'updateaboutapp',
			'updatepolicy',
			'updatesmtp',
			'updatesms',
			'updateonesignal',
			'updatefcm',
			'storedynamicsetting',
			'updatedynamicsetting',
			'deletedynamicsetting',
			'Storesocial',
			'socialUpdate',
			'Deletesocial',
			'updatewhyus',
		]
	]);

	# update main setting
	Route::post('update-main-setting',[
		'uses'=>'SettingController@UpdateMainSetting',
		'as'  =>'updatemainsetting',
		'title'=>'تحديث الإعدادات العامه'
	]);

	# update copyrigth
	Route::post('update-copyrigth',[
		'uses'=>'SettingController@UpdateMainCopyrigth',
		'as'  =>'updatecopyrigth',
		'title'=>'تحديث الحقوق'
	]);

	# update about app
	Route::post('update-about-app',[
		'uses'=>'SettingController@UpdateMainAboutApp',
		'as'  =>'updateaboutapp',
		'title'=>'تحديث عن التطبيق'
	]);

	# update why us
	Route::post('update-why-us',[
		'uses'=>'SettingController@UpdateWhyUs',
		'as'  =>'updatewhyus',
		'title'=>'تحديث لماذا أفتي'
	]);

	# update app policy
	Route::post('update-policy',[
		'uses'=>'SettingController@UpdatePolicy',
		'as'  =>'updatepolicy',
		'title'=>' تحديث الشروط والأحكام'
	]);

	# update smtp
	Route::post('update-smtp',[
		'uses'=>'SettingController@UpdateSMTP',
		'as'  =>'updatesmtp',
		'title'=>'تحديث ال SMTP'
	]);

	# update sms
	Route::post('update-sms',[
		'uses'=>'SettingController@UpdateSmS',
		'as'  =>'updatesms',
		'title'=>'تحديث ال sms'
	]);

	# update onesignal
	Route::post('update-onesignal',[
		'uses'=>'SettingController@UpdateOneSignal',
		'as'  =>'updateonesignal',
		'title'=>'تحديث ال onesignal'
	]);

	# update fcm
	Route::post('update-fcm',[
		'uses'=>'SettingController@UpdateFCM',
		'as'  =>'updatefcm',
		'title'=>'تحديث ال fcm'
	]);

	# store dynamic setting
	Route::post('store-dynamic-setting',[
		'uses'=>'SettingController@StoreDynamicSetting',
		'as'  =>'storedynamicsetting',
		'title'=>'إضافة إعدادات إضافية'
	]);

	# update dynamic setting
	Route::post('update-dynamic-setting',[
		'uses'=>'SettingController@UpdateDynamicSetting',
		'as'  =>'updatedynamicsetting',
		'title'=>'تحديث إعدادات إضافية'
	]);

	# delete dynamic setting
	Route::post('delete-dynamic-setting',[
		'uses'=>'SettingController@DeleteDynamicSetting',
		'as'  =>'deletedynamicsetting',
		'title'=>'حذف إعدادات إضافية'
	]);

	# store social
	Route::post('store-socials',[
		'uses'=>'SettingController@Storesocial',
		'as'  =>'Storesocial',
		'title'=>'إضافة موقع'
	]);

	# update social
	Route::post('update-socials-media',[
		'uses'=>'SettingController@socialUpdate',
		'as'  =>'socialUpdate',
		'title'=>'تحديث موقع'
	]);

	# delete social
	Route::post('delete-socials',[
		'uses'=>'SettingController@Deletesocial',
		'as'  =>'Deletesocial',
		'title'=>'حذف موقع'
	]);

	#------------------------------- end of SettingController -----------------------------#
});

	# update e-shop sort
	Route::get('shop-sort/{id}/{sort}',[
		'uses'=>'E_ShopsController@UpdateSort',
	]);

use App\Product;
use  Illuminate\Support\Facades\Auth;

Route::get('dd',function(){

	Artisan::queue('view:clear');
	return 'done';
	
});
// Auth::routes();
Route::get('admin/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('admin/login', 'Auth\LoginController@login');
Route::get('admin/logout', 'Auth\LoginController@logout')->name('logout');


// Jamlia
// omar.abdelazizz@gmail.com => 12345678

// Gado
// omar.abdelazizz@gmail.com  => 12345678


// omar.abdellaziz.admin@gmail.com


