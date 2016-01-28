<?php 
namespace App\API\Connectors;

use Exception, Session;

class APIMe extends APIData
{
	function __construct() 
	{
		parent::__construct();
	}

	public function getShow($id)
	{
		$this->apiUrl 					= '/me';

		return $this->get();
	}	
}