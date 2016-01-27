<?php

/**
* Routes untuk menu barang
*/
Route::group(['prefix' => 'barang', 'namespace' => 'Barang\\'], function()
{
	/**
	* Routes untuk sub menu produk dan varian
	*/
	Route::resource('produk',  				'ProductController',	['names' => ['index' => 'goods.product.index', 'create' => 'goods.product.create', 'store' => 'goods.product.store', 'show' => 'goods.product.show', 'edit' => 'goods.product.edit', 'update' => 'goods.product.update', 'destroy' => 'goods.product.destroy']]);
	Route::resource('produk/{pid}/varian',	'VarianController',		['names' => ['index' => 'goods.varian.index', 'create' => 'goods.varian.create', 'store' => 'goods.varian.store', 'show' => 'goods.varian.show', 'edit' => 'goods.varian.edit', 'update' => 'goods.varian.update', 'destroy' => 'goods.varian.destroy']]);
	
	/**
	* Routes untuk sub menu harga produk
	*/
	Route::resource('harga',  				'PriceController',		['names' => ['index' => 'goods.price.index', 'create' => 'goods.price.create', 'store' => 'goods.price.store', 'show' => 'goods.price.show']]);
	Route::resource('harga/{pid}/detail', 	'PriceController', 		['names' => ['create' => 'goods.price.detail.create', 'store' => 'goods.price.detail.store', 'edit' => 'goods.price.detail.edit', 'update' => 'goods.price.detail.update', 'destroy' => 'goods.price.detail.destroy']]);
	
	/**
	* Routes untuk stok produk
	*/
	Route::resource('stok',  	'StockController',			['names' => ['index' => 'goods.stock.index', 'show' => 'goods.stock.show'], 'only' => ['show', 'index']]);

	/**
	* Routes untuk sub menu atribut dari produk
	*/
	Route::resource('kategori', 'CategoryController',		['names' => ['index' => 'goods.category.index', 'create' => 'goods.category.create', 'store' => 'goods.category.store', 'show' => 'goods.category.show', 'edit' => 'goods.category.edit', 'update' => 'goods.category.update', 'destroy' => 'goods.category.destroy']]);
	Route::resource('tag', 		'TagController',			['names' => ['index' => 'goods.tag.index', 'create' => 'goods.tag.create', 'store' => 'goods.tag.store', 'show' => 'goods.tag.show', 'edit' => 'goods.tag.edit', 'update' => 'goods.tag.update', 'destroy' => 'goods.tag.destroy']]);
	Route::resource('label', 	'LabelController',			['names' => ['index' => 'goods.label.index', 'create' => 'goods.label.create', 'store' => 'goods.label.store', 'show' => 'goods.label.show', 'edit' => 'goods.label.edit', 'update' => 'goods.label.update', 'destroy' => 'goods.label.destroy']]);

	//ajax
	Route::get('tag/ajax/findName',							['uses' => 'AjaxController@FindTagByName', 	'as' => 'ajax.tag.findName']);
	Route::get('category/ajax/findName',					['uses' => 'AjaxController@FindCategoryByName', 	'as' => 'ajax.category.findName']);
	Route::get('label/ajax/findName',						['uses' => 'AjaxController@FindLabelByName', 	'as' => 'ajax.label.findName']);
	Route::get('product/ajax/findName',						['uses' => 'AjaxController@FindProductByName', 	'as' => 'ajax.product.findName']);
});

Route::group(['prefix' => 'toko', 'namespace' => 'Toko\\'], function()
{
	Route::resource('penjualan', 'SellController',			['names' => ['index' => 'admin.sell.index', 'create' => 'admin.sell.create', 'store' => 'admin.sell.store', 'show' => 'admin.sell.show', 'edit' => 'admin.sell.edit', 'update' => 'admin.sell.update', 'destroy' => 'admin.sell.destroy']]);
	Route::resource('bayar', 'PayController',				['names' => ['index' => 'admin.pay.index', 'create' => 'admin.pay.create', 'store' => 'admin.pay.store', 'show' => 'admin.pay.show', 'edit' => 'admin.pay.edit', 'update' => 'admin.pay.update', 'destroy' => 'admin.pay.destroy']]);
	Route::resource('packing', 'PackingController',			['names' => ['index' => 'admin.packing.index', 'create' => 'admin.packing.create', 'store' => 'admin.packing.store', 'show' => 'admin.packing.show', 'edit' => 'admin.packing.edit', 'update' => 'admin.packing.update', 'destroy' => 'admin.packing.destroy']]);
	Route::resource('kirim', 'ShippController',				['names' => ['index' => 'admin.shipp.index', 'create' => 'admin.shipp.create', 'store' => 'admin.shipp.store', 'show' => 'admin.shipp.show', 'edit' => 'admin.shipp.edit', 'update' => 'admin.shipp.update', 'destroy' => 'admin.shipp.destroy']]);
	Route::resource('done', 'FinishedTransactionController',['names' => ['index' => 'admin.finishedTransaction.index', 'create' => 'admin.finishedTransaction.create', 'store' => 'admin.finishedTransaction.store', 'show' => 'admin.finishedTransaction.show', 'edit' => 'admin.finishedTransaction.edit', 'update' => 'admin.finishedTransaction.update', 'destroy' => 'admin.finishedTransaction.destroy']]);
	Route::resource('cancel', 'CancelOrderController',		['names' => ['index' => 'admin.cancelorder.index', 'create' => 'admin.cancelorder.create', 'store' => 'admin.cancelorder.store', 'show' => 'admin.cancelorder.show', 'edit' => 'admin.cancelorder.edit', 'update' => 'admin.cancelorder.update', 'destroy' => 'admin.cancelorder.destroy']]);
	Route::resource('kurir', 'CourierController',			['names' => ['index' => 'admin.courier.index', 'create' => 'admin.courier.create', 'store' => 'admin.courier.store', 'show' => 'admin.courier.show', 'edit' => 'admin.courier.edit', 'update' => 'admin.courier.update', 'destroy' => 'admin.courier.destroy']]);
	Route::resource('buy', 'BuyController',					['names' => ['index' => 'admin.buy.index', 'create' => 'admin.buy.create', 'store' => 'admin.buy.store', 'show' => 'admin.buy.show', 'edit' => 'admin.buy.edit', 'update' => 'admin.buy.update', 'destroy' => 'admin.buy.destroy']]);

	//ajax
	Route::get('sell/ajax/findAmount',						['uses' => 'AjaxController@FindTransactionByAmount', 	'as' => 'ajax.sell.findAmount']);
	Route::get('sell/ajax/findRefNumber',					['uses' => 'AjaxController@FindTransactionByRefNumber', 	'as' => 'ajax.sell.findRefNumber']);
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
