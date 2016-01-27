<div class="container-fluid">
	<div class="row">

<!-- desktop section -->
		<div class="col-lg-12 col-md-12 hidden-sm hidden-xs">
			<div class="row">

	<!-- balin logo	-->
				<div class="col-md-2 col-sm-1">
					<a href="#">
						{!! HTML::image('images/balin-white.png', 'alt', array( 'class' => 'nav-logo', 'style' => 'margin-top: 15px; max-width: 150px; max-height: 30px;' )) !!}
					</a>
				</div>
	<!-- end of balin logo -->

	<!-- menu -->
				<div class="col-md-8 col-sm-9 text-center" style="padding:0px;">
					<ul class="nav navbar-top-links">
						<li><a href="{{ URL::route('admin.dashboard') }}" class="menu-desktop link-gray">Dashboard</a></li>

						<li class="dropdown">
							<a href="#" class="dropdown-toggle link-gray text-right menu-desktop" data-toggle="dropdown" aria-expanded="true">
								Barang
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu submenu-desktop">
								<li><a href="{{ URL::route('goods.product.index') }}">Produk</a></li>
								<li><a href="{{ URL::route('goods.price.index') }}">Harga</a></li>
								<li><a href="{{ URL::route('goods.stock.index') }}">Stok</a></li>
								<li><a href="{{ URL::route('goods.category.index') }}">Kategori</a></li>
								<li><a href="{{ URL::route('goods.tag.index') }}">Tag</a></li>
								<li><a href="{{ URL::route('goods.label.index') }}">Label</a></li>
							</ul>
						</li>

						<li class="dropdown">
							<a href="#" class="dropdown-toggle link-gray text-right menu-desktop" data-toggle="dropdown" aria-expanded="true">
								Toko
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu submenu-desktop">
								<li><a href="{{ URL::route('shop.sell.index') }}">Data Penjualan</a></li>
								<li><a href="{{ URL::route('shop.pay.create') }}">Validasi Bayar</a></li>
								<li><a href="{{ URL::route('shop.packing.create') }}">Packing</a></li>
								<li><a href="{{ URL::route('shop.shipping.create') }}">Kirim Barang</a></li>
								<li><a href="{{ URL::route('shop.completeorder.create') }}">Transaksi Selesai</a></li>
								<li><a href="{{ URL::route('shop.cancelorder.create') }}">Transaksi Dibatalkan</a></li>
								<li><a href="{{ URL::route('shop.courier.index') }}">Kurir</a></li>
								<li><a href="{{ URL::route('shop.buy.index') }}">Data Pembelian</a></li>
							</ul>
						</li>

						<li class="dropdown">
							<a href="#" class="dropdown-toggle link-gray text-right menu-desktop" data-toggle="dropdown" aria-expanded="true">
								Laporan
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu submenu-desktop">
								<li><a href="{{ URL::route('report.product.sold') }}">Penjualan Barang</a></li>
								<li><a href="{{ URL::route('report.voucher.usage') }}">Penggunaan Voucher</a></li>
							</ul>
						</li>

						<li class="dropdown">
							<a href="#" class="dropdown-toggle link-gray text-right menu-desktop" data-toggle="dropdown" aria-expanded="true">
								Konfigurasi
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu submenu-desktop">
								<li><a href="{{ URL::route('config.administrative.index') }}">Administrasi</a></li>
								<li><a href="{{ URL::route('config.website.index') }}">Website</a></li>
								<li><a href="{{ URL::route('config.policy.index') }}">Policy</a></li>
							</ul>
						</li>

						<li class="dropdown">
							<a href="#" class="dropdown-toggle link-gray text-right menu-desktop" data-toggle="dropdown" aria-expanded="true">
								Customer
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu submenu-desktop">
								<li><a href="{{ URL::route('customer.customer.index') }}">Data Customer</a></li>
								<li><a href="{{ URL::route('customer.point.index') }}">Poin</a></li>
								<li><a href="{{ URL::route('customer.referral.index') }}">Referral</a></li>
							</ul>							
						</li>

						<li class="dropdown">
							<a href="#" class="dropdown-toggle link-gray text-right menu-desktop" data-toggle="dropdown" aria-expanded="true">
								Promosi
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu submenu-desktop">
								<li><a href="{{ URL::route('promote.voucher.index') }}">Voucher</a></li>
								<li><a href="{{ URL::route('promote.discount.index') }}">Diskon</a></li>
							</ul>
						</li>
					</ul>
				</div>
	<!-- end of menu -->

	<!-- user menu -->
				<div class="col-lg-2 col-md-2">
					<ul class="nav navbar-top-links navbar-right">
						<li class="dropdown userme" style="margin-right:5px !important;">
							<a href="#" class="dropdown-toggle link-gray text-right" data-toggle="dropdown" aria-expanded="true">
								<i class="fa fa-user"></i>User
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu">
								<li><a href="#">Ganti Password</a></li>
								<li><a href="#">Log Out</a></li>
							</ul>
						</li>
					</ul>				
				</div>
	<!-- end of user menu -->

			</div>
		</div>
