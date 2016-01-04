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
				'newDataRoute' 		=> route('admin.stock.create'),
				'filterDataRoute' 	=> route('admin.stock.index')
			])
			@include('pageElements.searchResult', [
				'closeSearchLink' 	=> route('admin.stock.index') 
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
							<th class="col-md-1">No.</th>							
							<th class="col-md-2">SKU</th>
							<th class="col-md-3">Nama Produk</th>
							<th class="text-center">Varian</th>
							<th class="text-center">Stok Saat Ini</th>
							<th class="text-center">Stok Keluar Bulan Ini</th>
							<th class="text-center col-md-2">Kontrol</th>
						</tr>
					</thead> 
					<tbody>
						@if (count($data) == 0)
							<tr>
								<td colspan="7" class="text-center">
									Tidak ada data
								</td>
							</tr>
						@else 
							<tr>
								<td>
									{{$dt['id'] + 1}}
								</td>
								<td>
									<p>
									</p>
								</td>
								<td>
									<p>
									</p>
								</td>
								<td>
									<p>
									</p>
								</td>
								<td>
									<p>
									</p>
								</td>
								<td>
									<p>
									</p>
								</td>																																
								<td class="text-center">
									<a href="#"> Re-stock</a>                                                                              
									<a href="{{ route('admin.stock.show',  $dt['id']) }}"> Detail</a>                                                                              
								</td>    
							</tr>
						@endif         						
					</tbody>
				</table>
			</div>
		</div>
	</div>
<!-- end of content -->

</div>
@stop