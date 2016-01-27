<?php

Route::group(['namespace' => 'Admin\\'], function()
{
	Route::any('dashboard',									['uses' => 'HomeController@index', 'as' => 'admin.dashboard']);
});
