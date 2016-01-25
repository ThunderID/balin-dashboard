<?php 
namespace App\Http\Controllers\Laporan;

use App\API\Connectors\APIReport;

use App\Http\Controllers\AdminController;

use Input, Session, DB, Redirect, Response, Auth;

class ReportController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->page_attributes->title 				= 'Laporan';
		$this->page_attributes->source 				= 'pages.laporan.voucher.';
		$this->page_attributes->breadcrumb			=	[
															'Laporan' 	=> route('admin.report.voucherusage'),
														];		
	}

	public function VoucherUsage()
	{
		//initialize 
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

		//get curent page
		if(is_null(Input::get('page')))
		{
			$page 									= 1;
		}
		else
		{
			$page 									= Input::get('page');
		}

		// data here
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

		//paginate
		$this->paginate(route('admin.report.voucherusage'), $report['data']['count'], $page);

		//breadcrumb
		$breadcrumb 								= [];	

		//generate View
		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		$this->page_attributes->source 				=  $this->page_attributes->source . 'index';

		return $this->generateView();
	}
}
