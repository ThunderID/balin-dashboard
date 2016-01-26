<?php 
namespace App\Http\Controllers\Toko;

use App\API\Connectors\APISale;

use App\Http\Controllers\Controller;
use Input, Collection;

class AjaxController extends Controller
{
	public function FindTransactionByAmount($amount = null)
	{
		//get input 
		$input 										= Input::get('amount');

		//get data 
		$APISale	 								= new APISale;
		$sale 										= $APISale->getIndex([
														'search' 	=> 	[
																			'bills' 		=> $input,
																			'status'		=> 'wait',
																		],
														'sort' 		=> 	[
																		],																		
														]);

		//check if success
		if($sale['status'] != 'success')
		{
			return abort(404);
		}

		//formating data
		$datas 										= [];
		foreach ($sale['data']['data'] as $key => $data) 
		{
			$datas[$key]['id']						= $data['id'];
			$datas[$key]['bills']					= ucwords(str_replace('_', ' ', $data['bills']));
		}										

		//return
		return $datas;		
	}
}