<?php

/**
* Routes untuk menu barang
*
*/
Route::group(['prefix' => 'barang', 'namespace' => 'Barang\\'], function()
{
	/**
	* Routes untuk sub menu produk dan varian
	*
	*/
	Route::resource('produk',  				'ProductController',	['names' => ['index' => 'goods.product.index', 'create' => 'goods.product.create', 'store' => 'goods.product.store', 'show' => 'goods.product.show', 'edit' => 'goods.product.edit', 'update' => 'goods.product.update', 'destroy' => 'goods.product.destroy']]);
	Route::resource('produk/{pid}/varian',	'VarianController',		['names' => ['index' => 'goods.varian.index', 'create' => 'goods.varian.create', 'store' => 'goods.varian.store', 'show' => 'goods.varian.show', 'edit' => 'goods.varian.edit', 'update' => 'goods.varian.update', 'destroy' => 'goods.varian.destroy']]);
	
	/**
	* Routes untuk sub menu harga produk
	*
	*/
	Route::resource('harga',  				'PriceController',		['names' => ['index' => 'goods.price.index', 'create' => 'goods.price.create', 'store' => 'goods.price.store', 'show' => 'goods.price.show']]);
	Route::resource('harga/{pid}/detail', 	'PriceController', 		['names' => ['create' => 'goods.price.detail.create', 'store' => 'goods.price.detail.store', 'edit' => 'goods.price.detail.edit', 'update' => 'goods.price.detail.update', 'destroy' => 'goods.price.detail.destroy']]);
	
	/**
	* Routes untuk stok produk
	*
	*/
	Route::resource('stok',  	'StockController',			['names' => ['index' => 'goods.stock.index', 'show' => 'goods.stock.show'], 'only' => ['show', 'index']]);

	/**
	* Routes untuk sub menu atribut dari produk
	*
	*/
	Route::resource('kategori', 'CategoryController',		['names' => ['index' => 'goods.category.index', 'create' => 'goods.category.create', 'store' => 'goods.category.store', 'show' => 'goods.category.show', 'edit' => 'goods.category.edit', 'update' => 'goods.category.update', 'destroy' => 'goods.category.destroy']]);
	Route::resource('tag', 		'TagController',			['names' => ['index' => 'goods.tag.index', 'create' => 'goods.tag.create', 'store' => 'goods.tag.store', 'show' => 'goods.tag.show', 'edit' => 'goods.tag.edit', 'update' => 'goods.tag.update', 'destroy' => 'goods.tag.destroy']]);
	Route::resource('label', 	'LabelController',			['names' => ['index' => 'goods.label.index', 'create' => 'goods.label.create', 'store' => 'goods.label.store', 'show' => 'goods.label.show', 'edit' => 'goods.label.edit', 'update' => 'goods.label.update', 'destroy' => 'goods.label.destroy']]);

	/**
	* Routes untuk select2 ajax
	*
	*/
	Route::get('tag/ajax/findName',							['uses' => 'AjaxController@FindTagByName', 	'as' => 'ajax.tag.findName']);
	Route::get('category/ajax/findName',					['uses' => 'AjaxController@FindCategoryByName', 	'as' => 'ajax.category.findName']);
	Route::get('label/ajax/findName',						['uses' => 'AjaxController@FindLabelByName', 	'as' => 'ajax.label.findName']);
	Route::get('product/ajax/findName',						['uses' => 'AjaxController@FindProductByName', 	'as' => 'ajax.product.findName']);
});

/**
* Routes untuk menu toko
*
*/
Route::group(['prefix' => 'toko', 'namespace' => 'Toko\\'], function()
{
	/**
	* Routes untuk sub menu sale dan proses
	*
	*/
	Route::resource('penjualan',  	'SellController',			['names' => ['index' => 'shop.sell.index', 'show' => 'shop.sell.show'], 'only' => ['show', 'index']]);
	Route::resource('pembayaran',  	'PayController',			['names' => ['create' => 'shop.pay.create', 'store' => 'shop.pay.store'], 'only' => ['create', 'store']]);
	Route::resource('packing',  	'PackingController',		['names' => ['create' => 'shop.packing.create', 'store' => 'shop.packing.store'], 'only' => ['create', 'store']]);
	Route::resource('pengirman',  	'ShippingController',		['names' => ['create' => 'shop.shipping.create', 'store' => 'shop.shipping.store'], 'only' => ['create', 'store']]);
	Route::resource('penerimaan',	'CompleteOrderController',	['names' => ['create' => 'shop.completeorder.create', 'store' => 'shop.completeorder.store'], 'only' => ['create', 'store']]);
	Route::resource('pembatalan',	'CancelOrderController',	['names' => ['create' => 'shop.cancelorder.create', 'store' => 'shop.cancelorder.store'], 'only' => ['create', 'store']]);
	
	Route::resource('kurir', 'CourierController',				['names' => ['index' => 'shop.courier.index', 'create' => 'shop.courier.create', 'store' => 'shop.courier.store', 'show' => 'shop.courier.show', 'edit' => 'shop.courier.edit', 'update' => 'shop.courier.update', 'destroy' => 'shop.courier.destroy']]);
	Route::resource('buy', 'BuyController',						['names' => ['index' => 'shop.buy.index', 'create' => 'shop.buy.create', 'store' => 'shop.buy.store', 'show' => 'shop.buy.show', 'edit' => 'shop.buy.edit', 'update' => 'shop.buy.update', 'destroy' => 'shop.buy.destroy']]);

	/**
	* Routes untuk select2 ajax
	*
	*/
	Route::get('sell/ajax/findAmount',							['uses' => 'AjaxController@FindTransactionByAmount', 	'as' => 'ajax.sell.findAmount']);
	Route::get('sell/ajax/findRefNumber',						['uses' => 'AjaxController@FindTransactionByRefNumber', 	'as' => 'ajax.sell.findRefNumber']);
});

