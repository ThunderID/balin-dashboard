<?php 
namespace App\API\connectors;

use Exception, Session;

class APICourier extends APIData
{
	function __construct() 
	{
		parent::__construct();
		$this->apiUrl	 				= '/couriers';
	}

	public function getIndex($parameter = null)
	{
		if(!is_null($parameter))
		{
			$this->apiData 				= array_merge($this->apiData, $parameter);
		}

		return $this->get();
	}
}