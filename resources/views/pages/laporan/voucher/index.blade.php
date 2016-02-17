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
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b-md">
			@include('page_elements.alertbox')
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			@include('page_elements.navigationDateAndSearch')
			

		</div>
	</div>

	<div id="contentData">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b-md">			
			</div>
		</div>
		</br> 
<!-- end of head -->

<!-- content -->
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="table-responsive">
					<table class="table ">
						<thead>
							<tr>
								<th class="col-md-1 text-center">
									No.
								</th>
								<th class="col-md-1 text-left">
									Nama Pembeli
								</th>
								<th class="col-md-2">
									Nama Barang
								</th>
								<th class="col-md-1 text-center">
									Qty
								</th>
								<th class="col-md-1 text-right">
									Harga
								</th>
								<th class="col-md-1 text-right">
									Total
								</th>
								<th class="col-md-1 text-right">
									Ongkir
								</th>
								<th class="col-md-1 text-right">
									Potongan Point
								</th>
								<th class="col-md-1 text-right">
									Potongan Transfer
								</th>
								<th class="col-md-1 text-right">
									Total Bayar
								</th>
								<th class="col-md-1 text-center">
									Kode Voucher
								</th>
							</tr>
						</thead>
						<tbody>
							@if(count($data['report']['data']['data']) == 0)
								<tr>
									<td colspan="11" class="text-center">
										Tidak ada data
									</td>
								</tr>
							@else
								@foreach($data['report']['data']['data'] as $key => $dt)
									<tr>
										<td class="text-center" rowspan="{{ count($dt['transactiondetails']) }}">
											{{ ($paging->perPage() * ($paging->currentPage() - 1)) + $key + 1}}
										</td>
										<td class="text-left" rowspan="{{ count($dt['transactiondetails']) }}">
											{{ $dt['user']['name'] }}
										</td>
										<td class="text-left">
											{{ $dt['transactiondetails'][0]['varian']['product']['name'] }} (Size : {{ $dt['transactiondetails'][0]['varian']['size'] }})
										</td>
										<td class="text-center">
											{{ $dt['transactiondetails'][0]['quantity'] }}
										</td>
										<td class="text-right">
											@money_indo($dt['transactiondetails'][0]['price'])
										</td>
										<td class="text-right" rowspan="{{ count($dt['transactiondetails']) }}">
											@money_indo($dt['amount'])
										</td>
										<td class="text-right" rowspan="{{ count($dt['transactiondetails']) }}">
											@money_indo($dt['shipping_cost'])
										</td>
										<td class="text-right" rowspan="{{ count($dt['transactiondetails']) }}">
											@foreach($dt['paidpointlogs'] as $point)
												@money_indo(abs($point['amount']))
											@endforeach
										</td>
										<td class="text-right" rowspan="{{ count($dt['transactiondetails']) }}">
											@money_indo($dt['unique_number'])
										</td>
										<td class="text-right" rowspan="{{ count($dt['transactiondetails']) }}">
											@money_indo($dt['payment']['amount'])
										</td>
										<td class="text-center" rowspan="{{ count($dt['transactiondetails']) }}">
											@foreach($dt['paidpointlogs'] as $point)
												@if(isset($point['referencepointvoucher']))
													{{$point['referencepointvoucher']['referencevoucher']['code']}}
												@elseif(isset($point['referencepointreferral']))
													{{$point['referencepointreferral']['referencereferral']['code_referral']}}
												@else
													<br/>
												@endif
											@endforeach
										</td>
									</tr>    

									@for ($x = 1; $x < count($dt['transactiondetails']); $x++)
									<tr>
										<td class='text-left'>
											{{ $dt['transactiondetails'][$x]['varian']['product']['name'] }} (Size : {{ $dt['transactiondetails'][$x]['varian']['size'] }})
										</td>
										<td class='text-center'>
											{{ $dt['transactiondetails'][$x]['quantity'] }}
										</td>
										<td class='text-right'>
											@money_indo($dt['transactiondetails'][$x]['price'])
										</td>
									</tr>
									@endfor									
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
