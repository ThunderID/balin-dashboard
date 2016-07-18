<?php
	$dt = $data['sale']['data'];
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
					<p><strong>{{$dt['user']['name']}}</strong> telah melakukan pesanan, sebagai berikut :</p>
				</div>
			</div>

			<div class="row m-b-md">
				<div class="col-md-12">
					<div class="table-responsive">
						</br>
						<table class="table">
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
										<td colspan="6">
											<strong>Biaya Kurir</strong> {{$dt['shipment']['courier']['name']}}
										</td>
										<td class="text-right">
											@money_indo($dt['shipping_cost'])
										</td>
									</tr>
									<tr>
										<td colspan="6">
											<strong>Potongan</strong> Point BALIN
										</td>
										<td class="text-right text-red">
											@money_indo($dt['point_discount'])
										</td>
									</tr>
									<tr>
										<td colspan="6">
											<strong>Potongan</strong> Voucher {{$dt['voucher']['code']}}
										</td>
										<td class="text-right text-red">
											@money_indo($dt['voucher_discount'])
										</td>
									</tr>
									<tr>
										<td colspan="6">
											<strong>Pengenal Pembayaran</strong>
										</td>
										<td class="text-right text-red">
											@money_indo($dt['unique_number'])
										</td>
									</tr>
									<tr>
										<td colspan="6">
											<strong>Biaya</strong>
											@foreach($dt['transactionextensions'] as $key => $value)
												<br/> {{$value['productextension']['name']}}
											@endforeach
										</td>
										<td class="text-right">
											@money_indo($dt['extend_cost'])
										</td>
									</tr>
									<tr>
										<td colspan="6">
											<strong>Pembayaran</strong> {{$dt['payment']['method']}} {{$dt['payment']['destination']}}
										</td>
										<td class="text-right text-red">
											@money_indo($dt['payment']['amount'])
										</td>
									</tr>
									<tr>
										<td colspan="6">
											<strong>Jumlah</strong> yang harus dibayarkan
										</td>
										<td class="text-right">
											@money_indo($dt['bills'])
										</td>
									</tr>
								@endif
							</tbody>
						</table>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-3">
					<h3>Alamat Tujuan</h3>
					@if($dt['shipment']['receiver_name'])
						<h5>{{$dt['shipment']['receiver_name']}}</h5>
						<p>{{$dt['shipment']['address']['address']}}</p>
						<p>{{$dt['shipment']['address']['zipcode']}}</p>
						<p><i class="fa fa-phone"></i> {{$dt['shipment']['address']['phone']}}</p>
					@else
						<h5>Tidak ada data</h5>
					@endif
				</div>

				<div class="col-md-3">
					<h3>Data Pembayaran</h3>
					@if($dt['payment']['amount'])
						<h5>{{$dt['payment']['method']}} {{$dt['payment']['destination']}}</h5>
						<h5>@money_indo($dt['payment']['amount'])</h5>
						<p><strong>a.n.</strong> {{$dt['payment']['account_name']}}</p>
						<p><strong>No.rek</strong> {{$dt['payment']['account_number']}}</p>
						<p><strong>Tanggal</strong> @date_indo(new Carbon($dt['payment']['ondate']))</p>
					@else
						<h5>Transaksi belum dibayar</h5>
					@endif
				</div>

				<div class="col-md-3">
					<h3>Data Pengiriman</h3>
					@if($dt['shipment']['receipt_number'])
						<h5>{{$dt['shipment']['courier']['name']}}</h5>
						<p>{{$dt['shipment']['receipt_number']}}</p>
					@else
						<h5>Barang belum dikirim</h5>
					@endif
				</div>

				<div class="col-md-3">
					<h3>Histori</h3>
					@foreach($dt['transactionlogs'] as $key => $value)
						<p><strong>{{$value['status']}}</strong>&nbsp;&nbsp;&nbsp; @date_indo(new Carbon($value['changed_at'])) &nbsp; @if(in_array($value['status'], ['wait', 'payment_process', 'paid', 'shipping', 'delivered', 'canceled'])) <a href="{{route('shop.resend.email', ['id' => $value['transaction_id'], 'status' => $value['status']])}}">[ Resend Email ]</a> @endif</p>
					@endforeach
				</div>
			</div>

		</div>
	</div>
<!-- end of content -->
@stop
