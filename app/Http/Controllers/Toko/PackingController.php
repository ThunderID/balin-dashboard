<?php 
namespace App\Http\Controllers\Toko;

use App\API\Connectors\APISale;

use App\Http\Controllers\AdminController;

use Input, Session, DB, Redirect, Response, Auth;

/**
 * Handle sale packong information
 * 
 * @author cmooy
 */
class PackingController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->page_attributes->title 				= 'Packing';
		$this->page_attributes->source 				= 'pages.toko.packing.';
		$this->page_attributes->breadcrumb			=	[
															'Packing' 	=> route('shop.packing.create'),
														];			
	}

	/**
	 * create form of a transaction ref number
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
															'Data Packing' => route('shop.packing.create'),
														];

			$data 									= null;														

			$this->page_attributes->subtitle 		= 'Data Packing';
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
		}

		//3. Generate breadcrumb
		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		//3. Generate view
		$this->page_attributes->data 				=  $data;

		$this->page_attributes->source 				=  $this->page_attributes->source . 'create';

		return $this->generateView();	
	}

	/**
	 * Store a packing transaction
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
		$sale 										= $prev_sale['data'];

		//2. Check input
		$sale['status']								= 'packed';

		//3. Store transaction
		$result 									= $APISale->postData($sale);

		//4. Check response
		if($result['status'] != 'success')
		{
			$this->errors 							= $result['message'];
		}

		//5. Generate view
		if(!empty($id))
		{
			$this->page_attributes->success 		= "Pesanan sudah di packing!";
		}
		else
		{
			$this->page_attributes->success 		= "Pesanan sudah di packing!";
		}

		return $this->generateRedirectRoute('admin.dashboard', ['tab' => 'toko']);
	}
}
