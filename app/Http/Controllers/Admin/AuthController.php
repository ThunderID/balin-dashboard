<?php 
namespace App\Http\Controllers\Admin;

use App\API\API;
use App\Http\Controllers\AdminController;

use Input, Session, DB, Redirect, Response, Auth;

class AuthController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
	}

	public function login()
	{
		$this->page_attributes->source 		= 'pages.login';

		return $this->generateView();
	}

	public function doLogin()
	{
		$apiUrl 							= '/oauth/access_token';
		$apiData 							= 	[
													'email' 		=> Input::get('email'),
													'password' 		=> Input::get('password'),
													'grant_type'	=> 'password',
													'client_id'		=> 'f3d259ddd3ed8ff3843839b',
													'client_secret'	=> '4c7f6f8fa93d59c45502c0ae8c4a95b',
												];


		$api 								= new API;
		$result 							= json_decode($api->post($apiUrl, $apiData),true);

		if($result['status'] == "success")
		{
			Session::set('APIToken', $result['data']['token']['access_token']);

			return Redirect::route('admin.dashboard');
		}
		else
		{
			return Redirect::route('auth.login');
		}
	}	

	public function logout()
	{
		Session::flush();

		return Redirect::route('auth.login');
	}
}
