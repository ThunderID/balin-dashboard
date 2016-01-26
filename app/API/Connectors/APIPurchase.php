<?php 
namespace App\API\Connectors;

use Exception, Session;

class APIPurchase extends APIData
{
	function __construct() 
	{
		parent::__construct();
	}

	public function getIndex($parameter = null)
	{
		$this->apiUrl 					= '/purchases';
		
		if(!is_null($parameter))
		{
			$this->apiData 				= array_merge($this->apiData, $parameter);
		}

		return $this->get();
	}

	public function postData($data)
	{
		$this->apiUrl 					= '/purchase/update/status';
		$this->apiData 					= array_merge($this->apiData, ["purchase" => $data]);

		return $this->post();
	}	

	public function getShow($id)
	{
		$this->apiUrl 					= '/purchase/' . $id;

		return $this->get();
	}
}