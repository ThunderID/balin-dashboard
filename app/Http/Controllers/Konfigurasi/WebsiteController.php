<?php 
namespace App\Http\Controllers\konfigurasi;

use App\API\Connectors\APIStore;
use App\API\Connectors\APIStorePage;
use App\API\Connectors\APISlider;

use App\Http\Controllers\AdminController;

use Input, Session, DB, Redirect, Response, Auth, Carbon;

/**
 * Handle website resource
 * 
 * @author cmooy
 */
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

	/**
	 * Display all website
	 * 
	 * 1. Check filter
	 * 2. Check page
	 * 3. Get data from API
	 * 4. Generate breadcrumb
	 * 5. Generate view
	 * @param page, q
	 * @return Object View
	 */
	public function index()
	{
		//1. Check filter 
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

		//2. Check page
		if(is_null(Input::get('page')))
		{
			$page 									= 1;
		}
		else
		{
			$page 									= Input::get('page');
		}

		//3. Get data from API
		$APIStorePage 								= new APIStorePage;

		$storepage 									= $APIStorePage->getIndex([
														'search' 	=> 	[
																			'name' 		=> Input::get('q'),
																			'default'	=> 'true',
																		],
														'sort' 		=> 	[
																			'name'	=> 'asc',
																		],
														]);

		$APIStore 									= new APIStore;
		
		$storeinfo 									= $APIStore->getIndex([
														'search' 	=> 	[
																			'name' 		=> Input::get('q'),
																			'default'	=> 'true',
																		],
														'sort' 		=> 	[
																			'name'	=> 'asc',
																		],
														]);

		$APISlider 									= new APISlider;
		
		$slider 									= $APISlider->getIndex([
														'search' 	=> 	[
																			'name' 		=> Input::get('q'),
																			'default'	=> 'true',
																		],
														'sort' 		=> 	[
																			'name'	=> 'asc',
																		],
														]);

		$this->page_attributes->data				= 	[
															'storepage' => $storepage,
															'storeinfo' => $storeinfo,
															'slider' 	=> $slider,
														];
		//4. Generate breadcrumb
		$breadcrumb								=	[
													];

		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);
		
		//5. Generate View
		$this->page_attributes->source 				=  $this->page_attributes->source . '.index';

		return $this->generateView();
	}

	/**
	 * Store a website
	 * 
	 * 1. Check input
	 * 2. Check data
	 * 3. Save website
	 * 4. Check Response
	 * 5. Return view
	 * @param id
	 * @return object view
	 */
	public function store($id = null)
	{
		//1. Check input
		$inputValue 								= Input::get('value');

		if(Input::has('started_at'))
		{
			$inputStartDate 						= Carbon::createFromFormat('d-m-Y H:i', Input::get('started_at'))->format('Y-m-d H:i:s');
		}

		if(Input::has('ended_at'))
		{
			$inputEndDate 							= Carbon::createFromFormat('d-m-Y H:i', Input::get('ended_at'))->format('Y-m-d H:i:s');
		}

		if(Input::has('image'))
		{
			$inputImage 							= Input::get('image');
		}

		//2. Check data
		$APIStore 									= new APIStore;
		if(empty($id))
		{
			\App::abort(404);
		}
		else
		{
			//get data
			$data 									= $APIStore->getShow($id);

			$website['id']							= $data['data']['id'];
			$website['type']						= $data['data']['type'];
			$website['value']						= $inputValue;

			if(strtolower($data['data']['type'])=='slider')
			{
				if($data['data']['images'] != $inputImage)
				{
					$website['id']					= '';
				}

				$website['started_at']				= $inputStartDate;

				$website['ended_at']				= "";
				$website['images']					= $data['data']['images'];
				$website['images'][]				= 	[
															'id'		=> '',
															'thumbnail'	=> $inputImage,
															'image_xs'	=> $inputImage,
															'image_sm'	=> $inputImage,
															'image_md'	=> $inputImage,
															'image_lg'	=> $inputImage,
														];
			}
			else
			{
				$website['started_at']				= $data['data']['started_at'];
			}
		}

		//3. Save website
		$result 									= $APIStore->postData($website);

		//4. Check Response
		if($result['status'] != 'success')
		{
			$this->errors 							= $result['message'];
		}

		//5. Return view
		if(!empty($id))
		{
			$this->page_attributes->success 		= "Data website Telah Diedit";
		}
		else
		{
			$this->page_attributes->success 		= "Data website Telah Ditambahkan";
		}

		return $this->generateRedirectRoute('config.website.index', ['id' => Input::get('website')]);
	}

	/**
	 * Update a website
	 * 
	 * @param id
	 * @return function
	 */
	public function Update($id)
	{
		return $this->store($id);
	}


	public function deleteSlider($id)
	{
		dd($id);
	}
}
