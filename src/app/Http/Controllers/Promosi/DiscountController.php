<?php 
namespace App\Http\Controllers\Promosi;

use App\API\Connectors\APIProduct;
use App\API\Connectors\APITag;
use App\API\Connectors\APICategory;
use App\API\Connectors\APILabel;
use App\API\Connectors\APIBroadcast;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Helper\SortList;

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

		if (Input::has('sort'))
		{
			$sort_item 								= explode('-', Input::get('sort'));
			$sort 									= [$sort_item[0] => $sort_item[1]];
		}
		else
		{
			$sort									= ['name' => 'asc'];
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
														'search' 	=> $search,
														'sort' 		=> $sort,																		
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

		$SortList 									= new SortList;

		$this->page_attributes->sorts 				= 	[
															'titles'	=> ['nama', 'harga', 'promo', 'discount'],
															'nama'		=> $SortList->getSortingList('nama'),
															'harga'		=> $SortList->getSortingList('harga'),
															'promo'		=> $SortList->getSortingList('promo'),
															'discount'	=> $SortList->getSortingList('discount'),
														]; 	


		$this->page_attributes->filters 			= 	[
															'titles' 	=> $filterTitles,
															'tag'		=> $filterTags,
															'kategori'	=> $filterCategories,
															'label'		=> $filterLabels,
														];


		$this->page_attributes->source 				=  $this->page_attributes->source . 'index';

		return $this->generateView();
	}

	/**
	 * create form of a discount
	 * 
	 * 1. Get Previous data and page setting
	 * 2. Generate breadcrumb
	 * 3. Generate view
	 * @param id
	 * @return Object View
	 */
	public function create()
	{
		//1. Get page setting
		$data 									= null;

		$breadcrumb								=	[
														'Data Baru' => route('promote.discount.create'),
													];


		$this->page_attributes->subtitle 		= 'Data Baru';

		//2. Generate breadcrumb
		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);


		//3. Generate view
		$this->page_attributes->source 				=  $this->page_attributes->source . 'create';

		return $this->generateView();
	}

	/**
	 * store discount queue
	 * 
	 * 1. Get Previous data and page setting
	 * 2. Generate breadcrumb
	 * 3. Generate view
	 * @param id
	 * @return Object View
	 */
	public function store()
	{
		//get data
		$data['discount_percentage']				= Input::get('discount_percentage');

		if(Input::has('category_ids'))
		{
			$c_ids									= explode(',', Input::get('category_ids'));
			$data['category_ids']					= $c_ids;	
		}

		if(Input::has('tag_ids'))
		{
			$t_ids									= explode(',', Input::get('tag_ids'));
			$data['tag_ids']						= $t_ids;	
		}

		$data['discount_amount']					= str_replace('IDR ', '', str_replace('.', '', Input::get('discount_amount')));
		$data['started_at'] 						= date('Y-m-d H:i:s', strtotime(Input::get('started_at')));
		$data['ended_at'] 							= date('Y-m-d H:i:s', strtotime(Input::get('ended_at')));

		//api
		$APIBroadcast 								= new APIBroadcast;

		$result 									= $APIBroadcast->postData($data);

		//response
		if($result['status'] != 'success')
		{
			$this->errors 							= $result['message'];
		}

		//return view
		$this->page_attributes->success 			= "Data Diskon Telah Ditambahkan. Membutuhkan waktu kurang lebih 10 menit untuk mengubah data diskon.";
		
		return $this->generateRedirectRoute('promote.discount.index');				
	}
}
