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
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b-md">
			@include('pageElements.indexNavigation', [
				'newDataRoute' 		=> route('admin.price.create'),
				'filterDataRoute' 	=> route('admin.price.index')
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
							<th class="col-md-1 text-left">No.</th>							
							<th class="col-md-2 text-left">SKU</th>
							<th class="col-md-3 text-left">Nama Produk</th>
							<th class="text-left">Tanggal</th>
							<th class="text-right">Harga</th>
							<th class="text-right">Harga Promo</th>
							<th class="text-center col-md-2">Kontrol</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="text-left">
								nomer
							</td>

							<td class="text-left">
								sku
							</td>

							<td class="text-left">
								nama
							</td>

							<td class="text-left">
								tanggal
							</td>

							<td class="text-right">
								harga
							</td>

							<td class="text-right">
								harga promo
							</td>		

							<td class="text-right">
								
							</td>																		
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
<!-- end of content -->

</div>
@stop