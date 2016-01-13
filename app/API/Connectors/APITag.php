<?php 
namespace App\API\connectors;

use Exception, Session;

class APITag extends APIData
{
	function __construct() 
	{
		parent::__construct();
		$this->apiData 					= array_merge($this->apiData, ['type' => 'tag']);
	}

	public function getIndex($filter = null)
	{
		$this->apiUrl 					= '/clusters/tag';

		if(!is_null($filter))
		{
			$this->apiData 				= array_merge($this->apiData, ["search" => $filter]);
		}

		return $this->get();
	}

	public function postData($data)
	{
		$this->apiUrl 				= '/cluster/tag/store';
		$this->apiData 				= array_merge($this->apiData,  ["tag" => $data]);

		// dd($this->apiData);

		return $this->post();
	}		

	public function getShow($id)
	{
		$this->apiUrl 				= '/cluster/tag/' . $id;

		return $this->get();
	}		
}