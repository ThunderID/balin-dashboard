<?php 
namespace App\Http\Controllers\Toko;

use App\API\Connectors\APISale;
use App\API\Connectors\APISendMail;

use App\Http\Controllers\AdminController;
use Input, BalinMail;

/**
 * Handle update transaction shipment status
 * 
 * @author cmooy
 */
class ShippingController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->page_attributes->title 				= 'Kirim Barang';
		$this->page_attributes->source 				= 'pages.toko.pengiriman.';
		$this->page_attributes->breadcrumb			=	[
															'Kirim Barang' 	=> route('shop.shipping.create'),
														];			
        $this->middleware('password.needed', ['only' => ['destroy']]);														
	}

	/**
	 * create form of a receipt number notes
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
															'Data Pengiriman' => route('shop.shipping.create'),
														];

			$data 									= null;

			$this->page_attributes->subtitle 		= 'Data Pengiriman';
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
	 * Store a shipping notes
	 * 
	 * 1. Check transaction
	 * 2. Check input
	 * 3. Store Shipment
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
		$inputShipment 								= Input::get('receipt_number');

		$sale['shipment']['receipt_number']			= $inputShipment;
		$sale['status']								= 'shipping';

		//3. Store Shipment
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
		
			$mail->shippingorder($result['data'], $this->balininfo());
		}

		//5. Generate view
		if(!empty($id))
		{
			$this->page_attributes->success 		= "Pesanan sedang dalam pengiriman!";
		}
		else
		{
			$this->page_attributes->success 		= "Pesanan sedang dalam pengiriman!";
		}

		return $this->generateRedirectRoute('shop.sell.show', ['id' => $saleid]);
	}
}
