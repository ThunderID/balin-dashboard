<?php 
namespace App\API\Connectors;

use Exception, Session;

class APIExtension extends APIData
{
	function __construct() 
	{
		parent::__construct();
	}

	public function getIndex($parameter = null)
	{
		$this->apiUrl	 				= '/products/extensions';

		if(!is_null($parameter))
		{
			$this->apiData 				= array_merge($this->apiData, $parameter);
		}

		return $this->get();
	}

	public function postData($data)
	{
		$this->apiUrl 					= '/products/extension/store';
		$this->apiData 					= array_merge($this->apiData, ["extension" => $data]);

		return $this->post();
	}		

	public function getShow($id)
	{
		$this->apiUrl 					= '/products/extension/' . $id;

		return $this->get();
	}	

	public function deleteData($id)
	{
		$this->apiUrl 				= '/products/extension/delete/' . $id;
		$this->apiData 				= array_merge($this->apiData,  ["id" => $id]);

		return $this->delete();
	}		
}