<?php 
namespace App\Http\Controllers\konfigurasi;

use App\API\connectors\APICourier;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Helper\SortList;

use Input, Session, DB, Redirect, Response, Auth, Excel, Carbon;

class CourierController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->page_attributes->title 				= 'Kurir';
		$this->page_attributes->source 				= 'pages.konfigurasi.kurir.';
		$this->page_attributes->breadcrumb			=	[
															'Kurir' 	=> route('shop.courier.index'),
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
		$APICourier 								= new APICourier;
		$courier 									= $APICourier->getIndex([
															'search' 	=> 	[
																				'name' 	=> Input::get('q'),
																			],
															'sort' 		=> $sort,																		
															'take'		=> $this->take,
															'skip'		=> ($page - 1) * $this->take,
														]);

		$this->page_attributes->data				= 	[
															'courier' 	=> $courier['data']
														];


		//sorting
		$SortList 									= new SortList;

		$this->page_attributes->sorts 				= 	[
															'titles'	=> ['nama'],
															'nama'		=> $SortList->getSortingList('nama'),
														]; 	

		//paginate
		$this->paginate(route('shop.courier.index'), $courier['data']['count'], $page);

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

			$collection 							= collect($courier['data']['shippingcosts']);

			$result 								= $collection->filter(function ($col) {
															return ($col['start_postal_code'] <= Input::get('q')) && ($col['end_postal_code'] >= Input::get('q'));
														});

			$courier['data']['shippingcosts']		= $result;				
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
		$collection 								= collect($courier['data']['shippingcosts']);

		if(count($collection) != 0)
		{
			$result 								= $collection->chunk($this->take);

			$this->paginate(route('shop.courier.index'), count($courier['data']['shippingcosts']), $page);	

			$courier['data']['shippingcosts']		= $result[($page-1)];
		}
		else
		{
			$this->paginate(route('shop.courier.index'), count($courier['data']['shippingcosts']), $page);	
		}


		// data here
		$this->page_attributes->data				= 	[
															'courier' 	=> $courier['data'],
															'recents' 	=> [],
														];															
		//breadcrumb
		$breadcrumb 								=	[
															$courier['data']['name'] => route('shop.courier.show', ['id' => $courier['data']['name']])
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
															'Data Baru' => route('shop.courier.create'),
														];

			$this->page_attributes->subtitle 		= 'Data Baru';
		}
		else
		{
			$APICourier								= new APICourier;

			$courier 								= $APICourier->getShow($id)['data'];

			$this->page_attributes->data			= $courier;

			$breadcrumb								=	[
															$courier['name']  =>  route('shop.courier.show', ['id' => $id]),
															'Edit'  =>  route('shop.courier.edit', ['id' => $id]),
														];

			$this->page_attributes->subtitle 		= $courier['name'];
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
		
		return $this->generateRedirectRoute('shop.courier.index');				
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
		
		return $this->generateRedirectRoute('shop.courier.index');	
	}		


	public function addShippingCost($id)
	{
		$APICourier 								= new APICourier;
		$courier 									= $APICourier->getShow($id);

		$courier 									= $courier['data'];

		$breadcrumb									=	[
															$courier['name']  =>  route('shop.courier.show', ['id' => $id ]),
															'Ongkos Kirim'  =>  route('shop.courier.edit', ['id' => $id ]),
														];

		// data here
		$this->page_attributes->data				= $courier;	

		//generate View
		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		$this->page_attributes->source 				=  $this->page_attributes->source . 'Cost.create';

		return $this->generateView();											
	}

	public function importShippingCost($id)
	{
		//get CSV
		$file_csv         	= Input::file('file');
	    $attributes 		= [];                
        $sheet 				= Excel::load($file_csv)->toArray();        


        //data cost
        $cost 				= [];
        foreach ($sheet as $key => $value) 
        {
        	$cost[$key]['id']						= "";
        	$cost[$key]['start_postal_code']		= $value[0];
        	$cost[$key]['end_postal_code']			= $value[1];
        	$cost[$key]['started_at']				= Carbon::createFromFormat('m/d/Y', $value[2])->format('Y-m-d H:i:s');;
        	$cost[$key]['cost']						= $value[3];
        }


        //get data courier
		$APICourier 								= new APICourier;
		$courier 									= $APICourier->getShow($id)['data'];
		$courier['shippingcosts']        			= $cost;

        //save data 
		$result 									= $APICourier->postData($courier);

		//response
		if($result['status'] != 'success')
		{
			$this->errors 							= $result['message'];
		}

		//return view
		$this->page_attributes->success 			= "Data Ongkos Kirim Telah Ditambahkan";
		
		return $this->generateRedirectRoute('shop.courier.show' , ['id' => $id]);	
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
