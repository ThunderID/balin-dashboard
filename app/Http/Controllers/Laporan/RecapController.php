<?php 
namespace App\Http\Controllers\Laporan;

use App\API\Connectors\APIReport;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Helper\SortList;

use Input, Session, DB, Redirect, Response, Auth, Carbon;
/**
 * Handle report controller
 * 
 * @author budi
 */
class RecapController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->page_attributes->title 				= 	'Rekap Penjualan & Penggunaan Voucher';
		$this->page_attributes->source 				= 	'pages.laporan.rekap.';
		$this->page_attributes->breadcrumb			=	[];		
	}

	public function sale()
	{
		//1. Check filter
		$search 									= [];
		$sort 										= [];

		if(Input::has('periode'))
		{
			$tmpdate 								= "01-" . Input::get('periode') . " 00:00:00";

			$search['ondate'] 						= 	[
															Carbon::createFromFormat('d-m-Y H:i:s', ($tmpdate))->format('Y-m-d H:i:s'),
															Carbon::createFromFormat('d-m-Y H:i:s', ($tmpdate))->addMonths(1)->format('Y-m-d H:i:s'),
														];

		}												
		else
		{
			$tmpdate 								= "01-" . date('m-Y') . " 00:00:00";


			$search['ondate'] 						= 	[
															Carbon::createFromFormat('d-m-Y H:i:s', ($tmpdate))->format('Y-m-d H:i:s'),
															Carbon::createFromFormat('d-m-Y H:i:s', ($tmpdate))->addMonths(1)->format('Y-m-d H:i:s'),
														];
		}

		if(Input::has('q'))
		{
			$search['name']							= Input::get('q');
			$this->page_attributes->search 			= Input::get('q');
		}

		if (Input::has('sort'))
		{
			$sort_item 								= explode('-', Input::get('sort'));
			$sort 									= [$sort_item[0] => $sort_item[1]];
		}
		else
		{
			$sort									= [];
		}


		$this->page_attributes->filters				= 	[
															'titles' 		=> ['pembayaran'], 
															'pembayaran' 	=> ['Cash','Voucher']
														];


		//2. Sorting
		if (Input::has('sort'))
		{
			$sort_item 								= explode('-', Input::get('sort'));
			$sort 									= [$sort_item[0] => $sort_item[1]];
		}
		else
		{
			$sort									= [];
		}

		$SortList 									= new SortList;
		$this->page_attributes->sorts 				= 	[
															'titles'	=> ['tanggal', 'jumlah'],
															'tanggal'	=> $SortList->getSortingList('tanggal'),
															'jumlah'	=> $SortList->getSortingList('jumlah'),
														]; 	


		//3. Check page
		if(is_null(Input::get('page')))
		{
			$page 									= 1;
		}
		else
		{
			$page 									= Input::get('page');
		}

		//4. Generate breadcrumb
		$breadcrumb 								=	[
															'Rekap Penjualan & Penggunaan Voucher' 		=> route('report.recap.sale'),
														];	
		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);
														

		//5. Get data from API
		$APIReport 									= new APIReport;

		$report 									= $APIReport->getVoucherUsage([
														'search' 	=> $search,
														'sort' 		=> $sort,																		
														'take'		=> $this->take,
														'skip'		=> ($page - 1) * $this->take,
														]);

		$this->page_attributes->data				= 	[
															'report' => $report,
														];

		//6. Generate paginator
		$this->paginate(route('report.recap.sale'), $report['data']['count'], $page);

		//7. Generate view
		$this->page_attributes->source 				=  $this->page_attributes->source . 'penjualan.index';

		return $this->generateView();
	}

}
