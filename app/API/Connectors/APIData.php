<?php 
namespace App\API\connectors;

use App\API\API;
use Exception, Session;

abstract class APIData
{
	protected $apiUrl;
	protected $apiData;

	function __construct() 
	{
		$this->apiData 				= ['access_token' => Session::get('APIToken')];
	}

	protected function get()
	{
		$api 						= new API;
		$queryString 				= Null;

		foreach ($this->apiData as $title => $data) {
			if(is_array($data))
			{
				foreach ($data as $subTitle => $subData) {
					$queryString 	= $queryString . $title . "[" .  $subTitle . "]=" . $subData . "&";				
				}
			}
			else
			{
				$queryString 		= $queryString . $title . "=" . $data;
			}

			if($title != key($this->apiData))
			{
				$queryString 		= $queryString . "&";
			}		
		}

		$queryString 				= str_replace(' ', '%20', $queryString);

		$this->apiUrl				= $this->apiUrl . '?' . $queryString;

		$result 					= json_decode($api->get($this->apiUrl, $this->apiData), true);

		return $this->validateResponse($result);
	}

	protected function post()
	{
		$api 						= new API;

		$result 					= json_decode($api->post($this->apiUrl, $this->apiData),true);

		return $this->validateResponse($result);
	}

	private function validateResponse($result)
	{
		if($result['status'] != 'success')
		{
			dd($result['message']);
			// case fail
			// case error
		}

		if(is_null($result['data']))
		{
			$result['data'] 		= [];
		}

		return $result;
	}
}