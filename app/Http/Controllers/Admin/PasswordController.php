<?php 
namespace App\Http\Controllers\Admin;

use App\API\API;

use App\API\Connectors\APIMe;
use App\API\Connectors\APIAdmin;

use App\Http\Controllers\AdminController;

use Carbon\Carbon;
use Input, Session, DB, Redirect, Response, Auth, Validator;

/**
 * Handle change password
 * 
 * @author cmooy
 */
class PasswordController extends AdminController
{
	public function __construct()
	{
		parent::__construct();

		$this->page_attributes->title 				= 'Ubah Password';
	}

	/**
	 * Edit password form
	 * 
	 * @param id
	 * @return object view
	 */
	public function edit()
	{
		$this->page_attributes->source 				= 'pages.password';

		$this->page_attributes->breadcrumb			= ['Ubah Password' => route('password.change.edit')];

		return $this->generateView();
	}

	/**
	 * Update password
	 * 
	 * 1. Check new password
	 * 2. Check old password
	 * 3. Save password
	 * @param id
	 * @return redirect url
	 */
	public function update()
	{
		//1. Check new password
		if(Input::has('password'))
		{
			$rules 									= ['password' => 'min:8|confirmed'];

			$validator 								= Validator::make(Input::only('password', 'password_confirmation'), $rules);

			if(!$validator->passes())
			{
				$this->errors 						= $validator->errors();
	
				return $this->generateRedirectRoute('password.change.edit', ['id' => Input::get('password')]);
			}
		}

		//2. Check old password
		$APIMe 										= new APIMe;
		$me 										= $APIMe->getShow(true);

		if($me['status']!='success')
		{
			\App::abort(404);
		}

		$apiUrl 									= '/oauth/access_token';
		$apiData 									= 	[
															'email' 		=> $me['data']['email'],
															'password' 		=> Input::get('old_password'),
															'grant_type'	=> 'password',
															'client_id'		=> 'f3d259ddd3ed8ff3843839b',
															'client_secret'	=> '4c7f6f8fa93d59c45502c0ae8c4a95b',
														];


		$api 								= new API;
		$result 							= json_decode($api->post($apiUrl, $apiData),true);

		//3. Save password
		if($result['status'] == "success")
		{
			Session::set('APIToken', $result['data']['token']['access_token']);
			Session::set('userID', $result['data']['me']['id']);

			$APIAdmin 									= new APIAdmin;

			$data 										= $APIAdmin->getShow($result['data']['me']['id']);

			$admin										= $data['data'];
			if(strtotime($data['data']['date_of_birth']))
			{
				$admin['date_of_birth']					= date('Y-m-d H:i:s', strtotime($data['data']['date_of_birth']));
			}
			else
			{
				$admin['date_of_birth']					= '';
			}

			$admin['password']							= Input::get('password');

			$result 									= $APIAdmin->postData($admin);

			//3b. Check Response
			if($result['status'] != 'success')
			{
				$this->errors 							= $result['message'];
			}

			//3c. Return view
			if(!empty($id))
			{
				$this->page_attributes->success 		= "Data Admin Telah Diedit";
			}
			else
			{
				$this->page_attributes->success 		= "Data Admin Telah Ditambahkan";
			}

			return $this->generateRedirectRoute('admin.dashboard');
		}

		else
		{
			return Redirect::route('auth.login');
		}
	}
}
