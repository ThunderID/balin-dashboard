<?php 
namespace App\Http\Controllers\Promosi;

use App\Http\Controllers\AdminController;
use App\API\Connectors\APIVoucher;
use Input, Session, DB, Redirect, Response, Auth;

class VoucherController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->page_attributes->title 				= 'Voucher';
		$this->page_attributes->source 				= 'pages.promosi.voucher.';
		$this->page_attributes->breadcrumb			=	[
															'Voucher' 	=> route('admin.voucher.index'),
														];			
	}

	public function index()
	{
		//initialize 
		$filters 									= null;

		if(Input::has('q'))
		{
			$filters 								= ['code' => Input::get('q')];
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
		$APIVoucher 								= new APIVoucher;

		$voucher 									= $APIVoucher->getIndex([
														'search' 	=> 	[
																			'code' 	=> Input::get('q'),
																		],
														'sort' 		=> 	[
																			'code'	=> 'asc',
																		],																		
														'take'		=> $this->take,
														'skip'		=> ($page - 1) * $this->take,
														]);

		$this->page_attributes->data				= 	[
															'voucher' => $voucher,
														];

		//paginate
		$this->paginate(route('admin.voucher.index'), $voucher['data']['count'], $page);

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
															'Data Baru' => route('admin.voucher.create'),
														];

			$data 									= null;														

			$this->page_attributes->subtitle 		= 'Data Baru';
		}
		else
		{
			$APIVoucher 								= new APIVoucher;
			$data 									= ['data' => $APIVoucher->getShow($id)['data'] ];	

			$breadcrumb								=	[
															$data['data']['code']  =>  route('admin.voucher.show', ['id' => $data['data']['id']] ),
															'Edit'  =>  route('admin.voucher.create', ['id' => $data['data']['id']] ),
														];

			$this->page_attributes->subtitle 		= $data['data']['code'];
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

	public function store($id = '')
	{
		$APIVoucher 								= new APIVoucher;
		
		//format input
		$inputCode 									= Input::get('code');
		$inputType 									= Input::get('type');
		$inputValue 								= str_replace('IDR ', '', str_replace('.', '', Input::get('value')));
		$inputQuota 								= Input::get('quota');
		$inputStartDate 							= date('Y-m-d H:i:s', strtotime(Input::get('started_at')));
		$inputExpireDate 							= date('Y-m-d H:i:s', strtotime(Input::get('expired_at')));

		//is edit
		if(!empty($id))
		{
			//get data
			$data 									= $APIVoucher->getShow($id);

			$voucher['id']							= $data['data']['id'];
			$voucher['code']						= $inputCode;
			$voucher['type']						= $inputType;
			$voucher['value']						= $inputValue;
			$voucher['quota']						= $inputQuota;
			$voucher['started_at']					= $inputStartDate;
			$voucher['expired_at']					= $inputExpireDate;
			$voucher['quotalogs']					= $data['data']['quotalogs'];
		}
		else
		{
			$voucher['code']						= $inputCode;
			$voucher['type']						= $inputType;
			$voucher['value']						= $inputValue;
			$voucher['quota']						= $inputQuota;
			$voucher['started_at']					= $inputStartDate;
			$voucher['expired_at']					= $inputExpireDate;

			$voucher['id']							= '';
		}


		//save
		$result 									= $APIVoucher->postData($voucher);

		//response
		if($result['status'] != 'success')
		{
			$this->errors 							= $result['message'];
		}

		//return view
		if(!empty($id))
		{
			$this->page_attributes->success 		= "Data Voucher Telah Diedit";
		}
		else
		{
			$this->page_attributes->success 		= "Data Voucher Telah Ditambahkan";
		}

		return $this->generateRedirectRoute('admin.voucher.show', ['id' => Input::get('voucher')]);
	}

	public function Update($id)
	{
		return $this->store($id);
	}

	public function destroy($id)
	{
		$APIVoucher 								= new APIVoucher;

		//api
		$result 									= $APIVoucher->deleteData($id);

		//response
		if($result['status'] != 'success')
		{
			$this->errors 							= $result['message'];
		}

		//return
		$this->page_attributes->success 			= "Data telah dihapus";
		
		return $this->generateRedirectRoute('admin.voucher.index');	

	}		
}
