<?php 
namespace App\Http\Controllers\Toko;

use App\API\connectors\APICourier;
use App\Http\Controllers\AdminController;

use Input, Session, DB, Redirect, Response, Auth;

class CourierController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->page_attributes->title 				= 'Kurir';
		$this->page_attributes->source 				= 'pages.toko.kurir.';
		$this->page_attributes->breadcrumb			=	[
															'Kurir' 	=> route('admin.courier.index'),
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
		$APICourier 								= new APICourier;
		$courier 									= $APICourier->getIndex([
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
															'courier' 	=> $courier['data']
														];

		//paginate
		$this->paginate(route('admin.courier.index'), $courier['data']['count'], $page);

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
		$APICourier									= new APICourier;
		$courier									= $APICourier->getShow($id);

		$this->page_attributes->subtitle 			= $courier['data']['name'];		

		// filters
		if(Input::has('q'))
		{
			$filters 								= ['name' => Input::get('q')];
			$this->page_attributes->search 			= Input::get('q');

			// $collection 							= collect($courier['data']['products']);

			// $result 								= 	$collection->filter(function ($col) {
			// 												return strpos(strtolower($col['name']), strtolower(Input::get('q'))) !== FALSE;
			// 											});

			// $category['data']['products']			= $result;				
		}
		else
		{
			$this->page_attributes->search 			= null;
		}

		// data here
		$this->page_attributes->data				= 	[
															'courier' 	=> $courier['data'],
															'recents' 	=> [],
														];															
		//breadcrumb
		$breadcrumb 								=	[
															$courier['data']['name'] => route('admin.courier.show', ['id' => $courier['data']['name']])
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
															'Data Baru' => route('admin.courier.create'),
														];

			$this->page_attributes->subtitle 		= 'Data Baru';
		}
		else
		{
			$APICourier								= new APICourier;

			$courier 								= $APICourier->getShow($id)['data'];

			$this->page_attributes->data			= $courier;

			$breadcrumb								=	[
															'Edit'  =>  route('admin.courier.edit', ['id' => $id]),
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
		//price
		$tmpAddress 								= 	[
															'id' 			=> "",
															'phone'			=> Input::get('phone'),
															'address'		=> Input::get('address'),
															'zipcode'		=> Input::get('zipcode'),
														];

		//image
		$tmpImage 									= 	[
															'id' 			=> "",
															'thumbnail'		=> Input::get('thumbnail'),
															'image_xs'		=> Input::get('image_xs'),
															'image_sm'		=> Input::get('image_sm'),
															'image_md'		=> Input::get('image_md'),
															'image_lg'		=> Input::get('image_lg'),
															'is_default'	=> TRUE,
														];	

		//get data
		$data 										= 	[
															'id' 			=> $id,
															'name'			=> Input::get('name'),
															'shippingcosts'	=> [],
															'images'		=> ['0' => $tmpImage],
															'addresses'		=> ['0' => $tmpAddress],
														];

		//api
		$APICourier 								= new APICourier;

		$result 									= $APICourier->postData($data);

		//response
		if($result['status'] != 'success')
		{
			$this->errors 							= $result['message'];
		}

		//return view
		if(!empty($id))
		{
			$this->page_attributes->success 		= "Data Kurir Telah Diedit";
		}
		else
		{
			$this->page_attributes->success 		= "Data Kurir Telah Ditambahkan";
		}
		
		return $this->generateRedirectRoute('admin.courier.index');				
	}

	public function Update($id)
	{
		return $this->store($id);
	}

	public function destroy($id)
	{
		$APICourier 								= new APICourier;

		//api
		$result 									= $APICourier->deleteData($id);

		//response
		if($result['status'] != 'success')
		{
			$this->errors 							= $result['message'];
		}

		//return
		$this->page_attributes->success 			= "Data telah dihapus";
		
		return $this->generateRedirectRoute('admin.courier.index');	
	}		
}
