<?php 
namespace App\API\Connectors;

use Exception, Session;

class APIVoucher extends APIData
{
	function __construct() 
	{
		parent::__construct();
	}

	public function getIndex($parameter = null)
	{
		$this->apiUrl 					= '/vouchers';
		
		if(!is_null($parameter))
		{
			$this->apiData 				= array_merge($this->apiData, $parameter);
		}

		return $this->get();
	}

	public function postData($data)
	{
		$this->apiUrl 					= '/voucher/store';
		$this->apiData 					= array_merge($this->apiData, ["voucher" => $data]);

		return $this->post();
	}	

	public function getShow($id)
	{
		$this->apiUrl 					= '/voucher/' . $id;

		return $this->get();
	}

	public function deleteData($id)
	{
		$this->apiUrl 				= '/voucher/delete/' . $id;
		$this->apiData 				= array_merge($this->apiData,  ["id" => $id]);

		return $this->delete();
	}	
}