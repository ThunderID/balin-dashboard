<?php 
namespace App\API\Connectors;

use Exception, Session;

class APIAdmin extends APIData
{
	function __construct() 
	{
		parent::__construct();
	}

	public function getIndex($parameter = null)
	{
		$this->apiUrl 					= '/admins';

		if(!is_null($parameter))
		{
			$this->apiData 				= array_merge($this->apiData, $parameter);
		}

		return $this->get();
	}

	public function getShow($id)
	{
		$this->apiUrl 					= '/admin/' . $id;

		return $this->get();
	}	
}