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

Route::get('/',             ['as' => 'frontend.index' , 'uses' => 'Frontend\IndexController@index']);


// Front end Auth Routes 
// Auth::routes();
Route::get('/login',                            ['as' => 'frontend.show_login_form',        'uses' => 'Frontend\Auth\LoginController@showLoginForm']);
Route::post('login',                            ['as' => 'frontend.login',                  'uses' => 'Frontend\Auth\LoginController@login']);
Route::post('logout',                           ['as' => 'frontend.logout',                 'uses' => 'Frontend\Auth\LoginController@logout']);
Route::get('register',                          ['as' => 'frontend.show_register_form',     'uses' => 'Frontend\Auth\RegisterController@showRegistrationForm']);
Route::post('register',                         ['as' => 'frontend.register',               'uses' => 'Frontend\Auth\RegisterController@register']);
Route::get('password/reset',                    ['as' => 'password.request',                'uses' => 'Frontend\Auth\ForgotPasswordController@showLinkRequestForm']);
Route::post('password/email',                   ['as' => 'password.email',                  'uses' => 'Frontend\Auth\ForgotPasswordController@sendResetLinkEmail']);
Route::get('password/reset/{token}',            ['as' => 'password.reset',                  'uses' => 'Frontend\Auth\ResetPasswordController@showResetForm']);
Route::post('password/reset',                   ['as' => 'password.update',                 'uses' => 'Frontend\Auth\ResetPasswordController@reset']);
Route::get('email/verify',                      ['as' => 'verification.notice',             'uses' => 'Frontend\Auth\VerificationController@show']);
Route::get('/email/verify/{id}/{hash}',         ['as' => 'verification.verify',             'uses' => 'Frontend\Auth\VerificationController@verify']);
Route::post('email/resend',                     ['as' => 'verification.resend',             'uses' => 'Frontend\Auth\VerificationController@resend']);


/// Admin
Route::group(['prefix' => 'admin' ] , function (){
    Route::get('/login',                            ['as' => 'admin.show_login_form',        'uses' => 'Frontend\Auth\LoginController@showLoginForm']);
    Route::post('login',                            ['as' => 'admin.login',                  'uses' => 'Frontend\Auth\LoginController@login']);
    Route::post('logout',                           ['as' => 'admin.logout',                 'uses' => 'Frontend\Auth\LoginController@logout']);
    Route::get('password/reset',                    ['as' => 'admin.password.request',                'uses' => 'Frontend\Auth\ForgotPasswordController@showLinkRequestForm']);
    Route::post('password/email',                   ['as' => 'admin.password.email',                  'uses' => 'Frontend\Auth\ForgotPasswordController@sendResetLinkEmail']);
    Route::get('password/reset/{token}',            ['as' => 'admin.password.reset',                  'uses' => 'Frontend\Auth\ResetPasswordController@showResetForm']);
    Route::post('password/reset',                   ['as' => 'admin.password.update',                 'uses' => 'Frontend\Auth\ResetPasswordController@reset']);
    Route::get('email/verify',                      ['as' => 'admin.verification.notice',             'uses' => 'Frontend\Auth\VerificationController@show']);
    Route::get('/email/verify/{id}/{hash}',         ['as' => 'admin.verification.verify',             'uses' => 'Frontend\Auth\VerificationController@verify']);
    Route::post('email/resend',                     ['as' => 'admin.verification.resend',             'uses' => 'Frontend\Auth\VerificationController@resend']);

});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
