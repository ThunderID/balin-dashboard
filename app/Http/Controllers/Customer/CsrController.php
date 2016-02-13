<?php 
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\AdminController;


/**
 * Handle customer information
 * 
 * @author cmooy
 */
class CsrController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->page_attributes->title 				= 'Relasi Pelanggan';
		$this->page_attributes->source 				= 'pages.kostumer.csr.';
		$this->page_attributes->breadcrumb			=	[];	
	}

	public function index()
	{

	}

	public function show($id)
	{

	}	

	public function create($id)
	{

	}

	public function store($id)
	{

	}					
}
