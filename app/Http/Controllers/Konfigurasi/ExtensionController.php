<?php 
namespace App\Http\Controllers\Konfigurasi;

use App\API\Connectors\APIExtension;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Helper\SortList;

use Input, Session, DB, Redirect, Response, Auth, Excel, Carbon;

class ExtensionController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->page_attributes->title 				= 'Produk Extension';
		$this->page_attributes->source 				= 'pages.konfigurasi.extension.';
		$this->page_attributes->breadcrumb			=	[
															'Produk Extension' 	=> route('config.extension.index'),
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


		//sort
		if (Input::has('sort'))
		{
			$sort_item 								= explode('-', Input::get('sort'));
			$sort 									= [$sort_item[0] => $sort_item[1]];
		}
		else
		{
			$sort									= ['name' => 'asc'];
		}


		// data here
		$APIExtension 								= new APIExtension;
		$extension 									= $APIExtension->getIndex([
															'search' 	=> 	[
																				'name' 	=> Input::get('q'),
																			],
															'sort' 		=> $sort,																		
															'take'		=> $this->take,
															'skip'		=> ($page - 1) * $this->take,
														]);

		$this->page_attributes->data				= 	[
															'extension' 	=> $extension['data']
														];


		//sorting
		$SortList 									= new SortList;

		$this->page_attributes->sorts 				= 	[
															'titles'	=> ['nama'],
															'nama'		=> $SortList->getSortingList('nama'),
														]; 	

		//paginate
		$this->paginate(route('config.extension.index'), $extension['data']['count'], $page);

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
		$APIExtension									= new APIExtension;
		$extension									= $APIExtension->getShow($id);

		$this->page_attributes->subtitle 			= $extension['data']['name'];		

		// filters
		if(Input::has('q'))
		{
			$filters 								= ['name' => Input::get('q')];
			$this->page_attributes->search 			= Input::get('q');

			$collection 							= collect($extension['data']['shippingcosts']);

			$result 								= $collection->filter(function ($col) {
															return ($col['start_postal_code'] <= Input::get('q')) && ($col['end_postal_code'] >= Input::get('q'));
														});

			$extension['data']['shippingcosts']		= $result;				
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

		//data paging	
		$collection 								= collect($extension['data']['shippingcosts']);

		if(count($collection) != 0)
		{
			$result 								= $collection->chunk($this->take);

			$this->paginate(route('config.extension.index'), count($extension['data']['shippingcosts']), $page);	

			$extension['data']['shippingcosts']		= $result[($page-1)];
		}
		else
		{
			$this->paginate(route('config.extension.index'), count($extension['data']['shippingcosts']), $page);	
		}


		// data here
		$this->page_attributes->data				= 	[
															'extension' 	=> $extension['data'],
															'recents' 	=> [],
														];															
		//breadcrumb
		$breadcrumb 								=	[
															$extension['data']['name'] => route('config.extension.show', ['id' => $extension['data']['name']])
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
															'Data Baru' => route('config.extension.create'),
														];

			$this->page_attributes->subtitle 		= 'Data Baru';
		}
		else
		{
			$APIExtension							= new APIExtension;

			$extension 								= $APIExtension->getShow($id)['data'];

			$this->page_attributes->data			= $extension;

			$breadcrumb								=	[
															$extension['name']  =>  route('config.extension.show', ['id' => $id]),
															'Edit'  =>  route('config.extension.edit', ['id' => $id]),
														];

			$this->page_attributes->subtitle 		= $extension['name'];
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
		//image
		$tmpImage 									= 	[
															'id' 			=> "",
															'thumbnail'		=> $this->isDataEmpty(Input::get('thumbnail')),
															'image_xs'		=> $this->isDataEmpty(Input::get('image_xs')),
															'image_sm'		=> $this->isDataEmpty(Input::get('image_sm')),
															'image_md'		=> $this->isDataEmpty(Input::get('image_md')),
															'image_lg'		=> $this->isDataEmpty(Input::get('image_lg')),
															'is_default'	=> TRUE,
														];	

		//get data
		$data 										= 	[
															'id' 			=> $id,
															'name'			=> Input::get('name'),
															'is_active'		=> Input::get('is_active'),
															'description'	=> Input::get('description'),
															'images'		=> ['0' => $tmpImage],
														];
		$data['price']								= str_replace('IDR ', '', str_replace('.', '', Input::get('price')));

		//api
		$APIExtension 								= new APIExtension;

		$result 									= $APIExtension->postData($data);

		//response
		if($result['status'] != 'success')
		{
			$this->errors 							= $result['message'];
		}

		//return view
		if(!empty($id))
		{
			$this->page_attributes->success 		= "Data Produk Extension Telah Diedit";
		}
		else
		{
			$this->page_attributes->success 		= "Data Produk Extension Telah Ditambahkan";
		}
		
		return $this->generateRedirectRoute('config.extension.index');				
	}

	public function Update($id)
	{
		return $this->store($id);
	}

	public function destroy($id)
	{
		$APIExtension 								= new APIExtension;

		//api
		$result 									= $APIExtension->deleteData($id);

		//response
		if($result['status'] != 'success')
		{
			$this->errors 							= $result['message'];
		}

		//return
		$this->page_attributes->success 			= "Data Produk Extension telah dihapus";
		
		return $this->generateRedirectRoute('config.extension.index');	
	}	

	public function isDataEmpty($data)
	{
		if(is_null($data))
		{
			return "";
		}

		return $data;
	}	
}
