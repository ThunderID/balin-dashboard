<?php 
namespace App\Http\Controllers\Barang;

use App\API\connectors\APIProduct;

use App\Http\Controllers\AdminController;
use Input, Session, DB, Redirect, Response, Auth;

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

		// data here
		$APIProduct 								= new APIProduct;
		$product 									= $APIProduct->getIndex([
															'name' 	=> Input::get('q')
														]);

		$this->page_attributes->data				= 	[
															'product' => $product['data']
														];


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

		// filters
		if(Input::has('start') && Input::has('end'))
		{
			$this->page_attributes->search 			= 'Periode ' . Input::get('start') . ' sampai ' . Input::get('end');
		}		

		// data here
		$this->page_attributes->data				= 	[
															'product' => $product,
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

			if(is_null($id))
			{
				$data 								= 	[
															'productId' 	=> $productId,
														];

				$breadcrumb							=	[
															$product['data']['name'] => route('admin.price.show', ['productId' => $productId]),
															'Data Baru' => route('admin.price.create'),
														];

				$this->page_attributes->subtitle 	= $product['data']['name'];
			}
			else
			{
				$data 								= 	[
															'productId' 	=> $productId,
														];

				$breadcrumb							=	[
															$product['data']['name'] => route('admin.price.show', ['productId' => $productId]),
															'Edit Data ' . $data['name']  =>  route('admin.price.create'),
														];
			}
		}
		else
		{
			$data 									= 	[
															'productId' 	=> $productId,
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
