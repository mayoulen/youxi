<?php

Route::get('/login', 'LoginController@showLogin')->name('admin_show_login');
Route::post('/login', 'LoginController@login')->name('admin_login');
Route::any('/test', 'TestController@index')->name('admin_test');

Route::middleware(['auth.admin'])->group(function () {
	// 仪表盘
	Route::get('/', 'DashboardController@index')->name('admin_dashboard');
	Route::get('/dashboard', 'DashboardController@index')->name('admin_dashboard');

	// 用户管理
	Route::get('/user', 'UserController@index')->name('admin_user');
	Route::get('/user/info', 'UserController@info')->name('admin_user_info');
	Route::post('/user/create', 'UserController@create')->name('admin_user_create');
	Route::post('/user/edit', 'UserController@edit')->name('admin_user_edit');
	Route::post('/user/destory', 'UserController@destory')->name('admin_user_destory');

	// 地区
	Route::any('/region', 'RegionController@index')->name('admin_region');
});
