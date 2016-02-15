<?php 
namespace App\Http\Controllers\Barang;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Helper\SortList;

use App\API\Connectors\APIPurchase;
use App\API\Connectors\APIProduct;

use Input, Session, DB, Redirect, Response, Auth, Carbon,App;

class BuyController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->page_attributes->title 				= 'Data Pengadaan Barang';
		$this->page_attributes->source 				= 'pages.barang.pembelian.';
		$this->page_attributes->breadcrumb			=	[
															'Data Pengadaan Barang' 	=> route('shop.buy.index'),
														];			
	}

	public function index()
	{
		//initialize 
		$search 									= [];

		if(Input::has('periode'))
		{
			$tmpdate 								= "01-" . Input::get('periode')[0] . " 00:00:00";

			$search['ondate'] 						= 	[
															Carbon::createFromFormat('d-m-Y H:i:s', ($tmpdate))->format('Y-m-d H:i:s'),
															Carbon::createFromFormat('d-m-Y H:i:s', ($tmpdate))->addMonths(1)->format('Y-m-d H:i:s'),
														];
		}
		else
		{
			$searchResult							= null;
		}

		if(Input::has('q'))
		{
			$search['refnumber']					= Input::get('q');
			$this->page_attributes->search 			= Input::get('q');
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


		//sorting
		if (Input::has('sort'))
		{
			$sort_item 								= explode('-', Input::get('sort'));
			$sort 									= [$sort_item[0] => $sort_item[1]];
		}
		else
		{
			$sort									= [];
		}

		$SortList 									= new SortList;

		$this->page_attributes->sorts 				= 	[
															'titles'	=> ['tanggal','nota', 'jumlah'],
															'tanggal'	=> $SortList->getSortingList('tanggal'),
															'nota'		=> $SortList->getSortingList('nota'),
															'jumlah'	=> $SortList->getSortingList('jumlah'),
														];


		// data here
		$APIPurchase 								= new APIPurchase;


		$purchase 									= $APIPurchase->getIndex([
															'search' 	=> $search,
															'sort' 		=> $sort,
															'take'		=> $this->take,
															'skip'		=> ($page - 1) * $this->take,
														]);

		$this->page_attributes->data				= 	[
															'purchase' => $purchase,
														];

		//paginate
		$this->paginate(route('shop.buy.index'), $purchase['data']['count'], $page);

		//breadcrumb
		$breadcrumb								=	[
													];

		//generate View
		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		$this->page_attributes->source 				=  $this->page_attributes->source . '.index';

		return $this->generateView();
	}

	public function show($id)
	{
		//initialize 
		$APIPurchase 								= new APIPurchase;
		$purchase 									= $APIPurchase->getShow($id);

		$this->page_attributes->subtitle 			= $purchase['data']['ref_number'];

		// filters
		if(Input::has('q'))
		{
			$this->page_attributes->search 			= Input::get('q');
		}

		// data here
		$this->page_attributes->data				= 	[
															'purchase' => $purchase,
														];

		//breadcrumb
		$breadcrumb 								=	[
															$purchase['data']['ref_number'] => route('shop.buy.show', ['id' => $id])
														];	

		//generate View
		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		$this->page_attributes->source 				= $this->page_attributes->source . 'show';

		return $this->generateView();
	}	

	/**
	 * create form of a purchase
	 * 
	 * 1. Get Previous data and page setting
	 * 2. Initialize data
	 * 3. Generate breadcrumb
	 * 4. Generate view
	 * @param id
	 * @return Object View
	 */
	public function create($id = null)
	{
		//1. Get Previous data and page setting
		if (is_null($id))
		{
			$data 									= null;

			$breadcrumb								=	[
															'Baru' => route('shop.buy.create'),
														];


			$this->page_attributes->subtitle 		= 'Baru';
		}
		else
		{
			$APIPurchase 							= new APIPurchase;
			$data 									= ['data' => $APIPurchase->getShow($id)['data'] ];	

			//explode description saved in json
			$breadcrumb								=	[
															$data['data']['ref_number']  =>  route('shop.buy.show', ['id' => $data['data']['id']] ),
															'Edit'  =>  route('shop.buy.create', ['id' => $data['data']['id']] ),
														];

			$this->page_attributes->subtitle 		= $data['data']['ref_number'];
		}

		//2. Initialize data
		if(Input::get('pid') && Input::get('vid'))
		{
			$APIProduct 							= new APIProduct;

			$product 								= $APIProduct->getShow(Input::get('pid'))['data'] ;	

			foreach ($product['varians'] as $key => $value) 
			{
				if(Input::get('vid') == $value['id'])
				{
					$product['varians']				= ['0' => $value];
				}
			}

			if(count($product['varians']) == 0)
			{
				App::abort(404, 'data not found');
			}

			$data['data'] 							= 	[
															'id' 				=> null,
															'user_id'			=> null,
															'supplier_id'		=> null,
															'voucher_id'		=> null,
															'ref_number'		=> null,
															'type'				=> 'buy',
															'transact_at'		=> null,
															'unique_number'		=> null,
															'shipping_cost'		=> null,
															'voucher_discount'	=> null,
															'amount'			=> null,
															'status'			=> null,
															'transactionlogs'	=> [],
															'supplier'			=> [],
															'transactiondetails'=> 	[
																						'0' => 	[
																									'id'				=> null,
																									'transaction_id'	=> null,
																									'varian_id' 		=> $product['varians'][0]['id'],
																							        'quantity' 			=> null,
																							        'price' 			=> null,
																							        'discount' 			=> null,
																							        'varian'			=>	[
																							        							'id'			=> $product['varians'][0]['id'],
																							        							'product_id'	=> $product['varians'][0]['product_id'],
																							        							'sku'			=> $product['varians'][0]['sku'],
																							        							'size'			=> $product['varians'][0]['size'],
																							        							'product'		=> 	[
																							        													'id'		=> $product['id'],
																							        													'name'		=> $product['name']
																							        												]
																							        						]
																								]
																					]
														];
			$data['src']							= 'dashboard';														

		}

		$this->page_attributes->data 				= $data;

		//3. Generate breadcrumb
		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);


		//4. Generate view
		$this->page_attributes->source 				=  $this->page_attributes->source . 'create';

		return $this->generateView();	
	}

	public function edit($id)
	{
		return $this->create($id);
	}

	public function store($id = "")
	{
		//1. Store Detail
		$varians 									= [];
		foreach (Input::get('varian_id') as $key => $varian)
		{
			$tmpDetail 								= 	[
															'id' 			=> "",
															'varian_id'		=> Input::get('varian_id')[$key],
															'price'			=> str_replace('IDR ', '', str_replace('.', '', Input::get('price')[$key])),
															'promo_price'	=> str_replace('IDR ', '', str_replace('.', '', Input::get('promo_price')[$key])),
															'quantity'		=> Input::get('quantity')[$key],
														];

			if(!empty($tmpDetail['varian_id']) || !empty($tmpDetail['price']) || !empty($tmpDetail['promo_price']) || !empty($tmpDetail['quantity']))
			{
				array_push($varians,$tmpDetail);
			}														
		}

		//2. Store Transaction
		$data 										= 	[
															'id' 					=> $id,
															'supplier_id'			=> 1,
															'transact_at'			=> date('Y-m-d H:i:s', strtotime(Input::get('transact_at'))),
															'transactiondetails'	=> $varians,
														];											

		//check is null varian												
		if(empty($data['varians']))
		{
			unset($data['varians']);
		}

		//api
		$APIPurchase 								= new APIPurchase;

		$result 									= $APIPurchase->postData($data);

		//result
		if($result['status'] != 'success')
		{
			$this->errors							= $result['message'];
		}

		//return view
		if(!empty($id))
		{
			$this->page_attributes->success 		= "Data Pembelian Telah Diedit";
		}
		else
		{
			$this->page_attributes->success 		= "Data Pembelian Telah Ditambahkan";
		}

		//decide redirect
		if(strtolower(Input::get('src')) == 'dashboard')
		{
			return $this->generateRedirectRoute('admin.dashboard', ['tab' => 'barang']);
		}else{
			return $this->generateRedirectRoute('shop.buy.index');
		}
	}

	/**
	 * Update a purchase
	 * 
	 * @param id
	 * @return function
	 */
	public function Update($id)
	{
		return $this->store($id);
	}
}
