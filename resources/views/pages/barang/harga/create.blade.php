@extends('page_templates.layout') 

@section('content')
<div class="container-fluid">
<!-- head -->
    @include('pageElements.createHeader', ['title' => 'Data Harga ' . $data['name'] ])    
<!-- end of head -->

<!-- body -->
	@if(isset($data['price']['data']['id']))
    {!! Form::open(['url' => route('admin.price.detail.update', ['productID' => $data['productId'], 'id' => $data['price']['data']['id']]), 'method' => 'PATCH']) !!}
    @else
    {!! Form::open(['url' => route('admin.price.store'), 'method' => 'POST']) !!}
    @endif
	<div class="row">

		@if(is_null($data['productId']))
			<div class="col-md-12">
				<div class="form-group">
					<label for="category">Produk</label>
					{!! Form::text('produk', null, [
								'class'         => 'select-product', 
								'tabindex'      => '1',
								'id'            => 'find_product',
								'style'         => 'width:100%',
					]) !!}
				</div>
			</div>
		@else
			{!! Form::hidden('produk', $data['productId']) !!}
		@endif

		<div class="col-md-4">
			<div class="form-group">
				<label for="start_at">Tanggal Mulai</label>
				{!! Form::text('start_at', $data['price']['data']['started_at'], [
							'class'         => 'form-control date-time-format',
							'tabindex'      => '2', 
							'placeholder'   => 'Tanggal berlaku'
				]) !!}
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label for="price" class="text-capitalize">Harga</label>
				{!! Form::text('price', $data['price']['data']['price'], [
							'class'         => 'form-control money', 
							'tabindex'      => '3',
							'placeholder'   => 'Harga'
				]) !!}
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label for="price" class="text-capitalize">Harga Promo</label>
				{!! Form::text('promo_price', $data['price']['data']['promo_price'], [
							'class'         => 'form-control money', 
							'tabindex'      => '4',
							'placeholder'   => 'Harga promo (setelah di diskon).'
				]) !!}
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">             
			</br>
			<div class="form-group text-right">
				@if(is_null($data['productId']))
					<a href="{{ route('admin.price.index') }}" class="btn btn-md btn-default" tabindex="4">Batal</a>
				@else
					<a href="{{ route('admin.price.show', ['productId' => $data['productId']]) }}" class="btn btn-md btn-default" tabindex="4">Batal</a>
				@endif
				<button type="submit" class="btn btn-md btn-primary" tabindex="5">Simpan</button>
			</div>
		</div>
	</div>
    {!! Form::close() !!}
<!-- end of body -->
</div>
@stop

@section('script_plugin')
    @include('plugins.select2', ['max_input' => 1, 'section' => 'product'])
	@include('plugins.inputMask')
@stop