<?php 
namespace App\Http\Controllers\Barang;

use App\API\Connectors\APICategory;
use App\API\Connectors\APIProduct;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Helper\SortList;

use Input, Session, DB, Redirect, Response, Auth, Collection;

class CategoryController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->page_attributes->title 				= 'Kategori';
		$this->page_attributes->source 				= 'pages.barang.kategori.';
		$this->page_attributes->breadcrumb			=	[
															'Kategori' 	=> route('goods.category.index'),
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
		$this->paginate(route('goods.category.index'), $category['data']['count'], $page);

		//breadcrumb
		$breadcrumb 								= [];	

		//generate View
		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		$this->page_attributes->source 				=  $this->page_attributes->source . 'index';

		return $this->generateView();
	}

	public function show($id)
	{
		//get data category
		$APICategory	 							= new APICategory;
		$category									= $APICategory->getShow($id);

		$this->page_attributes->subtitle 			= $category['data']['name'];

		//search
		if(Input::has('q'))
		{
			$search 								= 	[
															'name'			=> 	Input::get('q'),
															'categories'	=> 	str_replace(" ", "-", strtolower($category['data']['slug'])),
														];

			$this->page_attributes->search 			= Input::get('q');
		}
		else
		{
			$search 								= 	[
															'categories'	=> 	str_replace(" ", "-", strtolower($category['data']['slug'])),
														];
		}		

		//sort
		if (Input::has('sort'))
		{
			$sort_item 								= explode('-', Input::get('sort'));
			$sort 									= [$sort_item[0] => $sort_item[1]];
		}
		else
		{
			$sort									= [];
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

		//get product data
		$APIProduct	 								= new APIProduct;

		$product 									= $APIProduct->getIndex([
															'search' 	=> $search,
															'sort' 		=> $sort,																		
															'take'		=> $this->take,
															'skip'		=> ($page - 1) * $this->take,
														]);

		//data paging	
		$this->paginate(route('goods.category.show', ['id' => $category['data']['id']]), $product['data']['count'], $page);

		$category['data']['products']				= $product['data']['data'];

		//sorting
		$SortList 									= new SortList;

		$this->page_attributes->sorts 				= 	[
															'titles'	=> ['nama', 'harga', 'stok'],
															'nama'		=> $SortList->getSortingList('nama'),
															'harga'		=> $SortList->getSortingList('harga'),
															'stok'		=> $SortList->getSortingList('stok'),
														]; 	

		// data here
		$this->page_attributes->data				= $category['data'];

		//breadcrumb
		$breadcrumb 								=	[
															$category['data']['name'] => route('goods.category.show', ['id' => $category['data']['name']])
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
															'Data Baru' => route('goods.category.create'),
														];

			$this->page_attributes->subtitle 		= 'Data Baru';
		}
		else
		{
			$APICategory							= new APICategory;

			$category 								= $APICategory->getShow($id)['data'];

			$this->page_attributes->data			= $category;

			$breadcrumb								=	[
															$category['name'] =>  route('goods.category.show', ['id' => $id]),
															'Edit' =>  route('goods.category.edit', ['id' => $id]),
														];

			$this->page_attributes->subtitle 		= $category['name'];
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
		return $this->generateRedirectRoute('goods.category.index');	
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

		//return view
		$this->page_attributes->success 			= "Data Produk Telah Dihapus";
		
		return $this->generateRedirectRoute('goods.category.index');	
	}		

	//AJAX
	public function AjaxFindName()
	{
		return json_encode('test');
	}		
}
