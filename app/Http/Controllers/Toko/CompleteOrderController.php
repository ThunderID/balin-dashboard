<?php 
namespace App\Http\Controllers\Toko;

use App\API\Connectors\APISale;
use App\API\Connectors\APISendMail;

use App\Http\Controllers\AdminController;

use Input, BalinMail;

/**
 * Handle update transaction delivered status
 * 
 * @author cmooy
 */
class CompleteOrderController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->page_attributes->title 				= 'Transaksi Selesai';
		$this->page_attributes->source 				= 'pages.toko.lengkap.';
		$this->page_attributes->breadcrumb			=	[
															'Transaksi Selesai' 	=> route('shop.completeorder.create'),
														];			
	}

	/**
	 * create form of a complete transactions
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
															'Data Penerima Paket' => route('shop.completeorder.create'),
														];

			$data 									= null;

			$this->page_attributes->subtitle 		= 'Data Penerima Paket';
		}
		else
		{
			\App::abort(404);
		}

		//2. Generate breadcrumb
		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		//3. Generate view
		$this->page_attributes->data 				=  $data;

		$this->page_attributes->source 				=  $this->page_attributes->source . 'create';

		return $this->generateView();		
	}

	/**
	 * Store a delivered order
	 * 
	 * 1. Check transaction
	 * 2. Check input
	 * 3. Store transaction
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
			
			return $this->generateRedirectRoute('shop.shipping.create');	
		}

		$sale 										= $prev_sale['data'];

		//2. Check input
		$sale['status']								= 'delivered';
		$sale['notes']								= 'Diterima Oleh '.Input::get('notes');

		//3. Store Transction
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
		
			$mail->deliveredorder($result['data'], $this->balininfo());
		}

		//5. Generate view
		if(!empty($id))
		{
			$this->page_attributes->success 		= "Pesanan sudah di diterima pembeli";
		}
		else
		{
			$this->page_attributes->success 		= "Pesanan sudah di diterima pembeli";
		}

		return $this->generateRedirectRoute('shop.sell.show', ['id' => $saleid]);
	}
}
