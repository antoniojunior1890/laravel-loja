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


Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'auth'], function(){
    

    Route::get('/', 'AdminController@index')->name('admin.home');



    Route::resource('category', 'CategoryController');

    Route::resource('product', 'ProductController');

    Route::resource('stock', 'StockController');

    Route::resource('purchases', 'PurchaseController');

    Route::get('purchases-products/{id}', 'PurchaseController@products')->name('purchases.products');

    Route::get('purchases-autocomplete', 'PurchaseController@autocomplete')->name('purchases.autocomplete');

    Route::get('add-cart-purchases/{id}', 'PurchaseController@addProductCartPurchase')->name('add.cart.purchase');

    Route::get('remove-cart-purchases/{id}', 'PurchaseController@removeProductCartPurchase')->name('remove.cart.purchase');

    Route::get('empty-cart-purchases', 'PurchaseController@emptyPurchase')->name('empty.cart.purchase');

    Route::get('remove-product-purchases/{id}', 'PurchaseController@removeProductPurchase')->name('remove.product.cart.purchase');

    Route::get('save-purchases', 'PurchaseController@savePurchase')->name('save.purchase');

    /**************************************************************************************/

    Route::get('carrinho','CartController@cart')->name('cart');

    Route::get('carrinho-test/{id}','CartController@cartTeste')->name('cart.test');

    Route::get('product-autocomplete', 'CartController@autocomplete')->name('product.autocomplete');

    Route::get('add-cart/{id}', 'CartController@add')->name('add.cart');

    Route::get('remove-cart/{id}', 'CartController@remove')->name('remove.cart');

    Route::get('empty-cart', 'CartController@empty')->name('empty.cart');

    Route::get('remove-product-cart/{id}', 'CartController@removeProduct')->name('remove.product.cart');

    Route::get('save-order', 'OrderController@saveOrder')->name('save.order');

    Route::get('orders', 'OrderController@orders')->name('orders');

    Route::get('details-order/{id}', 'OrderController@detailsOrder')->name('details.order');

    Route::get('pay-order/{id}', 'OrderController@payOrderExisting')->name('pay.order.existing');

    Route::get('paid-orders', 'OrderController@paidOrders')->name('paid.orders');

    Route::get('create-order-paid', 'OrderController@createOrderPaid')->name('create.order.paid');

    Route::get('sales-month', 'AdminController@salesMonth')->name('sales.month');

    Route::get('sales-week', 'AdminController@salesWeek')->name('sales.week');



});

Route::get('/', 'Admin\AdminController@index')->name('home')->middleware('auth');
//Route::get('/', 'Site\SiteController@index')->name('home');

Auth::routes();

