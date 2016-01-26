<?php 
namespace App\Http\Controllers\Toko;

use App\API\Connectors\APISale;

use App\Http\Controllers\AdminController;
use Input, Session, DB, Redirect, Response, Auth;

class PayController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->page_attributes->title 				= 'Validasi Bayar';
		$this->page_attributes->source 				= 'pages.toko.validasiBayar.';
		$this->page_attributes->breadcrumb			=	[
															'Validasi Bayar' 	=> route('admin.pay.index'),
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

		// data here
		$this->page_attributes->data				= [];


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
															'Data Baru' => route('admin.pay.create'),
														];

			$data 									= null;														

			$this->page_attributes->subtitle 		= 'Data Baru';
		}
		else
		{
			$APISale 								= new APISale;
			$data 									= ['data' => $APISale->getShow($id)['data'] ];	

			$breadcrumb								=	[
															$data['data']['ref_number']  =>  route('admin.pay.show', ['id' => $data['data']['id']] ),
															'Edit'  =>  route('admin.pay.create', ['id' => $data['data']['id']] ),
														];

			$this->page_attributes->subtitle 		= $data['data']['ref_number'];
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
		$saleid 									= Input::get('transaction_id');

		$APISale 									= new APISale;

		$data 										= $APISale->getShow($saleid);
		$sale 										= $data['data'];

		//format input
		$inputPayment 								= Input::only('method', 'destination', 'account_name', 'account_number');
		$inputPayment['id'] 						= '';
		$inputPayment['amount'] 					= $sale['bills'];
		$inputPayment['ondate'] 					= date('Y-m-d H:i:s', strtotime(Input::get('ondate')));

		$sale['payment']							= $inputPayment;
		$sale['status']								= 'paid';

		//save
		$result 									= $APISale->postData($sale);

		//response
		if($result['status'] != 'success')
		{
			$this->errors 							= $result['message'];
		}

		//return view
		if(!empty($id))
		{
			$this->page_attributes->success 		= "Pesanan sudah di validasi!";
		}
		else
		{
			$this->page_attributes->success 		= "Pesanan sudah di validasi!";
		}

		return $this->generateRedirectRoute('admin.sell.show', ['id' => $saleid]);
	}

	public function Update($id)
	{
		return $this->store($id);
	}

	public function destroy($id)
	{

	}		
}
