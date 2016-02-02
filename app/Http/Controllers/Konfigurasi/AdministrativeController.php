<?php 
namespace App\Http\Controllers\konfigurasi;

use App\API\Connectors\APIAdmin;

use App\Http\Controllers\AdminController;

use Input, Session, DB, Redirect, Response, Auth, Validator;

/**
 * Handle admin resource
 * 
 * @author cmooy
 */
class AdministrativeController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->page_attributes->title 				= 'Administrasi';
		$this->page_attributes->source 				= 'pages.konfigurasi.administrasi.';
		$this->page_attributes->breadcrumb			=	[
															'Administrasi' 	=> route('config.administrative.index'),
														];			
	}

	/**
	 * Display all admin
	 * 
	 * 1. Check filter
	 * 2. Check page
	 * 3. Get data from API
	 * 4. Generate paginator
	 * 5. Generate breadcrumb
	 * 6. Generate view
	 * @param page, q
	 * @return Object View
	 */
	public function index()
	{
		//1. Check filter 
		$search 									= [];

		if(Input::has('q'))
		{
			$search 								= ['name' => Input::get('q')];
			$this->page_attributes->search 			= Input::get('q');
		}
		else
		{
			$searchResult							= null;
		}

		if(Input::has('role'))
		{
			$search['role']							= Input::get('role');
		}

		$this->page_attributes->filters 			= 	[
															'titles' 	=> ['role'],
															'role'		=> ['admin', 'staff', 'store manager'],
														];

		//2. Check page
		if(is_null(Input::get('page')))
		{
			$page 									= 1;
		}
		else
		{
			$page 									= Input::get('page');
		}

		//3. Get data from API
		$APIAdmin 									= new APIAdmin;

		$admin 										= $APIAdmin->getIndex([
														'search' 	=> 	$search,
														'sort' 		=> 	[
																			'name'	=> 'asc',
																		],																		
														'take'		=> $this->take,
														'skip'		=> ($page - 1) * $this->take,
														]);

		$this->page_attributes->data				= 	[
															'admin' => $admin,
														];

		//4. Generate paginator
		$this->paginate(route('config.administrative.index'), $admin['data']['count'], $page);

		//5. Generate breadcrumb
		$breadcrumb								=	[
													];

		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);
		
		//6. Generate View
		$this->page_attributes->source 				=  $this->page_attributes->source . '.index';

		return $this->generateView();
	}

	/**
	 * Display an admin
	 * 
	 * 1. Get data from API
	 * 2. Generate breadcrumb
	 * 3. Generate view
	 * @param id
	 * @return Object View
	 */
	public function show($id)
	{
		//1. Get data from API 
		$APIAdmin 									= new APIAdmin;
		$admin 										= $APIAdmin->getShow($id);

		$this->page_attributes->subtitle 			= $admin['data']['name'];

		$this->page_attributes->data				= 	[
															'admin' => $admin,
														];

		//2. Generate breadcrumb
		$breadcrumb 								=	[
															$admin['data']['name'] => route('config.administrative.show', ['id' => $id])
														];	
		
		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		//3. Generate view
		$this->page_attributes->source 				= $this->page_attributes->source . 'show';

		return $this->generateView();
	}	

	/**
	 * create form of an admin
	 * 
	 * 1. Get Previous data and page setting
	 * 2. Initialize data
	 * 3. Generate breadcrumb
	 * 4. Generate view
	 * @param id
	 * @return Object View
	 */
	public function create($id = null)
	{
		//1. Get Previous data and page setting
		if (is_null($id))
		{
			$breadcrumb								=	[
															'Data Baru' => route('config.administrative.create'),
														];

			$data 									= null;														

			$this->page_attributes->subtitle 		= 'Data Baru';
		}
		else
		{
			$APIAdmin 								= new APIAdmin;
			$data 									= ['data' => $APIAdmin->getShow($id)['data'] ];	

			$breadcrumb								=	[
															$data['data']['name']  	=>  route('config.administrative.show', ['id' => $data['data']['id']] ),
															'Edit'  				=>  route('config.administrative.create', ['id' => $data['data']['id']] ),
														];

			$this->page_attributes->subtitle 		= $data['data']['name'];
		}

		//2. Initialize data
		$this->page_attributes->data 				=  $data;
		
		//3. Generate breadcrumb
		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		//4. Generate view
		$this->page_attributes->source 				=  $this->page_attributes->source . 'create';

		return $this->generateView();
	}

	/**
	 * Edit an admin
	 * 
	 * @param id
	 * @return function
	 */
	public function edit($id)
	{
		return $this->create($id);
	}

	/**
	 * Store an admin
	 * 
	 * 1. Check input
	 * 2. Check data
	 * 3. Save admin
	 * 4. Check Response
	 * 5. Return view
	 * @param id
	 * @return object view
	 */
	public function store($id = null)
	{
		//1. Check input
		$inputName 									= Input::get('name');
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
				$this->errors 						= $validator->errors();
	
				return $this->generateRedirectRoute('config.administrative.show', ['id' => Input::get('admin')]);
			}
		}

		$APIAdmin 									= new APIAdmin;

		//2. Check data
		if(!empty($id))
		{
			$data 									= $APIAdmin->getShow($id);

			$admin['id']							= $data['data']['id'];
			$admin['name']							= $inputName;
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
			$admin['name']							= $inputName;
			$admin['email']							= $inputEmail;
			$admin['role']							= $inputRole;
			$admin['is_active']						= $inputIsActive;

			$admin['id']							= '';
		}

		if(Input::has('password'))
		{
			$admin['password']						= Input::get('password');
		}


		//3. Save admin
		$result 									= $APIAdmin->postData($admin);

		//4. Check Response
		if($result['status'] != 'success')
		{
			$this->errors 							= $result['message'];
		}

		//5. Return view
		if(!empty($id))
		{
			$this->page_attributes->success 		= "Data Admin Telah Diedit";
		}
		else
		{
			$this->page_attributes->success 		= "Data Admin Telah Ditambahkan";
		}

		return $this->generateRedirectRoute('config.administrative.show', ['id' => Input::get('admin')]);
	}

	/**
	 * Update an admin
	 * 
	 * @param id
	 * @return function
	 */
	public function Update($id)
	{
		return $this->store($id);
	}
}
