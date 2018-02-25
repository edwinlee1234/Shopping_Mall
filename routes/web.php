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

//Admin
Route::group(['prefix' => 'admin'], function(){
    Route::get('/', 'HomeController@adminIndex')->middleware(['user.auth.admin']);
    Route::get('/sign-in', 'User\UserController@adminSignInPage');
});


//User
Route::group(['prefix' => 'user'], function(){
    Route::group(['prefix' => 'auth'], function(){
        Route::get('/sign-up', 'User\UserController@signUpPage');
        Route::post('/sign-up', 'User\UserController@signUpProcess');
        Route::get('/sign-in', 'User\UserController@signInPage');
        Route::post('/sign-in', 'User\UserController@signInProcess');
        Route::get('/sign-out', 'User\UserController@signOut');
        Route::post('/admin-sign-in', 'User\UserController@adminSignInProcess');
    });
});

//Merchandise
Route::group(['prefix' => 'merchandise'], function(){
    //使用者的產品清單
    Route::get('/', 'Merchandise\MerchandiseController@merchandiseListPage');
    
    Route::group(['middleware' => ['user.auth.admin']], function() {
        //取得新增產品頁
        Route::get('/create', 'Merchandise\MerchandiseController@merchandiseCreatePage');
        //管理產品頁
        Route::get('/manage', 'Merchandise\MerchandiseController@merchandiseManageListPage');
        //新增產品
        Route::post('/create', 'Merchandise\MerchandiseController@merchandiseCreateProcess'); 
    });
    
    Route::group(['prefix' => '{merchandise_id}'], function(){
        
        Route::group(['middleware' => ['user.auth.admin']], function() {
            //取得修改產品頁
            Route::get('/edit', 'Merchandise\MerchandiseController@merchandiseItemEditPage');
            //修改產品頁
            Route::put('/', 'Merchandise\MerchandiseController@merchandiseItemUpdate');
        });
        
        ////使用者的單項產品購買頁
        Route::get('/', 'Merchandise\MerchandiseController@merchandiseItemPage');
        //按了購買按鈕
        Route::post('/', 'Merchandise\MerchandiseController@merchandiseBuyProcess')->middleware(['user.auth']);
    });
});

//Order
Route::group(['prefix' => 'order', 'middleware' => ['user.auth']], function(){
    //取得購物車頁面
    Route::get('/', 'Order\OrderController@orderListPage');
});