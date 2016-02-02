<?php 
namespace App\Http\Controllers\Promosi;

use App\API\connectors\APIProduct;
use App\API\Connectors\APITag;
use App\API\Connectors\APICategory;
use App\API\Connectors\APILabel;

use App\Http\Controllers\AdminController;

use Input, Session, DB, Redirect, Response, Auth;

/**
 * Handle customer discount information
 * 
 * @author cmooy
 */
class DiscountController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->page_attributes->title 				= 'Diskon';
		$this->page_attributes->source 				= 'pages.promosi.diskon.';
		$this->page_attributes->breadcrumb			=	[
															'Diskon' 	=> route('promote.discount.index'),
														];			
	}

	/**
	 * Display all discount
	 * 
	 * 1. Check filter
	 * 2. Check page
	 * 3. Get data from API
	 * 4. Generate paginator
	 * 5. Generate breadcrumb
	 * 6. Generate view
	 * @param page, q
	 * @return Object View
	 */
	public function index()
	{
		//1. Check filter 
		$search 									= ['discount' => true,];

		if(Input::has('q'))
		{
			$search['name']							= Input::get('q');
			$this->page_attributes->search 			= Input::get('q');
		}
		else
		{
			$searchResult							= null;
		}

		if(Input::has('category'))
		{
			$search['categories']					= str_replace(" ", "-", Input::get('category'));
		}

		if(Input::has('tag'))
		{
			$search['tags']							= str_replace(" ", "-", Input::get('tag'));
		}

		if(Input::has('label'))
		{
			$search['labelname']					= str_replace(" ", "_", Input::get('label'));
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
		$APIProduct 								= new APIProduct;

		$product 									= $APIProduct->getIndex([
														'search' 	=> 	$search,
														'sort' 		=> 	[
																			'name'	=> 'asc',
																		],																		
														'take'		=> $this->take,
														'skip'		=> ($page - 1) * $this->take,
														]);

		$this->page_attributes->data				= 	[
															'product' => $product,
														];

		//4. Generate paginator
		$this->paginate(route('promote.discount.index'), $product['data']['count'], $page);

		//5. Generate breadcrumb
		$breadcrumb 								= [];	
		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		//6. Generate View
		$filterTitles								= ['tag','kategori','label'];
		
		$filterTags 								= [];
		$filterCategories 							= [];
		$filterLabels 								= [];

		$APITag 									= new APITag;
		$tmpTag 	 								= $APITag->getIndex()['data']['data'];

		$key 										= 0;
		foreach ($tmpTag as $value) 
		{
			if($value['category_id'] != 0)
			{
				$filterTags[$key]					= ucwords(str_replace("-", " ",$value['slug']));
				$key++;
			}
		}


		$APICategory 								= new APICategory;
		$tmpCategory 	 							= $APICategory->getIndex()['data']['data'];

		$key 										= 0;
		foreach ($tmpCategory as $value) 
		{
			if($value['category_id'] != 0)
			{
				$filterCategories[$key]				= ucwords(str_replace("-", " ",$value['name']));
				$key++;
			}
		}


		$APILabel 									= new APILabel;
		$tmpLabel 	 								= $APILabel->getIndex()['data']['data'];

		$key 										= 0;
		foreach ($tmpLabel as $value) 
		{
			$filterLabels[$key]						= ucwords(str_replace("_", " ",$value['label']));
			$key++;
		}		


		$this->page_attributes->filters 			= 	[
															'titles' 	=> $filterTitles,
															'tag'		=> $filterTags,
															'kategori'	=> $filterCategories,
															'label'		=> $filterLabels,
														];


		$this->page_attributes->source 				=  $this->page_attributes->source . 'index';

		return $this->generateView();
	}
}
