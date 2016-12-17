<?php 
namespace App\API\Connectors;

use Exception, Session;

class APIStorePage extends APIData
{
	function __construct() 
	{
		parent::__construct();
	}

	public function getIndex($parameter = null)
	{
		$this->apiUrl 					= '/settings/page';

		if(!is_null($parameter))
		{
			$this->apiData 				= array_merge($this->apiData, $parameter);
		}

		return $this->get();
	}

	public function getShow($id)
	{
		$this->apiUrl 					= '/setting/' . $id;

		return $this->get();
	}	
	
	public function postData($data)
	{
		$this->apiUrl 					= '/setting/store';
		$this->apiData 					= array_merge($this->apiData, ["setting" => $data]);

		return $this->post();
	}	
}