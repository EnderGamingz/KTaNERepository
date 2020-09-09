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

Auth::routes();

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

Route::resource('/modules', 'ModuleController');
Route::patch('/modules/{module}/approve', 'ModuleController@approve')->name('modules.approve');
Route::post('/modules/{module}/capabilities', 'ModuleCapabilityController@store')->name('modules.capabilities.store');
Route::delete('/modules/{module}/capabilities/{capability}', 'ModuleCapabilityController@destroy')->name('modules.capabilities.destroy');