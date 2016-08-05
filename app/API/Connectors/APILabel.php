<?php 
namespace App\API\Connectors;

use Exception, Session;

class APILabel extends APIData
{
	function __construct() 
	{
		parent::__construct();
	}

	public function getIndex($filter = null)
	{
		$this->apiUrl 					= '/balin/public/labels';

		if(!is_null($filter))
		{
			$this->apiData 				= array_merge($this->apiData, $filter);
		}

		return $this->get();
	}
}