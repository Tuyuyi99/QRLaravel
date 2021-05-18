<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QrController;
use Illuminate\Support\Facades\Storage;

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

Route::get('admin', 'App\Http\Controllers\ServicioController@index')->name('main');

//CRUD de QRs

Route::get('admin/qr', 'App\Http\Controllers\QrController@index')->name('qr.index');
Route::get('admin/qrFormDocumento', 'App\Http\Controllers\QrController@createDocumento')->name('qr.createDocumento');
Route::get('admin/qrFormEnlace', 'App\Http\Controllers\QrController@createEnlace')->name('qr.createEnlace');
Route::post('admin/subirDocumento/qr', '\App\Http\Controllers\QrController@subirDocumento')->name('qr.subirDocumento');
Route::post('admin/storeEnlace/qr', '\App\Http\Controllers\QrController@store')->name('qr.storeEnlace');
Route::patch('admin/update/qr/{id}', 'App\Http\Controllers\QrController@update')->name('qr.update');
Route::delete('admin/destroy/qr/{id}', 'App\Http\Controllers\QrController@destroy')->name('qr.destroy');
Route::get('admin/edit/qr/{id}', 'App\Http\Controllers\QrController@edit')->name('qr.edit');
Route::get('Pdf/{codigo}', '\App\Http\Controllers\QrController@acortarLinkDocumento')->name('acortar.linkDocumento');
Route::get('{codigo}', '\App\Http\Controllers\QrController@acortarLinkEnlace')->name('acortar.linkEnlace');

//CRUD de Servicios

Route::get('admin/servicio/', 'App\Http\Controllers\ServicioController@index')->name('servicio.index');
Route::get('admin/servicioForm', 'App\Http\Controllers\ServicioController@create')->name('servicio.create');
Route::post('admin/store/servicio', '\App\Http\Controllers\ServicioController@store')->name('servicio.store');
Route::patch('admin/update/servicio/{id}', 'App\Http\Controllers\ServicioController@update')->name('servicio.update');
Route::delete('admin/destroy/servicio/{id}', 'App\Http\Controllers\ServicioController@destroy')->name('servicio.destroy');
Route::get('admin/edit/servicio/{id}', 'App\Http\Controllers\ServicioController@edit')->name('servicio.edit');