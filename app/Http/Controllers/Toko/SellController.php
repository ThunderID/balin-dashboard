<?php 
namespace App\Http\Controllers\Toko;

use App\Http\Controllers\AdminController;
use App\API\Connectors\APISale;
use Input, Session, DB, Redirect, Response, Auth;

class SellController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->page_attributes->title 				= 'Data Penjualan';
		$this->page_attributes->source 				= 'pages.toko.penjualan.';
		$this->page_attributes->breadcrumb			=	[
															'Data Penjualan' 	=> route('admin.sell.index'),
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
		$APISale 									= new APISale;

		$sale 										= $APISale->getIndex([
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
															'sale' => $sale,
														];

		//paginate
		$this->paginate(route('admin.sell.index'), $sale['data']['count'], $page);

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
		$APISale 									= new APISale;
		$sale 										= $APISale->getShow($id);

		$this->page_attributes->subtitle 			= $sale['data']['ref_number'];

		// filters
		if(Input::has('q'))
		{
			$this->page_attributes->search 			= Input::get('q');
		}		

		// data here
		$this->page_attributes->data				= 	[
															'sale' => $sale,
														];

		//breadcrumb
		$breadcrumb 								=	[
															$sale['data']['ref_number'] => route('admin.sell.show', ['id' => $id])
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
