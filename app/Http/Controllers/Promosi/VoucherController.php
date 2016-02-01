<?php 
namespace App\Http\Controllers\Promosi;

use App\API\Connectors\APIVoucher;

use App\Http\Controllers\AdminController;

use Input, Session, DB, Redirect, Response, Auth;

/**
 * Handle voucher resource
 * 
 * @author cmooy
 */
class VoucherController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->page_attributes->title 				= 'Voucher';
		$this->page_attributes->source 				= 'pages.promosi.voucher.';
		$this->page_attributes->breadcrumb			=	[
															'Voucher' 	=> route('promote.voucher.index'),
														];			
        $this->middleware('password.needed', ['only' => ['destroy']]);
	}

	/**
	 * Display all voucher
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
			$filters 								= ['code' => Input::get('q')];
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

		//4. Generate paginator
		$this->paginate(route('promote.voucher.index'), $voucher['data']['count'], $page);

		//5. Generate breadcrumb
		$breadcrumb								=	[
													];
		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		//6. Generate view
		$this->page_attributes->source 				=  $this->page_attributes->source . '.index';

		return $this->generateView();
	}

	/**
	 * create form of a voucher
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
															'Data Baru' => route('promote.voucher.create'),
														];

			$data 									= null;														

			$this->page_attributes->subtitle 		= 'Data Baru';
		}
		else
		{
			$APIVoucher 								= new APIVoucher;
			$data 									= ['data' => $APIVoucher->getShow($id)['data'] ];	

			$breadcrumb								=	[
															$data['data']['code']  =>  route('promote.voucher.index'),
															'Edit'  =>  route('promote.voucher.create', ['id' => $data['data']['id']] ),
														];

			$this->page_attributes->subtitle 		= $data['data']['code'];
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
	 * Edit a voucher
	 * 
	 * @param id
	 * @return function
	 */
	public function edit($id)
	{
		return $this->create($id);
	}

	/**
	 * Store a voucher
	 * 
	 * 1. Check input
	 * 2. Check data
	 * 3. Save voucher
	 * 4. Check Response
	 * 5. Return view
	 * @param id
	 * @return object view
	 */
	public function store($id = '')
	{
		//1. Check input
		$inputCode 									= Input::get('code');
		$inputType 									= Input::get('type');
		$inputValue 								= str_replace('IDR ', '', str_replace('.', '', Input::get('value')));
		$inputQuota 								= Input::get('quota');
		$inputStartDate 							= date('Y-m-d H:i:s', strtotime(Input::get('started_at')));
		$inputExpireDate 							= date('Y-m-d H:i:s', strtotime(Input::get('expired_at')));

		//2. Check data
		$APIVoucher 								= new APIVoucher;
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


		//3. Save voucher
		$result 									= $APIVoucher->postData($voucher);

		//4. Check Response
		if($result['status'] != 'success')
		{
			$this->errors 							= $result['message'];
		}

		//5. Return view
		if(!empty($id))
		{
			$this->page_attributes->success 		= "Data Voucher Telah Diedit";
		}
		else
		{
			$this->page_attributes->success 		= "Data Voucher Telah Ditambahkan";
		}

		return $this->generateRedirectRoute('promote.voucher.index');
	}

	/**
	 * Update a voucher
	 * 
	 * @param id
	 * @return function
	 */
	public function Update($id)
	{
		return $this->store($id);
	}

	/**
	 * Delete a voucher
	 * 
	 * @param id
	 * @return function
	 */
	public function destroy($id)
	{
		$APIVoucher 								= new APIVoucher;

		//Call API
		$result 									= $APIVoucher->deleteData($id);

		//Check response
		if($result['status'] != 'success')
		{
			$this->errors 							= $result['message'];
		}

		//Return Message
		$this->page_attributes->success 			= "Data voucher telah dihapus";
		
		return $this->generateRedirectRoute('promote.voucher.index');	

	}		
}
