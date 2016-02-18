<?php

/**
* Routes untuk menu barang
*
*/
Route::group(['prefix' => 'barang', 'namespace' => 'Barang\\', 'middleware' => 'auth.api'], function()
{
	/**
	* Routes untuk sub menu produk dan varian
	*
	*/
	Route::resource('produk',  				'ProductController',	['names' => ['index' => 'goods.product.index', 'create' => 'goods.product.create', 'store' => 'goods.product.store', 'show' => 'goods.product.show', 'edit' => 'goods.product.edit', 'update' => 'goods.product.update', 'destroy' => 'goods.product.destroy']]);
	Route::resource('produk/{pid}/varian',	'VarianController',		['names' => ['index' => 'goods.varian.index', 'create' => 'goods.varian.create', 'store' => 'goods.varian.store', 'show' => 'goods.varian.show', 'edit' => 'goods.varian.edit', 'update' => 'goods.varian.update', 'destroy' => 'goods.varian.destroy']]);
	Route::resource('produk/{pid}/harga',  	'PriceController',		['names' => ['index' => 'goods.price.index', 'create' => 'goods.price.create', 'store' => 'goods.price.store', 'show' => 'goods.price.show', 'edit' => 'goods.price.edit', 'update' => 'goods.price.update', 'destroy' => 'goods.price.destroy']]);
	
	/**
	* Routes untuk sub menu atribut dari produk
	*
	*/
	Route::resource('kategori', 'CategoryController',		['names' => ['index' => 'goods.category.index', 'create' => 'goods.category.create', 'store' => 'goods.category.store', 'show' => 'goods.category.show', 'edit' => 'goods.category.edit', 'update' => 'goods.category.update', 'destroy' => 'goods.category.destroy']]);
	Route::resource('tag', 		'TagController',			['names' => ['index' => 'goods.tag.index', 'create' => 'goods.tag.create', 'store' => 'goods.tag.store', 'show' => 'goods.tag.show', 'edit' => 'goods.tag.edit', 'update' => 'goods.tag.update', 'destroy' => 'goods.tag.destroy']]);
	Route::resource('label', 	'LabelController',			['names' => ['index' => 'goods.label.index', 'show' => 'goods.label.show'], 'only' => ['index', 'show']]);

	Route::resource('pembelian', 	'BuyController',		['names' => ['index' => 'shop.buy.index', 'create' => 'shop.buy.create', 'store' => 'shop.buy.store', 'show' => 'shop.buy.show', 'edit' => 'shop.buy.edit', 'update' => 'shop.buy.update', 'destroy' => 'shop.buy.destroy']]);

	/**
	* Routes untuk select2 ajax
	*
	*/
	Route::get('tag/ajax/findName',							['uses' => 'AjaxController@FindTagByName', 	'as' => 'ajax.tag.findName']);
	Route::get('category/ajax/findName',					['uses' => 'AjaxController@FindCategoryByName', 	'as' => 'ajax.category.findName']);
	Route::get('label/ajax/findName',						['uses' => 'AjaxController@FindLabelByName', 	'as' => 'ajax.label.findName']);
	Route::get('product/ajax/findName',						['uses' => 'AjaxController@FindProductByName', 	'as' => 'ajax.product.findName']);
	Route::get('productVarian/ajax/findName',				['uses' => 'AjaxController@FindProductVarianByName', 	'as' => 'ajax.product.varian.findName']);
});

/**
* Routes untuk menu laporan
*
*/
Route::group(['prefix' => 'laporan', 'namespace' => 'Laporan\\'], function()
{
	/**
	* Routes untuk sub menu laporan
	*
	*/
	Route::get('pembelian/barang',								['uses' => 'ReportController@buyproduct', 'as' => 'report.product.stok']);

	Route::get('rekap/penjualan',								['uses' => 'RecapController@sale', 'as' => 'report.recap.sale']);
	Route::resource('penjualan',  	'SaleController',			['names' => ['index' => 'report.product.sale', 'show' => 'report.product.sale.detail'], 'only' => ['show', 'index']]);

	Route::resource('stok/barang',  	'StockController',		['names' => ['index' => 'report.stock.product', 'show' => 'report.stock.product.detail'], 'only' => ['show', 'index']]);

});

