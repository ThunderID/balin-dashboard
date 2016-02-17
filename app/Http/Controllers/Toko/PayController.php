<?php 
namespace App\Http\Controllers\Toko;

use App\API\Connectors\APISale;
use App\API\Connectors\APISendMail;

use App\Http\Controllers\AdminController;

use Input, Session, DB, Redirect, Response, Auth, BalinMail;

/**
 * Handle update transaction payment status
 * 
 * @author cmooy
 */
class PayController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->page_attributes->title 				= 'Validasi Bayar';
		$this->page_attributes->source 				= 'pages.toko.pembayaran.';
		$this->page_attributes->breadcrumb			=	[
															'Validasi Bayar' 	=> route('shop.pay.create'),
														];			
	}

	/**
	 * create form of a payment notes
	 * 
	 * 1. Get page setting
	 * 2. Generate breadcrumb
	 * 3. Generate view
	 * @param id
	 * @return Object View
	 */
	public function create($id = null)
	{
		//1. Get page setting
		if (is_null($id))
		{
			$breadcrumb								=	[
															'Data Pembayaran' => route('shop.pay.create'),
														];

			$data 									= null;														

			$this->page_attributes->subtitle 		= 'Data Pembayaran';
		}
		else
		{
			\App::abort(404);
		}


		//2. Get input 
		if(Input::get('id'))
		{
			$APISale								= new APISale;
			$data 									= $APISale->getShow(Input::get('id'));
			$data['data']['account_name']			= null;
			$data['data']['method']					= null;
			$data['data']['destination']			= null;
			$data['data']['account_number']			= null;
			$data['data']['ondate']					= null;
		}


		//3. Generate breadcrumb
		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		//4. Generate view
		$this->page_attributes->data 				=  $data;

		$this->page_attributes->source 				=  $this->page_attributes->source . 'create';

		return $this->generateView();
	}

	/**
	 * Store a payment notes
	 * 
	 * 1. Check transaction
	 * 2. Check input
	 * 3. Store Payment
	 * 4. Check response
	 * 5. Generate view
	 * @param id
	 * @return object view
	 */
	public function store($id = null)
	{
		//1. Check transaction
		if(Input::has('transaction_id'))
		{
			$saleid 								= Input::get('transaction_id');
		}
		else
		{
			\App::abort(404);
		}

		$APISale 									= new APISale;

		$prev_sale 									= $APISale->getShow($saleid);

		if($prev_sale['status'] != 'success')
		{
			$this->errors 							= $prev_sale['message'];
			
			return $this->generateRedirectRoute('shop.pay.create');	
		}

		$sale 										= $prev_sale['data'];

		//2. Check input
		$inputPayment 								= Input::only('method', 'destination', 'account_name', 'account_number');
		$inputPayment['id'] 						= '';
		$inputPayment['amount'] 					= $sale['bills'];
		$inputPayment['ondate'] 					= date('Y-m-d H:i:s', strtotime(Input::get('ondate')));

		$sale['payment']							= $inputPayment;
		$sale['status']								= 'paid';

		//3. Store Payment
		$result 									= $APISale->postData($sale);

		//4. Check response
		if($result['status'] != 'success')
		{
			$this->errors 							= $result['message'];
		}
		//4a. sending mail
		else
		{
			$mail 									= new APISendMail;
		
			$mail->paidorder($result['data'], $this->balininfo());
		}

		//5. Generate view
		$this->page_attributes->success 			= 	[
															'title' 		=> 'Pesanan sudah divalidasi. ',
															'action'		=> 	route('report.product.sale.detail', ['id' => $saleid]),
															'actionTitle'	=> 'Klik disini untuk melihat Invoice barang.',
														];


		return $this->generateRedirectRoute('admin.dashboard', ['tab' => 'toko']);
	}
}
