<?php 
namespace App\Http\Controllers\konfigurasi;

use App\API\Connectors\APIAdmin;
use App\Http\Controllers\AdminController;
use Input, Session, DB, Redirect, Response, Auth;

class AdministrativeController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->page_attributes->title 				= 'Administrasi';
		$this->page_attributes->source 				= 'pages.konfigurasi.administrasi.';
		$this->page_attributes->breadcrumb			=	[
															'Administrasi' 	=> route('admin.administrative.index'),
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
		$APIAdmin 									= new APIAdmin;

		$admin 										= $APIAdmin->getIndex([
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
															'admin' => $admin,
														];

		//paginate
		$this->paginate(route('admin.administrative.index'), $admin['data']['count'], $page);

		//breadcrumb
		$breadcrumb								=	[
													];

		//generate View
		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		$this->page_attributes->source 				=  $this->page_attributes->source . '.index';

		return $this->generateView();
	}

	public function show($id)
	{
		//initialize 
		$APIAdmin 									= new APIAdmin;
		$admin 										= $APIAdmin->getShow($id);

		$this->page_attributes->subtitle 			= $admin['data']['name'];

		// filters
		if(Input::has('q'))
		{
			$this->page_attributes->search 			= Input::get('q');
		}		

		// data here
		$this->page_attributes->data				= 	[
															'admin' => $admin,
														];

		//breadcrumb
		$breadcrumb 								=	[
															$admin['data']['name'] => route('admin.administrative.show', ['id' => $id])
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