Route::group(['prefix' => 'laporan', 'namespace' => 'Laporan\\'], function()
{
	Route::get('penggunaan/voucher',						['uses' => 'ReportController@voucherusage', 'as' => 'admin.report.voucherusage']);
	Route::get('penjualan/barang',							['uses' => 'ReportController@soldproduct', 'as' => 'admin.report.soldproduct']);
});

Route::group(['prefix' => 'konfigurasi', 'namespace' => 'Konfigurasi\\'], function()
{
	Route::resource('admin', 'AdministrativeController',	['names' => ['index' => 'admin.administrative.index', 'create' => 'admin.administrative.create', 'store' => 'admin.administrative.store', 'show' => 'admin.administrative.show', 'edit' => 'admin.administrative.edit', 'update' => 'admin.administrative.update', 'destroy' => 'admin.administrative.destroy']]);
	Route::resource('website', 'WebsiteController',			['names' => ['index' => 'admin.website.index', 'create' => 'admin.website.create', 'store' => 'admin.website.store', 'show' => 'admin.website.show', 'edit' => 'admin.website.edit', 'update' => 'admin.website.update', 'destroy' => 'admin.website.destroy']]);
	Route::resource('policy', 'PolicyController',			['names' => ['index' => 'admin.policy.index', 'create' => 'admin.policy.create', 'store' => 'admin.policy.store', 'show' => 'admin.policy.show', 'edit' => 'admin.policy.edit', 'update' => 'admin.policy.update', 'destroy' => 'admin.policy.destroy']]);
});

Route::group(['prefix' => 'customer', 'namespace' => 'Customer\\'], function()
{
	Route::resource('customer', 'CustomerController',		['names' => ['index' => 'admin.customer.index', 'create' => 'admin.customer.create', 'store' => 'admin.customer.store', 'show' => 'admin.customer.show', 'edit' => 'admin.customer.edit', 'update' => 'admin.customer.update', 'destroy' => 'admin.customer.destroy']]);
	Route::resource('point', 'PointController',				['names' => ['index' => 'admin.point.index', 'create' => 'admin.point.create', 'store' => 'admin.point.store', 'show' => 'admin.point.show', 'edit' => 'admin.point.edit', 'update' => 'admin.point.update', 'destroy' => 'admin.point.destroy']]);
	Route::resource('referral', 'ReferralController',		['names' => ['index' => 'admin.referral.index', 'create' => 'admin.referral.create', 'store' => 'admin.referral.store', 'show' => 'admin.referral.show', 'edit' => 'admin.referral.edit', 'update' => 'admin.referral.update', 'destroy' => 'admin.referral.destroy']]);

	//ajax
	Route::get('customer/ajax/findName',					['uses' => 'AjaxController@FindCustomerByName', 	'as' => 'ajax.customer.findName']);
});

Route::group(['prefix' => 'promosi', 'namespace' => 'Promosi\\'], function()
{
	Route::resource('voucher', 'VoucherController',		['names' => ['index' => 'admin.voucher.index', 'create' => 'admin.voucher.create', 'store' => 'admin.voucher.store', 'show' => 'admin.voucher.show', 'edit' => 'admin.voucher.edit', 'update' => 'admin.voucher.update', 'destroy' => 'admin.voucher.destroy']]);
	Route::resource('diskon', 'DiscountController',		['names' => ['index' => 'admin.discount.index', 'create' => 'admin.discount.create', 'store' => 'admin.discount.store', 'show' => 'admin.discount.show', 'edit' => 'admin.discount.edit', 'update' => 'admin.discount.update', 'destroy' => 'admin.discount.destroy']]);
});
