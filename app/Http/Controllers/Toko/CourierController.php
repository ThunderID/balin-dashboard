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
															'Data Baru' => route('admin.courier.create'),
														];

			$this->page_attributes->subtitle 		= 'Data Baru';
		}
		else
		{
			$data 									= ['name' => 'nama'];

			$breadcrumb								=	[
															'Edit Data ' . $data['name']  =>  route('admin.courier.create'),
														];

			// $this->page_attributes->subtitle 		= $courier->name;
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
}
