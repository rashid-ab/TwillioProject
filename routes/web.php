<?php

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

// Route::get('/', function () {
//     // return view('welcome');

//     $exitCode = Artisan::call('config:clear');
//     $exitCode = Artisan::call('cache:clear');
//     $exitCode = Artisan::call('config:cache');
//     return 'DONE'; //Return anything
// });
// die;
// Auth::routes();

Route::get('/curl','UserController@curl');

Route::get('/', function () {

    return view('index');
});
Route::post('/zip','UserController@zip');
Route::get('/zip','UserController@zip_index');
Route::get('/login', 'UserController@index');

Route::post('/submit_login', 'UserController@logins');


Route::group(['middleware'=>'logins'],function(){

Route::group(['middleware'=>'superadmin'],function(){
Route::get('/manage_admins', 'UserController@manage_admins');
Route::get('/new_admin', 'UserController@new_admin');
Route::post('/new_admin', 'UserController@add_admin');
Route::get('/block_admin/{id}', 'UserController@block_admin');
Route::get('/un_block_admin/{id}', 'UserController@un_block_admin');

});

Route::get('/home', 'HomeController@index')->name('home');



Route::get('/logout', 'UserController@get_logout');

Route::post('/email_send','UserController@email_send');



// Route::post('/create_employee','UserController@create_employee');





Route::get('/share_data/{id}', 'UserController@share_data');


Route::get('/dashboard', 'UserController@index');
Route::get('/manage_user', 'UserController@manage_user');
Route::get('/block_user/{id}', 'UserController@block_user');
Route::get('/un_block_user/{id}', 'UserController@un_block_user');
Route::get('/block_employee/{id}', 'UserController@block_employee');
Route::get('/un_block_employee/{id}', 'UserController@un_block_employee');
Route::post('/block_order/{id}', 'UserController@block_order');
Route::get('/un_block_order/{id}', 'UserController@un_block_order');
Route::get('/get_details/{id}', 'UserController@get_users');
Route::get('/delete_user/{id}', 'UserController@delete_user');




/****************** Bilal ******************************************/

Route::get('/pust_notification', 'UserController@pust_notification');
Route::post('/send_push_notification', 'UserController@send_push');

/****************** Bilal ******************************************/

Route::get('/manage_rates', 'UserController@manage_rates');
Route::get('/edit_rate/{id}', 'UserController@edit_rate');
Route::get('/delete_rate/{id}', 'UserController@delete_rate');

/****************** Zaid ******************************************/
Route::get('/delete_event/{id}','UserController@delete_event');
Route::get('/changePassword','UserController@changepassword');
Route::get('/changePassword','UserController@changepassword');
Route::get('/change_password/{id}','UserController@employee_change');
Route::post('/change_password_employee','UserController@employee_change_password');
Route::post('/send_pass_var','UserController@sendPasswordVar');


Route::get('password', 'UserController@password');
Route::post('password', 'UserController@mit');



/******************** Category **********************/

Route::get('manage_category','UserController@manage_category');
Route::get('new_category','UserController@new_category');
Route::get('edit_category/{id}','UserController@edit_category');
Route::post('new_category','UserController@add_category');
Route::post('update_category','UserController@update_category');
Route::get('/block_category/{id}', 'UserController@block_category');
Route::get('/un_block_category/{id}', 'UserController@un_block_category');
Route::get('/delete_category/{id}', 'UserController@delete_category');
Route::get('/get_category/{id}', 'UserController@get_category');
Route::post('/change_order_category','UserController@change_order_category');
/******************** Product **********************/

Route::get('manage_product','UserController@manage_product');
Route::get('new_product','UserController@new_product');
Route::get('edit_product/{id}','UserController@edit_product');
Route::post('new_product','UserController@add_product');
Route::post('update_product','UserController@update_product');
Route::get('/block_product/{id}', 'UserController@block_product');
Route::get('/un_block_product/{id}', 'UserController@un_block_product');
Route::get('/delete_product/{id}', 'UserController@delete_product');
Route::get('/get_product/{id}', 'UserController@get_product');
Route::post('/change_order_product','UserController@change_order_product');
Route::post('/product_search','UserController@product_search');


/******************** Order **********************/

Route::get('manage_order','UserController@manage_order');
Route::get('/block_order/{id}', 'UserController@block_order');
Route::get('/un_block_order/{id}', 'UserController@un_block_order');
Route::get('/pending_payment_status/{id}', 'UserController@pending_payment_status');
Route::get('/paid_payment_status/{id}', 'UserController@paid_payment_status');
Route::post('/order_status/{id}', 'UserController@order_status');
Route::get('/orderdetail/{id}', 'UserController@orderdetail');


/******************** Ad's **********************/

Route::get('/manage_ads','UserController@manage_ads');
Route::get('/add_ads','UserController@add_ads');
Route::post('/add_ads','UserController@save_ad');
Route::get('/block_ad/{id}','UserController@block_ad');
Route::get('/un_block_ad/{id}','UserController@un_block_ad');
Route::get('/delete_ad/{id}','UserController@delete_ad');
Route::get('/edit_ad/{id}','UserController@edit_ad');
Route::post('/edit_ad/{id}','UserController@update_ad');
Route::get('/ad_details/{id}','UserController@ad_details');

 });


