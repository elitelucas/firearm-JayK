<?php
use Illuminate\Support\Facades\Route;
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

Auth::routes();

Route::get('admin-users', 'AdminUserController@index');
Route::get('admin-users/payout', 'AdminUserController@togglePayout');
Route::get('admin-users/manage/{id}', 'AdminUserController@manage');
Route::get('admin-users/save', 'AdminUserController@save');
Route::get('admin-users/delete/{id}', 'AdminUserController@delete');
Route::get('admin-users/save_commission_fee', 'AdminUserController@saveCommissionFee');

Route::get('customers', 'CustomerController@index');
Route::get('customers/registration/{id}', 'CustomerController@register');
Route::get('customers/select_location', 'CustomerController@select_location');
Route::get('customers/select_class_date', 'CustomerController@select_class_date');
Route::get('customers/select_QTY', 'CustomerController@select_qty');
Route::post('customers/save', 'CustomerController@save');
Route::get('customers/confirmation', 'CustomerController@confirm');
Route::get('customers/payout', 'CustomerController@payout');
Route::get('customers/checkout', 'CustomerController@checkout');

Route::get('dashboard', 'UserController@index');
Route::get('contacts-profile/edit', 'UserController@editProfile');
Route::post('contacts-profile/save', 'UserController@updateProfile');
Route::get('contacts-profile/save_commission_fee', 'UserController@saveCommissionFee');
Route::get('contacts-profile/save_customer_message', 'UserController@saveCustomerMessage');
Route::get('contacts-profile/check_category', 'UserController@checkCategory');

Route::get('pages-login', 'SkoteController@index');
Route::get('pages-login-2', 'SkoteController@index');
Route::get('pages-register', 'SkoteController@index');
Route::get('pages-register-2', 'SkoteController@index');
Route::get('pages-recoverpw', 'SkoteController@index');
Route::get('pages-recoverpw-2', 'SkoteController@index');
Route::get('pages-lock-screen', 'SkoteController@index');
Route::get('pages-lock-screen-2', 'SkoteController@index');
Route::get('pages-404', 'SkoteController@index');
Route::get('pages-500', 'SkoteController@index');
Route::get('pages-maintenance', 'SkoteController@index');
Route::get('pages-comingsoon', 'SkoteController@index');

Route::post('keep-live', 'SkoteController@live');

Route::get('index/{locale}', 'LocaleController@lang');

Route::get('auth/{provider}', 'Auth\RegisterController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\RegisterController@handleProviderCallback');

//Add routes before this line only

Route::get('/', 'HomeController@root');