<?php 
namespace App\Http\Controllers\Barang;

use App\API\connectors\APIProduct;
use App\Http\Controllers\AdminController;

use Input, Session, DB, Redirect, Response, Auth;

class VarianController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->page_attributes->title 				= 'Varian';
		$this->page_attributes->source 				= 'pages.barang.produk.varian.';
		$this->page_attributes->breadcrumb			=	[
															'Produk' 	=> route('admin.product.index'),
														];			
	}

	public function index()
	{
		// ga ada
		return Redirect::back();
	}

	public function show($pid = null, $id = null)
	{
		//get data 
		$APIProduct	 								= new APIProduct;
		$product									= $APIProduct->getShow($pid);

		$this->page_attributes->subtitle 			= $product['data']['name'];

		// data here
		$this->page_attributes->data['data']		= $this->VarianFindData($product['data']['varians'], $id)['data'];
		$this->page_attributes->data['name']		= $product['data']['name'];

		//breadcrumb
		$breadcrumb 								=	[
															$product['data']['name'] => route('admin.product.show', ['id' => $pid]),
															'Ukuran ' . $this->page_attributes->data['data']['size'] => route('admin.varian.show', ['pid' => $pid, 'id' => $id])
														];	

		//generate View
		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		$this->page_attributes->source 				= $this->page_attributes->source . 'show';

		return $this->generateView();
	}	

	public function create($pid = null, $id = null)
	{
		//initialize
		$APIProduct 								= new APIProduct;
		$tmpData 									= $APIProduct->getShow($pid);

		//formating data
		$data['pid']								= $tmpData['data']['id'];
		$data['name']								= $tmpData['data']['name'];
		$data['upc']								= $tmpData['data']['upc'];
		$data['data']								= null;

		//is edit
		if(!is_null($id))
		{
			$data['data']							= $this->VarianFindData($tmpData['data']['varians'],$id)['data'];
		}


		if(is_null($id))
		{
			$breadcrumb								=	[
															$data['name']  =>  route('admin.product.show', ['id' => $data['pid']] ),
															'Ukuran Baru'  =>  route('admin.varian.create', ['pid' => $pid ] ),
														];
		}
		else
		{
			$breadcrumb								=	[
															$data['name']  =>  route('admin.product.show', ['id' => $data['pid']] ),
															'Edit Ukuran ' . $data['data']['size']  =>  route('admin.varian.edit', ['pid' => $pid,'id' => $id] ),
														];
		}

		//generate View
		$this->page_attributes->subtitle 			= $data['name'];

		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		$this->page_attributes->data 				= array_merge($data, ['pid' => $pid]);

		$this->page_attributes->source 				= $this->page_attributes->source . 'create';

		return $this->generateView();
	}

	public function edit($pid = null, $id = null)
	{
		return $this->create($pid, $id);
	}

	public function store($pid = null, $id = null)
	{
		//get data product

		$APIProduct 								= new APIProduct;
		$product 									= $APIProduct->getShow($pid);

		//is edit
		if(!is_null($id))
		{
			$tmpVarian 								= $this->VarianFindData($product['data']['varians'],$id);

			$varian 								= $tmpVarian['data'];
			$key 									= $tmpVarian['key'];

			//set value
			$varian['sku'] 							= Input::get('sku');
			$varian['size'] 						= Input::get('size');
		}
		else
		{
			$key 									= count($product['data']['varians']);

			//set value
			$varian['id'] 							= "";
			$varian['product_id'] 					= $pid;
			$varian['sku'] 							= Input::get('sku');
			$varian['size'] 						= Input::get('size');
			$varian['current_stock'] 				= 0;
		    $varian['on_hold_stock'] 				= 0;
		    $varian['inventory_stock'] 				= 0;
		    $varian['reserved_stock'] 				= 0;
		    $varian['packed_stock'] 				= 0;			
		}

		//embedd new data varian into product
		$product['data']['varians'][$key]			= $varian;	

		//save
		$result 									= $APIProduct->postData($product['data']);

		//response
		if($result['status'] != 'success')
		{
			$this->errors 							= $result['message'];
		}

		//return view
		if(!is_null($id))
		{
			$this->page_attributes->success 		= "Data Varian Telah Diedit";
		}
		else
		{
			$this->page_attributes->success 		= "Data Varian Telah Ditambahkan";
		}

		return $this->generateRedirectRoute('admin.product.show', ['id' => $pid]);
	}

	public function Update($pid = null, $id = null)
	{
		return $this->store($pid, $id);
	}

	public function destroy($pid = null, $id = null)
	{
		//cek auth

		//get data
		$APIProduct 								= new APIProduct;
		$product 									= $APIProduct->getShow($pid);

		$varian 									= $this->VarianFindData($product['data']['varians'], $id);

		//delete varian
		unset($product['data']['varians'][$varian['key']]);

		//save
		$result 									= $APIProduct->postData($product['data']);

		//response
		if($result['status'] != 'success')
		{
			$this->errors 							= $result['message'];
		}

		//return view
		$this->page_attributes->success 			= "Data Varian Telah Dihapus";

		return $this->generateRedirectRoute('admin.product.show', ['id' => $pid]);		
	}		

	//FUNCTIONS
	private function VarianFindData($arraySource, $id)
	{
		//select data from arraySource based on id and return it
		//if data not found, it will return error

		//return
		//array['key','data']

		//parameter
		//arraysource 	= array varian
		//id 			= varian id

		foreach ($arraySource as $key =>  $varian) 
		{
			if($varian['id'] == $id)
			{
				return ['key' => $key, 'data' => $varian];
			}
		}

		return abort(404, 'No varian data with id ' . $id);
	}	
}
