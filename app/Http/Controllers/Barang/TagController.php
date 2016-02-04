<?php 
namespace App\Http\Controllers\Barang;

use App\API\connectors\APITag;

use App\Http\Controllers\AdminController;
use Input, Session, DB, Redirect, Response, Auth, Collection;

class TagController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->page_attributes->title 				= 'Tag';
		$this->page_attributes->source 				= 'pages.barang.tag.';
		$this->page_attributes->breadcrumb			=	[
															'Tag' 	=> route('goods.tag.index'),
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
		$APITag 									= new APITag;
		$tag 										= $APITag->getIndex([
															'search' 	=> 	[
																				'name' 	=> Input::get('q'),
																			],
															'sort' 		=> 	[
																				'name'	=> 'asc',
																			],																		
															'take'		=> $this->take,
															'skip'		=> ($page - 1) * $this->take,															
														]);


		$this->page_attributes->data				=  	[
															'data' => $tag['data'],
														];

		//paginate
		$this->paginate(route('goods.tag.index'), $tag['data']['count'], $page);


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
		$APITag	 									= new APITag;
		$tag										= $APITag->getShow($id);

		$this->page_attributes->subtitle 			= $tag['data']['name'];


		// filters
		if(Input::has('q'))
		{
			$filters 								= ['name' => Input::get('q')];
			$this->page_attributes->search 			= Input::get('q');

			$collection 							= collect($tag['data']['products']);


			$result 								= $collection->filter(function ($col) {
															return strpos(strtolower($col['name']), strtolower(Input::get('q'))) !== FALSE;
														});			

			$tag['data']['products']				= $result;				
		}
		else
		{
			$this->page_attributes->search 			= null;
		}
	
		// data here
		$this->page_attributes->data				= $tag['data'];

		//breadcrumb
		$breadcrumb 								=	[
															$tag['data']['name'] => route('goods.tag.show', ['id' => $tag['data']['name']])
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
															'Data Baru' => route('goods.tag.create'),
														];

			$this->page_attributes->subtitle 		= 'Data Baru';
		}
		else
		{
			$APITag									= new APITag;

			$tag 									= $APITag->getShow($id)['data'];

			$this->page_attributes->data			= $tag;

			$breadcrumb								=	[
															$tag['name']  =>  route('goods.tag.show', ['id' => $id]),
															'Edit'  =>  route('goods.tag.edit', ['id' => $id]),
														];

			$this->page_attributes->subtitle 		= $tag['name'];
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
		$APITag 									= new APITag;

		$result 									= $APITag->postData($data);

		//response
		if($result['status'] != 'success')
		{
			$this->errors 							= $result['message'];
		}

		//return view
		if(!empty($id))
		{
			$this->page_attributes->success 		= "Data Tag Telah Diedit";
		}
		else
		{
			$this->page_attributes->success 		= "Data Tag Telah Ditambahkan";
		}
		
		return $this->generateRedirectRoute('goods.tag.index');														
	}

	public function Update($id)
	{
		return $this->store($id);
	}

	public function destroy($id)
	{
		$APITag 									= new APITag;

		//api
		$result 									= $APITag->deleteData($id);

		//response
		if($result['status'] != 'success')
		{
			$this->errors 							= $result['message'];
		}

		//return
		$this->page_attributes->success 			= "Data telah dihapus";
		
		return $this->generateRedirectRoute('goods.tag.index');	
	}	


	//AJAX
	public function AjaxFindName()
	{
		return json_encode('test');
	}	
}
