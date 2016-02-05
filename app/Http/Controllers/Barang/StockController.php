<?php 
namespace App\Http\Controllers\Barang;

use App\API\connectors\APIStock;

use App\Http\Controllers\AdminController;

use Input, Session, DB, Redirect, Response, Auth, Carbon;

/**
 * Handle stock information
 * 
 * @author cmooy
 */
class StockController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->page_attributes->title 				= 'Stok';
		$this->page_attributes->source 				= 'pages.barang.stok.';
		$this->page_attributes->breadcrumb			=	[
															'Stok' 	=> route('goods.stock.index'),
														];	
        $this->middleware('password.needed', ['only' => ['destroy']]);
	}

	/**
	 * Display all varian stock on certain date
	 * 
	 * 1. Check filter
	 * 2. Check page
	 * 3. Get data from API
	 * 4. Generate paginator
	 * 5. Generate breadcrumb
	 * 6. Generate view
	 * @param page, q
	 * @return Object View
	 */
	public function index()
	{
		//1. Check filter
		$search 									= [];

		if(Input::has('periode'))
		{
			$tmpdate 								= "01-" . Input::get('periode') . " 00:00:00";

			$search['ondate'] 						= 	[
															Carbon::createFromFormat('d-m-Y H:i:s', ($tmpdate))->format('Y-m-d H:i:s'),
															Carbon::createFromFormat('d-m-Y H:i:s', ($tmpdate))->addMonths(1)->format('Y-m-d H:i:s'),
														];

		}												
		else
		{
			$tmpdate 								= "01-" . date('m-Y') . " 00:00:00";


			$search['ondate'] 						= 	[
															Carbon::createFromFormat('d-m-Y H:i:s', ($tmpdate))->format('Y-m-d H:i:s'),
															Carbon::createFromFormat('d-m-Y H:i:s', ($tmpdate))->addMonths(1)->format('Y-m-d H:i:s'),
														];

			$searchResult							= null;
		}


		if(Input::has('q'))
		{
			$search['name']							= Input::get('q');
			$this->page_attributes->search 			= Input::get('q');
		}


		//2. Check page
		if(is_null(Input::get('page')))
		{
			$page 									= 1;
		}
		else
		{
			$page 									= Input::get('page');
		}

		//3. Get data from API
		$APIStock 									= new APIStock;

		$product 									= $APIStock->getIndex([
															'search' 	=> 	$search,
															'sort' 		=> 	[
																				'size'	=> 'asc',
																			],																		
															'take'		=> $this->take,
															'skip'		=> ($page - 1) * $this->take,
														]);

		$this->page_attributes->data				= 	[
															'product' => $product,
														];

		//4. Generate paginator
		$this->paginate(route('goods.stock.index'), $product['data']['count'], $page);

		//5. Generate breadcrumb
		$breadcrumb 								= [];	

		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		//6. Generate view
		$this->page_attributes->source 				=  $this->page_attributes->source . 'index';

		return $this->generateView();
	}

	/**
	 * Display a varian stock card
	 * 
	 * 1. Get data from API
	 * 2. Check return status
	 * 3. Generate breadcrumb
	 * 4. Generate view
	 * @param id
	 * @return Object View
	 */
	public function show($id)
	{
		//1. Get data from API
		$APIStock 									= new APIStock;
		$product 									= $APIStock->getShow($id);

		//2. Check return status
		if($product['status'] != 'success')
		{
			$this->errors 							= $product['message'];
			
			return $this->generateRedirectRoute('goods.stock.index');	
		}

		$this->page_attributes->subtitle 			= $product['data']['product']['name'];

		// data here
		$this->page_attributes->data				= 	[
															'product' => $product,
														];

		//3. Generate breadcrumb
		$breadcrumb 								=	[
															$product['data']['product']['name'] => route('goods.stock.show', ['id' => $id])
														];	

		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		//4. Generate view
		$this->page_attributes->source 				= $this->page_attributes->source . 'show';

		return $this->generateView();
	}	
}
