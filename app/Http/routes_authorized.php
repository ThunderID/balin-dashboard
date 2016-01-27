<?php

Route::group(['namespace' => 'Admin\\'], function()
{
	Route::get('login',										['uses' => 'AuthController@login', 	'as' => 'backend.login']);

	Route::post('login',									['uses' => 'AuthController@doLogin', 	'as' => 'backend.dologin']);
});
