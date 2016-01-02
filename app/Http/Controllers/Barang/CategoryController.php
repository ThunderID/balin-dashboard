<?php 
namespace App\Http\Controllers\Barang;

use App\Http\Controllers\AdminController;
use Input, Session, DB, Redirect, Response, Auth;

class CategoryController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->page_attributes->title 				= 'Kategori';
		$this->page_attributes->source 				= 'pages.barang.kategori.';
		$this->page_attributes->breadcrumb			=	[
															'Kategori' 	=> route('admin.category.index'),
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
		//initialize
		if (is_null($id))
		{
			$breadcrumb								=	[
															'Data Baru' => route('admin.category.create'),
														];

			$this->page_attributes->subtitle 		= 'Data Baru';
		}
		else
		{
			$data 									= ['name' => 'nama'];

			$breadcrumb								=	[
															'Edit Data ' . $data['name']  =>  route('admin.category.create'),
														];

			// $this->page_attributes->subtitle 		= $tag->name;
		}

		//generate View
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

	//AJAX
	public function AjaxFindName()
	{
		return json_encode('test');
	}		
}
