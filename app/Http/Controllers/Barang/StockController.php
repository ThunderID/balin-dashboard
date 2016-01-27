<?php 
namespace App\Http\Controllers\Barang;

use App\API\connectors\APIStock;

use App\Http\Controllers\AdminController;
use Input, Session, DB, Redirect, Response, Auth;

class StockController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->page_attributes->title 				= 'Stok';
		$this->page_attributes->source 				= 'pages.barang.stok.';
		$this->page_attributes->breadcrumb			=	[
															'Stok' 	=> route('admin.stock.index'),
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
		$APIStock 									= new APIStock;

		$product 									= $APIStock->getIndex([
														'search' 	=> 	[
																			'ondate' 	=> Input::get('q'),
																		],
														'sort' 		=> 	[
																			'size'	=> 'asc',
																		],																		
														'take'		=> $this->take,
														'skip'		=> ($page - 1) * $this->take,
														]);

		$this->page_attributes->data				= 	[
															'product' => $product,
														];

		//paginate
		$this->paginate(route('admin.stock.index'), $product['data']['count'], $page);

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
		$APIStock 									= new APIStock;
		$product 									= $APIStock->getShow($id);

		//result
		if($product['status'] != 'success')
		{
			$this->errors 							= $product['message'];
			
			return $this->generateRedirectRoute('admin.stock.index');	
		}

		$this->page_attributes->subtitle 			= $product['data']['product']['name'];

		// filters
		if(Input::has('q'))
		{
			$this->page_attributes->search 			= Input::get('q');
		}		

		// data here
		$this->page_attributes->data				= 	[
															'product' => $product,
														];

		//breadcrumb
		$breadcrumb 								=	[
															$product['data']['product']['name'] => route('admin.stock.show', ['id' => $id])
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
