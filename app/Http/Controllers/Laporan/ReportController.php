<?php 
namespace App\Http\Controllers\Laporan;

use App\API\Connectors\APIReport;

use App\Http\Controllers\AdminController;

use Input, Session, DB, Redirect, Response, Auth;

/**
 * Handle report controller
 * 
 * @author cmooy
 */
class ReportController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->page_attributes->title 				= 	'Laporan';
		$this->page_attributes->source 				= 	'pages.laporan.';
		$this->page_attributes->breadcrumb			=	[];		
	}

	/**
	 * Display all voucher usage
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
	public function VoucherUsage()
	{
		//1. Check filter 
		$filters 									= null;

		if(Input::has('q'))
		{
			$dates 									= explode('to', Input::get('q'));
			$filters 								= ['ondate' => $dates];
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
		$APIReport 									= new APIReport;

		$report 									= $APIReport->getVoucherUsage([
														'search' 	=> 	[
																			'ondate' 	=> Input::get('q'),
																		],
														'sort' 		=> 	[
																			'name'	=> 'asc',
																		],																		
														'take'		=> $this->take,
														'skip'		=> ($page - 1) * $this->take,
														]);

		$this->page_attributes->data				= 	[
															'report' => $report,
														];

		//4. Generate paginator
		$this->paginate(route('report.voucher.usage'), $report['data']['count'], $page);

		//5. Generate breadcrumb
		$breadcrumb								=	[
														'Laporan Penggunaan Voucher' => route('report.voucher.usage'),
													];

		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		//6. Generate view
		$this->page_attributes->source 				=  $this->page_attributes->source . 'voucher.index';

		return $this->generateView();
	}

	/**
	 * Display all sold varian
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
	public function SoldProduct()
	{
		//1. Check filter 
		$filters 									= null;

		if(Input::has('q'))
		{
			$dates 									= explode('to', Input::get('q'));
			$filters 								= ['ondate' => $dates];
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
		$APIReport 									= new APIReport;

		$report 									= $APIReport->getSoldProduct([
														'search' 	=> 	[
																			'ondate' 	=> Input::get('q'),
																		],
														'sort' 		=> 	[
																			'name'	=> 'asc',
																		],																		
														'take'		=> $this->take,
														'skip'		=> ($page - 1) * $this->take,
														]);

		$this->page_attributes->data				= 	[
															'report' => $report,
														];
		//4. Generate paginator
		$this->paginate(route('report.product.sold'), $report['data']['count'], $page);

		//5. Generate breadcrumb
		$breadcrumb									=	[
															'Laporan Penjualan Barang' => route('report.product.sold'),
														];

		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		//6. Generate view
		$this->page_attributes->source 				=  $this->page_attributes->source . 'product.index';

		return $this->generateView();
	}
}
