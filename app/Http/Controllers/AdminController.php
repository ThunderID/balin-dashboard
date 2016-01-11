<?php namespace App\Http\Controllers;

use Illuminate\Support\MessageBag;
use Redirect, URL;

abstract class AdminController extends Controller 
{
	protected $page_attributes;
	protected $errors;

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

		//initialize view
  		$this->layout 			= view($this->page_attributes->source)
									->with('breadcrumb', $this->page_attributes->breadcrumb)
									->with('pagetitle', $this->page_attributes->title)
									->with('pagesubtitle', $this->page_attributes->subtitle)
									->with('data', $this->page_attributes->data)
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
			return Redirect::route($to, $parameter)
					->with('msg',$this->page_attributes->success)
					->with('msg-type', 'success');
		}
		else
		{
			return Redirect::back()
					->withErrors($this->errors)
					->with('msg-type', 'danger');

		}
	}
}
