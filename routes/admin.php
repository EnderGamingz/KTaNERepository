<?php

Route::get('/', 'AdminController@index')->name('index');

Route::get('permissions', 'PermissionController@index')->name('permissions.index');
Route::patch('permissions/sync', 'PermissionController@sync')->name('permissions.sync');
Route::resource('roles', 'RoleController')->only(['show', 'store', 'update']);

Route::patch('users/{user}/permissions', 'UserController@permissions')->name('users.permissions');
Route::resource('users', 'UserController');
