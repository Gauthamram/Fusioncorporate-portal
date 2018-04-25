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

Route::get('/', function () {
    return redirect('/dashboard');
});


Route::group(['middleware' => 'api'], function () {
    Route::get('dashboard', 'HomeController@dashboard');

    Route::post('setting', 'HomeController@setting');
    Route::get('setting', 'HomeController@setting');

    Route::get('print-shop', 'PrintController@index');
    Route::post('printer/setting','PrintController@printersetting');
    Route::get('printer/setting','PrintController@printersetting');
    Route::get('printer/samplelabels','LabelController@printsamples');

    Route::get('label/rawdata/{id}', 'PrintController@rawdata');
    Route::get('label/archive/{id}', 'PrintController@archive');
    Route::post('label/create/ticket', 'LabelController@createticket');
    Route::get('label/order/{order?}', 'OrderController@orderdetails');

    Route::post('label/orders/search', 'OrderController@orderlist');
    Route::get('label/orders', 'OrderController@orderlist');
    Route::get('label/order/download/{order_no}/{format}', 'OrderController@download');

    Route::post('label/carton/search', 'LabelController@search');
    Route::get('label/carton/search', 'LabelController@search');

    Route::get('label/history', 'LabelController@history');
    Route::get('label/reprint/{order_no}', 'LabelController@reprint');
    Route::get('label/print/cartons/{order?}', 'LabelController@printcartons');
    Route::get('label/print/stickies/{order?}', 'LabelController@printstickies');
    Route::get('label/print/{cartontype}/{order_no}/{item}', 'LabelController@printcartontype');

    Route::post('label/items', 'ItemController@itemlist');
    Route::get('label/items', 'ItemController@itemlist');

    Route::post('label/print/mixed/{order?}', 'LabelController@printmixed');
    Route::post('label/print/item', 'LabelController@printitem');
    Route::get('users', 'UserController@users');

    Route::post('user/new', 'UserController@create');
    Route::get('user/new', 'UserController@create');

    Route::post('users/search', 'UserController@search');

    Route::get('user/logout', 'UserController@logout');

    Route::get('suppliers', 'SupplierController@index');
    Route::get('supplier/search/{term?}', 'SupplierController@search');
    Route::post('supplier/search/', 'SupplierController@search');

    Route::get('usermanual', 'HomeController@usermanual');

    Route::get('promise/certificate', 'PrintController@promise_certificate');
    Route::get('promise/signature', 'PrintController@promise_signature');
});

Route::post('user/recovery', 'UserController@recovery');
Route::get('user/recovery/{id?}', 'UserController@recovery');

Route::post('login', 'AuthenticateController@login');
Route::get('login', 'AuthenticateController@login');

Route::post('reset_password/{token}', 'UserController@reset');
Route::get('reset_password/{token}', 'UserController@reset');
//Route::get('portal/print-shop', 'PrintController@index');
