<?php 
namespace App\Http\Controllers\Laporan;

use App\API\Connectors\APIStock;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Helper\SortList;

use Input, Session, DB, Redirect, Response, Auth, Carbon;
/**
 * Handle report controller
 * 
 * @author budi
 */
class StockController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->page_attributes->title 				= 'Laporan Stok';
		$this->page_attributes->source 				= 'pages.laporan.stok.';
		$this->page_attributes->breadcrumb			=	[
															'Laporan Stok' 	=> route('report.stock.product'),
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
															"",
															Carbon::createFromFormat('d-m-Y H:i:s', ($tmpdate))->addMonths(1)->format('Y-m-d H:i:s'),
														];

		}												
		else
		{
			$tmpdate 								= "01-" . date('m-Y') . " 00:00:00";


			$search['ondate'] 						= 	[
															"",
															Carbon::createFromFormat('d-m-Y H:i:s', ($tmpdate))->addMonths(1)->format('Y-m-d H:i:s'),
														];
		}

		if(Input::has('q'))
		{
			$search['name']							= Input::get('q');
			$this->page_attributes->search 			= Input::get('q');
		}

		if(Input::has('size'))
		{
			$search['size']							= Input::get('size');
		}		

		if (Input::has('sort'))
		{
			$sort_item 								= explode('-', Input::get('sort'));
			$sort 									= [$sort_item[0] => $sort_item[1]];
		}
		else
		{
			$sort									= ['name' => 'asc'];
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
															'search' 	=> $search,
															'sort' 		=> $sort,		
															'take'		=> $this->take,
															'skip'		=> ($page - 1) * $this->take,
														]);

		$this->page_attributes->data				= 	[
															'product' => $product,
														];

		$this->page_attributes->filters				= 	[
															'titles' 	=> ['size'], 
															'size' 		=> ['15','15½','16']
														];

		$SortList 									= new SortList;
		$this->page_attributes->sorts 				= 	[
															'titles'			=> ['stockinventory', 'stockout'],
															'stockinventory'	=> $SortList->getSortingList('stockinventory'),
															'stockout'			=> $SortList->getSortingList('stockout'),
														]; 														

		//4. Generate paginator
		$this->paginate(route('report.stock.product'), $product['data']['count'], $page);

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
		//1. Check filter
		$search 									= [];
		$sort 										= [];

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
		}

		$this->page_attributes->filters				= 	[];
		$this->page_attributes->sorts				= 	[];


		//2. get curent page
		if(is_null(Input::get('page')))
		{
			$page 									= 1;
		}
		else
		{
			$page 									= Input::get('page');
		}


		//4. Get data from API
		$APIStock 									= new APIStock;
		$stock 										= $APIStock->getShow($id, [
														'search' 	=> $search,
														'sort' 		=> $sort,																		
														'take'		=> $this->take,
														'skip'		=> ($page - 1) * $this->take,
														]);

		$this->page_attributes->data				= 	[
															'product' => $stock,
														];


		$this->paginate(route('report.stock.product.detail', ['id' => $id]), count($stock['data']['details']), $page);														

		//5. Generate breadcrumb
		$breadcrumb 								=	[
															$stock['data']['product']['name'] => route('report.stock.product.detail', ['id' => $id])
														];	
		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);														


		//6. Generate view
		$this->page_attributes->source 				= $this->page_attributes->source . 'show';

		return $this->generateView();
	}		
}
