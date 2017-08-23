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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/matching',['as' => 'Matching', 'uses' => 'Aitai@matching']);

Route::get('/getuser',['as' => 'getUser','uses' => 'Aitai@getAllUser']);

Route::get('/demo',['as' => 'Demo','uses' => 'Aitai@demo']);