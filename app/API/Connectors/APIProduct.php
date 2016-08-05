<?php 
namespace App\API\Connectors;

use Exception, Session;

class APIProduct extends APIData
{
	function __construct() 
	{
		parent::__construct();
	}

	public function getIndex($parameter = null)
	{
		$this->apiUrl 					= '/products';
		
		if(!is_null($parameter))
		{
			$this->apiData 				= array_merge($this->apiData, $parameter);
		}

		return $this->get();
	}

	public function postData($data)
	{
		$this->apiUrl 					= '/product/store';
		$this->apiData 					= array_merge($this->apiData, ["product" => $data]);

		return $this->post();
	}	

	public function getShow($id)
	{
		$this->apiUrl 					= '/product/' . $id;

		return $this->get();
	}	
	
	public function deleteData($id)
	{
		$this->apiUrl 				= '/product/delete/' . $id;
		$this->apiData 				= array_merge($this->apiData,  ["id" => $id]);

		return $this->delete();
	}	
}