<?php 
namespace App\API\Connectors;

use Exception, Session;

class APICustomer extends APIData
{
	function __construct() 
	{
		parent::__construct();
	}

	public function getIndex($parameter = null)
	{
		$this->apiUrl 					= '/customers';

		if(!is_null($parameter))
		{
			$this->apiData 				= array_merge($this->apiData, $parameter);
		}

		return $this->get();
	}

	public function getShow($id)
	{
		$this->apiUrl 					= '/customer/' . $id;

		return $this->get();
	}	
}