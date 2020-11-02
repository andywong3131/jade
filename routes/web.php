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