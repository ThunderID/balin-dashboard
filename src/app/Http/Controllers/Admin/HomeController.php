<?php 
namespace App\Http\Controllers\Admin;

use App\API\Connectors\APIWarehouse;
use App\API\Connectors\APISale;

use App\Http\Controllers\AdminController;
use Input, Session, DB, Redirect, Response, Auth;

class HomeController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->page_attributes->title = 'Dashboard';
	}

	public function index()
	{
		$APIwarehouse	 					= new APIWarehouse;

		$warehouse							= $APIwarehouse->getCritical()['data'];


		$APISale 							= new APISale;

		$wait 								= $APISale->getIndex([
													'search' 	=> 	['status' => ['wait', 'veritrans_processing_payment']],
												])['data'];


		$paid 								= $APISale->getIndex([
													'search' 	=> 	['status' => 'paid', 'productnotes' => true],
												])['data'];

		$packed 							= $APISale->getIndex([
													'search' 	=> 	['status' => 'packed', 'addressnotes' => true],
												])['data'];

		$shipped 							= $APISale->getIndex([
													'search' 	=> 	['status' => 'shipping', 'shippingnotes' => true],
												])['data'];

		$expired 							= $APISale->getIndex([
													'search' 	=> 	['expiredwait' => true],
												])['data'];

		$this->page_attributes->data 		= 	[
													'warehouse' => $warehouse,
													'wait' 		=> $wait,
													'paid' 		=> $paid,
													'packed' 	=> $packed,
													'shipped' 	=> $shipped,
													'expired' 	=> $expired,
												];



		$this->page_attributes->source 		= 'pages.dashboard';

		return $this->generateView();
	}
}
