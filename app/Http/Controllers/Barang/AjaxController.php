<?php 
namespace App\Http\Controllers\Barang;

use App\API\connectors\APIAjax;

use App\Http\Controllers\Controller;
use Input, Collection;

class AjaxController extends Controller
{
	public function FindLabelByName($name = null)
	{
	}

	public function FindCategoryByName($name = null)
	{
		//get input 
		$input 										= Input::get('name');

		//get data 
		$APIAjax	 								= new APIAjax;
		$category									= $APIAjax->getCategory(['name' => $input]);		

		//check if success
		if($category['status'] != 'success')
		{
			dd($category);
			return abort(404);
		}

		//formating data
		$datas 										= [];
		foreach ($category['data']['data'] as $key => $data) 
		{
			$datas[$key]['id']						= $data['id'];
			$datas[$key]['name']					= $data['slug'];
		}										

		//return
		return $datas;
	}

	public function FindTagByName()
	{
		//get input 
		$input 										= Input::get('name');

		//get data 
		$APIAjax	 								= new APIAjax;
		$tag										= $APIAjax->getTag(['name' => $input]);		

		//check if success
		if($tag['status'] != 'success')
		{
			dd($tag);
			return abort(404);
		}

		//formating data
		$datas 										= [];
		foreach ($tag['data']['data'] as $key => $data) 
		{
			$datas[$key]['id']						= $data['id'];
			$datas[$key]['name']					= $data['slug'];
		}										

		//return
		return $datas;
	}		
}