<?php namespace App\API;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class API
{
	// protected $domain			= '192.168.1.118';
	protected $domain			= 'localhost';
	protected $port				= '8800';
	public $timeout				= 2;
	public $basic_url;

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

	public function get($url)
	{
		$client 				= new Client([
										'base_uri' => $this->basic_url,
									    'timeout'  => $this->timeout
									]);

		$request 				= new Request('GET',  $this->basic_url . $url);
		$response 				= $client->send($request, ['timeout' => $this->timeout]);
		$body 					= $response->getBody();

		return (string) $body;
	}

	public function post($url, $data = [])
	{
		$client 				= new Client([
										'base_uri' => $this->basic_url,
									    'timeout'  => $this->timeout,
									]);

		$response 				= $client->request('POST',  $this->basic_url . $url, ['form_params' => $data] );

		$body 					= $response->getBody();

		return (string) $body;
	}

	public function delete($url, $data = [])
	{
		$client 				= new Client([
										'base_uri' => $this->basic_url,
									    'timeout'  => $this->timeout,
									]);


		$request 				= new Request('DELETE',  $this->basic_url . $url);
		$response 				= $client->send($request, ['timeout' => $this->timeout]);

		$body 					= $response->getBody();

		return (string) $body;
	}	
}