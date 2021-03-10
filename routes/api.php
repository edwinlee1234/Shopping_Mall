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

//API
Route::group(['prefix' => 'cart', 'middleware' => ['api.user.auth']], function(){
    //新增購物車物品
    Route::post('/add', 'Order\OrderController@addItem');
    //delete
    Route::put('/del', 'Order\OrderController@delItem');
    //change buy num
    Route::put('/changeBuyCount', 'Order\OrderController@changeBuyCount');
});