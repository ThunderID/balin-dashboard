<?php 
namespace App\API\connectors;

use Exception, Session;

class APIAjax extends APIData
{
	function __construct() 
	{
		parent::__construct();
	}

	public function getCategory($filter = null)
	{
		$this->apiUrl 					= '/balin/store/clusters/category/';

		if(!is_null($filter))
		{
			$this->apiData 				= array_merge($this->apiData, ['type' => 'category', "search" => $filter]);
		}

		return $this->get();
	}	

	public function getTag($filter = null)
	{
		$this->apiUrl 					= '/balin/store/clusters/tag/';

		if(!is_null($filter))
		{
			$this->apiData 				= array_merge($this->apiData, ['type' => 'tag', "search" => $filter]);
		}

		return $this->get();
	}	
}