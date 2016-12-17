<?php 
namespace App\Http\Controllers\Customer;

use App\API\Connectors\APICustomer;

use App\Http\Controllers\AdminController;

use Input, Session, DB, Redirect, Response, Auth;

/**
 * Handle customer referral information
 * 
 * @author cmooy
 */
class ReferralController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->page_attributes->title 				= 'Referral';
		$this->page_attributes->source 				= 'pages.kostumer.referral.';
		$this->page_attributes->breadcrumb			=	[
															'Referral' 	=> route('customer.referral.index'),
														];	
        $this->middleware('password.needed', ['only' => ['destroy']]);																
	}

	/**
	 * Display all referral
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

		//3. Get data from API
		$APICustomer 								= new APICustomer;

		$customer 									= $APICustomer->getIndex([
														'search' 	=> 	[
																			'name' 	=> Input::get('q'),
																		],
														'sort' 		=> 	[
																			'name'	=> 'asc',
																		],																		
														'take'		=> $this->take,
														'skip'		=> ($page - 1) * $this->take,
														]);

		$this->page_attributes->data				= 	[
															'customer' => $customer,
														];

		//4. Generate paginator
		$this->paginate(route('customer.referral.index'), $customer['data']['count'], $page);

		//5. Generate breadcrumb
		$breadcrumb									=	[
														];
		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		//6. Generate View
		$this->page_attributes->source 				=  $this->page_attributes->source . 'index';

		return $this->generateView();
	}
}
