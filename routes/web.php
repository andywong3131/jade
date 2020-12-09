<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/home', 'App\Http\Controllers\HomeController@index');
Route::get('/about', 'App\Http\Controllers\AboutController@index');
Route::get('/branch', 'App\Http\Controllers\BranchController@index');
Route::post('/branch/store', 'App\Http\Controllers\BranchController@store');
Route::post('/branch/{id}', 'App\Http\Controllers\BranchController@update');
Route::delete('/branch/{id}', 'App\Http\Controllers\BranchController@destroy');
Route::get('/branch/fetchbranchesdata', 'App\Http\Controllers\BranchController@fetchBranchesData')->name('branch.fetchBranchesData');
Route::get('/branch/{id}/fetchbranchdatabyid', 'App\Http\Controllers\BranchController@fetchBranchDataById')->name('fetchBranchDataById');

Route::get('/itemclass', 'App\Http\Controllers\ItemClassController@index');
Route::post('/itemclass/store', 'App\Http\Controllers\ItemClassController@store');
Route::post('/itemclass/{id}', 'App\Http\Controllers\ItemClassController@update');
Route::delete('/itemclass/{id}', 'App\Http\Controllers\ItemClassController@destroy');
Route::get('/itemclass/fetchitemclassesdata', 'App\Http\Controllers\ItemClassController@fetchItemClassesData');
Route::get('/itemclass/{id}/fetchitemclassdatabyid', 'App\Http\Controllers\ItemClassController@fetchItemClassDataById');

Route::get('/supplier', 'App\Http\Controllers\SupplierController@index');
Route::post('/supplier/store', 'App\Http\Controllers\SupplierController@store');
Route::post('/supplier/{id}', 'App\Http\Controllers\SupplierController@update');
Route::delete('/supplier/{id}', 'App\Http\Controllers\SupplierController@destroy');
Route::get('/supplier/fetchsuppliersdata', 'App\Http\Controllers\SupplierController@fetchSuppliersData');
Route::get('/supplier/{id}/fetchsupplierdatabyid', 'App\Http\Controllers\SupplierController@fetchSupplierDataById');


Route::get('/item', 'App\Http\Controllers\ItemController@index');
Route::post('/item/store', 'App\Http\Controllers\ItemController@store');
Route::post('/item/{id}', 'App\Http\Controllers\ItemController@update');
Route::delete('/item/{id}', 'App\Http\Controllers\ItemController@destroy');
Route::get('/item/fetchitemsdata', 'App\Http\Controllers\ItemController@fetchItemsData');
Route::get('/item/{id}/fetchitemdatabyid', 'App\Http\Controllers\ItemController@fetchItemDataById');



Route::get('/itemin', 'App\Http\Controllers\ItemInController@index');
Route::get('/itemin/search', 'App\Http\Controllers\ItemInController@search');
Route::get('/itemin/createitemin', 'App\Http\Controllers\ItemInController@createItemIn');
Route::get('/itemin/store', 'App\Http\Controllers\ItemInController@store');
Route::get('/itemin/test/{data}', 'App\Http\Controllers\ItemInController@test');
Route::get('/itemin/test2', 'App\Http\Controllers\ItemInController@test2');
// Route::get('/itemin/fetchiteminsdata', 'App\Http\Controllers\ItemInController@fetchItemInsData');
Route::get('/itemin/fetchcontrolnumber', 'App\Http\Controllers\ItemInController@fetchControlNumber');
Route::get('/itemin/fetchiteminsdata', 'App\Http\Controllers\ItemInController@fetchItemInsData');



Route::get('/sale', 'App\Http\Controllers\SaleController@index');
Route::get('/sale/create', 'App\Http\Controllers\SaleController@create');
Route::get('/sale/fetchserialnumbers/{itemId}/{branchId}', 'App\Http\Controllers\SaleController@fetchSerialNumbers');
Route::get('/itemin/search', 'App\Http\Controllers\ItemInController@search');
Route::get('/itemin/createitemin', 'App\Http\Controllers\ItemInController@createItemIn');
Route::get('/itemin/store', 'App\Http\Controllers\ItemInController@store');
Route::get('/itemin/fetchcontrolnumber', 'App\Http\Controllers\ItemInController@fetchControlNumber');
Route::get('/itemin/fetchiteminsdata', 'App\Http\Controllers\ItemInController@fetchItemInsData');
// Route::post('/item/store', 'App\Http\Controllers\ItemController@store');
// Route::post('/item/{id}', 'App\Http\Controllers\ItemController@update');
// Route::delete('/item/{id}', 'App\Http\Controllers\ItemController@destroy');
// Route::get('/item/fetchitemsdata', 'App\Http\Controllers\ItemController@fetchItemsData');
// Route::get('/item/{id}/fetchitemdatabyid', 'App\Http\Controllers\ItemController@fetchItemDataById');