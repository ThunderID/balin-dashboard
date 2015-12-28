<?php 
namespace App\Http\Controllers\Admin;

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
		$this->page_attributes->source 		= 'pages.dashboard';

		return $this->generateView();
	}
}
