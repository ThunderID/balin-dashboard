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

	public function getCouriers($filter = null)
	{
		if(!is_null($filter))
		{
			$this->apiData 				= array_merge($this->apiData, ["search" => $filter]);
		}

		return $this->get();
	}
}