<?php

namespace App\Http\Middleware;

use Session;
use Redirect;
use Closure;
use Input;

use App\API\API;

use App\API\Connectors\APIMe;

use Illuminate\Contracts\Auth\Guard;

class PasswordNeeded
{
	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;

	/**
	 * Create a new filter instance.
	 *
	 * @param  Guard  $auth
	 * @return void
	 */
	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		//1. Check input
		if(!Input::has('password'))
		{
			return Redirect::route('auth.login');
		}

		//2. Check password
		$APIMe 										= new APIMe;
		$me 										= $APIMe->getShow(true);

		if($me['status']!='success')
		{
			\App::abort(404);
		}

		$apiUrl 									= '/oauth/access_token';
		$apiData 									= 	[
															'email' 		=> $me['data']['email'],
															'password' 		=> Input::get('password'),
															'grant_type'	=> 'password',
															'client_id'		=> 'f3d259ddd3ed8ff3843839b',
															'client_secret'	=> '4c7f6f8fa93d59c45502c0ae8c4a95b',
														];


		$api 								= new API;
		$result 							= json_decode($api->post($apiUrl, $apiData),true);

		//3. Check status
		if($result['status'] != "success")
		{
			return Redirect::back()->withErrors('Password tidak valid')->with('msg-type', 'danger');
		}

		Session::set('APIToken', $result['data']['token']['access_token']);
		Session::set('userID', $result['data']['me']['id']);

		return $next($request);
	}
}
