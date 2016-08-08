<?php namespace App\API;

use Exception;
use GuzzleHttp\Client;

class API
{
	protected $domain;
	protected $port;

	public $timeout				= 2;
	public $basic_url;

	public function __construct()
	{
		$this->domain 			= env('RESOURCE_DOMAIN', '');
		$this->port 			= env('RESOURCE_PORT', '');
		
		$this->basic_url 		= $this->domain;

		if(!is_null($this->port))
		{
			if(!empty($this->port))
			{
				$this->basic_url = $this->basic_url . ':' . $this->port;
			}
		}
	}

	public function get($url)
	{
		$client 				= new Client([
										'base_uri' => $this->basic_url,
									    'timeout'  => $this->timeout
									]);

		$response 				= $client->get($this->basic_url . $url , ['timeout' => $this->timeout]);
		$response->addHeader('Content-Type','application/json');

		$body 					= $response->getBody();

		return (string) $body;
	}

	public function post($url, $data = [])
	{
		$client 				= new Client([
										'base_uri' => $this->basic_url,
									    'timeout'  => $this->timeout,
									]);
		$response 				= $client->post($this->basic_url . $url, ['body' => $data] , ['timeout' => $this->timeout] );
		$response->addHeader('Content-Type','application/json');

		$body 					= $response->getBody();

		return (string) $body;
	}

	public function delete($url, $data = [])
	{
		$client 				= new Client([
										'base_uri' => $this->basic_url,
									    'timeout'  => $this->timeout,
									]);

		$response 				= $client->delete($this->basic_url . $url , ['timeout' => $this->timeout]);
		$response->addHeader('Content-Type','application/json');

		$body 					= $response->getBody();

		return (string) $body;
	}	
}