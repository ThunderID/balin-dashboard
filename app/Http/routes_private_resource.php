<?php

Route::group(['namespace' => 'Admin\\', 'middleware' => 'auth.api'], function()
{
	Route::any('dashboard',									['uses' => 'HomeController@index', 'as' => 'admin.dashboard']);

	Route::get('change/password',							['uses' => 'PasswordController@edit', 'as' => 'password.change.edit']);

	Route::post('change/password',							['uses' => 'PasswordController@update', 'as' => 'password.change.update']);
});
