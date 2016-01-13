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
			<h2 style="margin-top:0px;">{{ ucwords($data['name']) }}</h2>
			<h5>
				<strong>UPC</strong> 
				{{ $data['upc'] }}
			</h5> 				

			@include('pageElements.alertbox')
		</div>
	</div>
	<!-- end of title sub-page -->

<!-- end of head -->

<!-- body -->
	@if(isset(  $data['data']['id'] ))
		{!! Form::open(['url' => route('admin.varian.update', ['pid' => $data['pid'], 'id' => $data['data']['id']] ), 'method' => 'PATCH']) !!}
	@else
		{!! Form::open(['url' => route('admin.varian.store', ['pid' => $data['pid']] ), 'method' => 'POST', 'id' => 'my-awesome-dropzone', 'class' => 'dropzone']) !!}
	@endif
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="sku">SKU</label>
					{!! Form::text('sku', $data['data']['sku'], [
								'class'         => 'form-control', 
								'placeholder'   => 'Masukkan kode SKU',
								'tabindex'      => '1', 
					]) !!}
				</div>
			</div> 			
			<div class="col-md-6">
				<div class="form-group">
					<label for="size">Ukuran</label>
					{!! Form::text('size', $data['data']['size'], [
								'class'         => 'form-control', 
								'tabindex'      => '2', 
								'placeholder'   => 'Masukkan ukuran produk'
					]) !!}
				</div>  
			</div> 
		</div>
	
		<div class="clearfix">&nbsp;</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group text-right">
					<a href="{{ URL::route('admin.product.show', ['id' => $data['pid']]) }}" class="btn btn-md btn-default" tabindex="3">Batal</a>
					<button type="submit" class="btn btn-md btn-primary" tabindex="4">Simpan</button>
				</div>        
			</div>        
		</div>        
	{!! Form::close() !!}   
<!-- end of body -->
@stop