<?php
	$dt = $data['customer']['data'];
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
			<!-- <h2 style="margin-top:0px;">Data Kostumer</h2> -->

			@include('page_elements.alertbox')
		</div>
	</div>
	<!-- end of title sub-page -->

<!-- end of head -->

<!-- content -->
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b-md">
			<div class="row">
				<div class="col-md-12">
				</div>
			</div>			
			<div class="row">
<!-- 				<div class="col-md-6">
					<div class="row">
						<div class="col-md-10">
						</div>
						<div class="col-md-2">
							<a href="javascript:clickNext();"><i class="fa fa-angle-right fa-lg pull-right"></i></a>
							&nbsp;
							<a href="javascript:clickPrev();"><i class="fa fa-angle-left fa-lg pull-right"></i></a>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="owl-carousel gallery-customer">
								
							</div>
						</div>
					</div>
				</div> -->

				<div class="col-md-6 customer-info">
					<div class="row">
						<div class="col-md-12">
							<h2 style="margin-top:0px;">{{ ucwords($dt['name']) }}</h2>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12 col-sm-6 col-xs-11">
							<div class="row">
								<div class="col-md-3 col-sm-7 col-xs-5">
									<h4>Email</h4> 
								</div>
								<div class="col-md-1 col-sm-1 col-xs-2">
									<h4>:</h4> 
								</div>
								<div class="col-md-8 col-sm-3 col-xs-5">
									<h4>{{ $dt['email'] }}</h4> 
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12 col-sm-6 col-xs-11">
							<div class="row">
								<div class="col-md-3 col-sm-7 col-xs-5">
									<h4>Kode Referral</h4> 
								</div>
								<div class="col-md-1 col-sm-1 col-xs-2">
									<h4>:</h4> 
								</div>
								<div class="col-md-8 col-sm-3 col-xs-5">
									<h4>{{$dt['code_referral']}}</h4> 
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12 col-sm-6 col-xs-11">
							<div class="row">
								<div class="col-md-3 col-sm-7 col-xs-5">
									<h4>Quota Referral</h4> 
								</div>
								<div class="col-md-1 col-sm-1 col-xs-2">
									<h4>:</h4> 
								</div>
								<div class="col-md-8 col-sm-3 col-xs-5">
									<h4>{{$dt['quota_referral']}}</h4> 
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12 col-sm-6 col-xs-11">
							<div class="row">
								<div class="col-md-3 col-sm-7 col-xs-5">
									<h4>Total Referral</h4> 
								</div>
								<div class="col-md-1 col-sm-1 col-xs-2">
									<h4>:</h4> 
								</div>
								<div class="col-md-8 col-sm-3 col-xs-5">
									<h4>{{$dt['total_reference']}}</h4> 
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12 col-sm-6 col-xs-11">
							<div class="row">
								<div class="col-md-3 col-sm-7 col-xs-5">
									<h4>Pemberi Referens</h4> 
								</div>
								<div class="col-md-1 col-sm-1 col-xs-2">
									<h4>:</h4> 
								</div>
								<div class="col-md-8 col-sm-3 col-xs-5">
									<h4>{{$dt['reference_name']}}</h4> 
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12 col-sm-6 col-xs-11">
							<div class="row">
								<div class="col-md-3 col-sm-7 col-xs-5">
									<h4>Total Point</h4> 
								</div>
								<div class="col-md-1 col-sm-1 col-xs-2">
									<h4>:</h4> 
								</div>
								<div class="col-md-8 col-sm-3 col-xs-5">
									<h4>@money_indo($dt['total_point'])</h4> 
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12 col-sm-6 col-xs-11">
							<div class="row">
								<div class="col-md-3 col-sm-7 col-xs-5">
									<h4>Terakhir Login</h4> 
								</div>
								<div class="col-md-1 col-sm-1 col-xs-2">
									<h4>:</h4> 
								</div>
								<div class="col-md-8 col-sm-3 col-xs-5">
									<h4>@datetime_indo(new Carbon($dt['last_logged_at']))</h4> 
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row clearfix m-b-md">&nbsp;</div>

			<div class="row">
				<div class="col-md-12">
					<h3>Data Pembelian</h3>
				</div>
				<div class="col-md-12 m-t-sm m-b-lg">
					@include('page_elements.indexNavigation', [
						'disabled' 			=> true,
						'newDataRoute' 		=> '/',
						'searchLabel'		=> 'cari nomor nota',
						'filterDataRoute' 	=> route('customer.customer.show', ['id' => $dt['id']]),
						'filters'			=> [],
						'sorts'				=> $sorts
					])						
				</div>				
			</div>

			<div id="contentData">
				<div class="row">
					@include('page_elements.searchResult', [
						'closeSearchLink' 	=>  route('goods.tag.show', ['id' => $dt['id']]) 
					])
				</div>	

				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							</br>
							<table class="table table-hover">
								<thead>
									<tr>
										<th class="text-center">No</th>
										<th class="text-left">No Nota</th>
										<th class="text-center">Tanggal</th>
										<th class="text-center">Status</th>
										<th class="text-right">Total Tagihan</th>
										<th class="text-center">Kontrol</th>
									</tr>
								</thead>
								<tbody>
									@if (count($dt['sales']) == 0)
										<tr>
											<td colspan="6">
												<p class="text-center">Tidak ada data</p>
											</td>
										</tr>
									@else
										@foreach($dt['sales'] as $ctr => $sale)
											<tr>
												<td class="text-center">
													{{ ($paging->perPage() * ($paging->currentPage() - 1)) + $ctr + 1}}
												</td>
												<td class="text-left">{{ $sale['ref_number'] }}</td>
												<td class="text-center">@date_indo(new Carbon($sale['transact_at']))</td>
												<td class="text-center">{{ $sale['status'] }}</td>
												<td class="text-right">@money_indo($sale['bills'])</td>
												<td class="text-center">
													<a href="{{ route('report.product.sale.detail', $sale['id']) }}"> Detail</a>, 
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
	</div>
<!-- end of content -->
@stop

@section('scripts')
	$(document).ready(function() {
		$('.galery').hide().fadeIn('slow');
		$('.galery').attr("class","img img-responsive canvasSource");
	});

	function clickNext() {
		$('#car-btn-next').trigger("click");
	}

	function clickPrev() {
		$('#car-btn-prev').trigger("click");
	}
@stop

@section('script_plugin')
	@include('plugins.owlCarousel')
@stop