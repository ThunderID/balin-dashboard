<?php 
namespace App\API\connectors;

use Exception, Session;

class APICourier extends APIData
{
	function __construct() 
	{
		parent::__construct();
	}

	public function getIndex($parameter = null)
	{
		$this->apiUrl	 				= '/couriers';

		if(!is_null($parameter))
		{
			$this->apiData 				= array_merge($this->apiData, $parameter);
		}

		return $this->get();
	}

	public function postData($data)
	{
		$this->apiUrl 					= '/courier/store';
		$this->apiData 					= array_merge($this->apiData, ["courier" => $data]);

		return $this->post();
	}		

	public function getShow($id)
	{
		$this->apiUrl 					= '/courier/' . $id;

		return $this->get();
	}	

	public function deleteData($id)
	{
		$this->apiUrl 				= '/courier/delete/' . $id;
		$this->apiData 				= array_merge($this->apiData,  ["id" => $id]);

		return $this->delete();
	}		
}