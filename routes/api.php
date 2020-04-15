<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('signup','UserController@create');
Route::post('resend_code','UserController@resend_code');
Route::post('verification','UserController@verification');
Route::post('signin','UserController@login');
Route::post('forgetpassword','UserController@forgetpassword');
Route::post('update_profile','UserController@update');
Route::post('update_profile_pic','UserController@update_profile_pic');
Route::post('get_profile','UserController@get_profile');
Route::post('change_password','UserController@change_password');
Route::post('logout','UserController@logout');
Route::get('ads','ApiController@ads');
Route::post('/deleteuser', 'UserController@deleteuser');

/***************************** Categories ****************************/
Route::post('get_categories','ApiController@get_categories');
Route::get('get_category','ApiController@get_category');

/***************************** Products ****************************/
Route::post('get_product_by_category_id','ApiController@get_product_by_category_id');
Route::post('get_product_by_category_ids','ApiController@get_product_by_category_ids');
Route::post('get_product_by_product_name','ApiController@get_product_by_product_name');
Route::post('get_product_by_product_names','ApiController@get_product_by_product_names');
Route::get('aboutus','ApiController@aboutus');
Route::get('faq','ApiController@faq');
Route::post('contactus','ApiController@contactus');
Route::post('products_information','ApiController@products_information');

/***************************** Cart ****************************/
Route::post('add_cart','ApiController@add_cart');
Route::post('update_cart','ApiController@update_cart');
Route::post('cancel_cart_item','ApiController@cancel_cart_item');
Route::post('get_cart','ApiController@get_cart');
Route::post('delete_cart','ApiController@delete_cart');
/**************************** Order ****************************/

Route::post('add_order','ApiController@add_order');
Route::post('cancel_order','ApiController@cancel_order');
Route::post('/get_orders', 'ApiController@get_orders');

/**************************** Other ****************************/
Route::get('aboutus','ApiController@aboutus');
Route::get('faq','ApiController@faq');
Route::post('contactus','ApiController@contactus');


/**************************** Address ****************************/

Route::post('add_address','ApiController@add_address');
Route::post('get_address','ApiController@get_address');
Route::get('get_region','ApiController@get_region');
Route::post('get_cities','ApiController@get_cities');
Route::post('next_previous_caegory','ApiController@next_previous_caegory');



/**************************** Next Category ****************************/
Route::post('update_address','ApiController@update_address');

/**************************** Notification ****************************/
Route::post('get_notification','ApiController@get_notification');

/**************************** Ads ****************************/


/***************************** Hasan ****************************/

Route::post('getjwt','ApiController@getjwt');
Route::post('getjwtvideo','ApiController@getjwtvideo');