<!-- end of desktop section -->

<!-- tablet and mobile section -->
		<div class="hidden-lg hidden-md col-sm-12 col-xs-12">
			<div class="row" style="padding-top:10px; padding-bottom:10px;">

	<!-- button menu tablet -->
				<div class="col-sm-1 hidden-xs">
					<a href="#" class="btn btn-default btn-sm pull-left" data-toggle="modal" data-target="#modal-fullscreen">
						<i class="fa fa-bars"></i> &nbsp; Menu
					</a>
				</div>
	<!-- end of button menu tablet -->
				
	<!-- button menu mobile -->
				<div class="hidden-sm col-xs-2">
					<a href="#" class="btn btn-default btn-sm pull-left" data-toggle="modal" data-target="#modal-fullscreen">
						<i class="fa fa-bars"></i>
					</a>
				</div>
	<!-- end of button menu mobile -->

	<!-- center balin logo -->
				<div class="col-sm-10 col-xs-8 text-center">
					<a href="#">
						{!! HTML::image('images/balin-white.png', 'alt', array( 'class' => 'nav-logo', 'style' =>'max-width: 150px; max-height: 30px;' )) !!}
					</a>					
				</div>
	<!-- end of center balin logo -->

	<!-- button user tablet -->
				<div class="col-sm-1 hidden-xs">
					<a href="#" class="btn btn-default btn-sm pull-right" data-toggle="modal" data-target="#myModal">
						<i class="fa fa-user"></i> &nbsp; User
					</a>
				</div>
	<!-- end of button user tablet -->

	<!-- button user mobile -->
				<div class="hidden-sm col-xs-2">
					<a href="#" class="btn btn-default btn-sm pull-right" data-toggle="modal" data-target="#myModal">
						<i class="fa fa-user"></i>
					</a>
				</div>
	<!-- end of button user tablet -->

			</div>
		</div>
<!-- end of tablet and mobile section -->

	</div>
</div>

@section('modals')
<!-- mobile user menu -->
	<div id="myModal" class="modal modal-center fade" role="dialog">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-body p-b-none">
					<div class="row">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="row p-t-md p-b-md">
						<h2 class="modal-title text-center"><small>Hello</small> User name</h2>
					</div>
				</div>
				<div class="modal-footer">
					<div class="col-sm-12 col-xs-12 m-b-sm">
						<a href="{{ URL::route('admin.dashboard') }}" class="btn btn-default btn-block btn-sm pull-left">
							<h4>
								Ganti Password
							</h4>
						</a>
					</div>
					<div class="col-sm-12 col-xs-12 m-b-sm">
						<a href="{{ URL::route('admin.dashboard') }}" class="btn btn-default btn-block btn-sm pull-left">
							<h4>
								Log Out
							</h4>
						</a>
					</div>													
				</div>
			</div>
		</div>
	</div>
<!-- end of mobile user menu -->

