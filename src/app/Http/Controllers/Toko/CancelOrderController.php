<?php 
namespace App\Http\Controllers\Toko;

use App\API\Connectors\APISale;

use App\Http\Controllers\AdminController;

use Input, BalinMail;

/**
 * Handle update transaction canceled status
 * 
 * @author cmooy
 */
class CancelOrderController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->page_attributes->title 				= 'Transaksi Batal';
		$this->page_attributes->source 				= 'pages.toko.batal.';
		$this->page_attributes->breadcrumb			=	[
															'Transaksi Batal' 	=> route('shop.cancelorder.create'),
														];			
	}

	/**
	 * create form of a cancel transactions
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
															'Data Baru' => route('shop.cancelorder.create'),
														];

			$data 									= null;														

			$this->page_attributes->subtitle 		= 'Data Baru';
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
			$data['data']['notes']					= null;
		}

		//3. Generate breadcrumb
		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		//4. Generate view
		$this->page_attributes->data 				=  $data;

		$this->page_attributes->source 				=  $this->page_attributes->source . 'create';

		return $this->generateView();		
	}

	/**
	 * Store a canceled order
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
		$sale['status']								= 'canceled';
		$sale['notes']								= 'Alasan Pembatalan : '.Input::get('notes');

		//3. Store transaction
		$result 									= $APISale->postData($sale);

		//4. Check response
		if($result['status'] != 'success')
		{
			$this->errors 							= $result['message'];
		}

		//5. Generate view
		$this->page_attributes->success 			= 	[
															'title' 		=> 'Pesanan sudah dibatalkan. ',
															'action'		=> 	route('report.product.sale.detail', ['id' => $saleid]),
															'actionTitle'	=> 'Klik disini untuk melihat Invoice barang dibatalkan.',
														];			

		return $this->generateRedirectRoute('admin.dashboard', ['tab' => 'toko']);
	}
}
