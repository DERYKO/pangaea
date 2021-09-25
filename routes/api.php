<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/subscribe/{topic}', 'HttpNotificationController@subscribe');
Route::post('/publish/{topic}', 'HttpNotificationController@publish');
Route::post('/test1', 'HttpNotificationController@message');
Route::post('/test2', 'HttpNotificationController@message');

