<?php
use GuzzleHttp\Client;

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
    //Route::put('{idHabitant}','HabitantController@update');
    //Route::delete('{idHabitant}','HabitantController@destroy');    
    //Route::put('{idHabitant}','HabitantController@update');
    Route::put('{idHabitant}/images/{idImage}','HabitantController@updateImage');
});

Route::resource('/api/user','UserController');
Route::group(['prefix' => '/api/user'], function() {
    Route::post('auth','UserController@authenticate');
    Route::post('auth/renew','UserController@renew');
    Route::post('notify', function(){
        $client = new Client(['headers' => [
            'Authorization' => 'key=AIzaSyD004GHyZqw75enxwCJHbhUUEHOFgaiQZw',
            'content-type' => 'application/json'
        ]]);
        $res = $client->post('https://fcm.googleapis.com/fcm/send', ['body' => json_encode([
            "data" => [
                "title" => "Hola mundo animus",
                "message" => "Que sucede con los animus ???"
            ],
            "to" => "e9ilCBL70ns:APA91bFgTT3Wk8aSlTUkF4hGZTFkt1yz1a145xd-rwO8gxVm3HcgbTKVW-CBxKZOoJAyU8L3rzM04mduCAyOyH6ZinXJStZM68PQStRuOFqy7-pdEy78SbcXFoVCyd9u0Pw8gTsalSYvHjOFarKCE7vyrWmTWcR0ig"
        ])]);
        return ['message' => json_decode($res->getBody())];
    });
});

Route::resource('/api/alarms/in-time-range','AlarmInTimeRangeController');
Route::group(['prefix' => '/api/alarms'], function() {
    Route::post('detection','AlarmInTimeRangeController@detection');
    Route::put('{idAlarma}','AlarmInTimeRangeController@update');
}); 


