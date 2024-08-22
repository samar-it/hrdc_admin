<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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



	Route::get('', 'IndexController@index')->name('index')->middleware(['redirect.to.home']);
	Route::get('index/login', 'IndexController@login')->name('login');
	
	Route::post('auth/login', 'AuthController@login')->name('auth.login');
	Route::any('auth/logout', 'AuthController@logout')->name('logout')->middleware(['auth']);

	Route::get('auth/accountcreated', 'AuthController@accountcreated')->name('accountcreated');
	Route::get('auth/accountpending', 'AuthController@accountpending')->name('accountpending');
	Route::get('auth/accountblocked', 'AuthController@accountblocked')->name('accountblocked');
	Route::get('auth/accountinactive', 'AuthController@accountinactive')->name('accountinactive');


	
	Route::get('index/register', 'AuthController@register')->name('auth.register')->middleware(['redirect.to.home']);
	Route::post('index/register', 'AuthController@register_store')->name('auth.register_store');
		
	Route::post('auth/login', 'AuthController@login')->name('auth.login');
	Route::get('auth/password/forgotpassword', 'AuthController@showForgotPassword')->name('password.forgotpassword');
	Route::post('auth/password/sendemail', 'AuthController@sendPasswordResetLink')->name('password.email');
	Route::get('auth/password/reset', 'AuthController@showResetPassword')->name('password.reset.token');
	Route::post('auth/password/resetpassword', 'AuthController@resetPassword')->name('password.resetpassword');
	Route::get('auth/password/resetcompleted', 'AuthController@passwordResetCompleted')->name('password.resetcompleted');
	Route::get('auth/password/linksent', 'AuthController@passwordResetLinkSent')->name('password.resetlinksent');
	

/**
 * All routes which requires auth
 */
Route::middleware(['auth', 'rbac'])->group(function () {
		
	Route::get('home', 'HomeController@index')->name('home');

	

/* routes for Assets Controller */
	Route::get('assets', 'AssetsController@index')->name('assets.index');
	Route::get('assets/index/{filter?}/{filtervalue?}', 'AssetsController@index')->name('assets.index');	
	Route::get('assets/view/{rec_id}', 'AssetsController@view')->name('assets.view');	
	Route::get('assets/add', 'AssetsController@add')->name('assets.add');
	Route::post('assets/add', 'AssetsController@store')->name('assets.store');
		
	Route::any('assets/edit/{rec_id}', 'AssetsController@edit')->name('assets.edit');	
	Route::get('assets/delete/{rec_id}', 'AssetsController@delete');	
	Route::get('assets/need_purchase', 'AssetsController@need_purchase');
	Route::get('assets/need_purchase/{filter?}/{filtervalue?}', 'AssetsController@need_purchase');

/* routes for Audits Controller */
	Route::get('audits', 'AuditsController@index')->name('audits.index');
	Route::get('audits/index/{filter?}/{filtervalue?}', 'AuditsController@index')->name('audits.index');	
	Route::get('audits/view/{rec_id}', 'AuditsController@view')->name('audits.view');

/* routes for Collection Controller */
	Route::get('collection', 'CollectionController@index')->name('collection.index');
	Route::get('collection/index/{filter?}/{filtervalue?}', 'CollectionController@index')->name('collection.index');	
	Route::get('collection/view/{rec_id}', 'CollectionController@view')->name('collection.view');	
	Route::get('collection/add', 'CollectionController@add')->name('collection.add');
	Route::post('collection/add', 'CollectionController@store')->name('collection.store');
		
	Route::any('collection/edit/{rec_id}', 'CollectionController@edit')->name('collection.edit');	
	Route::get('collection/delete/{rec_id}', 'CollectionController@delete');

/* routes for Permissions Controller */
	Route::get('permissions', 'PermissionsController@index')->name('permissions.index');
	Route::get('permissions/index/{filter?}/{filtervalue?}', 'PermissionsController@index')->name('permissions.index');	
	Route::get('permissions/view/{rec_id}', 'PermissionsController@view')->name('permissions.view');	
	Route::get('permissions/add', 'PermissionsController@add')->name('permissions.add');
	Route::post('permissions/add', 'PermissionsController@store')->name('permissions.store');
		
	Route::any('permissions/edit/{rec_id}', 'PermissionsController@edit')->name('permissions.edit');	
	Route::get('permissions/delete/{rec_id}', 'PermissionsController@delete');

/* routes for Person Controller */
	Route::get('person', 'PersonController@index')->name('person.index');
	Route::get('person/index/{filter?}/{filtervalue?}', 'PersonController@index')->name('person.index');	
	Route::get('person/view/{rec_id}', 'PersonController@view')->name('person.view');
	Route::get('person/masterdetail/{rec_id}', 'PersonController@masterDetail')->name('person.masterdetail')->withoutMiddleware(['rbac']);	
	Route::get('person/add', 'PersonController@add')->name('person.add');
	Route::post('person/add', 'PersonController@store')->name('person.store');
		
	Route::any('person/edit/{rec_id}', 'PersonController@edit')->name('person.edit');	
	Route::get('person/delete/{rec_id}', 'PersonController@delete');

/* routes for Roles Controller */
	Route::get('roles', 'RolesController@index')->name('roles.index');
	Route::get('roles/index/{filter?}/{filtervalue?}', 'RolesController@index')->name('roles.index');	
	Route::get('roles/view/{rec_id}', 'RolesController@view')->name('roles.view');
	Route::get('roles/masterdetail/{rec_id}', 'RolesController@masterDetail')->name('roles.masterdetail')->withoutMiddleware(['rbac']);	
	Route::get('roles/add', 'RolesController@add')->name('roles.add');
	Route::post('roles/add', 'RolesController@store')->name('roles.store');
		
	Route::any('roles/edit/{rec_id}', 'RolesController@edit')->name('roles.edit');	
	Route::get('roles/delete/{rec_id}', 'RolesController@delete');

/* routes for Stock Controller */
	Route::get('stock', 'StockController@index')->name('stock.index');
	Route::get('stock/index/{filter?}/{filtervalue?}', 'StockController@index')->name('stock.index');	
	Route::get('stock/view/{rec_id}', 'StockController@view')->name('stock.view');	
	Route::get('stock/add', 'StockController@add')->name('stock.add');
	Route::post('stock/add', 'StockController@store')->name('stock.store');
		
	Route::any('stock/edit/{rec_id}', 'StockController@edit')->name('stock.edit');	
	Route::get('stock/delete/{rec_id}', 'StockController@delete');

/* routes for User Controller */
	Route::get('user', 'UserController@index')->name('user.index');
	Route::get('user/index/{filter?}/{filtervalue?}', 'UserController@index')->name('user.index');	
	Route::get('user/view/{rec_id}', 'UserController@view')->name('user.view');	
	Route::any('account/edit', 'AccountController@edit')->name('account.edit');	
	Route::get('account', 'AccountController@index');	
	Route::post('account/changepassword', 'AccountController@changepassword')->name('account.changepassword');	
	Route::get('user/add', 'UserController@add')->name('user.add');
	Route::post('user/add', 'UserController@store')->name('user.store');
		
	Route::any('user/edit/{rec_id}', 'UserController@edit')->name('user.edit');	
	Route::get('user/delete/{rec_id}', 'UserController@delete');
});


	
Route::get('componentsdata/name_option_list',  function(Request $request){
		$compModel = new App\Models\ComponentsData();
		return $compModel->name_option_list($request);
	}
)->middleware(['auth']);
	
