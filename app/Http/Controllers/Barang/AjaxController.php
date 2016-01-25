<?php 
namespace App\Http\Controllers\Barang;

use App\API\connectors\APIAjax;

use App\Http\Controllers\Controller;
use Input, Collection;

class AjaxController extends Controller
{
	public function FindLabelByName($name = null)
	{
		//get input 
		$input 										= Input::get('name');

		//get data 
		$APIAjax	 								= new APIAjax;
		$label										= $APIAjax->getLabel(['name' => $input]);		

		//check if success
		if($label['status'] != 'success')
		{
			dd($label);
			return abort(404);
		}

		//formating data
		$datas 										= [];
		foreach ($label['data']['data'] as $key => $data) 
		{
			$datas[$key]['id']						= $data['label'];
			$datas[$key]['name']					= ucwords(str_replace('_', ' ', $data['label']));
		}										

		//return
		return $datas;		
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

	public function FindProductByName()
	{
		//get input 
		$input 										= Input::get('name');

		//get data 
		$APIAjax	 								= new APIAjax;
		$product									= $APIAjax->getProduct(['name' => $input]);		

		//check if success
		if($product['status'] != 'success')
		{
			dd($product);
			return abort(404);
		}

		//formating data
		$datas 										= [];
		foreach ($product['data']['data'] as $key => $data) 
		{
			$datas[$key]['id']						= $data['id'];
			$datas[$key]['name']					= $data['name'];
		}										

		//return
		return $datas;
	}
}