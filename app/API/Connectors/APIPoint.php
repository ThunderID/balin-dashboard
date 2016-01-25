<?php 
namespace App\API\Connectors;

use Exception, Session;

class APIPoint extends APIData
{
	function __construct() 
	{
		parent::__construct();
	}

	public function getIndex($parameter = null)
	{
		$this->apiUrl 					= '/points';
		
		if(!is_null($parameter))
		{
			$this->apiData 				= array_merge($this->apiData, $parameter);
		}

		return $this->get();
	}

	public function postData($data)
	{
		$this->apiUrl 					= '/point/store';
		$this->apiData 					= array_merge($this->apiData, ["point" => $data]);

		return $this->post();
	}	
}