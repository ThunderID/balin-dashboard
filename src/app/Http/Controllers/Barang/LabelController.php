<?php 
namespace App\Http\Controllers\Barang;

use App\API\Connectors\APILabel;
use App\API\Connectors\APIProduct;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Helper\SortList;

use Input, Session, DB, Redirect, Response, Auth;

class LabelController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->page_attributes->title 				= 'Label';
		$this->page_attributes->source 				= 'pages.barang.label.';
		$this->page_attributes->breadcrumb			=	[
															'Label' 	=> route('goods.label.index'),
														];	
        $this->middleware('password.needed', ['only' => ['destroy']]);
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

		//sort
		if (Input::has('sort'))
		{
			$sort_item 							= explode('-', Input::get('sort'));
			$sort 								= [$sort_item[0] => $sort_item[1]];
		}
		else
		{
			$sort								= ['name' => 'asc'];
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
		$APILabel	 								= new APILabel;

		$labels										= $APILabel->getIndex([
															'search' 	=> 	[
																				'name' 	=> Input::get('q'),
																			],			
															'sort'		=> $sort,
															'take'		=> $this->take,
															'skip'		=> ($page - 1) * $this->take,
														]);

		$this->page_attributes->data 				= 	[
															'data' 		=> []
														];

		foreach ($labels['data']['data'] as $key => $value) 
		{
			$this->page_attributes->data['data']  			= array_merge($this->page_attributes->data['data'], [$key => ['id' => $value['label'] ,'name' => ucwords(str_replace('_', ' ', $value['label'])) ]] );
		}

		//sorting

		$SortList 									= new SortList;

		$this->page_attributes->sorts 				= 	[
															'titles'	=> ['label'],
															'label'		=> $SortList->getSortingList('label'),
														]; 			

		//breadcrumb
		$breadcrumb 								= 	[];	

		//paginate
		$this->paginate(route('goods.label.index'), $labels['data']['count'], $page);

		//generate View
		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		$this->page_attributes->source 				=  $this->page_attributes->source . 'index';

		return $this->generateView();
	}

	public function show($id = null)
	{
		//initialize 
		$this->page_attributes->subtitle 			= ucwords(str_replace('_', ' ', $id));

		// filters
		if(Input::has('q'))
		{
			$this->page_attributes->search 			= Input::get('q');
		}	

		//sort
		if (Input::has('sort'))
		{
			$sort_item 							= explode('-', Input::get('sort'));
			$sort 								= [$sort_item[0] => $sort_item[1]];
		}
		else
		{
			$sort								= ['name' => 'asc'];
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
																				'labelname' => $id,
																				'name' 	=> Input::get('q')
																			],
															'sort' 		=> $sort,																		
															'take'		=> $this->take,
															'skip'		=> ($page - 1) * $this->take,
														]);

		$SortList 									= new SortList;

		$this->page_attributes->sorts 				= 	[
															'titles'	=> ['nama', 'harga', 'stok'],
															'nama'		=> $SortList->getSortingList('nama'),
															'harga'		=> $SortList->getSortingList('harga'),
															'stok'		=> $SortList->getSortingList('stok'),
														]; 	


		$this->page_attributes->data				= 	[
															'id' => $id,
															'name' => ucwords(str_replace('_', ' ', $id)),
															'product' => $product['data']['data'],
														];

		//paginate
		$this->paginate(route('goods.label.show', ['id' => $id]), $product['data']['count'], $page);

		//breadcrumb
		$breadcrumb 								=	[
															ucwords(str_replace('_', ' ', $id)) => route('goods.label.show', $id)
														];	

		//generate View
		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		$this->page_attributes->source 				= $this->page_attributes->source . 'show';

		return $this->generateView();
	}	
}
