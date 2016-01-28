<?php

Route::group(['namespace' => 'Admin\\', 'middleware' => 'auth.api'], function()
{
	Route::any('dashboard',									['uses' => 'HomeController@index', 'as' => 'admin.dashboard']);
});
