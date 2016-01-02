<?php 
namespace App\Http\Controllers\Barang;

use App\API\connectors\APIProduct;
use App\Http\Controllers\AdminController;

use Input, Session, DB, Redirect, Response, Auth;

class LabelController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->page_attributes->title 				= 'Label';
		$this->page_attributes->source 				= 'pages.barang.Label.';
		$this->page_attributes->breadcrumb			=	[
															'Label' 	=> route('admin.label.index'),
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

		// data here
		$this->page_attributes->data				= 	[
															['id' => '0' ,'name' => 'Best Seller'],
															['id' => '1' ,'name' => 'New Item'],
															['id' => '2' ,'name' => 'Sale']
														];

		//breadcrumb
		$breadcrumb 								= 	[];	

		//generate View
		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		$this->page_attributes->source 				=  $this->page_attributes->source . 'index';

		return $this->generateView();
	}

	public function show($id)
	{
		//initialize 
		$tmpData									= ['Best Seller', 'New Item', 'Sale'];

		$this->page_attributes->subtitle 			= $tmpData[$id];

		// filters
		if(Input::has('q'))
		{
			$this->page_attributes->search 			= Input::get('q');
		}		

		// data here
		$APIProduct 								= new APIProduct;
		$product 									= $APIProduct->getProducts([
															// 'labelname' => $tmpData[$id],
															'name' 	=> Input::get('q')
														]);

		$this->page_attributes->data				= 	[
															'id' => $id,
															'name' => $tmpData[$id],
															'product' => $product
														];

		//breadcrumb
		$breadcrumb 								=	[
															$tmpData[$id] => route('admin.label.show', $id)
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
