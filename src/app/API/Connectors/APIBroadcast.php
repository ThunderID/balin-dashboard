<?php 
namespace App\API\Connectors;

use Exception, Session;

class APIBroadcast extends APIData
{
	function __construct() 
	{
		parent::__construct();
	}

	public function postData($data)
	{
		$this->apiUrl 					= '/broadcast/price';
		$this->apiData 					= array_merge($this->apiData, ["price" => $data]);

		return $this->post();
	}	
}