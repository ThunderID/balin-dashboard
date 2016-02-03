<?php
	$dt = $data['product'];
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

	<!-- title sub-page -->
	<div class="row">
		<div class="col-md-12 m-b-md">
			<h2 style="margin-top:0px;">Data Harga</h2>

			@include('page_elements.alertbox')
		</div>
	</div>
	<!-- end of title sub-page -->	
<!-- end of head -->

<!-- content -->
	<div class="row">
		<div class="col-md-12">
			<a class="btn btn-default pull-right"  href="{{ route('goods.price.detail.create', ['id' => $dt['id']] ) }}"> Harga Baru </a>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b-md">
			<div class="row">
				<div class="col-md-5 col-sm-6 col-xs-11">
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-5">
							<h4>UPC</h4> 
						</div>
						<div class="col-md-1 col-sm-1 col-xs-2">
							<h4>:</h4> 
						</div>
						<div class="col-md-5 col-sm-5 col-xs-5">
							<h4>{{ $dt['upc'] }}</h4> 
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
							<h4>{{ ucwords($dt['name']) }}</h4> 
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-5">
							<h4>Harga Saat Ini</h4> 
						</div>
						<div class="col-md-1 col-sm-1 col-xs-2">
							<h4>:</h4> 
						</div>
						<div class="col-md-5 col-sm-5 col-xs-5">
							<h4> @money_indo($dt['price']) </h4> 
						</div>
					</div>	
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-5">
							<h4>Harga Promo Saat Ini</h4> 
						</div>
						<div class="col-md-1 col-sm-1 col-xs-2">
							<h4>:</h4> 
						</div>
						<div class="col-md-5 col-sm-5 col-xs-5">
							<h4> @money_indo($dt['promo_price']) </h4> 
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-5">
							<h4>Harga Mulai Berlaku</h4> 
						</div>
						<div class="col-md-1 col-sm-1 col-xs-2">
							<h4>:</h4> 
						</div>
						<div class="col-md-5 col-sm-5 col-xs-5">
							<h4> 
								@datetime_indo(new Carbon($dt['price_start']))
							</h4> 
						</div>
					</div>					
				</div>
			</div>						
			<div class="row clearfix m-b-md">&nbsp;</div>
			<div class="row">
				<div class="col-md-12">
					<h4>Riwayat Harga</h4> 
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
										<th class="text-left">
											No.
										</th>
										<th class="col-md-3 text-left">
											Tanggal
										</th>
										<th class="col-md-3 text-right">
											Harga
										</th>
										<th class="col-md-3 text-right">
											Harga Promo
										</th>
										<th class="text-center">
											Kontrol
										</th>							
									</tr>
								</thead>
								<tbody>
									@if(count($dt['prices']) == 0)
										<tr>
											<td colspan="6" class="text-center">
												Tidak ada data
											</td>
										</tr>
									@else                
										<?php $ctr = 0; ?>
										@foreach($dt['prices'] as $key => $price)
											<tr>
												<td class="text-left">
													{{ ($paging->perPage() * ($paging->currentPage() - 1)) + $key + 1}}
												</td>

												<td class="text-left">
													@datetime_indo(new Carbon($price['started_at']))
												</td>

												<td class="text-right">
													@money_indo($price['price'])
												</td>

												<td class="text-right">
													@money_indo($price['promo_price'])
												</td>

												<td class="text-center">
													<a href="{{ route('goods.price.detail.edit', ['productId' => $dt['id'] ,'id' => $price['id']]) }}">Edit</a>, 
													<a href="javascript:void(0);" data-backdrop="static" data-keyboard="false" data-toggle="modal" 
														data-target="#price_del"
														data-id="{{$price['id']}}"
														data-title="Hapus Data Harga Produk {{$dt['name']}}"
														data-action="{{ route('goods.price.detail.destroy', ['productId' => $dt['id'] ,'id' => $price['id']]) }}">
														Hapus
													</a>
													<?php
								        			// <a href="{{ route('goods.product.show', $dt['id']) }}"> Detail</a>,
													?>                                          
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