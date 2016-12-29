@extends('page_templates.layout') 

@section('content')
<?php

	$stores		= 	[
						'balin.dashboard' 	=> 'Balin', 
						'lazada.web' 		=> 'Lazada', 
						'shopee.web'		=> 'Shopee', 
						'tokopedia.web'		=> 'Tokopedia', 
						'matahari_mall.web'	=> 'Matahari Mall',
						'blibli.web'		=> 'BliBli',
						'bukalapak.web'		=> 'Bukalapak', 
						'elevania.web'		=> 'Elevania', 
						'blanja.web'		=> 'Blanja.com'
					];
?>
<div class="container-fluid">
<!-- head -->
    @include('page_elements.createHeader', ['title' => 'Data Penjualan Offline ' . $data['data']['ref_number'] ])    
<!-- end of head -->

<!-- micro template section	-->
	<div class="hidden">
		<div id="tmplt" class="m-b-sm">
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label for="varian_id" class="text-capitalize">Nama Produk <a href="{{ route('goods.product.create') }}" target="blank">[ Produk Baru ]</a></label>
						{!! Form::text('varian_id[]', null, [
									'class'         => 'form-control list-generate', 
									'tabindex'      => '4',
									'placeholder'   => 'Masukkan varian',
						]) !!}
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<label for="quantity" class="text-capitalize">Kuantitas</label>
						{!! Form::text('quantity[]', null, [
									'class'         => 'form-control input-quantity', 
									'tabindex'      => '4',
									'placeholder'   => 'Qty',
						]) !!}
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<label for="price" class="text-capitalize">Harga</label>
						{!! Form::text('price[]', null, [
									'class'         => 'form-control input-price money', 
									'tabindex'      => '4',
									'placeholder'   => 'harga produk',
						]) !!}
					</div>
				</div>											
				<div class="col-md-2">
					<div class="form-group">
						<label for="promo_price" class="text-capitalize">Diskon</label>
						{!! Form::text('promo_price[]', null, [
									'class'         => 'form-control input-promo_price money', 
									'tabindex'      => '4',
									'placeholder'   => 'harga promo',
						]) !!}
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<label for="subtotal" class="text-capitalize">Subtotal</label>
						{!! Form::text('subtotal[]', null, [
									'class'         => 'form-control input-subtotal money', 
									'tabindex'      => '4',
									'disabled'		=> 'disabled'
						]) !!}							
					</div>
				</div>
				<div class="col-md-1">
					<div class="form-group">
						<a href="javascript:;" class="btn btn-sm btn-default m-t-mds btn-add-details pull-left", tabindex='3'>
							<i class="fa fa-plus"></i>
						</a>
					</div>
				</div>					
				<div class="clearfix">&nbsp;</div>
			</div>
		</div>
	</div>
<!-- end of micro template section -->


