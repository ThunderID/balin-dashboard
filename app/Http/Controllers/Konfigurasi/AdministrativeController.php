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
		//initialize
		if (is_null($id))
		{
			$breadcrumb								=	[
															'Data Baru' => route('admin.administrative.create'),
														];

			$data 									= null;														

			$this->page_attributes->subtitle 		= 'Data Baru';
		}
		else
		{
			$APIAdmin 								= new APIAdmin;
			$data 									= ['data' => $APIAdmin->getShow($id)['data'] ];	

			$breadcrumb								=	[
															$data['data']['name']  =>  route('admin.administrative.show', ['id' => $data['data']['id']] ),
															'Edit'  =>  route('admin.administrative.create', ['id' => $data['data']['id']] ),
														];

			$this->page_attributes->subtitle 		= $data['data']['name'];
		}

		//generate View
		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		$this->page_attributes->data 				=  $data;

		$this->page_attributes->source 				=  $this->page_attributes->source . 'create';

		return $this->generateView();
	}

	public function edit($id)
	{
		return $this->create($id);
	}

	public function store($id = null)
	{
		$APIAdmin 									= new APIAdmin;
		
		//format input
		$inputEmail 								= Input::get('email');
		$inputRole 									= Input::get('role');

		if(Input::has('is_active'))
		{
			$inputIsActive 							= true;
		}
		else
		{
			$inputIsActive 							= false;
		}

		if(Input::has('password'))
		{
			$rules 									= ['password' => 'min:8|confirmed'];

			$validator 								= Validator::make(Input::only('password', 'password_confirmation'), $rules);

			if(!$validator->passes())
			{
				$this->errors 							= $validator->errors;
	
				return $this->generateRedirectRoute('admin.administrative.show', ['id' => Input::get('admin')]);
			}
		}		

		//is edit
		if(!empty($id))
		{
			//get data
			$data 									= $APIAdmin->getShow($id);

			$admin['id']							= $data['data']['id'];
			$admin['name']							= $data['data']['name'];
			$admin['gender']						= $data['data']['gender'];
			if(strtotime($data['data']['date_of_birth']))
			{
				$admin['date_of_birth']				= $data['data']['date_of_birth'];
			}
			else
			{
				$admin['date_of_birth']				= '';
			}
			$admin['email']							= $inputEmail;
			$admin['role']							= $inputRole;
			$admin['is_active']						= $inputIsActive;
		}
		else
		{
			$admin['email']							= $inputEmail;
			$admin['role']							= $inputRole;
			$admin['is_active']						= $inputIsActive;

			$admin['id']							= '';
		}

		if(Input::has('password'))
		{
			$admin['password']						= Input::get('password');
		}


		//save
		$result 									= $APIAdmin->postData($admin);

		//response
		if($result['status'] != 'success')
		{
			$this->errors 							= $result['message'];
		}

		//return view
		if(!empty($id))
		{
			$this->page_attributes->success 		= "Data Admin Telah Diedit";
		}
		else
		{
			$this->page_attributes->success 		= "Data Admin Telah Ditambahkan";
		}

		return $this->generateRedirectRoute('admin.administrative.show', ['id' => Input::get('admin')]);
	}

	public function Update($id)
	{
		return $this->store($id);
	}

	public function destroy($id)
	{

	}		
}