/**
* Routes untuk menu konfigurasi
*
*/
Route::group(['prefix' => 'konfigurasi', 'namespace' => 'Konfigurasi\\'], function()
{
	/**
	* Routes untuk sub menu admin
	*
	*/
	Route::resource('admin', 	'AdministrativeController',		['names' => ['index' => 'config.administrative.index', 'create' => 'config.administrative.create', 'store' => 'config.administrative.store', 'show' => 'config.administrative.show', 'edit' => 'config.administrative.edit', 'update' => 'config.administrative.update'], 'except' => ['destroy']]);
	
	Route::resource('website', 	'WebsiteController',			['names' => ['index' => 'config.website.index', 'store' => 'config.website.store', 'update' => 'config.website.update'], 'only' => ['index', 'store', 'update']]);
	Route::resource('policy', 	'PolicyController',				['names' => ['index' => 'config.policy.index', 'create' => 'config.policy.create', 'store' => 'config.policy.store', 'edit' => 'config.policy.edit', 'update' => 'config.policy.update'], 'except' => ['show', 'destroy']]);
	Route::delete('website/slider/delete/{id}',					['uses' => 'WebsiteController@deleteSlider', 'as' => 'config.website.slider.delete']);


	Route::resource('kurir', 		'CourierController',		['names' => ['index' => 'shop.courier.index', 'create' => 'shop.courier.create', 'store' => 'shop.courier.store', 'show' => 'shop.courier.show', 'edit' => 'shop.courier.edit', 'update' => 'shop.courier.update', 'destroy' => 'shop.courier.destroy']]);
	Route::get('kurir/cost/{id}',								['uses' => 'CourierController@addShippingCost', 	'as' => 'shop.courier.shippingcost.create']);
	Route::post('kurir/cost/{id}',								['uses' => 'CourierController@importShippingCost', 	'as' => 'shop.courier.shippingcost.import']);
});

/**
* Routes untuk menu customer
*
*/
Route::group(['prefix' => 'customer', 'namespace' => 'Customer\\'], function()
{
	/**
	* Routes untuk sub menu customer
	*
	*/
	Route::resource('kostumer',  	'CustomerController',		['names' => ['index' => 'customer.customer.index', 'show' => 'customer.customer.show'], 'only' => ['show', 'index']]);
	Route::resource('point', 		'PointController',			['names' => ['index' => 'customer.point.index', 'create' => 'customer.point.create', 'store' => 'customer.point.store', 'edit' => 'customer.point.edit', 'update' => 'customer.point.update'], 'except' => ['show', 'destroy']]);


	Route::resource('relasi', 		'CsrController',			['names' => ['index' => 'customer.csr.index', 'create' => 'customer.csr.create', 'store' => 'customer.csr.store', 'show' => 'customer.csr.show'], 'except' => ['edit', 'update', 'destroy']]);

	/**
	* Routes untuk select2 ajax
	*
	*/
	Route::get('customer/ajax/findName',						['uses' => 'AjaxController@FindCustomerByName', 'as' => 'ajax.customer.findName']);
});

/**
* Routes untuk menu promosi
*
*/
Route::group(['prefix' => 'promosi', 'namespace' => 'Promosi\\'], function()
{
	/**
	* Routes untuk sub menu promosi
	*
	*/
	Route::resource('voucher', 		'VoucherController',		['names' => ['index' => 'promote.voucher.index', 'create' => 'promote.voucher.create', 'store' => 'promote.voucher.store', 'edit' => 'promote.voucher.edit', 'update' => 'promote.voucher.update', 'destroy' => 'promote.voucher.destroy'], 'except' => ['show']]);
	Route::resource('diskon',  		'DiscountController',		['names' => ['index' => 'promote.discount.index', 'create' => 'promote.discount.create', 'store' => 'promote.discount.store'], 'only' => ['index', 'create', 'store']]);
});


/**
* Routes untuk menu transaksi
*
*/
Route::group(['prefix' => 'toko', 'namespace' => 'Toko\\'], function()
{
	/**
	* Routes untuk sub menu sale dan proses
	*
	*/
	Route::resource('pembayaran',  	'PayController',			['names' => ['create' => 'shop.pay.create', 'store' => 'shop.pay.store'], 'only' => ['create', 'store']]);
	Route::resource('packing',  	'PackingController',		['names' => ['create' => 'shop.packing.create', 'store' => 'shop.packing.store'], 'only' => ['create', 'store']]);
	Route::resource('pengirman',  	'ShippingController',		['names' => ['create' => 'shop.shipping.create', 'store' => 'shop.shipping.store'], 'only' => ['create', 'store']]);
	Route::resource('penerimaan',	'CompleteOrderController',	['names' => ['create' => 'shop.completeorder.create', 'store' => 'shop.completeorder.store'], 'only' => ['create', 'store']]);
	Route::resource('pembatalan',	'CancelOrderController',	['names' => ['create' => 'shop.cancelorder.create', 'store' => 'shop.cancelorder.store'], 'only' => ['create', 'store']]);
	
	/**
	* Routes untuk resend mail
	*
	*/
	Route::get('resend/order/{id}/{status}',					['uses' => 'ResendMailController@sale', 		'as' => 'shop.resend.email']);

	/**
	* Routes untuk select2 ajax
	*
	*/
	Route::get('sell/ajax/findAmount',							['uses' => 'AjaxController@FindTransactionByAmount', 		'as' => 'ajax.sell.findAmount']);
	Route::get('sell/ajax/findRefNumber',						['uses' => 'AjaxController@FindTransactionByRefNumber', 	'as' => 'ajax.sell.findRefNumber']);
});




///trash

	Route::resource('penjualan',  	'SellController',			['names' => ['index' => 'shop.sell.index', 'show' => 'shop.sell.show'], 'only' => ['show', 'index']]);


	/**
	* Routes untuk sub menu harga produk
	*
	*/

	
	/**
	* Routes untuk stok produk
	*
	*/





	Route::resource('referral',  	'ReferralController',		['names' => ['index' => 'customer.referral.index'], 'only' => ['index']]);
