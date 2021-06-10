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

//Vista del cliente

//Redirigir desde una vista a otra

Route::redirect('admin', 'admin/qr');
Route::redirect('buscador', 'admin');
Route::redirect('home', 'admin');
Route::redirect('/', 'admin');
Route::redirect('/userlog', 'admin');

//CRUD de QRs

Route::get('admin/qr', 'App\Http\Controllers\QrController@index')->name('qr.index');
Route::get('admin/qrFormDocumento', 'App\Http\Controllers\QrController@createDocumento')->name('qr.createDocumento');
Route::get('admin/qrFormEnlace', 'App\Http\Controllers\QrController@createEnlace')->name('qr.createEnlace');
Route::post('admin/subirDocumento/qr', '\App\Http\Controllers\QrController@subirDocumento')->name('qr.subirDocumento');
Route::post('admin/storeEnlace/qr', '\App\Http\Controllers\QrController@store')->name('qr.storeEnlace');
Route::patch('admin/updateEnlace/qr/{id}', 'App\Http\Controllers\QrController@updateEnlace')->name('qr.updateEnlace');
Route::patch('admin/updateDocumento/qr/{id}', 'App\Http\Controllers\QrController@updateDocumento')->name('qr.updateDocumento');
Route::delete('admin/destroy/qr/{id}', 'App\Http\Controllers\QrController@destroy')->name('qr.destroy');
Route::get('admin/editEnlace/qr/{id}', 'App\Http\Controllers\QrController@editEnlace')->name('qr.editEnlace');
Route::get('admin/editDocumento/qr/{id}', 'App\Http\Controllers\QrController@editDocumento')->name('qr.editDocumento');
Route::get('documento/{codigo}', '\App\Http\Controllers\QrController@acortarLinkDocumento')->name('acortar.linkDocumento');
Route::get('qr/{codigo}', '\App\Http\Controllers\QrController@acortarLinkEnlace')->name('acortar.linkEnlace');
Route::get('admin/qr/buscador','\App\Http\Controllers\QrController@buscador')->name('qr.buscador');
Route::get('buscador/filtrar','\App\Http\Controllers\QrController@filtrarServicio')->name('qr.filtrar');


//CRUD de Servicios

Route::get('admin/servicio/', 'App\Http\Controllers\ServicioController@index')->name('servicio.index');
Route::get('admin/servicioForm', 'App\Http\Controllers\ServicioController@create')->name('servicio.create');
Route::post('admin/store/servicio', '\App\Http\Controllers\ServicioController@store')->name('servicio.store');
Route::patch('admin/update/servicio/{id}', 'App\Http\Controllers\ServicioController@update')->name('servicio.update');
Route::delete('admin/destroy/servicio/{id}', 'App\Http\Controllers\ServicioController@destroy')->name('servicio.destroy');
Route::get('admin/edit/servicio/{id}', 'App\Http\Controllers\ServicioController@edit')->name('servicio.edit');

Auth::routes();

//CRUD de Usuarios

Route::get('admin/usuario/', 'App\Http\Controllers\UserController@index')->name('user.index');
Route::delete('admin/destroy/usuario/{id}', 'App\Http\Controllers\UserController@destroy')->name('user.destroy');

//Log de usuarios

Route::post('/userlog', '\App\Http\Controllers\Auth\LoginController@authenticated')->name('userlog.store');