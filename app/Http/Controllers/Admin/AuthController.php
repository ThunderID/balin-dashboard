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
													'client_id'		=> env('API_client_id'),
													'client_secret'	=> env('API_client_secret'),
												];


		$api 								= new API;
		$result 							= json_decode($api->post($apiUrl, $apiData),true);

		if($result['status'] == "success")
		{
			Session::set('APIToken', $result['data']['token']['token']);
			Session::set('userID', $result['data']['me']['id']);
			Session::set('userName', $result['data']['me']['name']);

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
