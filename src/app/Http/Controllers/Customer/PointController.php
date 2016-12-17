<?php 
namespace App\Http\Controllers\Customer;

use App\API\Connectors\APIPoint;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Helper\SortList;

use Input, Session, DB, Redirect, Response, Auth;

/**
 * Handle customer point information
 * 
 * @author cmooy
 */
class PointController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->page_attributes->title 				= 'Poin';
		$this->page_attributes->source 				= 'pages.kostumer.poin.';
		$this->page_attributes->breadcrumb			=	[
															'Poin' 	=> route('customer.point.index'),
														];	
        $this->middleware('password.needed', ['only' => ['destroy']]);																
	}

	/**
	 * Display all point
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
		$search 									= null;

		if(Input::has('q'))
		{
			$search 								= ['customername' => Input::get('q')];
			$this->page_attributes->search 			= Input::get('q');
		}
		else
		{
			$searchResult							= null;
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

		$SortList 									= new SortList;
		
		$this->page_attributes->sorts 				= 	[
															'titles'		=> ['kadaluarsa', 'jumlah'],
															'kadaluarsa'	=> $SortList->getSortingList('kadaluarsa'),
															'jumlah'		=> $SortList->getSortingList('jumlah'),
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
		$APIPoint 									= new APIPoint;

		$point 										= $APIPoint->getIndex([
														'search' 	=> $search,
														'sort' 		=> $sort,																		
														'take'		=> $this->take,
														'skip'		=> ($page - 1) * $this->take,
														]);

		$this->page_attributes->data				= 	[
															'point' => $point,
														];

		//4. Generate paginator
		$this->paginate(route('customer.point.index'), $point['data']['count'], $page);

		//5. Generate breadcrumb
		$breadcrumb								=	[
													];
		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		//6. Generate view
		$this->page_attributes->source 				=  $this->page_attributes->source . 'index';

		return $this->generateView();
	}

	/**
	 * create form of a point
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
															'Data Baru' => route('customer.point.create'),
														];

			$data 									= null;														

			$this->page_attributes->subtitle 		= 'Data Baru';
		}
		else
		{
			$APIPoint 								= new APIPoint;
			$data 									= ['data' => $APIPoint->getShow($id)['data'] ];	

			$breadcrumb								=	[
															$data['data']['name']  =>  route('customer.point.show', ['id' => $data['data']['id']] ),
															'Edit'  =>  route('customer.point.create', ['id' => $data['data']['id']] ),
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
	 * Edit a point
	 * 
	 * @param id
	 * @return function
	 */
	public function edit($id)
	{
		return $this->create($id);
	}

	/**
	 * Store an point
	 * 
	 * 1. Check input
	 * 2. Check data
	 * 3. Save point
	 * 4. Check Response
	 * 5. Return view
	 * @param id
	 * @return object view
	 */
	public function store($id = null)
	{

		//1. Check input
		$inputCustomer 								= Input::get('customer');
		$inputNotes 								= Input::get('notes');
		$inputAmount 								= str_replace('IDR ', '', str_replace('.', '', Input::get('amount')));
		$inputExpireDate 							= date('Y-m-d H:i:s', strtotime(Input::get('expired_at')));

		//2. Check data
		$APIPoint 									= new APIPoint;

		if(!empty($id))
		{
			$point['id']							= '';
			$point['user_id']						= $inputCustomer;
			$point['notes']							= $inputNotes;
			$point['amount']						= $inputAmount;
			$point['expired_at']					= $inputExpireDate;
		}
		else
		{
			$point['id']							= '';
			$point['user_id']						= $inputCustomer;
			$point['notes']							= $inputNotes;
			$point['amount']						= $inputAmount;
			$point['expired_at']					= $inputExpireDate;
		}

		//3. Save point
		$result 									= $APIPoint->postData($point);

		//4. Check Response
		if($result['status'] != 'success')
		{
			$this->errors 							= $result['message'];
		}

		//5. Return view
		if(!empty($id))
		{
			$this->page_attributes->success 		= "Data Point Telah Ditambahkan";
		}
		else
		{
			$this->page_attributes->success 		= "Data Point Telah Ditambahkan";
		}

		return $this->generateRedirectRoute('customer.point.index');
	}

	/**
	 * Update a customer
	 * 
	 * @param id
	 * @return function
	 */
	public function Update($id)
	{
		return $this->store($id);
	}
}
