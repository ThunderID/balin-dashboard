<?php 
namespace App\Http\Controllers\Barang;

use App\API\Connectors\APIProduct;

use App\Http\Controllers\AdminController;

use Input, Session, DB, Redirect, Response, Auth;

/**
 * Handle Varian resource
 * 
 * @author budi
 */
class VarianController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->page_attributes->title 				= 'Varian';
		$this->page_attributes->source 				= 'pages.barang.produk.varian.';
		$this->page_attributes->breadcrumb			=	[
															'Produk' 	=> route('goods.product.index'),
														];
															
        $this->middleware('password.needed', ['only' => ['destroy']]);
	}

	/**
	 * Display all varian
	 * 
	 * @return redirected url
	 */
	public function index()
	{
		return Redirect::back();
	}

	/**
	 * Display a varian
	 * 
	 * 1. Get data from API
	 * 2. Generate breadcrumb
	 * 3. Generate view
	 * @param id, pid
	 * @return Object View
	 */
	public function show($pid = null, $id = null)
	{
		//1. Get data from API
		$APIProduct	 								= new APIProduct;
		$product									= $APIProduct->getShow($pid);

		$this->page_attributes->subtitle 			= $product['data']['name'];

		$this->page_attributes->data['data']		= $this->VarianFindData($product['data']['varians'], $id)['data'];
		$this->page_attributes->data['name']		= $product['data']['name'];

		//2. Generate breadcrumb
		$breadcrumb 								=	[
															$product['data']['name'] => route('goods.product.show', ['id' => $pid]),
															'Ukuran ' . $this->page_attributes->data['data']['size'] => route('goods.varian.show', ['pid' => $pid, 'id' => $id])
														];	
		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);
	
		//3. Generate view
		$this->page_attributes->source 				= $this->page_attributes->source . 'show';

		return $this->generateView();
	}	

	/**
	 * create form of a varian
	 * 
	 * 1. Get Previous data and page setting
	 * 2. Initialize data
	 * 3. Generate breadcrumb
	 * 4. Generate view
	 * @param q
	 * @return Object View
	 */
	public function create($pid = null, $id = null)
	{
		//1. Get Previous data and page setting
		$APIProduct 								= new APIProduct;
		$tmpData 									= $APIProduct->getShow($pid);

		//2. Initialize data
		$data['pid']								= $tmpData['data']['id'];
		$data['name']								= $tmpData['data']['name'];
		$data['upc']								= $tmpData['data']['upc'];
		$data['data']								= null;

		//is edit
		if(!is_null($id))
		{
			$data['data']							= $this->VarianFindData($tmpData['data']['varians'],$id)['data'];
		}

		//3. Generate breadcrumb
		if(is_null($id))
		{
			$breadcrumb								=	[
															$data['name']  =>  route('goods.product.show', ['id' => $data['pid']] ),
															'Ukuran Baru'  =>  route('goods.varian.create', ['pid' => $pid ] ),
														];
		}
		else
		{
			$breadcrumb								=	[
															$data['name']  =>  route('goods.product.show', ['id' => $data['pid']] ),
															'Edit Ukuran ' . $data['data']['size']  =>  route('goods.varian.edit', ['pid' => $pid,'id' => $id] ),
														];
		}
		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		//4. Generate view
		$this->page_attributes->subtitle 			= $data['name'];

		$this->page_attributes->data 				= array_merge($data, ['pid' => $pid]);

		$this->page_attributes->source 				= $this->page_attributes->source . 'create';

		return $this->generateView();
	}

	/**
	 * Edit a varian
	 * 
	 * @param id
	 * @return function
	 */
	public function edit($pid = null, $id = null)
	{
		return $this->create($pid, $id);
	}

	/**
	 * Store a varian
	 * 
	 * 1. Get data product
	 * 2. Init Variable
	 * 3. Embeed Varian to Products
	 * 4. Store product
	 * 5. Generate redirect
	 * @param id
	 * @return object view
	 */
	public function store($pid = null, $id = null)
	{
		//1. Get data product
		$APIProduct 								= new APIProduct;
		$product 									= $APIProduct->getShow($pid);

		//2. Init Variable
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

		//3. Embeed Varian to Product
		$product['data']['varians'][$key]			= $varian;	

		// 4. Store product
		$result 									= $APIProduct->postData($product['data']);

		//5. Generate redirect
		if($result['status'] != 'success')
		{
			$this->errors 							= $result['message'];
		}

		if(!is_null($id))
		{
			$this->page_attributes->success 		= "Data Varian Telah Diedit";
		}
		else
		{
			$this->page_attributes->success 		= "Data Varian Telah Ditambahkan";
		}

		return $this->generateRedirectRoute('goods.product.show', ['id' => $pid]);
	}

	/**
	 * Update a varian
	 * 
	 * @param pid, id
	 * @return function
	 */
	public function Update($pid = null, $id = null)
	{
		return $this->store($pid, $id);
	}

	/**
	 * Delete a varian
	 * 
	 * @param pid, id
	 * @return function
	 */
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

		return $this->generateRedirectRoute('goods.product.show', ['id' => $pid]);		
	}		

	/**
	 * find a varian in product varians
	 * 
	 * @param arraySource (array of varian), id (varian id)
	 * @return function
	 */
	private function VarianFindData($arraySource, $id)
	{
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
