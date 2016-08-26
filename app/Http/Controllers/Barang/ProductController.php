<?php 
namespace App\Http\Controllers\Barang;

use App\API\Connectors\APIProduct;
use App\API\Connectors\APITag;
use App\API\Connectors\APICategory;
use App\API\Connectors\APILabel;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Helper\SortList;

use Input, Session, DB, Redirect, Response, Auth;

/**
 * Handle Product resource
 * 
 * @author budi
 */
class ProductController extends AdminController
{
	public function __construct()
	{
		parent::__construct();

		$this->page_attributes->title 				= 'Produk';
		$this->page_attributes->source 				= 'pages.barang.produk.';
		$this->page_attributes->breadcrumb			=	[
															'Produk' 	=> route('goods.product.index'),
														];

        $this->middleware('password.needed', ['only' => ['destroy']]);
	}

	/**
	 * Display all product
	 * 
	 * 1. Check filter
	 * 2. Check page
	 * 3. Get data from API
	 * 4. Generate paginator
	 * 5. Generate breadcrumb
	 * 6. Generate filters param
	 * 7. Generate view
	 * @param page, q
	 * @return Object View
	 */
	public function index()
	{

		//1. Check filter
		$search 									= [];

		if(Input::has('q'))
		{
			$search 								= ['name' 			=> Input::get('q')];

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
		$this->paginate(route('goods.product.index'), $product['data']['count'], $page);

		//5. Generate breadcrumb
		$breadcrumb 								= [];	

		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		//6. Generate view
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


		$this->page_attributes->filters 			= 	[
															'titles' 	=> $filterTitles,
															'tag'		=> $filterTags,
															'kategori'	=> $filterCategories,
															'label'		=> $filterLabels,
														];
		
		$this->page_attributes->sorts 				= 	[
															'titles'	=> ['nama', 'harga', 'stok'],
															'nama'		=> $SortList->getSortingList('nama'),
															'harga'		=> $SortList->getSortingList('harga'),
															'stok'		=> $SortList->getSortingList('stok'),
														]; 														

		//7. Generate view
		$this->page_attributes->source 				=  $this->page_attributes->source . 'index';

		return $this->generateView();
	}

	/**
	 * Display a product
	 * 
	 * 1. Get data from API
	 * 2. Get collection search
	 * 3. Generate breadcrumb
	 * 4. Generate view
	 * @param q
	 * @return Object View
	 */
	public function show($id)
	{
		//1. Get data from API
		$APIProduct 								= new APIProduct;
		$product 									= $APIProduct->getShow($id);

		$this->page_attributes->data				= 	[
															'product' => $product,
														];

		//2. Get collection search
		if(Input::has('q'))
		{
			$this->page_attributes->search 			= Input::get('q');
		}		

		//3. Generate breadcrumb
		$breadcrumb 								=	[
															$product['data']['name'] => route('goods.product.show', ['id' => $id])
														];	

		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		//4. Generate view
		$this->page_attributes->subtitle 			= $product['data']['name'];

		$this->page_attributes->source 				= $this->page_attributes->source . 'show';

		return $this->generateView();
	}	

	/**
	 * create form of a product
	 * 
	 * 1. Get Previous data and page setting
	 * 2. Initialize data
	 * 3. Generate breadcrumb
	 * 4. Generate view
	 * @param id
	 * @return Object View
	 */
	public function create($id = null)
	{
		//1. Get Previous data and page setting
		if (is_null($id))
		{
			$data 									= null;

			$breadcrumb								=	[
															'Data Baru' => route('goods.product.create'),
														];


			$this->page_attributes->subtitle 		= 'Data Baru';
		}
		else
		{
			$APIProduct 							= new APIProduct;
			$data 									= ['data' => $APIProduct->getShow($id)['data'] ];	

			//explode description saved in json
			$tmp									= json_decode($data['data']['description'], true);
			$data['data']['description']			= $tmp['description'];			
			$data['data']['fit']					= $tmp['fit'];
			$data['data']['price_start']			= \Carbon\Carbon::parse($data['data']['price_start'])->format('d-m-Y H:i');		

			$breadcrumb								=	[
															$data['data']['name']  =>  route('goods.product.show', ['id' => $data['data']['id']] ),
															'Edit'  =>  route('goods.product.create', ['id' => $data['data']['id']] ),
														];

			$this->page_attributes->subtitle 		= $data['data']['name'];
		}

		//2. Initialize data
		$this->page_attributes->data 				=  $data;

		//3. Generate breadcrumb
		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);


		//4. Generate view
		$this->page_attributes->source 				=  $this->page_attributes->source . 'create';

		return $this->generateView();
	}

	/**
	 * Edit a product
	 * 
	 * @param id
	 * @return function
	 */
	public function edit($id)
	{
		return $this->create($id);
	}

