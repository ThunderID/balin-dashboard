<?php

Route::group(['namespace' => 'Admin\\'], function()
{
	Route::get('login',										['uses' => 'AuthController@login', 	'as' => 'auth.login']);

	Route::post('login',									['uses' => 'AuthController@doLogin', 	'as' => 'auth.dologin']);

	Route::get('logout',									['uses' => 'AuthController@logout', 	'as' => 'auth.logout']);
});
