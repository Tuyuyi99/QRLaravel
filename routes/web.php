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

Route::get('admin', 'App\Http\Controllers\ServicioController@index')->name('main');

//CRUD de QRs

Route::get('admin/qr', 'App\Http\Controllers\QrController@index')->name('qr.index');
Route::get('admin/qrForm', 'App\Http\Controllers\QrController@create')->name('qr.create');
Route::post('admin/store/qr', '\App\Http\Controllers\QrController@store')->name('qr.store');
Route::patch('admin/update/qr/{id}', 'App\Http\Controllers\QrController@update')->name('qr.update');
Route::delete('admin/destroy/qr/{id}', 'App\Http\Controllers\QrController@destroy')->name('qr.destroy');
Route::get('admin/edit/qr/{id}', 'App\Http\Controllers\QrController@edit')->name('qr.edit');
Route::get('{codigo}', '\App\Http\Controllers\QrController@acortarLink')->name('acortar.link');

//CRUD de Servicios

Route::get('admin/servicio/', 'App\Http\Controllers\ServicioController@index')->name('servicio.index');
Route::get('admin/servicioForm', 'App\Http\Controllers\ServicioController@create')->name('servicio.create');
Route::post('admin/store/servicio', '\App\Http\Controllers\ServicioController@store')->name('servicio.store');
Route::patch('admin/update/servicio/{id}', 'App\Http\Controllers\ServicioController@update')->name('servicio.update');
Route::delete('admin/destroy/servicio/{id}', 'App\Http\Controllers\ServicioController@destroy')->name('servicio.destroy');
Route::get('admin/edit/servicio/{id}', 'App\Http\Controllers\ServicioController@edit')->name('servicio.edit');

//CRUD de Documentos

Route::get('admin/documento/', 'App\Http\Controllers\DocumentoController@index')->name('documento.index');
Route::get('admin/documentoForm', 'App\Http\Controllers\DocumentoController@create')->name('documento.create');
Route::post('admin/store/documento', '\App\Http\Controllers\DocumentoController@store')->name('documento.store');
Route::patch('admin/update/documento/{id}', 'App\Http\Controllers\DocumentoController@update')->name('documento.update');
Route::delete('admin/destroy/documento/{id}', 'App\Http\Controllers\DocumentoController@destroy')->name('documento.destroy');
Route::get('admin/edit/documento/{id}', 'App\Http\Controllers\DocumentoController@edit')->name('documento.edit');