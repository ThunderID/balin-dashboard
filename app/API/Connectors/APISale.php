<?php 
namespace App\API\Connectors;

use Exception, Session;

class APISale extends APIData
{
	function __construct() 
	{
		parent::__construct();
	}

	public function getIndex($parameter = null)
	{
		$this->apiUrl 					= '/sales';
		
		if(!is_null($parameter))
		{
			$this->apiData 				= array_merge($this->apiData, $parameter);
		}

		return $this->get();
	}

	public function postData($data)
	{
		$this->apiUrl 					= '/sale/update/status';
		$this->apiData 					= array_merge($this->apiData, ["sale" => $data]);

		return $this->post();
	}	

	public function getShow($id)
	{
		$this->apiUrl 					= '/sale' .'/'.$id;

		return $this->get();
	}
}