<?php 
namespace App\Http\Controllers\Barang;

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
			$filters 								= ['name' => Input::get('q')];
			$this->page_attributes->search 			= Input::get('q');
		}
		else
		{
			$searchResult							= null;
		}

		// data here
		$this->page_attributes->data				= [];


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
		$this->page_attributes->subtitle 			= 'Product name';

		// filters
		if(Input::has('start') && Input::has('end'))
		{
			$this->page_attributes->search 			= 'Periode ' . Input::get('start') . ' sampai ' . Input::get('end');
		}		

		// data here
		$this->page_attributes->data				= 	[
															'id' => 1,

														];

		//breadcrumb
		$breadcrumb 								=	[
															'Produk Name' => route('admin.label.index')
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
