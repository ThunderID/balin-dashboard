<?php 
namespace App\Http\Controllers\konfigurasi;

use App\Http\Controllers\AdminController;
use Input, Session, DB, Redirect, Response, Auth;

class WebsiteController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->page_attributes->title 				= 'Website';
		$this->page_attributes->source 				= 'pages.konfigurasi.website.';
		$this->page_attributes->breadcrumb			=	[
															'Website' 	=> route('config.website.index'),
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
	
	}

	public function edit($id)
	{
		return $this->create($id);
	}

	public function store($id = null)
	{

	}

	public function Update($id)
	{
		return $this->store($id);
	}

	public function destroy($id)
	{

	}		
}
