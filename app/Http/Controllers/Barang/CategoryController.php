<?php 
namespace App\Http\Controllers\Barang;

use App\API\connectors\APICategory;

use App\Http\Controllers\AdminController;
use Input, Session, DB, Redirect, Response, Auth, Collection;

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
			$this->page_attributes->search 			= null;
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
		$APICategory 								= new APICategory;
		$category 									= $APICategory->getIndex([
														'search' 	=> 	[
																			'name' 	=> Input::get('q'),
																		],
														'sort' 		=> 	[
																			'name'	=> 'asc',
																		],																		
														'take'		=> $this->take,
														'skip'		=> ($page - 1) * $this->take,
														]);


		$this->page_attributes->data				= 	[
															'category' => $category['data']
														];

		//paginate
		$this->paginate(route('admin.category.index'), $category['data']['count'], $page);

		//breadcrumb
		$breadcrumb 								= [];	

		//generate View
		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		$this->page_attributes->source 				=  $this->page_attributes->source . 'index';

		return $this->generateView();
	}

	public function show($id)
	{
		//get data 
		$APICategory	 							= new APICategory;
		$category									= $APICategory->getShow($id);

		$this->page_attributes->subtitle 			= $category['data']['name'];


		// filters
		if(Input::has('q'))
		{
			$filters 								= ['name' => Input::get('q')];
			$this->page_attributes->search 			= Input::get('q');

			$collection 							= collect($category['data']['products']);

			$result 								= 	$collection->filter(function ($col) {
															return strpos(strtolower($col['name']), strtolower(Input::get('q'))) !== FALSE;
														});

			$category['data']['products']			= $result;			
		}
		else
		{
			$this->page_attributes->search 			= null;
		}

		// data here
		$this->page_attributes->data				= $category['data'];

		//breadcrumb
		$breadcrumb 								=	[
															$category['data']['name'] => route('admin.category.show', ['id' => $category['data']['name']])
														];	

		//generate View
		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		$this->page_attributes->source 				= $this->page_attributes->source . 'show';

		return $this->generateView();
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
			$APICategory							= new APICategory;

			$category 								= $APICategory->getShow($id)['data'];

			$this->page_attributes->data			= $category;

			$breadcrumb								=	[
															'Edit Kategori '. $category['name'] =>  route('admin.category.edit', ['id' => $id]),
														];

			$this->page_attributes->subtitle 		= 'Edit Data';
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

	public function store($id = "")
	{
		//get data
		$data 										= 	[
															'id' 			=> $id,
															'name'			=> Input::get('name'),
															'category_id'	=> Input::get('category_id'),
														];

		//api
		$APICategory 								= new APICategory;

		$result 									= $APICategory->postData($data);

		//response
		if($result['status'] != 'success')
		{
			$this->errors 							= $result['message'];
		}

		//return
		$this->page_attributes->success 			= "Data telah ditambahkan";
		return $this->generateRedirectRoute('admin.category.index');	
	}

	public function Update($id)
	{
		return $this->store($id);
	}

	public function destroy($id)
	{
		$APICategory 								= new APICategory;

		//api
		$result 									= $APICategory->deleteData($id);

		//response
		if($result['status'] != 'success')
		{
			$this->errors 							= $result['message'];
		}

		//return
		$this->page_attributes->success 			= "Data telah dihapus";
		
		return $this->generateRedirectRoute('admin.category.index');	
	}		

	//AJAX
	public function AjaxFindName()
	{
		return json_encode('test');
	}		
}
