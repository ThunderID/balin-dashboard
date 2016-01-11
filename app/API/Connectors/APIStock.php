<?php 
namespace App\API\connectors;

use Exception, Session;

class APIStock extends APIData
{
	function __construct() 
	{
		parent::__construct();
	}

	public function getStockCard()
	{
		$this->apiUrl 					= '/product/stock/product/' . $id;

		return $this->get();
	}
}