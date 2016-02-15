<?php 
namespace App\Http\Controllers\Customer;

use App\API\Connectors\APICustomer;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Helper\SortList;

use Input, Session, DB, Redirect, Response, Auth;

/**
 * Handle customer information
 * 
 * @author cmooy
 */
class CustomerController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->page_attributes->title 				= 'Data Kostumer';
		$this->page_attributes->source 				= 'pages.kostumer.kostumer.';
		$this->page_attributes->breadcrumb			=	[
															'Data Kostumer' 	=> route('customer.customer.index'),
														];	
        $this->middleware('password.needed', ['only' => ['destroy']]);																
	}

	/**
	 * Display all customer
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

		//3. sorting
		if (Input::has('sort'))
		{
			$sort_item 								= explode('-', Input::get('sort'));
			$sort 									= [$sort_item[0] => $sort_item[1]];
		}
		else
		{
			$sort									= ['name' => 'asc'];
		}


		$SortList 									= new SortList;
		
		$this->page_attributes->sorts 				= 	[
															'titles'		=> ['nama', 'kode_referral', 'total_reference', 'total_poin'],
															'nama'			=> $SortList->getSortingList('nama'),
															'kode_referral'	=> $SortList->getSortingList('referralcode'),
															'total_reference'=> $SortList->getSortingList('totalreference'),
															'total_poin'	=> $SortList->getSortingList('totalpoint'),
														]; 


		//3. Get data from API
		$APICustomer 								= new APICustomer;

		$customer 									= $APICustomer->getIndex([
														'search' 	=> 	[
																			'name' 	=> Input::get('q'),
																		],
														'sort' 		=> $sort,																		
														'take'		=> $this->take,
														'skip'		=> ($page - 1) * $this->take,
														]);

		$this->page_attributes->data				= 	[
															'customer' => $customer,
														];

		//4. Generate paginator
		$this->paginate(route('customer.customer.index'), $customer['data']['count'], $page);

		//5. Generate breadcrumb
		$breadcrumb								=	[
													];

		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		//6. Generate view
		$this->page_attributes->source 				=  $this->page_attributes->source . '.index';

		return $this->generateView();
	}

	/**
	 * Display a customer detail
	 * 
	 * 1. Get data from API
	 * 2. Check return status
	 * 3. Generate breadcrumb
	 * 4. Generate view
	 * @param id
	 * @return Object View
	 */
	public function show($id)
	{
		//1. Get data from API 
		$APICustomer 								= new APICustomer;
		$customer 									= $APICustomer->getShow($id);


		// filters
		if(Input::has('q'))
		{
			$filters 								= ['name' => Input::get('q')];
			$this->page_attributes->search 			= Input::get('q');

			$collection 							= collect($customer['data']['sales']);


			$result 								= $collection->filter(function ($col) {
															return strpos(strtolower($col['ref_number']), strtolower(Input::get('q'))) !== FALSE;
														});			

			$customer['data']['sales']				= $result;		
		}
		else
		{
			$this->page_attributes->search 			= null;
		}

		//get curent page
		if(is_null(Input::get('page')))
		{
			$page 									= 1;
		}
		else
		{
			$page 									= Input::get('page');
		}

		//data paging	
		$collection 								= collect($customer['data']['sales']);

		if(count($collection) != 0)
		{
			$result 								= $collection->chunk($this->take);

			$this->paginate(route('customer.customer.show', ['id' => $id]), count($collection), $page);	

			$customer['data']['sales']				= $result[($page-1)];
		}
		else
		{
			$this->paginate(route('customer.customer.show', ['id' => $id]), count($collection), $page);	
		}


		//2. Check return status
		if($customer['status'] != 'success')
		{
			$this->errors 							= $customer['message'];
			
			return $this->generateRedirectRoute('customer.customer.index');	
		}

		$this->page_attributes->subtitle 			= $customer['data']['name'];

		$this->page_attributes->data				= 	[
															'customer' => $customer,
														];

		//3. Generate breadcrumb
		$breadcrumb 								=	[
															$customer['data']['name'] => route('customer.customer.show', ['id' => $id])
														];	

		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		//4. Generate view
		$this->page_attributes->source 				= $this->page_attributes->source . 'show';

		return $this->generateView();
	}	
}
