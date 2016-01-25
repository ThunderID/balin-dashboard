<?php 
namespace App\Http\Controllers\Customer;

use App\API\Connectors\APIPoint;
use App\Http\Controllers\AdminController;
use Input, Session, DB, Redirect, Response, Auth;

class PointController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->page_attributes->title 				= 'Poin';
		$this->page_attributes->source 				= 'pages.customer.poin.';
		$this->page_attributes->breadcrumb			=	[
															'Poin' 	=> route('admin.point.index'),
														];			
	}

	public function index()
	{
		//initialize 
		$filters 									= null;

		if(Input::has('q'))
		{
			$filters 								= ['customername' => Input::get('q')];
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
		$APIPoint 									= new APIPoint;

		$point 										= $APIPoint->getIndex([
														'search' 	=> 	[
																			'customername' 	=> Input::get('q'),
																		],
														'sort' 		=> 	[
																			'name'	=> 'asc',
																		],																		
														'take'		=> $this->take,
														'skip'		=> ($page - 1) * $this->take,
														]);

		$this->page_attributes->data				= 	[
															'point' => $point,
														];

		//paginate
		$this->paginate(route('admin.point.index'), $point['data']['count'], $page);

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

	}	

	public function create($id = null)
	{
		//initialize
		if (is_null($id))
		{
			$breadcrumb								=	[
															'Data Baru' => route('admin.point.create'),
														];

			$data 									= null;														

			$this->page_attributes->subtitle 		= 'Data Baru';
		}
		else
		{
			$APIPoint 								= new APIPoint;
			$data 									= ['data' => $APIPoint->getShow($id)['data'] ];	

			$tmp									= json_decode($data['data']['description'], true);
			$data['data']['description']			= $tmp['description'];			
			$data['data']['fit']					= $tmp['fit'];		

			$breadcrumb								=	[
															$data['data']['name']  =>  route('admin.point.show', ['id' => $data['data']['id']] ),
															'Edit'  =>  route('admin.point.create', ['id' => $data['data']['id']] ),
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
		//get data
		$APIPoint 									= new APIPoint;

		//format input
		$inputCustomer 								= Input::get('customer');
		$inputNotes 								= Input::get('notes');
		$inputAmount 								= str_replace('IDR ', '', str_replace('.', '', Input::get('amount')));
		$inputExpireDate 							= date('Y-m-d H:i:s', strtotime(Input::get('expired_at')));

		//is edit
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

		//save
		$result 									= $APIPoint->postData($point);

		//response
		if($result['status'] != 'success')
		{
			$this->errors 							= $result['message'];
		}

		//return view
		if(!empty($id))
		{
			$this->page_attributes->success 		= "Data Point Telah Ditambahkan";
		}
		else
		{
			$this->page_attributes->success 		= "Data Point Telah Ditambahkan";
		}

		return $this->generateRedirectRoute('admin.point.index');
	}

	public function Update($id)
	{
		return $this->store($id);
	}

	public function destroy($id)
	{

	}		
}
