<?php

/**
* Routes Authorized used only for authorized (login / logout)
*/
include('routes_authorized.php');

/**
* Routes Protected depend on who you are
*/
include('routes_private_resource.php');

/**
* Routes Protected balin resource
*/
include('routes_protected_resource.php');

Route::get('/', function () {

	if(!Session::has('APIToken'))
	{
		return Redirect::route('auth.login');
	}

	return Redirect::route('admin.dashboard');
});