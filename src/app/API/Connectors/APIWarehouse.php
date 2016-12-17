<?php 
namespace App\API\Connectors;

use Exception, Session;

class APIWarehouse extends APIData
{
	function __construct() 
	{
		parent::__construct();
	}

	public function getCritical($parameter = null)
	{
		$this->apiUrl 					= '/products/stock/critical';

		if(!is_null($parameter))
		{
			$this->apiData 				= array_merge($this->apiData, $parameter);
		}

		return $this->get();
	}
}