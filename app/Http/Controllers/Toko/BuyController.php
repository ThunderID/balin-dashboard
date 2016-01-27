<?php 
namespace App\Http\Controllers\Toko;

use App\Http\Controllers\AdminController;
use App\API\Connectors\APIPurchase;
use Input, Session, DB, Redirect, Response, Auth;

class BuyController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->page_attributes->title 				= 'Data Pembelian';
		$this->page_attributes->source 				= 'pages.toko.pembelian.';
		$this->page_attributes->breadcrumb			=	[
															'Data Pembelian' 	=> route('shop.buy.index'),
														];			
	}

	public function index()
	{
		//initialize 
		$filters 									= null;

		if(Input::has('q'))
		{
			$filters 								= ['ondate' => Input::get('q')];
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
		$APIPurchase 								= new APIPurchase;

		$purchase 									= $APIPurchase->getIndex([
														'search' 	=> 	[
																			'ondate' 		=> Input::get('q'),
																		],
														'sort' 		=> 	[
																			'transact_at'	=> 'asc',
																		],																		
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
															$purchase['data']['ref_number'] => route('shop.sell.show', ['id' => $id])
														];	

		//generate View
		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		$this->page_attributes->source 				= $this->page_attributes->source . 'show';

		return $this->generateView();
	}	

	public function create($id = null)
	{
	
	}

	public function edit($id)
	{
		return $this->create($id);
	}

	public function store($id = null)
	{

	}

	public function Update($id)
	{
		return $this->store($id);
	}

	public function destroy($id)
	{

	}		
}
