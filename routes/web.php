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
Route::get('/',function(){
    return ['message' => 'Hello GCLOUD'];
});    
Route::resource('/api/home','HomeController');
Route::group(['prefix' => '/api/home'], function() {
    Route::post('validate-password','HomeController@validateMail');    
});

Route::group(['prefix' => '/api/auth'], function() {
    Route::post('renew','AuthController@renew')->middleware('jwt.auth');
});