<?php

//Home
Route::get('/', 'HomeController@index');
//Info
Route::get('/infos', 'HomeController@infoPage');
//Contact
Route::get('/contact', 'HomeController@contactPage');

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
    Route::get('/merchandiseType/{merchandiseType_id}', 'Merchandise\MerchandiseController@merchandiseTypeListPage');
    //搜查商品
    Route::post('search', 'Merchandise\MerchandiseController@search');
    
    Route::group(['middleware' => ['user.auth.admin']], function() {
        //取得新增產品頁
        Route::get('/create', 'Merchandise\MerchandiseController@merchandiseCreatePage');
        //管理產品頁
        Route::get('/manage', 'Merchandise\MerchandiseController@merchandiseManageListPage');
        //新增產品
        Route::post('/create', 'Merchandise\MerchandiseController@merchandiseCreateProcess'); 
        //取得商品目錄清單頁
        Route::get('/cataloguesListPage', 'Merchandise\MerchandiseController@merchandiseCataloguesListPage');
        
        //API for admin
        Route::group(['prefix' => 'api'], function(){
            //取得全部的分類
            Route::get('/getCataloguesListDatas', 'Merchandise\MerchandiseController@getCataloguesListDatas');
            //取得主大類
            Route::get('/getCataloguesListDatasGroup', 'Merchandise\MerchandiseController@getCataloguesListDatasGroup');
            //取得子類
            Route::get('/getCataloguesListDatasSubGroup', 'Merchandise\MerchandiseController@getCataloguesListDatasSubGroup');
            
            Route::post('/addMainType', 'Merchandise\MerchandiseController@addMainType');
            Route::post('/addSubType', 'Merchandise\MerchandiseController@addSubType');
            Route::delete('/deleteType/{id}', 'Merchandise\MerchandiseController@deleteType');
            Route::put('/changeTypeName', 'Merchandise\MerchandiseController@changeTypeName');
        });
    });
    
    Route::group(['prefix' => '{merchandise_id}'], function(){

        //Admin
        Route::group(['middleware' => ['user.auth.admin']], function() {
            //取得修改產品頁
            Route::get('/edit', 'Merchandise\MerchandiseController@merchandiseItemEditPage');
            //修改產品頁
            Route::put('/update', 'Merchandise\MerchandiseController@merchandiseItemUpdate');
        });
        
        //使用者的單項產品購買頁
        Route::get('/', 'Merchandise\MerchandiseController@merchandiseItemPage');
        //按了購買按鈕
        Route::post('/', 'Merchandise\MerchandiseController@merchandiseBuyProcess')->middleware(['user.auth']);
    });
});


Route::group(['prefix' => 'order'], function(){
    Route::group(['prefix' => 'admin', 'middleware' => ['user.auth.admin']], function(){
        Route::get('/mange', 'Order\OrderController@orderAdminMangePage');
        Route::post('/search', 'Order\OrderController@orderSearch');
        Route::get('/edit/{order_id}', 'Order\OrderController@orderEditPage');
        Route::put('/edit/{order_id}', 'Order\OrderController@orderEditProcess');
    });
});

//Order User Only
Route::group(['prefix' => 'cart', 'middleware' => ['user.auth']], function(){
    //取得購物車頁面
    Route::get('/', 'Order\OrderController@cartPage');
    //checkout page
    Route::get('/checkout', 'Order\OrderController@checkoutPage');
    //checkout post
    Route::post('/checkoutProcess', 'Order\OrderController@checkoutProcess');

    //API
    Route::group(['prefix' => 'api'], function(){
        //新增購物車物品
        Route::post('/add', 'Order\OrderController@addItem');
        //delete
        Route::put('/del', 'Order\OrderController@delItem');
        //change buy num
        Route::put('/changeBuyCount', 'Order\OrderController@changeBuyCount');
    });
});