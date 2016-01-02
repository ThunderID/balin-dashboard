<?php 
namespace App\API\connectors;

use Exception, Session;

class APIProduct extends APIData
{
	function __construct() 
	{
		parent::__construct();
		$this->apiUrl	 				= '/products';
	}

	public function getProducts($filter = null)
	{
		if(!is_null($filter))
		{
			$this->apiData 				= array_merge($this->apiData, ["search" => $filter]);
		}

		return $this->get();
	}
}