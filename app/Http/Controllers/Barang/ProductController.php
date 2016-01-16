<?php 
namespace App\Http\Controllers\Barang;

use App\API\connectors\APIProduct;

use App\Http\Controllers\AdminController;
use Illuminate\Pagination\Paginator;

use Input, Session, DB, Redirect, Response, Auth;

class ProductController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->page_attributes->title 				= 'Produk';
		$this->page_attributes->source 				= 'pages.barang.produk.';
		$this->page_attributes->breadcrumb			=	[
															'Produk' 	=> route('admin.product.index'),
														];		
	}

	public function index()
	{
		//initialize 
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

		//paginate

		// data here
		$APIProduct 								= new APIProduct;

		$product 									= $APIProduct->getIndex([
														'search' 	=> 	[
																			'name' 	=> Input::get('q'),
																		],
														'sort' 		=> 	[
																			'name'	=> 'asc',
																		],																		
														'take'		=> 5,
														'skip'		=> 0,
														]);

		$this->page_attributes->paginator 			= new Paginator(range(1,3), 5, Input::get('page'));
	    $this->page_attributes->paginator->setPath('admin.product.index');


		$this->page_attributes->data				= 	[
															'product' => $product
														];

		//breadcrumb
		$breadcrumb 								= [];	

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

		// filters
		if(Input::has('q'))
		{
			$this->page_attributes->search 			= Input::get('q');
		}		

		// data here
		$this->page_attributes->data				= 	[
															'product' => $product,
														];

		//breadcrumb
		$breadcrumb 								=	[
															$product['data']['name'] => route('admin.product.show', ['id' => $id])
														];	

		//generate View
		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		$this->page_attributes->source 				= $this->page_attributes->source . 'show';

		return $this->generateView();
	}	

	public function create($id = null)
	{
		//initialize
		if (is_null($id))
		{
			$breadcrumb								=	[
															'Data Baru' => route('admin.product.create'),
														];

			$data 									= null;														

			$this->page_attributes->subtitle 		= 'Data Baru';
		}
		else
		{
			$APIProduct 							= new APIProduct;
			$data 									= $APIProduct->getShow($id);	

			$tmp									= json_decode($data['data']['description'], true);
			$data['data']['description']			= $tmp['description'];			
			$data['data']['fit']					= $tmp['fit'];		

			$breadcrumb								=	[
															$data['data']['name']  =>  route('admin.product.show', ['id' => $data['data']['id']] ),
															'Edit'  =>  route('admin.product.create', ['id' => $data['data']['id']] ),
														];

			$this->page_attributes->subtitle 		= $data['data']['name'];
		}

		//generate View
		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		$this->page_attributes->data 				=  $data;

		$this->page_attributes->source 				=  $this->page_attributes->source . 'create';

		return $this->generateView();
	}

	public function edit($id)
	{
		return $this->create($id);
	}

	public function store($id = null)
	{
		//price
		$prices 									= [];

		$tmpPrice 									= 	[
															'id' 			=> "",
															'price'			=> str_replace('IDR ', '', str_replace('.', '', Input::get('price'))),
															'promo_price'	=> str_replace('IDR ', '', str_replace('.', '', Input::get('promo_price'))),
															'started_at'	=> date('Y-m-d H:i:s', strtotime(Input::get('started_at'))),
														];		
		array_push($prices,$tmpPrice);


		//image
		$images 									= [];
		foreach (Input::get('thumbnail') as $key => $image)
		{

			//image
			$tmpImage 								= 	[
															'id' 			=> null,
															'thumbnail'		=> Input::get('thumbnail')[$key],
															'image_xs'		=> Input::get('image_xs')[$key],
															'image_sm'		=> Input::get('image_sm')[$key],
															'image_md'		=> Input::get('image_md')[$key],
															'image_lg'		=> Input::get('image_lg')[$key],
														];

			if(!empty($tmpImage['thumbnail']) || !empty($tmpImage['image_xs']) || !empty($tmpImage['image_sm']) || !empty($tmpImage['image_md']) || !empty($tmpImage['lg']) )
			{
				array_push($images,$tmpImage);
			}														
		}

		//get data
		$data 										= 	[
															'id' 			=> $id,
															'name'			=> Input::get('name'),
															'upc'			=> Input::get('upc'),
															'label'			=> Input::get('lable'),
															'description'	=> json_encode([
																				'description' 	=> Input::get('description'),
																				'fit'			=> Input::get('fit'),
																				]),
															'categories'	=> Input::get('category'),
															'tag'			=> Input::get('tag'),
															'started_at'	=> Input::get('started_at'),
															'images'		=> $images,
															'prices'		=> $prices,
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
			$error 									= $result['message'];
			dd($error);
		}

		$this->page_attributes->success 			= "Data telah ditambahkan";
		return $this->generateRedirectRoute('admin.product.index');
	}

	public function Update($id)
	{
		return $this->store($id);
	}

	public function destroy($id)
	{

	}		

	
	//AJAX
	public function AjaxFindName()
	{
		return json_encode('test');
	}	
}
