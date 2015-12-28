<?php 
namespace App\Http\Controllers\Barang;

use App\Http\Controllers\AdminController;
use Input, Session, DB, Redirect, Response, Auth;

class ProductController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->page_attributes->title 				= 'Produk';
		$this->page_attributes->source 				= 'pages.barang.produk.';
		$this->page_attributes->breadcrumb			=	[
															'Produk' 	=> route('admin.product.index'),
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
