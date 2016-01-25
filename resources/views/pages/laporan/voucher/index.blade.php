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
			@include('pageElements.alertbox')
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b-md">
			@include('pageElements.indexNavigation', [
				'newDataRoute' 		=> route('admin.report.voucherusage'),
				'filterDataRoute' 	=> route('admin.report.voucherusage'),
				'searchLabel' 		=> 'dd-mm-yyyy to dd-mm-yyyy'
			])
			@include('pageElements.searchResult', ['closeSearchLink' => route('admin.report.voucherusage') ])
		</div>
	</div>
	</br> 	
<!-- end of head -->

<!-- content -->
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<table class="table table-bordered table-hover table-striped">
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
							<th class="col-md-1 text-center">
								Harga
							</th>
							<th class="col-md-1 text-center">
								Total
							</th>
							<th class="col-md-1 text-center">
								Ongkir
							</th>
							<th class="col-md-1 text-center">
								Potongan Point
							</th>
							<th class="col-md-1 text-center">
								Potongan Transfer
							</th>
							<th class="col-md-1 text-center">
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
									<td class="text-center">
										{{ ($paging->perPage() * ($paging->currentPage() - 1)) + $key + 1}}
									</td>
									<td class="text-left">
										{{ $dt['user']['name'] }}
									</td>
									<td class="text-left">
										@foreach($dt['transactiondetails'] as $detail)
											{{ $detail['varian']['product']['name'] }} (Size : {{ $detail['varian']['size'] }})
										@endforeach
									</td>
									<td class="text-center">
										@foreach($dt['transactiondetails'] as $detail)
											{{ $detail['quantity'] }}
										@endforeach
									</td>
									<td class="text-right">
										@foreach($dt['transactiondetails'] as $detail)
											@money_indo($detail['price'])
										@endforeach
									</td>
									<td class="text-right">
										@money_indo($dt['amount'])
									</td>
									<td class="text-right">
										@money_indo($dt['shipping_cost'])
									</td>
									<td class="text-right">
										@foreach($dt['paidpointlogs'] as $point)
											@money_indo(abs($point['amount']))
										@endforeach
									</td>
									<td class="text-right">
										@money_indo($dt['unique_number'])
									</td>
									<td class="text-right">
										@money_indo($dt['payment']['amount'])
									</td>
									<td class="text-center">
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
							@endforeach 
						@endif
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 hollow-pagination" style="text-align:right;">
			{!! $paging->appends(Input::all())->render() !!}
		</div>	
	</div>	
<!-- end of content -->

</div>
@stop
