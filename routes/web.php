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

//Home
Route::get('/', 'HomeController@index');

//User
Route::group(['prefix' => 'user'], function(){
    Route::group(['prefix' => 'auth'], function(){
        Route::get('/sign-up', 'User\UserController@signUpPage');
        Route::post('/sign-up', 'User\UserController@signUpProcess');
        Route::get('/sign-in', 'User\UserController@signInPage');
        Route::post('/sign-in', 'User\UserController@signInProcess');
        Route::get('/sign-out', 'User\UserController@signOut');
    });
});

//Merchandise
Route::group(['prefix' => 'merchandise'], function(){
    Route::get('/', 'Merchandise\MerchandiseController@merchandiseListPage');
    Route::get('/create', 'Merchandise\MerchandiseController@merchandiseCreateProcess');
    Route::get('/manage', 'Merchandise\MerchandiseController@merchandiseManageListPage');
    
    Route::group(['prefix' => '{merchandise_id}'], function(){
        Route::get('/', 'Merchandise\MerchandiseController@merchandiseItemPage');
        Route::get('/edit', 'Merchandise\MerchandiseController@merchandiseItemEditPage');
        Route::put('/', 'Merchandise\MerchandiseController@merchandiseItemUpdate');
        Route::post('/', 'Merchandise\MerchandiseController@merchandiseBuyProcess');
    });
});

//Order
Route::group(['prefix' => 'order'], function(){
    Route::get('/', 'Order\OrderController@orderListPage');
});