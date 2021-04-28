<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QrController;

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

//CRUD de QRs para el administrador.

Route::get('admin', 'App\Http\Controllers\QrController@index')->name('qr.index');
Route::get('admin/download', 'App\Http\Controllers\QrController@download')->name('qr.download');
Route::get('admin/qrForm', 'App\Http\Controllers\QrController@create')->name('qr.create');
Route::post('admin/store', '\App\Http\Controllers\QrController@store')->name('qr.store');
Route::patch('admin/update/{id}', 'App\Http\Controllers\QrController@update')->name('qr.update');
Route::delete('admin/destroy/{id}', 'App\Http\Controllers\QrController@destroy')->name('qr.destroy');
Route::get('admin/edit/{id}', 'App\Http\Controllers\QrController@edit')->name('qr.edit');