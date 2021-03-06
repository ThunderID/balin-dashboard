<?php 

namespace App\API\Connectors;

use App\API\API;
use Exception, Session, Redirect;

abstract class APIData
{
	protected $apiUrl;
	protected $apiData;

	function __construct() 
	{
		$this->api 					= new API;

		$this->apiData 				= ['token' => Session::get('APIToken')];
		
		if(is_null(Session::get('APIToken')))
		{
			Redirect::route('auth.login')->send();
		}
	}

	protected function get()
	{
		$queryString 				= Null;

		foreach ($this->apiData as $title => $data) {
			if(is_array($data))
			{
				foreach ($data as $subTitle => $subData) {
					if(!is_null($subData) || !empty($subData))
					{
						if(is_array($subData))
						{
							foreach ($subData as $subTitle2 => $subData2) {
								if(!is_null($subData2) || !empty($subData2))
								{
									$queryString = $queryString . $title . "[" .  $subTitle . "][" .  $subTitle2 . "]=" . $subData2 . "&";				
								}
							}
						}
						else
						{
							$queryString = $queryString . $title . "[" .  $subTitle . "]=" . $subData . "&";				
						}

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

		$result 					= json_decode($this->api->get($this->apiUrl), true);

		return $this->validateResponse($result);
	}

	protected function post()
	{
		$result 					= json_decode($this->api->post($this->apiUrl, $this->apiData),true);

		return $this->validateResponse($result);
	}

	protected function delete()
	{
		$queryString 				= null;

		foreach ($this->apiData as $key => $data) 
		{
			$queryString 			= $queryString . $key . '=' . $data . '&' ;
		}

		$this->apiUrl				= $this->apiUrl . '?' . $queryString;

		$result 					= json_decode($this->api->delete($this->apiUrl), true);		

		return $this->validateResponse($result);
	}	

	private function validateResponse($result)
	{

		// validate response
		try 
		{
		    if(empty($result['status']))
		    {
		    	Redirect::route('admin.dashboard', ['header' => '500', 'msg' => 'No status from server']);
		    }
		} 
		catch (Exception $e) 
		{
			Redirect::route('admin.dashboard', ['header' => '500', 'msg' => 'Unknown response from server']);
		}

		// data
		if(!isset($result['data']) || is_null($result['data']))
		{
			$result['data'] 		= [];
		}

		return $result;
	}
}