<!-- body -->
	@if(isset(  $data['data']['id'] ))
    {!! Form::open(['url' => route('shop.sell.update', $data['data']['id']), 'method' => 'PATCH']) !!}
    @else
    {!! Form::open(['url' => route('shop.sell.store'), 'method' => 'POST']) !!}
    @endif

		<div class="row">
			<div class="col-md-3">
				<div class="form-group">
					<label for="transact_at">Tanggal Penjualan</label>
					{!! Form::text('transact_at', $data['data']['transact_at'], [
								'class'         => 'form-control date-time-format', 
								'tabindex'      => '1', 
								'placeholder'   => 'Masukkan tanggal Penjualan'
					]) !!}
				</div>  
			</div> 
		</div>

		<div class="row">
			<div class="col-md-12">
				<h4 class="sub-header">
					Pembeli
				</h4>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="user[name]">Nama</label>
					{!! Form::text('user[name]', $data['data']['user']['name'], [
								'class'         => 'form-control', 
								'tabindex'      => '2', 
								'placeholder'   => 'Masukkan nama customer'
					]) !!}
				</div>  
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="issuer">Melalui</label>
					{!! Form::select('issuer', $stores,  $data['data']['issuer'], [
								'class'         => 'form-control', 
								'tabindex'      => '3', 
					]) !!}
				</div>  
			</div> 
		</div>

		<div class="clearfix">&nbsp;</div>
		<div class="row">
			<div class="col-md-12 m-b-md">
				<h4 class="sub-header">
					Item
				</h4>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div id="template-details">
				</div>	
			</div>	
		</div>
	<!-- end of details section -->

		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="voucher_discount">Diskon Lain Lain</label>
					{!! Form::text('voucher_discount', $data['data']['voucher_discount'], [
								'class'         => 'form-control money', 
								'tabindex'      => '4', 
								'placeholder'   => 'Masukkan diskon lain lain'
					]) !!}
				</div>  
			</div> 
		</div>

	<div class="clearfix">&nbsp;</div>

		<div class="row">
			<div class="col-md-12">
				<h4 class="sub-header">
					Pengiriman
				</h4>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="shipment[receiver_name]">Nama Penerima</label>
					{!! Form::text('shipment[receiver_name]', $data['data']['shipment']['receiver_name'], [
								'class'         => 'form-control', 
								'tabindex'      => '5', 
								'placeholder'   => 'Masukkan nama penerima'
					]) !!}
				</div>  
			</div>  

			<div class="col-md-6">
				<div class="form-group">
					<label for="shipment[address][address]">Alamat</label>
					{!! Form::textarea('shipment[address][address]', $data['data']['shipment']['address']['address'], [
								'class'         => 'form-control', 
								'tabindex'      => '6', 
					]) !!}
				</div>  
			</div>
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="shipment[address][phone]">Nomor Telepon</label>
							{!! Form::text('shipment[address][phone]', $data['data']['shipment']['address']['phone'], [
										'class'         => 'form-control', 
										'tabindex'      => '7', 
										'placeholder'   => 'Masukkan nomor telepon'
							]) !!}
						</div>  
					</div>  
					<div class="col-md-12">
						<div class="form-group">
							<label for="shipment[address][zipcode]">Kode Pos</label>
							{!! Form::text('shipment[address][zipcode]', $data['data']['shipment']['address']['zipcode'], [
										'class'         => 'form-control', 
										'tabindex'      => '8', 
										'placeholder'   => 'Masukkan kode pos'
							]) !!}
						</div>  
					</div>  
				</div>  
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="shipping_cost">Biaya Kirim</label>
					{!! Form::text('shipping_cost', $data['data']['shipping_cost'], [
								'class'         => 'form-control money', 
								'tabindex'      => '9', 
								'placeholder'   => 'Masukkan biaya pengiriman'
					]) !!}
				</div>  
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label for="shipment[receipt_number]">Nomor Resi Pengiriman</label>
					{!! Form::text('shipment[receipt_number]', $data['data']['shipment']['receipt_number'], [
								'class'         => 'form-control', 
								'tabindex'      => '10', 
								'placeholder'   => 'Masukkan nomor resi pengiriman'
					]) !!}
				</div>  
			</div>
		</div>

		<div class="clearfix">&nbsp;</div>

		<div class="row">
			<div class="col-md-12">
				<h4 class="sub-header">
					Pembayaran
				</h4>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="payment[method]">Bayar Dengan</label>
					{!! Form::text('payment[method]', $data['data']['payment']['method'], [
								'class'         => 'form-control', 
								'tabindex'      => '11', 
								'placeholder'   => 'Masukkan metode pembayaran'
					]) !!}
				</div>  
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="payment[destination]">Rekening Tujuan</label>
					{!! Form::text('payment[destination]', $data['data']['payment']['destination'], [
								'class'         => 'form-control', 
								'tabindex'      => '12', 
								'placeholder'   => 'Masukkan rekening tujuan'
					]) !!}
				</div>  
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="payment[account_name]">Nama Akun</label>
					{!! Form::text('payment[account_name]', $data['data']['payment']['account_name'], [
								'class'         => 'form-control', 
								'tabindex'      => '13', 
								'placeholder'   => 'Masukkan nama akun pembayar'
					]) !!}
				</div>  
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="payment[account_number]">Nomor Akun</label>
					{!! Form::text('payment[account_number]', $data['data']['payment']['account_number'], [
								'class'         => 'form-control', 
								'tabindex'      => '14', 
								'placeholder'   => 'Masukkan nomor akun bayar'
					]) !!}
				</div>  
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="payment[ondate]">Tanggal Pembayaran</label>
					{!! Form::text('payment[ondate]', $data['data']['payment']['ondate'], [
								'class'         => 'form-control date-time-format', 
								'tabindex'      => '15', 
								'placeholder'   => 'Masukkan tanggal Pembayaran'
					]) !!}
				</div>  
			</div> 
			<div class="col-md-6">
				<div class="form-group">
					<label for="payment[amount]">Total Bayar</label>
					{!! Form::text('payment[amount]', $data['data']['payment']['amount'], [
								'class'         => 'form-control money', 
								'tabindex'      => '16', 
								'placeholder'   => 'Masukkan total bayar'
					]) !!}
				</div>  
			</div>
		</div>

		<div class="clearfix">&nbsp;</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group text-right">
					@if(Input::get('ref'))
					<a href="{{ URL::route('shop.sell.index', ['tab' => 'barang']) }}" class="btn btn-md btn-default" tabindex="17">Batal</a>
					@else
					<a href="{{ URL::route('shop.sell.index') }}" class="btn btn-md btn-default" tabindex="18">Batal</a>
					@endif
					<button type="submit" class="btn btn-md btn-primary" tabindex="17">Simpan</button>
				</div>        
			</div>        
		</div> 
    {!! Form::close() !!}