<!-- mobile main menu -->
	<div class="modal modal-fullscreen fade" id="modal-fullscreen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog mobile-menu-canvas">
			<div class="modal-content">
				<div class="modal-header">

	<!-- mobile main menu title -->
					<div class="mobile-menu-page">
						<a href="#" class="btn btn-default btn-sm pull-right" data-dismiss="modal">
							<i class="fa fa-chevron-left"></i>&nbsp; Back
						</a>
						<h4 class="modal-title" id="myModalLabel" style="padding-top:6px;">
							Menu 
						</h4>
					</div>
	<!-- end of mobile main menu title -->

	<!-- mobile submenu title -->
					<div class="mobile-submenu-page hidden">
						<a href="javascript:void(0);" class="btn btn-default btn-sm pull-right" id="mobile-submenu-back">
							<i class="fa fa-chevron-left"></i>&nbsp; Back
						</a>
						<h4 class="modal-title" id="mobile-submenu-title" style="padding-top:6px;">
							Sub Menu
						</h4>						
					</div>
	<!-- end of mobile submenu title -->

				</div>
				<div class="modal-body">
					<div class="row">
	<!-- mobile main menu content -->
						<div class="mobile-menu-page">
		<!-- tablet section -->
							<div class="hidden-lg hidden-md col-sm-4 hidden-xs m-b-md">
								<a href="{{ URL::route('admin.dashboard') }}" class="btn btn-default btn-block btn-sm pull-left">
									<span class="fa-stack fa-4x">
									  	<i class="fa fa-dashboard fa-stack-1x"></i>
									</span>
									</br>
									<h3>Dashboard</h3>
								</a>
							</div>
							<div class="hidden-lg hidden-md col-sm-4 hidden-xs m-b-md">
								<a href="javascript:void(0);" data-id="Barang" class="btn btn-default btn-block btn-sm pull-left mobile-menu">
									<span class="fa-stack fa-4x">
									  	<i class="fa fa-cube fa-stack-1x"></i>
									</span>
									</br>
									<h3>Barang</h3>
								</a>
							</div>
							<div class="hidden-lg hidden-md col-sm-4 hidden-xs m-b-md">
								<a href="javascript:void(0);" data-id="Toko" class="btn btn-default btn-block btn-sm pull-left mobile-menu">
									<span class="fa-stack fa-4x">
									  	<i class="fa fa-shopping-basket fa-stack-1x"></i>
									</span>
									</br>
									<h3>Toko</h3>
								</a>
							</div>
							<div class="hidden-lg hidden-md col-sm-4 hidden-xs m-b-md">
								<a href="javascript:void(0);" data-id="Laporan" class="btn btn-default btn-block btn-sm pull-left mobile-menu">
									<span class="fa-stack fa-4x">
									  	<i class="fa fa-book fa-stack-1x"></i>
									</span>
									</br>
									<h3>Laporan</h3>
								</a>
							</div>
							<div class="hidden-lg hidden-md col-sm-4 hidden-xs m-b-md">
								<a href="javascript:void(0);" data-id="Pengaturan" class="btn btn-default btn-block btn-sm pull-left mobile-menu">
									<span class="fa-stack fa-4x">
									  	<i class="fa fa-glass fa-stack-1x fa-cogs"></i>
									</span>
									</br>
									<h3>Pengaturan</h3>
								</a>
							</div>
							<div class="hidden-lg hidden-md col-sm-4 hidden-xs m-b-md">
								<a href="javascript:void(0);" data-id="Customer" class="btn btn-default btn-block btn-sm pull-left mobile-menu">
									<span class="fa-stack fa-4x">
									  	<i class="fa fa-user fa-stack-1x"></i>
									</span>
									</br>
									<h3>Customer</h3>
								</a>
							</div>
							<div class="hidden-lg hidden-md col-sm-4 hidden-xs m-b-md">
								<a href="javascript:void(0);" data-id="Promosi" class="btn btn-default btn-block btn-sm pull-left mobile-menu">
									<span class="fa-stack fa-4x">
									  	<i class="fa fa-ticket fa-stack-1x"></i>
									</span>
									</br>
									<h3>Promosi</h3>
								</a>
							</div>																											
		<!-- end of tablet section -->

		<!-- mobile section -->
							<div class="hidden-sm col-xs-6 m-b-md">
								<a href="{{ URL::route('admin.dashboard') }}" class="btn btn-default btn-block btn-sm pull-left">
									<span class="fa-stack fa-3x">
									  	<i class="fa fa-dashboard fa-stack-1x"></i>
									</span>
									</br>
									<h5>Dashboard</h5>
								</a>
							</div>
							<div class="hidden-sm col-xs-6 m-b-md">
								<a href="javascript:void(0);" data-id="Barang" class="btn btn-default btn-block btn-sm pull-left mobile-menu">
									<span class="fa-stack fa-3x">
									  	<i class="fa fa-cube fa-stack-1x"></i>
									</span>
									</br>
									<h5>Barang</h5>
								</a>
							</div>
							<div class="hidden-sm col-xs-6 m-b-md">
								<a href="javascript:void(0);" data-id="Toko" class="btn btn-default btn-block btn-sm pull-left mobile-menu">
									<span class="fa-stack fa-3x">
									  	<i class="fa fa-shopping-basket fa-stack-1x"></i>
									</span>
									</br>
									<h5>Toko</h5>
								</a>
							</div>
							<div class="hidden-sm col-xs-6 m-b-md">
								<a href="javascript:void(0);" data-id="Laporan" class="btn btn-default btn-block btn-sm pull-left mobile-menu">
									<span class="fa-stack fa-3x">
									  	<i class="fa fa-book fa-stack-1x"></i>
									</span>
									</br>
									<h5>Laporan</h5>
								</a>
							</div>
							<div class="hidden-sm col-xs-6 m-b-md">
								<a href="javascript:void(0);" data-id="Pengaturan" class="btn btn-default btn-block btn-sm pull-left mobile-menu">
									<span class="fa-stack fa-3x">
									  	<i class="fa fa-cogs fa-stack-1x"></i>
									</span>
									</br>
									<h5>Pengaturan</h5>
								</a>
							</div>
							<div class="hidden-sm col-xs-6 m-b-md">
								<a href="javascript:void(0);" data-id="Customer" class="btn btn-default btn-block btn-sm pull-left mobile-menu">
									<span class="fa-stack fa-3x">
									  	<i class="fa fa-user fa-stack-1x"></i>
									</span>
									</br>
									<h5>Customer</h5>
								</a>
							</div>
							<div class="hidden-sm col-xs-6 m-b-md">
								<a href="javascript:void(0);" data-id="Promosi" class="btn btn-default btn-block btn-sm pull-left mobile-menu">
									<span class="fa-stack fa-3x">
									  	<i class="fa fa-ticket fa-stack-1x"></i>
									</span>
									</br>
									<h5>Promosi</h5>
								</a>
							</div>																		
		<!-- end of mobile section -->

						</div>
	<!-- end of mobile main menu content -->

	<!-- mobile submenu content -->
						<div class="mobile-submenu-page hidden">
		<!-- submenu product -->
							<div id="Barang" class="mobile-submenu hidden">
								<div class="col-sm-12 col-xs-12 m-b-sm">
									<a href="{{ URL::route('goods.product.index') }}" class="btn btn-default btn-block btn-sm pull-left">
										<h4>
											Produk
										</h4>
									</a>
								</div>
								<div class="col-sm-12 col-xs-12 m-b-sm">
									<a href="{{ URL::route('goods.price.index') }}" class="btn btn-default btn-block btn-sm pull-left">
										<h4>
											Harga
										</h4>
									</a>
								</div>
								<div class="col-sm-12 col-xs-12 m-b-sm">
									<a href="{{ URL::route('goods.stock.index') }}" class="btn btn-default btn-block btn-sm pull-left">
										<h4>
											Stok
										</h4>
									</a>
								</div>
								<div class="col-sm-12 col-xs-12 m-b-sm">
									<a href="{{ URL::route('goods.category.index') }}" class="btn btn-default btn-block btn-sm pull-left">
										<h4>
											Kategori
										</h4>
									</a>
								</div>
								<div class="col-sm-12 col-xs-12 m-b-sm">
									<a href="{{ URL::route('goods.tag.index') }}" class="btn btn-default btn-block btn-sm pull-left">
										<h4>
											Tag
										</h4>
									</a>
								</div>
								<div class="col-sm-12 col-xs-12 m-b-sm">
									<a href="{{ URL::route('goods.label.index') }}" class="btn btn-default btn-block btn-sm pull-left">
										<h4>
											Label
										</h4>
									</a>
								</div>
							</div>																											
		<!-- end of submenu product -->

		<!-- submenu toko -->
							<div id="Toko" class="mobile-submenu hidden">
								<div class="col-sm-12 col-xs-12 m-b-sm">
									<a href="{{ URL::route('shop.sell.index') }}" class="btn btn-default btn-block btn-sm pull-left">
										<h4>
											Data Penjualan
										</h4>
									</a>
								</div>
								<div class="col-sm-12 col-xs-12 m-b-sm">
									<a href="{{ URL::route('shop.pay.create') }}" class="btn btn-default btn-block btn-sm pull-left">
										<h4>
											Validasi Bayar
										</h4>
									</a>
								</div>
								<div class="col-sm-12 col-xs-12 m-b-sm">
									<a href="{{ URL::route('shop.packing.create') }}" class="btn btn-default btn-block btn-sm pull-left">
										<h4>
											Packing
										</h4>
									</a>
								</div>
								<div class="col-sm-12 col-xs-12 m-b-sm">
									<a href="{{ URL::route('shop.shipping.create') }}" class="btn btn-default btn-block btn-sm pull-left">
										<h4>
											Kirim Barang
										</h4>
									</a>
								</div>
								<div class="col-sm-12 col-xs-12 m-b-sm">
									<a href="{{ URL::route('shop.completeorder.create') }}" class="btn btn-default btn-block btn-sm pull-left">
										<h4>
											Transaksi Selesai
										</h4>
									</a>
								</div>
								<div class="col-sm-12 col-xs-12 m-b-sm">
									<a href="{{ URL::route('shop.cancelorder.create') }}" class="btn btn-default btn-block btn-sm pull-left">
										<h4>
											Transaksi Dibatalkan
										</h4>
									</a>
								</div>
								<div class="col-sm-12 col-xs-12 m-b-sm">
									<a href="{{ URL::route('shop.courier.index') }}" class="btn btn-default btn-block btn-sm pull-left">
										<h4>
											Kurir
										</h4>
									</a>
								</div>
								<div class="col-sm-12 col-xs-12 m-b-sm">
									<a href="{{ URL::route('shop.buy.index') }}" class="btn btn-default btn-block btn-sm pull-left">
										<h4>
											Data Pembelian
										</h4>
									</a>
								</div>																																				
							</div>
		<!-- end of submenu toko -->

		<!-- submenu laporan -->
							<div id="Laporan" class="mobile-submenu hidden">
								<div class="col-sm-12 col-xs-12 m-b-sm">
									<a href="{{ URL::route('report.product.sold') }}" class="btn btn-default btn-block btn-sm pull-left">
										<h4>
											Penjualan Barang
										</h4>
									</a>
								</div>
								<div class="col-sm-12 col-xs-12 m-b-sm">
									<a href="{{ URL::route('report.voucher.usage') }}" class="btn btn-default btn-block btn-sm pull-left">
										<h4>
											Penggunaan Voucher
										</h4>
									</a>
								</div>
							</div>
		<!-- end of submenu laporan -->

		<!-- submenu pengaturan -->
							<div id="Pengaturan" class="mobile-submenu hidden">
								<div class="col-sm-12 col-xs-12 m-b-sm">
									<a href="{{ URL::route('config.administrative.index') }}" class="btn btn-default btn-block btn-sm pull-left">
										<h4>
											Administrasi
										</h4>
									</a>
								</div>
								<div class="col-sm-12 col-xs-12 m-b-sm">
									<a href="{{ URL::route('config.website.index') }}" class="btn btn-default btn-block btn-sm pull-left">
										<h4>
											Website
										</h4>
									</a>
								</div>
								<div class="col-sm-12 col-xs-12 m-b-sm">
									<a href="{{ URL::route('config.policy.index') }}" class="btn btn-default btn-block btn-sm pull-left">
										<h4>
											Policy
										</h4>
									</a>
								</div>
							</div>
		<!-- end of submenu pengaturan -->

		<!-- submenu customer -->
							<div id="Customer" class="mobile-submenu hidden">
								<div class="col-sm-12 col-xs-12 m-b-sm">
									<a href="{{ URL::route('customer.customer.index') }}" class="btn btn-default btn-block btn-sm pull-left">
										<h4>
											Data Customer
										</h4>
									</a>
								</div>								
								<div class="col-sm-12 col-xs-12 m-b-sm">
									<a href="{{ URL::route('customer.point.index') }}" class="btn btn-default btn-block btn-sm pull-left">
										<h4>
											Poin
										</h4>
									</a>
								</div>
								<div class="col-sm-12 col-xs-12 m-b-sm">
									<a href="{{ URL::route('customer.referral.index') }}" class="btn btn-default btn-block btn-sm pull-left">
										<h4>
											Referral
										</h4>
									</a>
								</div>
							</div>
		<!-- end of submenu customer -->		

		<!-- submenu promosi -->
							<div id="Promosi" class="mobile-submenu hidden">
								<div class="col-sm-12 col-xs-12 m-b-sm">
									<a href="{{ URL::route('promote.voucher.index') }}" class="btn btn-default btn-block btn-sm pull-left">
										<h4>
											Voucher
										</h4>
									</a>
								</div>
								<div class="col-sm-12 col-xs-12 m-b-sm">
									<a href="{{ URL::route('promote.discount.index') }}" class="btn btn-default btn-block btn-sm pull-left">
										<h4>
											Diskon
										</h4>
									</a>
								</div>
							</div>
		<!-- end of submenu promosi -->	

						</div>
	<!-- end of modal submenu content -->

					</div>
				</div>
			</div>
		</div>
	</div>	
<!-- end of mobile main menu -->
@stop

@section('scripts')
	$('.mobile-menu').click( function() {
		$('.mobile-submenu').addClass('hidden');
		$('#' + $(this).attr("data-id")).removeClass('hidden');
		$('#mobile-submenu-title').text($(this).attr("data-id"));
		$('.mobile-menu-page').addClass('hidden');
		$('.mobile-submenu-page').removeClass('hidden');
	});

	$('#mobile-submenu-back').click( function() {
		$('.mobile-submenu-page').addClass('hidden');
		$('.mobile-menu-page').removeClass('hidden');
	});
@append