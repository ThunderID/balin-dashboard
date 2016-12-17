<?php 
namespace App\API\Connectors;

use Exception, Session;

class APIAjax extends APIData
{
	function __construct() 
	{
		parent::__construct();
	}

	public function getLabel($filter = null)
	{
		$this->apiUrl 					= '/balin/public/labels';

		if(!is_null($filter))
		{
			$this->apiData 				= array_merge($this->apiData, ["search" => $filter]);
		}

		return $this->get();
	}		

	public function getCategory($filter = null)
	{
		$this->apiUrl 					= '/balin/public/clusters/category';

		if(!is_null($filter))
		{
			$this->apiData 				= array_merge($this->apiData, ['type' => 'category', "search" => $filter]);
		}

		return $this->get();
	}	

	public function getTag($filter = null)
	{
		$this->apiUrl 					= '/balin/public/clusters/tag';

		if(!is_null($filter))
		{
			$this->apiData 				= array_merge($this->apiData, ['type' => 'tag', "search" => $filter]);
		}

		return $this->get();
	}	

	public function getProduct($filter = null)
	{
		$this->apiUrl 					= '/products';

		if(!is_null($filter))
		{
			$this->apiData 				= array_merge($this->apiData, ["search" => $filter]);
		}

		return $this->get();
	}	

}