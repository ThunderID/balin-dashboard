<?php 
namespace App\API\Connectors;

use Exception, Session;

class APIStock extends APIData
{
	function __construct() 
	{
		parent::__construct();
	}

	public function getIndex($parameter = null)
	{
		$this->apiUrl 					= '/products/stock/opname';
		
		if(!is_null($parameter))
		{
			$this->apiData 				= array_merge($this->apiData, $parameter);
		}

		return $this->get();
	}

	public function getShow($id, $parameter = null)
	{
		$this->apiUrl 					= '/product/stock/card/' . $id;

		if(!is_null($parameter))
		{
			$this->apiData 				= array_merge($this->apiData, $parameter);
		}		

		return $this->get();
	}	
}