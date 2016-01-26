<?php

Route::group(['prefix' => 'cms'], function()
{
	Route::group(['namespace' => 'Admin\\'], function()
	{
		Route::get('login',										['uses' => 'AuthController@login', 	'as' => 'backend.login']);
		Route::post('login',									['uses' => 'AuthController@doLogin', 	'as' => 'backend.dologin']);
	
		Route::any('dashboard',									['uses' => 'HomeController@index', 'as' => 'admin.dashboard']);
	});
	

	Route::group(['prefix' => 'barang', 'namespace' => 'Barang\\'], function()
	{
		Route::resource('produk',  	'ProductController',		['names' => ['index' => 'admin.product.index', 'create' => 'admin.product.create', 'store' => 'admin.product.store', 'show' => 'admin.product.show', 'edit' => 'admin.product.edit', 'update' => 'admin.product.update', 'destroy' => 'admin.product.destroy']]);
		Route::resource('produk/{pid}/varian','VarianController',['names' => ['index' => 'admin.varian.index', 'create' => 'admin.varian.create', 'store' => 'admin.varian.store', 'show' => 'admin.varian.show', 'edit' => 'admin.varian.edit', 'update' => 'admin.varian.update', 'destroy' => 'admin.varian.destroy']]);
		Route::resource('harga',  	'PriceController',			['names' => ['index' => 'admin.price.index', 'create' => 'admin.price.create', 'store' => 'admin.price.store', 'show' => 'admin.price.show']]);
		Route::resource('harga/{productId}/detail', 'PriceController', ['names' => ['create' => 'admin.price.detail.create', 'store' => 'admin.price.detail.store', 'edit' => 'admin.price.detail.edit', 'update' => 'admin.price.detail.update', 'destroy' => 'admin.price.detail.destroy']]);
		Route::resource('stok',  	'StockController',			['names' => ['index' => 'admin.stock.index', 'create' => 'admin.stock.create', 'store' => 'admin.stock.store', 'show' => 'admin.stock.show', 'edit' => 'admin.stock.edit', 'update' => 'admin.stock.update', 'destroy' => 'admin.stock.destroy']]);
		Route::resource('kategori', 'CategoryController',		['names' => ['index' => 'admin.category.index', 'create' => 'admin.category.create', 'store' => 'admin.category.store', 'show' => 'admin.category.show', 'edit' => 'admin.category.edit', 'update' => 'admin.category.update', 'destroy' => 'admin.category.destroy']]);
		Route::resource('tag', 		'TagController',			['names' => ['index' => 'admin.tag.index', 'create' => 'admin.tag.create', 'store' => 'admin.tag.store', 'show' => 'admin.tag.show', 'edit' => 'admin.tag.edit', 'update' => 'admin.tag.update', 'destroy' => 'admin.tag.destroy']]);
		Route::resource('label', 	'LabelController',			['names' => ['index' => 'admin.label.index', 'create' => 'admin.label.create', 'store' => 'admin.label.store', 'show' => 'admin.label.show', 'edit' => 'admin.label.edit', 'update' => 'admin.label.update', 'destroy' => 'admin.label.destroy']]);
	
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
});
