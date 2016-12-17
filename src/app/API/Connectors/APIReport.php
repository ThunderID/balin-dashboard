<?php 
namespace App\API\Connectors;

use Exception, Session;

class APIReport extends APIData
{
	function __construct() 
	{
		parent::__construct();
	}

	public function getSoldProduct($parameter = null)
	{
		$this->apiUrl 					= '/report/sold/products';
		
		if(!is_null($parameter))
		{
			$this->apiData 				= array_merge($this->apiData, $parameter);
		}

		return $this->get();
	}

	public function getVoucherUsage($parameter = null)
	{
		$this->apiUrl 					= '/report/usage/of/vouchers';
		
		if(!is_null($parameter))
		{
			$this->apiData 				= array_merge($this->apiData, $parameter);
		}

		return $this->get();
	}	
}