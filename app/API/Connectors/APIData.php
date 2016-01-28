<?php 
namespace App\API\connectors;

use App\API\API;
use Exception, Session, Redirect;

abstract class APIData
{
	protected $apiUrl;
	protected $apiData;

	function __construct() 
	{
		$this->apiData 				= ['access_token' => Session::get('APIToken')];
		
		if(is_null(Session::get('APIToken')))
		{
			Redirect::route('auth.login')->send();
		}
	}

	protected function get()
	{
		$api 						= new API;
		$queryString 				= Null;

		foreach ($this->apiData as $title => $data) {
			if(is_array($data))
			{
				foreach ($data as $subTitle => $subData) {
					if(!is_null($subData) || !empty($subData))
					{
						$queryString = $queryString . $title . "[" .  $subTitle . "]=" . $subData . "&";				
					}
				}
			}
			else
			{
				$queryString 		= $queryString . $title . "=" . $data . "&";
			}		
		}

		$queryString 				= str_replace(' ', '%20', $queryString);


		$this->apiUrl				= $this->apiUrl . '?' . $queryString;

		$result 					= json_decode($api->get($this->apiUrl), true);

		return $this->validateResponse($result);
	}

	protected function post()
	{
		$api 						= new API;

		$result 					= json_decode($api->post($this->apiUrl, $this->apiData),true);

		return $this->validateResponse($result);
	}

	protected function delete()
	{
		$api 						= new API;
		
		$queryString 				= null;

		foreach ($this->apiData as $key => $data) 
		{
			$queryString 			= $queryString . $key . '=' . $data . '?' ;
		}

		$this->apiUrl				= $this->apiUrl . '?' . $queryString;

		$result 					= json_decode($api->delete($this->apiUrl), true);		

		return $this->validateResponse($result);
	}	

	private function validateResponse($result)
	{
		// validate response
		try 
		{
		    if(empty($result['status']))
		    {
				print_r("RESPONSE ERROR : NO STATUS FROM SERVER!");
				dd($result);
		    }

		    if(empty($result['data']))
		    {
				print_r("RESPONSE ERROR : NO DATA FROM SERVER!");
				dd($result);
		    }
		} 
		catch (Exception $e) 
		{
			print_r("ERROR : UNKNOWN RESPONSE FROM SERVER!");
			dd($result);
		}

		// data
		if(is_null($result['data']))
		{
			$result['data'] 		= [];
		}

		return $result;
	}
}