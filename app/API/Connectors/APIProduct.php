<?php 
namespace App\API\connectors;

use Exception, Session;

class APIProduct extends APIData
{
	function __construct() 
	{
		parent::__construct();
	}

	public function getIndex($filter = null)
	{
		if(!is_null($filter))
		{
			$this->apiUrl 				= '/products';
			$this->apiData 				= array_merge($this->apiData, ["search" => $filter]);
		}

		return $this->get();
	}


	public function postData($data)
	{
		$this->apiUrl 				= '/product/store';
		$this->apiData 				= array_merge($this->apiData, ["product" => $data]);

		return $this->post();
	}	
}