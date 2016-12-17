@extends('page_templates.layout') 

@section('content')
<div class="container-fluid">
<!-- head -->
    @include('page_elements.createHeader', ['title' => 'Data Diskon (Semua Produk)' ])    
<!-- end of head -->

<!-- body -->
    {!! Form::open(['url' => route('promote.discount.store'), 'method' => 'POST']) !!}
	<div class="row">

		<div class="col-md-12 m-b-sm">
			<h5 class="sub-header text-red">
				Berikan diskon untuk kategori / tag tertentu, kosongkan keduanya untuk diskon semua produk.
				Jika keduanya diisi maka diskon berlaku untuk produk dengan kategori dan tag tsb.
			</h5>
		</div>

		<div class="col-md-12">
			<div class="form-group">
				<label for="category">Kategori</label>
				{!! Form::text('category_ids', null, [
							'class'         => 'select-category', 
							'tabindex'      => '1',
							'id'            => 'find_product',
							'style'         => 'width:100%',
				]) !!}
			</div>
		</div>

		<div class="col-md-12">
			<div class="form-group">
				<label for="category">Tag</label>
				{!! Form::text('tag_ids', null, [
							'class'         => 'select-tag', 
							'tabindex'      => '2',
							'id'            => 'find_product',
							'style'         => 'width:100%',
				]) !!}
			</div>
		</div>
		
		<div class="col-md-12 m-t-md m-b-sm">
			<h5 class="sub-header text-red">
				Tanggal mulai dan akhir merupakan periode berlaku diskon, prioritas utama jadwal harga akan mengikuti diskon. Setelah diskon berakhir, harga kembali seperti semula/sesuai jadwal.
			</h5>
		</div>

		<div class="col-md-6">
			<div class="form-group">
				<label for="started_at">Tanggal Mulai</label>
				{!! Form::text('started_at', null, [
							'class'         => 'form-control date-time-format',
							'tabindex'      => '3', 
							'placeholder'   => 'Tanggal berlaku'
				]) !!}
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="ended_at">Tanggal Akhir</label>
				{!! Form::text('ended_at', null, [
							'class'         => 'form-control date-time-format',
							'tabindex'      => '4', 
							'placeholder'   => 'Tanggal berlaku'
				]) !!}
			</div>
		</div>
		
		<div class="col-md-12 m-t-md m-b-sm">
			<h5 class="sub-header text-red">
				Isi salah satu cara pemberian potongan harga, jika keduanya maka potongan harga akan dilakukan dahulu kemudian di potong persentasi harga yang baru.
			</h5>
		</div>
		
		<div class="col-md-6">
			<div class="form-group">
				<label for="discount_amount" class="text-capitalize">Jumlah (IDR)</label>
				{!! Form::text('discount_amount', null, [
							'class'         => 'form-control money', 
							'tabindex'      => '5',
							'placeholder'   => 'Semua harga akan di potong sesuai potongan harga'
				]) !!}
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label for="discount_percentage" class="text-capitalize">Diskon (%)</label>
				<input type="number" name="discount_percentage" tabindex="6" placeholder="Semua harga akan di potong sesuai persentasi harga barang saat ini" max=100 min=0 class="form-control">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">             
			</br>
			<div class="form-group text-right">
				<a href="{{ route('promote.discount.index') }}" class="btn btn-md btn-default" tabindex="8">Batal</a>
				<button type="submit" class="btn btn-md btn-primary" tabindex="7">Simpan</button>
			</div>
		</div>
	</div>
    {!! Form::close() !!}
<!-- end of body -->
</div>
@stop

@section('script_plugin')
    @include('plugins.select2', ['section' => 'category'])
    @include('plugins.select2', ['section' => 'tag'])
	@include('plugins.inputMask')
@stop