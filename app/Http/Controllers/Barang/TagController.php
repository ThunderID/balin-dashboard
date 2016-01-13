<?php 
namespace App\Http\Controllers\Barang;

use App\API\connectors\APITag;

use App\Http\Controllers\AdminController;
use Input, Session, DB, Redirect, Response, Auth;

class TagController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->page_attributes->title 				= 'Tag';
		$this->page_attributes->source 				= 'pages.barang.tag.';
		$this->page_attributes->breadcrumb			=	[
															'Tag' 	=> route('admin.tag.index'),
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
			$this->page_attributes->search 			= null;
		}

		// data here
		$APITag 									= new APITag;
		$tag 										= $APITag->getIndex([
															'name' 	=> Input::get('q')
														]);


		$this->page_attributes->data				=  	[
															'data' => $tag['data'],
														];

		//breadcrumb
		$breadcrumb 								= [];	

		//generate View
		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		$this->page_attributes->source 				=  $this->page_attributes->source . 'index';

		return $this->generateView();
	}

	public function show($id)
	{
		//get data 
		$APITag	 									= new APITag;
		$tag										= $APITag->getShow($id);

		$this->page_attributes->subtitle 			= $tag['data']['name'];


		// filters
		if(Input::has('q'))
		{
			$filters 								= ['name' => Input::get('q')];
			$this->page_attributes->search 			= Input::get('q');
		}
		else
		{
			$this->page_attributes->search 			= null;
		}
	

		// data here
		$this->page_attributes->data				= $tag['data'];

		//breadcrumb
		$breadcrumb 								=	[
															$tag['data']['name'] => route('admin.tag.show', ['id' => $tag['data']['name']])
														];	

		//generate View
		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		$this->page_attributes->source 				= $this->page_attributes->source . 'show';

		return $this->generateView();
	}	

	public function create($id = null)
	{
		//initialize
		if (is_null($id))
		{
			$breadcrumb								=	[
															'Data Baru' => route('admin.tag.create'),
														];

			$this->page_attributes->subtitle 		= 'Data Baru';
		}
		else
		{
			$APITag									= new APITag;

			$tag 									= $APITag->getShow($id)['data'];

			$this->page_attributes->data			= $tag;

			$breadcrumb								=	[
															'Edit Tag ' . $tag['name']  =>  route('admin.tag.edit', ['id' => $id]),
														];

			$this->page_attributes->subtitle 		= 'Edit Data';
		}

		//generate View
		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		$this->page_attributes->source 				=  $this->page_attributes->source . 'create';

		return $this->generateView();
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


	//AJAX
	public function AjaxFindName()
	{
		return json_encode('test');
	}	
}
