<?php 
namespace App\Http\Controllers\Barang;

use App\API\connectors\APIProduct;

use App\Http\Controllers\AdminController;
use Input, Session, DB, Redirect, Response, Auth, Carbon, Collection;

class PriceController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->page_attributes->title 				= 'Harga';
		$this->page_attributes->source 				= 'pages.barang.harga.';
		$this->page_attributes->breadcrumb			=	[
															'Harga' 	=> route('admin.price.index'),
														];			
	}

	public function index()
	{
		//initialize 
		$filters 									= null;

		if(Input::has('q'))
		{
			$filters 								= ['name' => Input::get('q')];
			$this->page_attributes->search 			= Input::get('q');
		}
		else
		{
			$searchResult							= null;
		}

		//get curent page
		if(is_null(Input::get('page')))
		{
			$page 									= 1;
		}
		else
		{
			$page 									= Input::get('page');
		}

		// data here
		$APIProduct 								= new APIProduct;

		$product 									= $APIProduct->getIndex([
														'search' 	=> 	[
																			'name' 	=> Input::get('q'),
																		],
														'sort' 		=> 	[
																			'name'	=> 'asc',
																		],																		
														'take'		=> $this->take,
														'skip'		=> ($page - 1) * $this->take,
														]);

		$this->page_attributes->data				= 	[
															'product' => $product,
														];

		//paginate
		$this->paginate(route('admin.price.index'), $product['data']['count'], $page);

		//breadcrumb
		$breadcrumb 								= [];	

		//generate View
		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		$this->page_attributes->source 				=  $this->page_attributes->source . 'index';

		return $this->generateView();
	}

	public function show($id)
	{
		//initialize 
		$APIProduct 								= new APIProduct;
		$product 									= $APIProduct->getShow($id);

		$this->page_attributes->subtitle 			= $product['data']['name'];

		$collection 								= collect($product['data']['prices']);

		// filters & collection
		if(Input::has('start') && Input::has('end'))
		{
			$this->page_attributes->search 			= 'Periode ' . Input::get('start') . ' sampai ' . Input::get('end');

			$filterStart							= date('Y-m-d H:i:s', strtotime(Input::get('start')));
			$filterEnd								= date('Y-m-d H:i:s', strtotime(Input::get('end')));

			$result 								= $collection->filter(function ($col)use($filterStart, $filterEnd) {
															return $col['started_at'] >= $filterStart &&  $col['started_at'] <= $filterEnd;
														});
		}
		else
		{
			$result 								= $collection;
		}	

		//get curent page
		if(is_null(Input::get('page')))
		{
			$page 									= 1;
		}
		else
		{
			$page 									= Input::get('page');
		}

		//paginate
		$this->paginate(route('admin.price.show', ['id' => $id]), count($product['data']['prices']), $page);


		// set data
		$product['data']['prices']					= $result->forPage($page, $this->take);
		$this->page_attributes->data				= 	[
															'product' => $product['data'],
														];		

		//breadcrumb
		$breadcrumb 								=	[
															$product['data']['name'] => route('admin.price.show', ['id' => $id])
														];	

		//generate View
		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		$this->page_attributes->source 				= $this->page_attributes->source . 'show';

		return $this->generateView();
	}	

	public function create($productId = null,  $id = null)
	{
		//initialize
		if(!is_null($productId))
		{
			//initialize 
			$APIProduct 							= new APIProduct;
			$product 								= $APIProduct->getShow($productId);

			//is edit
			if(is_null($id))
			{
				$data 								= 	[
															'productId' 	=> $productId,
															'name' 			=> $product['data']['name'],
															'price'			=> null,
														];

				$breadcrumb							=	[
															$product['data']['name'] => route('admin.price.show', ['productId' => $productId]),
															'Data Baru' => route('admin.price.detail.create', ['productId' => $productId]),
														];

				$this->page_attributes->subtitle 	= $product['data']['name'];
			}
			else
			{
				$tmpPrice							= $this->PriceFindData($product['data']['prices'],$id);

				$tmpdate 							= Carbon::createFromFormat('Y-m-d H:i:s', $tmpPrice['data']['started_at'])->format('d-m-Y H:i:s');

				$tmpPrice['data']['started_at'] 	= $tmpdate;


				$data 								= 	[
															'productId' 	=> $productId,
															'price'			=> $tmpPrice,
															'name' 			=> $product['data']['name'],
														];

				$breadcrumb							=	[
															$product['data']['name'] => route('admin.price.show', ['productId' => $productId]),
															'Edit'  =>  route('admin.price.detail.create', ['productId' => $productId]),
														];
			}
		}
		else
		{
			$data 									= 	[
															'productId' 	=> $productId,
															'name'			=> null,
															'price'			=> null,
														];

			$breadcrumb								=	[
															'Data Baru' => route('admin.price.create'),
														];

			$this->page_attributes->subtitle 		= 'Data Baru';
		}

		//generate View
		$this->page_attributes->data				= $data;
		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		$this->page_attributes->source 				=  $this->page_attributes->source . 'create';

		return $this->generateView();
	}

	public function edit($productId = null, $id = null)
	{
		return $this->create($productId, $id);
	}

	public function store($productId = null, $id = "")
	{
		//get data
		$APIProduct 								= new APIProduct;
		$product 									= $APIProduct->getShow(Input::get('produk'));

		//format input
		$inputPrice 								= str_replace('IDR ', '', str_replace('.', '', Input::get('price')));
		$inputPromoPrice 							= str_replace('IDR ', '', str_replace('.', '', Input::get('promo_price'))); 
		$inputStartDate 							= date('Y-m-d H:i:s', strtotime(Input::get('start_at')));

		//is edit
		if(!empty($id))
		{
			$tmpPrice								= $this->PriceFindData($product['data']['prices'],$id);

			$price 									= $tmpPrice['data'];

			$key 									= $tmpPrice['key'];

			$price['price']							= $inputPrice;
			$price['promo_price']					= $inputPromoPrice;
			$price['started_at']					= $inputStartDate;
		}
		else
		{
			$key 									= count($product['data']['prices']);

			$price['id']							= $id;
			$price['product_id']					= $product['data']['id'];
			$price['price']							= $inputPrice;
			$price['promo_price']					= $inputPromoPrice;
			$price['started_at']					= $inputStartDate;
		}

		//embedd new data price into product
		$product['data']['prices'][$key]			= $price;	

		//save
		$result 									= $APIProduct->postData($product['data']);

		//response
		if($result['status'] != 'success')
		{
			$this->errors 							= $result['message'];
		}

		//return view
		if(!empty($id))
		{
			$this->page_attributes->success 		= "Data Harga Telah Diedit";
		}
		else
		{
			$this->page_attributes->success 		= "Data Harga Telah Ditambahkan";
		}

		return $this->generateRedirectRoute('admin.price.show', ['id' => Input::get('produk')]);		
	}

	public function Update($productId = null, $id = "")
	{
		return $this->store($productId, $id);
	}

	public function destroy($productId = null, $id = null)
	{
		//cek auth

		//get data
		$APIProduct 								= new APIProduct;
		$product 									= $APIProduct->getShow($productId);

		$price 										= $this->PriceFindData($product['data']['prices'], $id);

		//delete varian
		unset($product['data']['prices'][$price['key']]);

		//save
		$result 									= $APIProduct->postData($product['data']);

		//response
		if($result['status'] != 'success')
		{
			$this->errors 							= $result['message'];
		}		

		//return view
		$this->page_attributes->success 			= "Data Harga Produk Telah Dihapus";

		return $this->generateRedirectRoute('admin.price.show', ['id' => $productId]);				
	}		


	//FUNCTIONS
	private function PriceFindData($arraySource, $id)
	{
		//select data from arraySource based on id and return it
		//if data not found, it will return error

		//return
		//array['key','data']

		//parameter
		//arraysource 	= array price
		//id 			= price id

		foreach ($arraySource as $key =>  $price) 
		{
			if($price['id'] == $id)
			{
				return ['key' => $key, 'data' => $price];
			}
		}

		return abort(404, 'No price data with id ' . $id);
	}		
}
