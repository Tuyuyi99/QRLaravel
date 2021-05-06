<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QrController;
use App\Http\Controllers\AcortadorController;

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
Route::get('admin/qrForm', 'App\Http\Controllers\QrController@create')->name('qr.create');
Route::post('admin/store', '\App\Http\Controllers\QrController@store')->name('qr.store');
Route::patch('admin/update/{id}', 'App\Http\Controllers\QrController@update')->name('qr.update');
Route::delete('admin/destroy/{id}', 'App\Http\Controllers\QrController@destroy')->name('qr.destroy');
Route::get('admin/edit/{id}', 'App\Http\Controllers\QrController@edit')->name('qr.edit');
Route::get('admin/pdf/{id}', 'App\Http\Controllers\QrController@show')->name('qr.show');

Route::get('admin/acortador', 'App\Http\Controllers\AcortadorController@index')->name('acortador.index');
Route::get('admin/acortadorForm', 'App\Http\Controllers\AcortadorController@create')->name('acortador.create');
Route::get('admin/acortadorEdit/{id}', 'App\Http\Controllers\AcortadorController@edit')->name('acortador.edit');
Route::patch('admin/acortador/update/{id}', 'App\Http\Controllers\AcortadorController@update')->name('acortador.update');
Route::delete('admin/acortador/destroy/{id}', 'App\Http\Controllers\AcortadorController@destroy')->name('acortador.destroy');
Route::post('admin/acortador/store', '\App\Http\Controllers\AcortadorController@store')->name('acortador.store');
Route::get('{codigo}', '\App\Http\Controllers\QrController@acortarLink')->name('acortar.link');