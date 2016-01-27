<?php 
namespace App\Http\Controllers\Toko;

use App\API\Connectors\APISale;

use App\Http\Controllers\AdminController;

use Input, Session, DB, Redirect, Response, Auth;

/**
 * Handle sale information
 * 
 * @author cmooy
 */
class SellController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->page_attributes->title 				= 'Data Penjualan';
		$this->page_attributes->source 				= 'pages.toko.penjualan.';
		$this->page_attributes->breadcrumb			=	[
															'Data Penjualan' 	=> route('shop.sell.index'),
														];			
	}

	/**
	 * Display all sale
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
		$filters 									= null;

		if(Input::has('q'))
		{
			$filters 								= ['status' => Input::get('q')];
			$this->page_attributes->search 			= Input::get('q');
		}
		else
		{
			$searchResult							= null;
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
		$APISale 									= new APISale;

		$sale 										= $APISale->getIndex([
														'search' 	=> 	[
																			'status' 		=> Input::get('q'),
																		],
														'sort' 		=> 	[
																			'transact_at'	=> 'asc',
																		],																		
														'take'		=> $this->take,
														'skip'		=> ($page - 1) * $this->take,
														]);

		$this->page_attributes->data				= 	[
															'sale' => $sale,
														];

		//4. Generate paginator
		$this->paginate(route('shop.sell.index'), $sale['data']['count'], $page);

		//5. Generate breadcrumb
		$breadcrumb								=	[
													];
		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		//6. Generate view
		$this->page_attributes->source 				=  $this->page_attributes->source . '.index';

		return $this->generateView();
	}

	/**
	 * Display a sale detail
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
		$APISale 									= new APISale;
		$sale 										= $APISale->getShow($id);

		//2. Check return status
		if($sale['status'] != 'success')
		{
			$this->errors 							= $sale['message'];
			
			return $this->generateRedirectRoute('shop.sell.index');	
		}

		$this->page_attributes->subtitle 			= $sale['data']['ref_number'];
		$this->page_attributes->data				= 	[
															'sale' => $sale,
														];

		//3. Generate breadcrumb
		$breadcrumb 								=	[
															$sale['data']['ref_number'] => route('shop.sell.show', ['id' => $id])
														];	
		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		//4. Generate view

		$this->page_attributes->source 				= $this->page_attributes->source . 'show';

		return $this->generateView();

	}	
}
