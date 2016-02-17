<?php namespace App\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator;
use App\API\Connectors\APIConfig;

use Illuminate\Support\MessageBag;
use Redirect, Input, URL;

abstract class AdminController extends Controller 
{
	protected $page_attributes;
	protected $errors;
	protected $take 				= 15;

	function __construct() 
	{
		$this->errors 				= new MessageBag();

		$this->page_attributes 		= new \Stdclass;

		//nanti kalu butuh template lebih dari satu, switch case aja disini.
		$this->layout 				= view('page_templates.layout');
	}

	public function generateView()
  	{
  		//require
  		if(!isset($this->page_attributes->breadcrumb)){$this->page_attributes->breadcrumb = [];}
  		if(!isset($this->page_attributes->title)){$this->page_attributes->title = null;}
  		if(!isset($this->page_attributes->subtitle)){$this->page_attributes->subtitle = null;}
  		if(!isset($this->page_attributes->data)){$this->page_attributes->data = null;}
  		if(!isset($this->page_attributes->paginator)){$this->page_attributes->paginator = null;}
  		if(!isset($this->page_attributes->filters)){$this->page_attributes->filters = null;}
  		if(!isset($this->page_attributes->sorts)){$this->page_attributes->sorts = null;}

  		$paging				= $this->page_attributes->paginator;

		//initialize view
  		$this->layout 			= view($this->page_attributes->source, compact('paging'))
									->with('breadcrumb', $this->page_attributes->breadcrumb)
									->with('pagetitle', $this->page_attributes->title)
									->with('pagesubtitle', $this->page_attributes->subtitle)
									->with('data', $this->page_attributes->data)
									->with('filters', $this->page_attributes->filters)
									->with('sorts', $this->page_attributes->sorts)
									;

  		//optional data
  		if(isset($this->page_attributes->search))
  		{
  			$this->layout 		= $this->layout->with('searchResult', $this->page_attributes->search);
  		}

  		// return view
		return $this->layout;
	}


	public function generateRedirectRoute($to = null, $parameter = null)
	{
		if(count($this->errors) == 0)
		{
			$title 				= null;
			$action 			= null;
			$actionTitle		= null;

			if(is_array($this->page_attributes->success))
			{
				$title			= $this->page_attributes->success['title'];
				$action			= $this->page_attributes->success['action'];
				$actionTitle	= $this->page_attributes->success['actionTitle'];
			}
			else
			{
				$title			= $this->page_attributes->success;
			}

			return Redirect::route($to, $parameter)
					->with('msg',$title)
					->with('msg-type', 'success')
					->with('msg-action', $action)
					->with('msg-title', $actionTitle);
		}
		else
		{
			return Redirect::back()
					->withInput(Input::all())
					->withErrors($this->errors)
					->with('msg-type', 'danger');

		}
	}

	public function paginate($route = null, $count = null, $current = null)
	{
		//README
		//$route : route current page. $route = route('admin.product.index')
		//$count : number of data. $count = count($data)
		//$current : current page. $current = input::get($page)

		$this->page_attributes->paginator 			= new LengthAwarePaginator($count, $count, $this->take, $current);
	    $this->page_attributes->paginator->setPath($route);
	}

	//generate balin store information
	public function balininfo()
	{
  		$APIConfig 									= new APIConfig;
		
		$config 									= $APIConfig->getIndex([
														'search' 	=> 	[
																			'default'	=> 'true',
																		],
														'sort' 		=> 	[
																			'name'	=> 'asc',
																		],
														]);

		$balin 										= $config['data'];

		unset($balin['info']);
		foreach ($config['data']['info'] as $key => $value) 
		{
			$balin['info'][$value['type']]			= $value['value'];
		}

		return $balin['info'];
	}


}
