<?php 
namespace App\Http\Controllers\Barang;

use App\API\connectors\APIProduct;

use App\Http\Controllers\AdminController;
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

		// data here
		$APIProduct 								= new APIProduct;
		$product 									= $APIProduct->getIndex([
															'name' 	=> Input::get('q')
														]);

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

	}	

	public function create($id = null)
	{
		//initialize
		if (is_null($id))
		{
			$breadcrumb								=	[
															'Data Baru' => route('admin.product.create'),
														];

			$this->page_attributes->subtitle 		= 'Data Baru';
		}
		else
		{
			$data 									= ['name' => 'nama'];

			$breadcrumb								=	[
															'Edit Data ' . $data['name']  =>  route('admin.product.create'),
														];

			// $this->page_attributes->subtitle 		= $tag->name;
		}

		//generate View
		$this->page_attributes->breadcrumb			= array_merge($this->page_attributes->breadcrumb, $breadcrumb);

		$this->page_attributes->source 				=  $this->page_attributes->source . 'create';

		return $this->generateView();
	}

	public function edit($id)
	{
		return $this->create($id);
	}

	public function store($id = null)
	{
		//init
		$data 										= 	[
															'id' 			=> $id,
															'name'			=> Input::get('name'),
															'upc'			=> Input::get('upc'),
															'label'			=> Input::get('lable'),
															'description'	=> json_encode([
																				'description' 	=> Input::get('description'),
																				'fit'			=> Input::get('fit'),
																				]),
															'category'		=> Input::get('category'),
															'tag'			=> Input::get('tag'),
															'started_at'	=> Input::get('started_at'),
															'price'			=> Input::get('price'),
															'promo_price'	=> Input::get('promo_price'),
															'thumbnail'		=> Input::get('thumbnail'),
															'image_xs'		=> Input::get('image_xs'),
															'image_sm'		=> Input::get('image_sm'),
															'image_md'		=> Input::get('image_md'),
															'image_lg'		=> Input::get('image_lg'),
															'slug'			=> NULL,
														];


		//api
		$APIProduct 								= new APIProduct;

		$result 									= $APIProduct->postData($data);


		//result
		dd($result);

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
