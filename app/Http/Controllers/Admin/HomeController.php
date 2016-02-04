<?php 
namespace App\Http\Controllers\Admin;

use App\API\connectors\APIWarehouse;

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

		$warehouse							= $APIwarehouse->getCritical();

		dd($warehouse);

		$this->page_attributes->source 		= 'pages.dashboard';

		return $this->generateView();
	}
}
