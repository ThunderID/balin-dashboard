<?php 
namespace App\API\connectors;

use Exception, Session;

class APICategory extends APIData
{
	function __construct() 
	{
		parent::__construct();
		$this->apiData 					= array_merge($this->apiData, ['type' => 'category']);
	}

	public function getIndex($filter = null)
	{
		$this->apiUrl 					= '/clusters/category';

		if(!is_null($filter))
		{
			$this->apiData 				= array_merge($this->apiData, ["search" => $filter]);
		}

		return $this->get();
	}

	public function postData($data)
	{
		$this->apiUrl 				= '/cluster/category/store';
		$this->apiData 				= array_merge($this->apiData,  ["category" => $data]);

		// dd($this->apiData);

		return $this->post();
	}		

	public function getShow($id)
	{
		$this->apiUrl 				= '/cluster/category/' . $id;

		return $this->get();
	}

	public function deleteData($id)
	{
		$this->apiUrl 				= '/cluster/category/delete/' . $id;
		$this->apiData 				= array_merge($this->apiData,  ["id" => $id]);

		return $this->delete();
	}			
}