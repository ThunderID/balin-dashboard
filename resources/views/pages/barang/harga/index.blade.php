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

	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b-md">
			@include('pageElements.indexNavigation', [
				'newDataRoute' 		=> route('admin.price.create'),
				'newDataLabel'		=> 'Harga Baru',
				'filterDataRoute' 	=> route('admin.price.index'),
				'searchLabel'		=> 'Cari Nama Produk'
			])
			@include('pageElements.searchResult', [
				'closeSearchLink' 	=> route('admin.price.index') 
			])
		</div>
	</div>
	</br>
<!-- end of head -->

<!-- content -->
	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table table-bordered table-hover table-striped">
					<thead>
						<tr>
							<th class="text-left">No.</th>							
							<th class="col-md-2 text-left">Thumbnail</th>
							<th class="col-md-3 text-left">Nama Produk</th>
							<th class="col-md-2 text-center">UPC</th>
							<th class="col-md-2 text-right">Harga</th>
							<th class="col-md-2 text-right">Harga Promo</th>
							<th class="text-center col-md-1">Kontrol</th>
						</tr>
					</thead>
					<tbody>
						@if(count($data['product']['data']) == 0)
							<tr>
								<td colspan="7" class="text-center">
									Tidak ada data
								</td>
							</tr>
						@else                                                                 
							@foreach($data['product']['data'] as $dt)						
							<tr>
								<td class="text-left">
									nomer
								</td>

								<td class="text-left">
									{!! HTML::image($dt['thumbnail'], 'default', ['class' => 'img-responsive', 'style' => 'max-width:100px;']) !!}
								</td>

								<td class="text-left">
									{{ $dt['name'] }}
								</td>

								<td class="text-center">
									{{ $dt['upc'] }}
								</td>							

								<td class="text-right">
									@money_indo($dt['price'])
								</td>

								<td class="text-right">
									@money_indo($dt['promo_price'])
								</td>		

								<td class="text-center">
									<a href="{{ route('admin.price.show', $dt['id']) }}"> Detail</a>
								</td>																		
							</tr>
							@endforeach
						@endif
					</tbody>
				</table>
			</div>
		</div>
	</div>
<!-- end of content -->

</div>
@stop