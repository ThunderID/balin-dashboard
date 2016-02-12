@extends('page_templates.layout') 

@section('content')
<div class="container-fluid">
<!-- head -->
    @include('page_elements.createHeader', ['title' => 'Data Pembelian ' . $data['data']['ref_number'] ])    
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
									'tabindex'      => '2',
									'placeholder'   => 'Masukkan varian',
						]) !!}
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<label for="quantity" class="text-capitalize">Kuantitas</label>
						{!! Form::text('quantity[]', null, [
									'class'         => 'form-control input-quantity', 
									'tabindex'      => '2',
									'placeholder'   => 'Qty',
						]) !!}
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<label for="price" class="text-capitalize">Harga</label>
						{!! Form::text('price[]', null, [
									'class'         => 'form-control input-price money', 
									'tabindex'      => '2',
									'placeholder'   => 'harga produk',
						]) !!}
					</div>
				</div>											
				<div class="col-md-2">
					<div class="form-group">
						<label for="promo_price" class="text-capitalize">Diskon</label>
						{!! Form::text('promo_price[]', null, [
									'class'         => 'form-control input-promo_price money', 
									'tabindex'      => '2',
									'placeholder'   => 'harga promo',
						]) !!}
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<label for="subtotal" class="text-capitalize">Subtotal</label>
						{!! Form::text('subtotal[]', null, [
									'class'         => 'form-control input-subtotal money', 
									'tabindex'      => '2',
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
    {!! Form::open(['url' => route('shop.buy.update', $data['data']['id']), 'method' => 'PATCH']) !!}
    @else
    {!! Form::open(['url' => route('shop.buy.store'), 'method' => 'POST']) !!}
    @endif

	{!! Form::hidden('src', $data['src'], []) !!}

		<div class="row">
			<div class="col-md-3">
				<div class="form-group">
					<label for="transact_at">Tanggal Pembelian</label>
					{!! Form::text('transact_at', $data['data']['transact_at'], [
								'class'         => 'form-control date-time-format', 
								'tabindex'      => '1', 
								'placeholder'   => 'Masukkan tanggal pembelian'
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

		<div class="clearfix">&nbsp;</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group text-right">
					<a href="{{ URL::route('shop.buy.index') }}" class="btn btn-md btn-default" tabindex="5">Batal</a>
					<button type="submit" class="btn btn-md btn-primary" tabindex="4">Simpan</button>
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
		@if(count($data['data']['transactiondetails'] > 0))
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
	@include('plugins.microTemplate', ['section' => 'buy'])
	@include('plugins.inputMask')
	@include('plugins.select2', ['section' => null])
@stop