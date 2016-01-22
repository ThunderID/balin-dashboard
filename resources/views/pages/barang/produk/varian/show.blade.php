@extends('page_templates.layout')

@section('content')
<div class="container-fluid">
<!-- head -->
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b-md border-bottom">
			@include('pageElements.pagetitle')
			@include('pageElements.breadcrumb')
		</div>
	</div>

	<!-- title sub-page -->
	<div class="row">
		<div class="col-md-12 m-b-md">
			<h2 style="margin-top:0px;">Detail Ukuran</h2>

			@include('pageElements.alertbox')
		</div>
	</div>
	<!-- end of title sub-page -->	

<!-- end of head -->

<!-- content -->
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b-md">
			<div class="row">
				<div class="col-md-12">
					<a class="btn btn-default pull-right"  href="{{ route('admin.varian.edit', ['pid' => $data['data']['product_id'], 'id' => $data['data']['id']]) }}"> Edit Data </a>
				</div>
			</div>	

			<div class="row">
				<div class="col-md-5 col-sm-6 col-xs-11">
					<div class="row">
						<div class="col-md-6 col-sm-7 col-xs-5">
							<h4>Ukuran</h4> 
						</div>
						<div class="col-md-1 col-sm-1 col-xs-2">
							<h4>:</h4> 
						</div>
						<div class="col-md-5 col-sm-3 col-xs-5">
							<h4>{{ $data['data']['size'] }}</h4> 
						</div>
					</div>
				</div>
			</div>	

			<div class="row">
				<div class="col-md-5 col-sm-6 col-xs-11">
					<div class="row">
						<div class="col-md-6 col-sm-7 col-xs-5">
							<h4>SKU</h4> 
						</div>
						<div class="col-md-1 col-sm-1 col-xs-2">
							<h4>:</h4> 
						</div>
						<div class="col-md-5 col-sm-3 col-xs-5">
							<h4>{{ $data['data']['sku'] }}</h4> 
						</div>
					</div>
				</div>
			</div>					
			<div class="row clearfix m-b-md">&nbsp;</div>
			<div class="row">
				<div class="col-md-12 m-b-xs">
					<h4>Data Stok</h4> 
				</div>

				<div class="col-md-4 col-sm-6">
					<div class="panel panel-list panel-default">
						<div class="panel-heading">
							Stok Display
				            <button type="button" data-title="Stok Display" data-description="Jumlah stok yang tersedia untuk dijual" data-toggle="modal" data-target="#myModal" class="close togle-info" aria-hidden="true" style="margin-top:-2px;margin-right:-6px;"><i class="fa fa-info-circle"></i></button>
						</div>
						<div class="panel-body">
							<h2 class="m-r-sm m-t-sm text-right">
								@if($data['data']['current_stock'])
									{!! $data['data']['current_stock'] !!}
								@else
									0
								@endif
							</h2>
						</div>
					</div>
				</div>

				<div class="col-md-4 col-sm-6">
					<div class="panel panel-list panel-default">
						<div class="panel-heading">
							Stok Gudang
				            <button type="button" data-title="Stok Gudang" data-description="Total stok yang ada didalam gudang" data-toggle="modal" data-target="#myModal" class="close togle-info" aria-hidden="true" style="margin-top:-2px;margin-right:-6px;"><i class="fa fa-info-circle"></i></button>
						</div>
						<div class="panel-body">
							<h2 class="m-r-sm m-t-sm text-right">
								@if($data['data']['inventory_stock'])
									{!! $data['data']['inventory_stock'] !!}
								@else
									0
								@endif
							</h2>
						</div>
					</div>
				</div>	

				<div class="col-md-4 col-sm-6">
					<div class="panel panel-list panel-default">
						<div class="panel-heading">
							Terjual
				            <button type="button" data-title="Terjual" data-description="Total stok terjual" data-toggle="modal" data-target="#myModal" class="close togle-info" aria-hidden="true" style="margin-top:-2px;margin-right:-6px;"><i class="fa fa-info-circle"></i></button>
						</div>
						<div class="panel-body">
							<h2 class="m-r-sm m-t-sm text-right">
								@if($data['data']['sold_item'])
									{!! $data['data']['sold_item'] !!}
								@else
									0
								@endif
							</h2>
						</div>
					</div>
				</div>			

				<div class="col-md-4 col-sm-6">
					<div class="panel panel-list panel-default">
						<div class="panel-heading">
							In Cart
				            <button type="button" data-title="In Cart" data-description="Total stok yang ada dalam cart customer" data-toggle="modal" data-target="#myModal" class="close togle-info" aria-hidden="true" style="margin-top:-2px;margin-right:-6px;"><i class="fa fa-info-circle"></i></button>
						</div>
						<div class="panel-body">
							<h2 class="m-r-sm m-t-sm text-right">
								@if($data['data']['cart_item'])
									{!! $data['data']['cart_item'] !!}
								@else
									0
								@endif
							</h2>
						</div>
					</div>
				</div>				

				<div class="col-md-4 col-sm-6">
					<div class="panel panel-list panel-default">
						<div class="panel-heading">
							Stok Dipesan
				            <button type="button" data-title="Stok Dipesan" data-description="Total stok yang telah dicheckout dan menunggu pembayaran" data-toggle="modal" data-target="#myModal" class="close togle-info" aria-hidden="true" style="margin-top:-2px;margin-right:-6px;"><i class="fa fa-info-circle"></i></button>
						</div>
						<div class="panel-body">
							<h2 class="m-r-sm m-t-sm text-right">
								@if($data['data']['on_hold_stock'])
									{!! $data['data']['on_hold_stock'] !!}
								@else
									0
								@endif
							</h2>
						</div>
					</div>
				</div>

				<div class="col-md-4 col-sm-6">
					<div class="panel panel-list panel-default">
						<div class="panel-heading">
							Stok Dibayar
				            <button type="button" data-title ="Stok Dibayar" data-description="Total stok yang telah dibayar dan sedang menunggu untuk dipacking" data-toggle="modal" data-target="#myModal" class="close togle-info" aria-hidden="true" style="margin-top:-2px;margin-right:-6px;"><i class="fa fa-info-circle"></i></button>
						</div>
						<div class="panel-body">
							<h2 class="m-r-sm m-t-sm text-right">
								@if($data['data']['reserved_stock'])
									{!! $data['data']['reserved_stock'] !!}
								@else
									0
								@endif
							</h2>
						</div>
					</div>
				</div>

				<div class="col-md-4 col-sm-6">
					<div class="panel panel-list panel-default">
						<div class="panel-heading">
							Packing
				            <button type="button" data-title="Packing" data-description="Total stok yang sedang dipacking dan akan dikirim" data-toggle="modal" data-target="#myModal" class="close togle-info"  aria-hidden="true" style="margin-top:-2px;margin-right:-6px;"><i class="fa fa-info-circle"></i></button>
						</div>
						<div class="panel-body">
							<h2 class="m-r-sm m-t-sm text-right">
								@if($data['data']['packed_stock'])
									{!! $data['data']['packed_stock'] !!}
								@else
									0
								@endif
							</h2>
						</div>
					</div>
				</div>	

			</div>		
		</div>		
	</div>
<!-- end of content -->

</div>
@stop

@section('modals')
<!-- mobile user menu -->
	<div id="myModal" class="modal modal-center" role="dialog">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-body p-b-none">
					<div class="row">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="row p-t-md p-b-md">
						<h2 class="modal-title text-center" id="info_title"></h2>
						<p class="text-center" id="info_description"></p>
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- end of mobile user menu -->
@stop

@section('scripts')
	$('.togle-info').on('click', function () {
		$('#info_title').text($(this).attr("data-title"));
		$('#info_description').text($(this).attr("data-description"));
	})
@stop