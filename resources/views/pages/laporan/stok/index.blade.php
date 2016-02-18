@extends('page_templates.layout')
@section('content')
<div class="container-fluid">
<!-- head -->
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b-md border-bottom">
			@include('page_elements.pagetitle')
			@include('page_elements.breadcrumb')
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			@include('page_elements.indexNavigation', [
				'type' 				=> 'date',
				'searchLabel'		=>'cari produk',
				'filters'			=> $filters,
				'sorts'				=> $sorts,
			])			
		</div>
	</div>	
	
	<div id="contentData">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12 m-b-md">
				@include('page_elements.searchResult', [
					'closeSearchLink' 	=> route('report.stock.product') 
				])
			</div>
		</div>
		</br>
<!-- end of head -->

<!-- content -->
		<div class="row">
			<div class="col-lg-12">
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th class="text-center col-md-1">No.</th>
								<th class="text-left col-md-2">SKU</th>
								<th class="text-left col-md-3">Nama Produk</th>
								<th class="text-center col-md-2">Ukuran</th>
								<th class="text-center col-md-1">Stok Gudang</th>
								<th class="text-center col-md-2">Kontrol</th>
							</tr>
						</thead> 
						<tbody>
							@if(count($data['product']['data']['data']) == 0)
								<tr>
									<td colspan="7" class="text-center">
										Tidak ada data
									</td>
								</tr>
							@else
								@foreach($data['product']['data']['data'] as $key => $dt)
									<tr>
										<td class="text-center">
											{{ ($paging->perPage() * ($paging->currentPage() - 1)) + $key + 1}}
										</td>
										<td class="text-left">
											{{ $dt['sku'] }}
										</td>
										<td class="text-left">
											{{ $dt['product']['name'] }}
										</td>
										<td class="text-center">
											{{ $dt['size'] }}
										</td>
										<td class="text-center">
											{{ $dt['inventory_stock'] }}
										</td>
										<td class="text-center">
											<a href="{{ route('report.stock.product.detail', $dt['id']) }}"> Detail</a>
										</td>
									</tr>
								@endforeach 
							@endif
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="row">
			@include('page_elements.ajaxPaging')
		</div>	
<!-- end of content -->

	</div>
</div>
@stop