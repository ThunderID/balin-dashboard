<?php 
namespace App\Http\Controllers\Customer;

use App\API\Connectors\APICustomer;

use App\Http\Controllers\Controller;
use Input, Collection;

class AjaxController extends Controller
{
	public function FindCustomerByName($name = null)
	{
		//get input 
		$input 										= Input::get('name');

		//get data 
		$APICustomer	 							= new APICustomer;
		$customer									= $APICustomer->getIndex(['search' => ['name' => $input]]);		

		//check if success
		if($customer['status'] != 'success')
		{
			return abort(404);
		}

		//formating data
		$datas 										= [];
		foreach ($customer['data']['data'] as $key => $data) 
		{
			$datas[$key]['id']						= $data['id'];
			$datas[$key]['name']					= $data['name'];
		}										

		//return
		return $datas;
	}
}