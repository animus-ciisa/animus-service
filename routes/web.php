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
    Route::post('insert','HomeController@store');
});

Route::group(['prefix' => '/api/auth'], function() {
    Route::get('qr/{idHabitant}', 'AuthController@qrGenerate');
    Route::post('renew','AuthController@renew')->middleware('jwt.auth');
    Route::post('/','AuthController@authenticate');
    Route::post('recover-password','AuthController@recoverPassword');
});

Route::resource('/api/camera','CameraController');
Route::group(['prefix' => '/api/camera'], function() {
});

Route::resource('/api/habitant','HabitantController');
Route::group(['prefix' => '/api/habitant'], function() {
    Route::post('{idHabitant}/images','HabitantController@storeImage');
    Route::put('{idHabitant}/images/{idImage}','HabitantController@updateImage');
    Route::post('user', 'HabitantController@user');
    Route::delete('user/{habitantId}', 'HabitantController@deleteUser');
});

Route::resource('/api/user','UserController');
Route::group(['prefix' => '/api/user'], function() {
    Route::post('auth','UserController@authenticate');
    Route::post('auth/renew', 'UserController@renew');
});

Route::resource('/api/alarms/in-time-range','AlarmInTimeRangeController');
Route::group(['prefix' => '/api/alarms'], function() {
    Route::post('detection','AlarmInTimeRangeController@detection');
    Route::put('{idAlarma}','AlarmInTimeRangeController@update');
});
