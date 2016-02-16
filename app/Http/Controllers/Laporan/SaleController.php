<?php 
namespace App\Http\Controllers\Laporan;

use App\API\Connectors\APISale;

use App\Http\Controllers\AdminController;

use Input, Session, DB, Redirect, Response, Auth;
/**
 * Handle report controller
 * 
 * @author budi
 */
class SaleController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->page_attributes->title 				= 	'Laporan Penjualan';
		$this->page_attributes->source 				= 	'pages.laporan.penjualan.';
		$this->page_attributes->breadcrumb			=	[];		
	}

	public function index()
	{
		//1. Check filter
		$search 									= [];

		if(Input::has('periode'))
		{
			$tmpdate 								= "01-" . Input::get('periode')[0] . " 00:00:00";

			$search['ondate'] 						= 	[
															Carbon::createFromFormat('d-m-Y H:i:s', ($tmpdate))->format('Y-m-d H:i:s'),
															Carbon::createFromFormat('d-m-Y H:i:s', ($tmpdate))->addMonths(1)->format('Y-m-d H:i:s'),
														];
		}
		else
		{
			$searchResult							= null;
		}

		if(Input::has('q'))
		{
			$search['refnumber']					= Input::get('q');
			$this->page_attributes->search 			= Input::get('q');
		}

		if(Input::has('status'))
		{
			$search['status']						= Input::get('status');
		}


		$this->page_attributes->filters				= 	[
															'titles' 	=> ['periode','status'], 
															'periode' 	=> [],
															 'status' 	=> ['cart','wait','paid','packed','shipping','delivered','canceled','abandoned']]
														;


		//2. Check page
		if(is_null(Input::get('page')))
		{
			$page 									= 1;
		}
		else
		{
			$page 									= Input::get('page');
		}

		//3. Generate breadcrumb
		$breadcrumb 								=	[
															'Laporan Penjualan' 		=> route('report.product.sale'),
														];	
		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);
														

		//4. Get data from API
		$APISale 									= new APISale;

		$sale 										= $APISale->getIndex([
														'search' 	=> 	$search,
														'sort' 		=> 	[
																			'transact_at'	=> 'asc',
																		],																		
														'take'		=> $this->take,
														'skip'		=> ($page - 1) * $this->take,
														]);

		$this->page_attributes->data				= 	[
															'sale' => $sale,
														];

		//5. Generate paginator
		$this->paginate(route('report.product.sale'), $sale['data']['count'], $page);

		//6. Generate breadcrumb
		$breadcrumb								=	[
													];
		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

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
			
			return $this->generateRedirectRoute('report.product.sale');	
		}

		$this->page_attributes->subtitle 			= $sale['data']['ref_number'];
		
		$this->page_attributes->data				= 	[
															'sale' => $sale,
														];

		//3. Generate breadcrumb
		$breadcrumb 								=	[
															'Laporan Penjualan' 		=> route('report.product.sale'),
															$sale['data']['ref_number'] => route('report.product.sale.detail', ['id' => $id])
														];	
		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		//4. Generate view

		$this->page_attributes->source 				= $this->page_attributes->source . 'show';

		return $this->generateView();
	}

}
