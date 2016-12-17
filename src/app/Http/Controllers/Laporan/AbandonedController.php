<?php 
namespace App\Http\Controllers\Laporan;

use App\API\Connectors\APISale;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Helper\SortList;

use Input, Session, DB, Redirect, Response, Auth, Carbon;
/**
 * Handle report controller
 * 
 * @author budi
 */
class AbandonedController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->page_attributes->title 				= 	'Laporan Abandoned Cart';
		$this->page_attributes->source 				= 	'pages.laporan.abandoned.';

		$this->page_attributes->breadcrumb			=	[];		
	}

	public function index()
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
			$search['refnumber']					= Input::get('q');
			$this->page_attributes->search 			= Input::get('q');
		}


		$search['expiredcart']							= true;


		$this->page_attributes->filters				= 	[];

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
															'titles'	=> ['tanggal', 'nota', 'tagihan'],
															'tanggal'	=> $SortList->getSortingList('tanggal'),
															'nota'		=> $SortList->getSortingList('nota'),
															'tagihan'	=> $SortList->getSortingList('tagihan'),
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
															'Laporan Abandoned Cart' 		=> route('report.product.abandoned'),
														];	
		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);
														
		//5. Get data from API
		$APISale 									= new APISale;

		$sale 										= $APISale->getIndex([
														'search' 	=> $search,
														'sort' 		=> $sort,																		
														'take'		=> $this->take,
														'skip'		=> ($page - 1) * $this->take,
														]);

		$this->page_attributes->data				= 	[
															'sale' => $sale,
														];

		//6. Generate paginator
		$this->paginate(route('report.product.abandoned'), $sale['data']['count'], $page);


		//7. Generate view
		$this->page_attributes->source 				=  $this->page_attributes->source . '.index';

		return $this->generateView();
	}

	public function show($id)
	{
		//1. Get data from API
		$APISale 									= new APISale;
		$sale 										= $APISale->getShow($id);

		//2. Check return status
		if($sale['status'] != 'success')
		{
			$this->errors 							= $sale['message'];
			
			return $this->generateRedirectRoute('report.product.abandoned');	
		}

		$this->page_attributes->subtitle 			= $sale['data']['ref_number'];
		
		$this->page_attributes->data				= 	[
															'sale' => $sale,
														];

		//3. Generate breadcrumb
		$ref 										= $sale['data']['ref_number'];
		if(empty($ref)){
			$ref 									= '#';					
		}

		$breadcrumb 								=	[
															'Laporan Abandoned Cart' 		=> route('report.product.abandoned'),
															$ref => route('report.product.abandoned.detail', ['id' => $id])
														];	
		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		//4. Generate view

		$this->page_attributes->source 				= $this->page_attributes->source . 'show';

		return $this->generateView();
	}	
}