	/**
	 * Store a product
	 * 
	 * 1. Store Price
	 * 2. Store Image
	 * 3. Store Label
	 * 4. Store Tag
	 * 5. Store Category
	 * @param id
	 * @return object view
	 */
	public function store($id = "")
	{
		//1. Store Price
		$prices 									= json_decode(Input::get('prices'), true);

		if(is_null($prices))
		{
			$prices 								= [];
		}

		$tmpPrice 									= 	[
															'id' 			=> "",
															'price'			=> str_replace('IDR ', '', str_replace('.', '', Input::get('price'))),
															'promo_price'	=> str_replace('IDR ', '', str_replace('.', '', Input::get('promo_price'))),
															'started_at'	=> date('Y-m-d H:i:s', strtotime(Input::get('started_at'))),
														];		
		array_push($prices,$tmpPrice);

		//2. Store Image
		$images 									= [];
		foreach (Input::get('thumbnail') as $key => $image)
		{
			$tmpImage 								= 	[
															'id' 			=> "",
															'thumbnail'		=> Input::get('thumbnail')[$key],
															'image_xs'		=> Input::get('image_xs')[$key],
															'image_sm'		=> Input::get('image_sm')[$key],
															'image_md'		=> Input::get('image_md')[$key],
															'image_lg'		=> Input::get('image_lg')[$key],
															'is_default'	=> Input::get('default')[$key],
														];

			if(!empty($tmpImage['thumbnail']) || !empty($tmpImage['image_xs']) || !empty($tmpImage['image_sm']) || !empty($tmpImage['image_md']) || !empty($tmpImage['lg']) )
			{
				array_push($images,$tmpImage);
			}

			if(count($images) == 0)
			{
				$images[0] 							= 	[
															'id' 			=> "",
															'thumbnail'		=> "",
															'image_xs'		=> "",
															'image_sm'		=> "",
															'image_md'		=> "",
															'image_lg'		=> "",
															'is_default'	=> "",
														];
			}														
		}

		//3. Store Label
		$labels										= [];
		$tmpLabel 									= explode( ',', trim(Input::get('label'), ' '));

		foreach ($tmpLabel as $key => $tmp)
		{
			$labels[$key] 							= 	[
															'id' 			=> "",
															'product_id'	=> $id,
															'value'			=> "",
															"label"			=> $tmp,
															"started_at"	=> date('Y-m-d H:i:s', strtotime('now')),
															"ended_at"		=> "",
														];
		}

		//4. Store Tag
		$tags										= [];
		$tmpTag										= explode( ',', trim(Input::get('tag'), ' '));

		foreach ($tmpTag as $key => $tmp)
		{
			$tags[$key] 							= 	[
															'id' 			=> $tmp,
															'slug' 			=> "",
														];
		}	

		//5. Store Category
		$categories									= [];
		$tmpCategory								= explode( ',', trim(Input::get('category'), ' '));

		foreach ($tmpCategory as $key => $tmp)
		{
			$categories[$key] 						= 	[
															'id' 			=> $tmp,
															'slug' 			=> "",
														];
		}

		//6. Store Product
		$data 										= 	[
															'id' 			=> $id,
															'name'			=> Input::get('name'),
															'upc'			=> Input::get('upc'),
															'label'			=> Input::get('label'),
															'description'	=> json_encode([
																				'description' 	=> Input::get('description'),
																				'fit'			=> Input::get('fit'),
																				'care'			=> Input::get('care'),
																				]),
															'started_at'	=> Input::get('started_at'),
															'images'		=> $images,
															'prices'		=> $prices,
															'labels'		=> $labels,
															'categories'	=> $categories,
															'tags'			=> $tags,
															'slug'			=> NULL,
														];											

		//check is null image												
		if(empty($data['images']))
		{
			unset($data['images']);
		}

		//api
		$APIProduct 								= new APIProduct;

		$result 									= $APIProduct->postData($data);

		//result
		if($result['status'] != 'success')
		{
			$this->errors							= $result['message'];
		}

		//return view
		if(!empty($id))
		{
			$this->page_attributes->success 		= "Data Produk Telah Diedit";
		}
		else
		{
			$this->page_attributes->success 		= "Data Produk Telah Ditambahkan";
		}

		return $this->generateRedirectRoute('goods.product.index');
	}

	/**
	 * Update a product
	 * 
	 * @param id
	 * @return function
	 */
	public function Update($id)
	{
		return $this->store($id);
	}

	/**
	 * Delete a product
	 * 
	 * @param id
	 * @return function
	 */
	public function destroy($id)
	{
		//Call API
		$APIProduct 								= new APIProduct;

		$result 									= $APIProduct->deleteData($id);

		//Check response
		if($result['status'] != 'success')
		{
			$this->errors 							= $result['message'];
		}

		//Return Message
		$this->page_attributes->success 			= "Data Produk telah dihapus";
		
		return $this->generateRedirectRoute('goods.product.index');	
	}		
}
