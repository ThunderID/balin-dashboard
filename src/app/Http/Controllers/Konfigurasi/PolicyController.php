<?php 
namespace App\Http\Controllers\Konfigurasi;

use App\API\Connectors\APIPolicy;

use App\Http\Controllers\AdminController;

use Input, Session, DB, Redirect, Response, Auth;

/**
 * Handle policy resource
 * 
 * @author cmooy
 */
class PolicyController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->page_attributes->title 				= 'Policy';
		$this->page_attributes->source 				= 'pages.konfigurasi.policy.';
		$this->page_attributes->breadcrumb			=	[
															'Policy' 	=> route('config.policy.index'),
														];			
	}

	/**
	 * Display all policy
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
		$APIPolicy 									= new APIPolicy;

		$policy 									= $APIPolicy->getIndex([
														'search' 	=> 	[
																			'name' 		=> Input::get('q'),
																			'default'	=> 'true',
																		],
														'sort' 		=> 	[
																			'name'	=> 'asc',
																		],																		
														'take'		=> $this->take,
														'skip'		=> ($page - 1) * $this->take,
														]);

		$this->page_attributes->data				= 	[
															'policy' => $policy,
														];

		//4. Generate paginator
		$this->paginate(route('config.policy.index'), $policy['data']['count'], $page);

		//5. Generate breadcrumb
		$breadcrumb								=	[
													];

		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);
		
		//6. Generate View
		$this->page_attributes->source 				=  $this->page_attributes->source . '.index';

		return $this->generateView();
	}

	/**
	 * create form of a policy
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
			\App::abort(404);
		}
		else
		{
			$APIPolicy 								= new APIPolicy;
			$data 									= ['data' => $APIPolicy->getShow($id)['data'] ];	

			$breadcrumb								=	[
															str_replace('_', ' ', $data['data']['type'])  =>  route('config.policy.index'),
															'Edit'  =>  route('config.policy.create', ['id' => $data['data']['id']] ),
														];

			$this->page_attributes->subtitle 		= str_replace('_', ' ', $data['data']['type']);
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
	 * Edit a policy
	 * 
	 * @param id
	 * @return function
	 */
	public function edit($id)
	{
		return $this->create($id);
	}

	/**
	 * Store a policy
	 * 
	 * 1. Check input
	 * 2. Check data
	 * 3. Save policy
	 * 4. Check Response
	 * 5. Return view
	 * @param id
	 * @return object view
	 */
	public function store($id = null)
	{
		//1. Check input
		$inputValue 								= Input::get('value');
		$inputStartDate 							= date('Y-m-d H:i:s', strtotime(Input::get('started_at')));

		//2. Check data
		$APIPolicy 									= new APIPolicy;
		if(!empty($id))
		{
			//get data
			$data 									= $APIPolicy->getShow($id);

			$policy['id']							= '';
			$policy['type']							= $data['data']['type'];
			$policy['value']						= $inputValue;
			$policy['started_at']					= $inputStartDate;
		}
		else
		{
			\App::abort(404);
		}


		//3. Save policy
		$result 									= $APIPolicy->postData($policy);

		//4. Check Response
		if($result['status'] != 'success')
		{
			$this->errors 							= $result['message'];
		}

		//5. Return view
		if(!empty($id))
		{
			$this->page_attributes->success 		= "Data Policy Telah Diedit";
		}
		else
		{
			$this->page_attributes->success 		= "Data Policy Telah Ditambahkan";
		}

		return $this->generateRedirectRoute('config.policy.index', ['id' => Input::get('policy')]);
	}

	/**
	 * Update a policy
	 * 
	 * @param id
	 * @return function
	 */
	public function Update($id)
	{
		return $this->store($id);
	}
}
