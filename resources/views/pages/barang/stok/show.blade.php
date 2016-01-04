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
<!-- end of head -->

<!-- content -->
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b-md">
			<div class="row">
				<div class="col-md-5 col-sm-6 col-xs-11">
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-5">
							<h4>SKU</h4> 
						</div>
						<div class="col-md-1 col-sm-1 col-xs-2">
							<h4>:</h4> 
						</div>
						<div class="col-md-5 col-sm-5 col-xs-5">
							<h4>dummy</h4> 
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-5">
							<h4>Nama Produk</h4> 
						</div>
						<div class="col-md-1 col-sm-1 col-xs-2">
							<h4>:</h4> 
						</div>
						<div class="col-md-5 col-sm-5 col-xs-5">
							<h4> dummy & varian</h4> 
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-5">
							<h4>Stok Saat Ini</h4> 
						</div>
						<div class="col-md-1 col-sm-1 col-xs-2">
							<h4>:</h4> 
						</div>
						<div class="col-md-5 col-sm-5 col-xs-5">
							<h4> dummy </h4> 
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-5">
							<h4>Stok Keluar Bulan Ini</h4> 
						</div>
						<div class="col-md-1 col-sm-1 col-xs-2">
							<h4>:</h4> 
						</div>
						<div class="col-md-5 col-sm-5 col-xs-5">
							<h4> dummy </h4> 
						</div>
					</div>
				</div>
				<div class="col-md-7 col-sm-6 col-xs-12">
					<div class="row">
						<div class="col-md-9 col-sm-8 hidden-xs">
						</div>
						<div class="col-md-3 col-sm-4 col-xs-12">
							<a class="btn btn-default btn-block" href="#"> Re-stok Produk </a>
						</div>
					</div>
				</div>				
			</div>						
			<div class="row clearfix m-b-md">&nbsp;</div>
			<div class="row">
				<div class="col-md-12">
					<h4>Kartu Stok</h4> 
				</div>
				<div class="col-md-12 m-t-sm m-b-lg">
					@include('pageElements.dateRangeNavigation', [
						'filterDataRoute' 	=> route('admin.stock.show', ['id' => $data['id']])
					])	
					@include('pageElements.filterResult', [
						'closeSearchLink' 	=>  route('admin.stock.show', ['id' => $data['id']]) 
					])
				</div>			
				<div class="col-md-12">
					<div class="table-responsive">
						<table class="table table-bordered table-hover table-striped">
							<thead>
								<tr>
									<th class="text-left">
										No.
									</th>
									<th class="col-md-3 text-left">
										Tanggal
									</th>
									<th class="col-md-2 text-center">
										Stok Masuk
									</th>
									<th class="col-md-2 text-center">
										Stok Keluar 
									</th>
									<th class="col-md-2 text-center">
										Jumlah Stok
									</th>
									<th class="text-center">
										Kontrol
									</th>							
								</tr>
							</thead>
							<tbody>
								@if(count($data) == 0)
									<tr>
										<td colspan="6" class="text-center">
											Tidak ada data
										</td>
									</tr>
								@else                                                                 
									@foreach($data as $dt)
										<tr>
											<td class="text-left">
												nomer
											</td>

											<td class="text-left">
												tanggal
											</td>

											<td class="text-center">
												stok masuk
											</td>

											<td class="text-center">
												stok keluar
											</td>

											<td class="text-center">
												jumlah stok
											</td>


											<td class="text-center">
<!-- 	        									<a href="{{ route('admin.product.show', $dt['id']) }}"> Detail</a>,
												<a href="{{ route('admin.product.edit', $dt['id']) }}"> Edit</a>, 
												<a href="javascript:void(0);" data-backdrop="static" data-keyboard="false" data-toggle="modal" 
													data-target="#stock_del"
													data-id="{{$dt['id']}}"
													data-title="Hapus Data Produk {{$dt['name']}}"
													data-action="{{ route('admin.stock.destroy', $dt['id']) }}">
													Hapus
												</a>  -->                                         
											</td>    
										</tr>       
									@endforeach 
									
									@include('pageElements.modalDelete', [
											'modal_id'      => 'stock_del', 
											'modal_route'   => route('admin.stock.destroy')
									])						

								@endif
								
							</tbody>
						</table>
					</div>					
				</div>
			</div>		
		</div>
	<div>

<!-- end of content -->
@stop