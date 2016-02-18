<?php
	$dt = $data['purchase']['data'];
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
		<div class="col-md-6 m-b-md">
			<h2 style="margin-top:0px;">BALIN Invoice</h2>
		</div>
		<div class="col-md-6 m-b-md text-right">
			<h3>Status : {{ucwords($dt['status'])}}</h3>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 m-b-md">
			@include('page_elements.alertbox')
		</div>
	</div>
	<!-- end of title sub-page -->

<!-- end of head -->

<!-- content -->
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b-md">
			
			<div class="row">
				<div class="col-md-5 col-sm-6 col-xs-11">
					<div class="row">
						<div class="col-md-6 col-sm-7 col-xs-5">
							<h4>Nomor Invoice</h4> 
						</div>
						<div class="col-md-1 col-sm-1 col-xs-2">
							<h4>:</h4> 
						</div>
						<div class="col-md-5 col-sm-3 col-xs-5">
							<h4>{{$dt['ref_number']}}</h4> 
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-5 col-sm-6 col-xs-11">
					<div class="row">
						<div class="col-md-6 col-sm-7 col-xs-5">
							<h4>Tanggal Invoice</h4> 
						</div>
						<div class="col-md-1 col-sm-1 col-xs-2">
							<h4>:</h4> 
						</div>
						<div class="col-md-5 col-sm-3 col-xs-5">
							<h4>@date_indo(new Carbon($dt['transact_at']))</h4> 
						</div>
					</div>
				</div>
			</div>


			<div class="row">
				<div class="col-md-12 m-t-md">
					<p>Pembelian dari <strong>{{$dt['supplier']['name']}}</strong> sebagai berikut :</p>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="table-responsive">
						</br>
						<table class="table table-hover">
							<thead>
								<tr>
									<th class="text-center"></th>
									<th class="text-center">Nama Barang</th>
									<th class="text-center">Ukuran</th>
									<th class="text-center">Qty</th>
									<th class="text-right">Harga</th>
									<th class="text-right">Diskon</th>
									<th class="text-right">Sub Total</th>
								</tr>
							</thead>
							<tbody>
								@if (count($dt['transactiondetails']) == 0)
									<tr>
										<td colspan="7">
											<p class="text-center">Tidak ada data</p>
										</td>
									</tr>
								@else
									@foreach($dt['transactiondetails'] as $ctr => $detail)
										<tr>
											<td class="text-center">
											@if(is_null($detail['varian']['product']['thumbnail']))
												{!! HTML::image('https://pbs.twimg.com/profile_images/600060188872155136/st4Sp6Aw.jpg', 'default', ['class' => 'img-responsive', 'style' => 'width:100px;height:144px;']) !!}
											@else
												{!! HTML::image($detail['varian']['product']['thumbnail'], 'default', ['class' => 'img-responsive', 'style' => 'max-width:100px;']) !!}
											@endif
											</td>
											<td class="text-center">{{ $detail['varian']['product']['name'] }}</td>
											<td class="text-center">{{ $detail['varian']['size'] }}</td>
											<td class="text-center">{{ $detail['quantity'] }}</td>
											<td class="text-right">@money_indo($detail['price'])</td>
											<td class="text-right">@money_indo($detail['discount'])</td>
											<td class="text-right">@money_indo($detail['quantity'] * ($detail['price'] - $detail['discount']))</td>
										</tr>
									@endforeach
									<tr>
										<td colspan="6" class="text-right">
											<strong>Total Bayar</strong>
										</td>
										<td class="text-right">
											@money_indo($dt['amount'])
										</td>
									</tr>
								@endif
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- end of content -->
@stop
