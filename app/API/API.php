<?php namespace App\API;
use Exception;

class API
{
	protected $domain			= 'localhost';
	protected $port				= '8800';
	protected $basic_url;

	public function __construct()
	{
		$this->basic_url 		= $this->domain;

		if(!is_null($this->port))
		{
			if(!empty($this->port))
			{
				$this->basic_url = $this->basic_url . ':' . $this->port;
			}
		}
	}

	public function get($url, $data = [])
	{
		try
		{
			fsockopen($this->domain, $this->port, $errno, $errstr, 60);
		}
		catch (Exception $e) 
		{
			return json_encode(['status' => 'error' , 'message' => $e->getMessage()]);			
		}

		$curl 			= curl_init($this->basic_url.$url);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
		// curl_setopt($curl, CURLOPT_GET, true);
		$results 		= curl_exec($curl);
		if(!json_decode($results))
		{
			print('API.php Error : cannot decode json result');
			print_r($results);
		}
		return $results;
	}

	public function post($url, $data = [])
	{
		try
		{
			fsockopen($this->domain, $this->port, $errno, $errstr, 60);
		}
		catch (Exception $e) 
		{
			return json_encode(['status' => 'error' , 'message' => $e->getMessage()]);			
		}

		$content 		= json_encode($data);
		$curl 			= curl_init($this->basic_url.$url);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
		$results 		= curl_exec($curl);
		if(!json_decode($results))
		{
			print('API.php Error : cannot decode json result');
			print_r($results);
		}
		return $results;
	}
}