<?php
	$dt = $data['product']['data'];
?>
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
							<h4>{{$dt['sku']}}</h4> 
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
							<h4>{{$dt['product']['name']}}</h4> 
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-5">
							<h4>Ukuran</h4> 
						</div>
						<div class="col-md-1 col-sm-1 col-xs-2">
							<h4>:</h4> 
						</div>
						<div class="col-md-5 col-sm-5 col-xs-5">
							<h4>{{$dt['size']}}</h4> 
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-5">
							<h4>Stok Gudang</h4> 
						</div>
						<div class="col-md-1 col-sm-1 col-xs-2">
							<h4>:</h4> 
						</div>
						<div class="col-md-5 col-sm-5 col-xs-5">
							<h4>{{$dt['inventory_stock']}}</h4> 
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
							<h4>{{$dt['sold_item']}}</h4> 
						</div>
					</div>
				</div>
				<!-- <div class="col-md-7 col-sm-6 col-xs-12">
					<div class="row">
						<div class="col-md-9 col-sm-8 hidden-xs">
						</div>
						<div class="col-md-3 col-sm-4 col-xs-12">
							<a class="btn btn-default btn-block" href="#"> Re-stok Produk </a>
						</div>
					</div>
				</div>-->
			</div>						

			<div class="row clearfix m-b-md">&nbsp;</div>
			<div class="row">
				<div class="col-md-12">
					<h4>Kartu Stok</h4> 
				</div>
				<div class="col-md-12 m-t-sm m-b-lg">
					@include('page_elements.dateRangeNavigation', [
						'filterDataRoute' 	=> route('goods.price.show', ['id' => $dt['id']])
					])	
				</div>			
			</div>

			<div id="contentData">
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-bordered table-hover table-striped">
								<thead>
									<tr>
										<th class="col-md-1 text-left">
											No.
										</th>
										<th class="col-md-4 text-left">
											Tanggal
										</th>
										<th class="col-md-2 text-center">
											Stok Masuk
										</th>
										<th class="col-md-2 text-center">
											Stok Keluar 
										</th>
										<th class="col-md-3 text-center">
											Jumlah Stok
										</th>
									</tr>
								</thead>
								<tbody>
									@if(count($dt['details']) == 0)
										<tr>
											<td colspan="5" class="text-center">
												Tidak ada data
											</td>
										</tr>
									@else
										<?php $stock =0;?>
										@foreach($dt['details'] as $key => $detail)
											<?php $stock = $stock + $detail['stock_in'] - $detail['stock_out'];?>
											<tr>
												<td class="text-left">
													{{$key+1}}
												</td>

												<td class="text-left">
													@date_indo(new Carbon($detail['transact_at']))
												</td>

												<td class="text-right">
													{{$detail['stock_in']}}
												</td>

												<td class="text-right">
													{{$detail['stock_out']}}
												</td>

												<td class="text-right">
													{{$stock}}
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
			</div>
		</div>
	<div>

<!-- end of content -->
@stop