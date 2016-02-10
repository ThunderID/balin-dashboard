<?php 
namespace App\Http\Controllers\Barang;

use App\API\Connectors\APIProduct;
use App\API\Connectors\APITag;
use App\API\Connectors\APICategory;
use App\API\Connectors\APILabel;

use App\Http\Controllers\AdminController;
use Input, Session, DB, Redirect, Response, Auth, Carbon, Collection;

class PriceController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->page_attributes->title 				= 'Harga';
		$this->page_attributes->source 				= 'pages.barang.harga.';
		$this->page_attributes->breadcrumb			=	[
															'Harga' 	=> route('goods.price.index'),
														];			
														
        $this->middleware('password.needed', ['only' => ['destroy']]);
	}

	public function index()
	{
		//initialize 
		$search 									= [];

		if(Input::has('q'))
		{
			$search['name']							= Input::get('q');
			$this->page_attributes->search 			= Input::get('q');
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
			$sort_item 							= explode('-', Input::get('sort'));
			$sort 								= [$sort_item[0] => $sort_item[1]];
		}
		else
		{
			$sort								= ['name' => 'asc'];
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
		$APIProduct 								= new APIProduct;

		$product 									= $APIProduct->getIndex([
															'search' 	=> 	$search,
															'sort' 		=> 	$sort,																		
															'take'		=> $this->take,
															'skip'		=> ($page - 1) * $this->take,
														]);

		$this->page_attributes->data				= 	[
															'product' => $product,
														];

		//paginate
		$this->paginate(route('goods.price.index'), $product['data']['count'], $page);

		//breadcrumb
		$breadcrumb 								= [];	


		//filters
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


		foreach ($tmpLabel as $value) 
		{
			$filterLabels[$key]						= ucwords(str_replace("_", " ",$value['label']));
		}		


		$this->page_attributes->filters 			= 	[
															'titles' 	=> $filterTitles,
															'tag'		=> $filterTags,
															'kategori'	=> $filterCategories,
															'label'		=> $filterLabels,
														];

		//generate View
		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		$this->page_attributes->source 				=  $this->page_attributes->source . 'index';

		return $this->generateView();
	}

	public function show($id)
	{
		//initialize 
		$APIProduct 								= new APIProduct;
		$product 									= $APIProduct->getShow($id);

		$this->page_attributes->subtitle 			= $product['data']['name'];

		$collection 								= collect($product['data']['prices']);

		// filters & collection
		if(Input::has('start') && Input::has('end'))
		{
			$this->page_attributes->search 			= 'Periode ' . Input::get('start') . ' sampai ' . Input::get('end');

			$filterStart							= date('Y-m-d H:i:s', strtotime(Input::get('start')));
			$filterEnd								= date('Y-m-d H:i:s', strtotime(Input::get('end')));

			$result 								= $collection->filter(function ($col)use($filterStart, $filterEnd) {
															return $col['started_at'] >= $filterStart &&  $col['started_at'] <= $filterEnd;
														});
		}
		else
		{
			$result 								= $collection;
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
		$collection 								= collect($result);

		if(count($collection) != 0)
		{
			$result 								= $collection->chunk($this->take);

			$this->paginate(route('goods.price.show', ['id' => $id]), count($product['data']['prices']), $page);

			$product['data']['prices']				= $result[($page-1)];
		}
		else
		{
			$this->paginate(route('goods.price.show', ['id' => $id]), count($product['data']['prices']), $page);
		}


		// set data
		$product['data']['prices']					= $result->forPage($page, $this->take);
		$this->page_attributes->data				= 	[
															'product' => $product['data'],
														];		

		//breadcrumb
		$breadcrumb 								=	[
															$product['data']['name'] => route('goods.price.show', ['id' => $id])
														];	

		//generate View
		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		$this->page_attributes->source 				= $this->page_attributes->source . 'show';

		return $this->generateView();
	}	

	public function create($productId = null,  $id = null)
	{
		//initialize
		if(!is_null($productId))
		{
			//initialize 
			$APIProduct 							= new APIProduct;
			$product 								= $APIProduct->getShow($productId);

			//is edit
			if(is_null($id))
			{
				$data 								= 	[
															'productId' 	=> $productId,
															'name' 			=> $product['data']['name'],
															'price'			=> null,
														];

				$breadcrumb							=	[
															$product['data']['name'] => route('goods.price.show', ['productId' => $productId]),
															'Harga Baru' => route('goods.price.detail.create', ['productId' => $productId]),
														];

				$this->page_attributes->subtitle 	= $product['data']['name'];
			}
			else
			{
				$tmpPrice							= $this->PriceFindData($product['data']['prices'],$id);

				$tmpdate 							= Carbon::createFromFormat('Y-m-d H:i:s', $tmpPrice['data']['started_at'])->format('d-m-Y H:i:s');

				$tmpPrice['data']['started_at'] 	= $tmpdate;


				$data 								= 	[
															'productId' 	=> $productId,
															'price'			=> $tmpPrice,
															'name' 			=> $product['data']['name'],
														];

				$breadcrumb							=	[
															$product['data']['name'] => route('goods.price.show', ['productId' => $productId]),
															'Edit Harga'   =>  route('goods.price.detail.edit', ['productId' => $productId, 'id' => $id]),
														];
			}
		}
		else
		{
			$data 									= 	[
															'productId' 	=> $productId,
															'name'			=> null,
															'price'			=> null,
														];

			$breadcrumb								=	[
															'Data Baru' => route('goods.price.create'),
														];

			$this->page_attributes->subtitle 		= 'Data Baru';
		}

		//generate View
		$this->page_attributes->data				= $data;
		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		$this->page_attributes->source 				=  $this->page_attributes->source . 'create';

		return $this->generateView();
	}

	public function edit($productId = null, $id = null)
	{
		return $this->create($productId, $id);
	}

	public function store($productId = null, $id = "")
	{
		//get data
		$APIProduct 								= new APIProduct;
		$product 									= $APIProduct->getShow(Input::get('produk'));

		//format input
		$inputPrice 								= str_replace('IDR ', '', str_replace('.', '', Input::get('price')));
		$inputPromoPrice 							= str_replace('IDR ', '', str_replace('.', '', Input::get('promo_price'))); 
		$inputStartDate 							= date('Y-m-d H:i:s', strtotime(Input::get('start_at')));

		//is edit
		if(!empty($id))
		{
			$tmpPrice								= $this->PriceFindData($product['data']['prices'],$id);

			$price 									= $tmpPrice['data'];

			$key 									= $tmpPrice['key'];

			$price['price']							= $inputPrice;
			$price['promo_price']					= $inputPromoPrice;
			$price['started_at']					= $inputStartDate;
		}
		else
		{
			$key 									= count($product['data']['prices']);

			$price['id']							= $id;
			$price['product_id']					= $product['data']['id'];
			$price['price']							= $inputPrice;
			$price['promo_price']					= $inputPromoPrice;
			$price['started_at']					= $inputStartDate;
		}

		//embedd new data price into product
		$product['data']['prices'][$key]			= $price;	

		//save
		$result 									= $APIProduct->postData($product['data']);

		//response
		if($result['status'] != 'success')
		{
			$this->errors 							= $result['message'];
		}

		//return view
		if(!empty($id))
		{
			$this->page_attributes->success 		= "Data Harga Telah Diedit";
		}
		else
		{
			$this->page_attributes->success 		= "Data Harga Telah Ditambahkan";
		}

		return $this->generateRedirectRoute('goods.price.show', ['id' => Input::get('produk')]);		
	}

	public function Update($productId = null, $id = "")
	{
		return $this->store($productId, $id);
	}

	public function destroy($productId = null, $id = null)
	{
		//cek auth

		//get data
		$APIProduct 								= new APIProduct;
		$product 									= $APIProduct->getShow($productId);

		$price 										= $this->PriceFindData($product['data']['prices'], $id);

		//delete varian
		unset($product['data']['prices'][$price['key']]);

		//save
		$result 									= $APIProduct->postData($product['data']);

		//response
		if($result['status'] != 'success')
		{
			$this->errors 							= $result['message'];
		}		

		//return view
		$this->page_attributes->success 			= "Data Harga Produk Telah Dihapus";

		return $this->generateRedirectRoute('goods.price.show', ['id' => $productId]);				
	}		


	//FUNCTIONS
	private function PriceFindData($arraySource, $id)
	{
		//select data from arraySource based on id and return it
		//if data not found, it will return error

		//return
		//array['key','data']

		//parameter
		//arraysource 	= array price
		//id 			= price id

		foreach ($arraySource as $key =>  $price) 
		{
			if($price['id'] == $id)
			{
				return ['key' => $key, 'data' => $price];
			}
		}

		return abort(404, 'No price data with id ' . $id);
	}		
}