Route::get('componentsdata/asset_option_list',  function(Request $request){
		$compModel = new App\Models\ComponentsData();
		return $compModel->asset_option_list($request);
	}
)->middleware(['auth']);
	
Route::get('componentsdata/role_id_option_list',  function(Request $request){
		$compModel = new App\Models\ComponentsData();
		return $compModel->role_id_option_list($request);
	}
)->middleware(['auth']);
	
Route::get('componentsdata/user_username_value_exist',  function(Request $request){
		$compModel = new App\Models\ComponentsData();
		return $compModel->user_username_value_exist($request);
	}
);
	
Route::get('componentsdata/user_email_value_exist',  function(Request $request){
		$compModel = new App\Models\ComponentsData();
		return $compModel->user_email_value_exist($request);
	}
);
	
Route::get('componentsdata/getcount_collectionsdone',  function(Request $request){
		$compModel = new App\Models\ComponentsData();
		return $compModel->getcount_collectionsdone($request);
	}
)->middleware(['auth']);
	
Route::get('componentsdata/getcount_permissionsinthesystem',  function(Request $request){
		$compModel = new App\Models\ComponentsData();
		return $compModel->getcount_permissionsinthesystem($request);
	}
)->middleware(['auth']);
	
Route::get('componentsdata/getcount_peopleregisteredinsystem',  function(Request $request){
		$compModel = new App\Models\ComponentsData();
		return $compModel->getcount_peopleregisteredinsystem($request);
	}
)->middleware(['auth']);
	
Route::get('componentsdata/getcount_assets',  function(Request $request){
		$compModel = new App\Models\ComponentsData();
		return $compModel->getcount_assets($request);
	}
)->middleware(['auth']);


Route::post('fileuploader/upload/{fieldname}', 'FileUploaderController@upload');
Route::post('fileuploader/s3upload/{fieldname}', 'FileUploaderController@s3upload');
Route::post('fileuploader/remove_temp_file', 'FileUploaderController@remove_temp_file');


/**
 * All static content routes
 */
Route::get('info/about',  function(){
		return view("pages.info.about");
	}
);
Route::get('info/faq',  function(){
		return view("pages.info.faq");
	}
);

Route::get('info/contact',  function(){
	return view("pages.info.contact");
}
);
Route::get('info/contactsent',  function(){
	return view("pages.info.contactsent");
}
);

Route::post('info/contact',  function(Request $request){
		$request->validate([
			'name' => 'required',
			'email' => 'required|email',
			'message' => 'required'
		]);

		$senderName = $request->name;
		$senderEmail = $request->email;
		$message = $request->message;

		$receiverEmail = config("mail.from.address");

		Mail::send(
			'pages.info.contactemail', [
				'name' => $senderName,
				'email' => $senderEmail,
				'comment' => $message
			],
			function ($mail) use ($senderEmail, $receiverEmail) {
				$mail->from($senderEmail);
				$mail->to($receiverEmail)
					->subject('Contact Form');
			}
		);
		return redirect("info/contactsent");
	}
);


Route::get('info/features',  function(){
		return view("pages.info.features");
	}
);
Route::get('info/privacypolicy',  function(){
		return view("pages.info.privacypolicy");
	}
);
Route::get('info/termsandconditions',  function(){
		return view("pages.info.termsandconditions");
	}
);

Route::get('info/changelocale/{locale}', function ($locale) {
	app()->setlocale($locale);
	session()->put('locale', $locale);
    return redirect()->back();
})->name('info.changelocale');