<!-- end of body -->

</div>
@stop

@section('scripts')
	$( document ).ready(function() {
		<!-- init microtemplate -->
		<!-- preload details -->
		@if(count($data['data']['transactiondetails'])  > 0)
			@foreach($data['data']['transactiondetails'] as $key => $valueDetail)
				$('#tmplt').find('.input-quantity').val({{$valueDetail['quantity']}});
				$('#tmplt').find('.input-price').val({{$valueDetail['price']}});
				$('#tmplt').find('.input-promo_price').val({{$valueDetail['discount']}});
				$('#tmplt').find('.input-subtotal').val( {{$valueDetail['quantity'] * ($valueDetail['price'] - $valueDetail['discount']) }} );
				
		        var id   = '{!! $valueDetail['varian_id'] !!}';
		        var text = '{!! $valueDetail['varian']['product']['name'] . " - " . $valueDetail['varian']['size'] !!}';

				template_add_details($('.base'),id,text);
			@endforeach
		@else
			template_add_details($('.base'));
		@endif	
		<!-- end of preload detailss -->
		<!-- endof init microtemplate -->	
	});

	<!-- details default validator -->
	function detailsDefaultValidation(e) {
		$('#template-details').find('.default').val(0);
		$(e).val(1);		
	}
	<!-- end of details default validator -->

	function calculatePrice(e) {
		var total = 0;

		var qty = parseInt(e.parent().parent().parent().find('.input-quantity').val());
		if(isNaN(qty)){
			qty = 0;
		}

		var price = e.parent().parent().parent().find('.input-price').val();
		price = price.replace('IDR ', '');
		price = price.replace('.', '');
		if(isNaN(price)){
			price = 0;
		}

		var promo = e.parent().parent().parent().find('.input-promo_price').val();
		promo = promo.replace('IDR ', '');
		promo = promo.replace('.', '');		
		if(isNaN(promo)){
			promo = 0;
		}

		total = qty * (price - promo);

		e.parent().parent().parent().find('.input-subtotal').val(total);
	}
@stop


@section('script_plugin')
	@include('plugins.microTemplate', ['section' => 'sell'])
	@include('plugins.inputMask')
	@include('plugins.select2', ['section' => null])
@stop