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

	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			@include('pageElements.alertbox')
		</div>
	</div>

<!-- end of head -->

<!-- body -->
	@if(isset($data['id']))
    {!! Form::open(['url' => route('admin.product.update', $data['id']), 'method' => 'PATCH']) !!}
    @else
    {!! Form::open(['url' => route('admin.product.store'), 'method' => 'POST']) !!}
    @endif
		<div class="row">
			<div class="col-md-12">
				<h4 class="sub-header">
					Produk
				</h4>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="name">Nama Produk</label>
					{!! Form::text('name', null, [
								'class'         => 'form-control', 
								'tabindex'      => '1', 
								'placeholder'   => 'Masukkan nama produk'
					]) !!}
				</div>  
			</div> 
			<div class="col-md-6">
				<div class="form-group">
					<label for="upc">UPC</label>
					{!! Form::text('upc', null, [
								'class'         => 'form-control', 
								'placeholder'   => 'Masukkan kode UPC',
								'tabindex'      => '2', 
					]) !!}
				</div>
			</div> 
			<div class="col-md-12">
				<div class="form-group">
					<label for="label">Label</label>
					{!! Form::text('label', null, [
								'class'         => 'select-label', 
								'tabindex'      => '3',
								'id'            => 'find_label',
								'style'         => 'width:100%',
					]) !!}
				</div>  
			</div>			                                        
			<div class="col-md-12">
				<div class="form-group">
					<label for="description">Deskripsi</label>
					{!! Form::textarea('description',null, [
								'class'         => 'summernote form-control', 
								'placeholder'   => 'Masukkan deskripsi',
								'rows'          => '1',
								'tabindex'      => '4',
								'style'         => 'resize:none;',
					]) !!}
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label for="fit">Ukuran & Fit</label>
					{!! Form::textarea('fit', null, [
								'class'         => 'summernote form-control', 
								'placeholder'   => 'Masukkan ukuran',
								'rows'          => '1',
								'tabindex'      => '5',
								'style'         => 'resize:none;',
					]) !!}
				</div>
			</div>
		</div>

		<div class="clearfix">&nbsp;</div>
		<div class="row">
			<div class="col-md-12">
				<h4 class="sub-header">
					Filter
				</h4>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="category">Kategori</label>
					{!! Form::text('category', null, [
								'class'         => 'select-category', 
								'tabindex'      => '6',
								'id'            => 'find_category',
								'style'         => 'width:100%',
					]) !!}
				</div>  
			</div> 
			<div class="col-md-6">
				<div class="form-group">
					<label for="tag">Tag</label>
					{!! Form::text('tag', null, [
								'class'         => 'select-tag', 
								'tabindex'      => '7',
								'id'            => 'find_tag',
								'style'         => 'width:100%',
					]) !!}
				</div>  
			</div> 			
		</div>

		<div class="clearfix">&nbsp;</div>
		<div class="row">
			<div class="col-md-12">
				<h4 class="sub-header">
					Harga
				</h4>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="category">Mulai</label>
					{!! Form::text('started_at', null, [
								'class'         => 'form-control date-time-format',
								'tabindex'      => '8', 
								'placeholder'   => 'Isikan tanggal dan waktu mulai'
					]) !!}
				</div>  
			</div> 			
			<div class="col-md-4">
				<div class="form-group">
					<label for="category">Harga</label>
					{!! Form::text('price', null, [
								'class'        		=> 'form-control money', 
								'tabindex'     		=> '9', 
								'placeholder'  		=> 'harga',
					]) !!}
				</div>  
			</div>  
			<div class="col-md-4">
				<div class="form-group">
					<label for="category">Harga Promo</label>
					{!! Form::text('promo_price', null, [
								'class'         => 'form-control money', 
								'tabindex'      => '10', 
								'placeholder'   => '(kosongkan bila tidak ada promo)'
					]) !!}
				</div>  
			</div> 		
		</div>

	<!-- image section -->
		<div class="clearfix">&nbsp;</div>
		<div class="row">
			<div class="col-md-12">
				<h4 class="sub-header">
					Gambar
				</h4>
			</div>
		</div>
		<div class="row">
			<div id="template-image">
			</div>	
		</div>
	<!-- end of image section -->

		<div class="clearfix">&nbsp;</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group text-right">
					<a href="{{ URL::route('admin.product.index') }}" class="btn btn-md btn-default" tabindex="13">Batal</a>
					<button type="submit" class="btn btn-md btn-primary" tabindex="12">Simpan</button>
				</div>        
			</div>        
		</div> 
    {!! Form::close() !!}
<!-- end of body -->

</div>

<!-- micro template section	-->
	<div class="hidden">
		<div id="tmplt">
			<div class="col-md-4">
				<div class="form-group">
					<label for="thumbnail" class="text-capitalize">URL Image (320 X 463 px)</label>
					{!! Form::text('thumbnail[]', null, [
								'class'         => 'form-control input-image-thumbnail', 
								'tabindex'      => '11',
								'placeholder'   => 'Masukkan url image thumbnail',
					]) !!}
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="logo" class="text-capitalize">URL Image (320 X 463 px)</label>
					{!! Form::text('image_xs[]', null, [
								'class'         => 'form-control input-image-xs', 
								'tabindex'      => '11',
								'placeholder'   => 'Masukkan url image xs',
					]) !!}
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="logo" class="text-capitalize">URL Image (320 X 463 px)</label>
					{!! Form::text('image_sm[]', null, [
								'class'         => 'form-control input-image-sm', 
								'tabindex'      => '11',
								'placeholder'   => 'Masukkan url image sm',
					]) !!}
				</div>
			</div>											
			<div class="col-md-4">
				<div class="form-group">
					<label for="logo" class="text-capitalize">URL Image (772 X 1043 px)</label>
					{!! Form::text('image_md[]', null, [
								'class'         => 'form-control input-image-md', 
								'tabindex'      => '11',
								'placeholder'   => 'Masukkan url image md',
					]) !!}
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="logo" class="text-capitalize">URL Image (992 X 1434 px)</label>
					{!! Form::text('image_lg[]', null, [
								'class'         => 'form-control input-image-lg', 
								'tabindex'      => '11',
								'placeholder'   => 'Masukkan url image lg',
					]) !!}							
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">					
					<label for="default" class="text-capitalize">Default</label>
					<select name="default[]" class="form-control default" tabindex="11" onchange="ImageDefaultValidation(this)">
				        <option value="0" selected="selected">False</option>
				        <option value="1" >True</option>
					</select>							
				</div>						
			</div>
			<div class="col-md-1">
				<div class="form-group">
					<a href="javascript:;" class="btn btn-sm btn-default m-t-mds btn-add-image pull-left">
						<i class="fa fa-plus"></i>
					</a>
				</div>
			</div>					
			<div class="clearfix">&nbsp;</div>
		</div>
	</div>
<!-- end of micro template section -->
@stop

@section('script_plugin')
	@include('plugins.select2')
	@include('plugins.summerNote')
	@include('plugins.inputMask')
	@include('plugins.microTemplate')
@stop

@section('scripts')
	$( document ).ready(function() {
	<!-- init microtemplate -->
		template_add_image($('.base'));
	<!-- endof init microtemplate -->
	});

	<!-- image default validator -->
	function ImageDefaultValidation(e) {
		$('#template-image').find('.default').val(0);
		$(e).val(1);		
	}
	<!-- end of image default validator -->

@stop