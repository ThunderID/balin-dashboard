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
			<h2 style="margin-top:0px;">Detail Kurir</h2>

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
					<a class="btn btn-default pull-right"  href="{{ route('shop.courier.edit', ['id' => $data['courier']['id']] ) }}"> Edit Data </a>
				</div>
			</div>			

			<div class="row">
				<div class="col-md-6 col-sm-5">
					<div class="row m-b-md m-t-md">
						<div class="col-md-6">
							@if(is_null($data['courier']['thumbnail']))
								{!! HTML::image('https://pbs.twimg.com/profile_images/600060188872155136/st4Sp6Aw.jpg', 'default', ['class' => 'img-responsive']) !!}
							@else
								{!! HTML::image($data['courier']['thumbnail'], 'default', ['class' => 'img-responsive']) !!}
							@endif						
						</div>
					</div>
				</div>
				<div class="col-md-6 col-sm-7 product-info">
					<div class="row">
						<div class="col-md-12">
							<h2 style="margin-top:0px;">{{ ucwords($data['courier']['name']) }}</h2>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3 col-sm-4 col-xs-5">
							<h4>No. Telepon</h4> 
						</div>
						<div class="col-md-1 col-sm-1 col-xs-2">
							<h4>:</h4> 
						</div>
						<div class="col-md-8 col-sm-7 col-xs-5">
							<h4>{{ $data['courier']['current_phone'] }}</h4> 
						</div>
					</div>
					<div class="row">
						<div class="col-md-3 col-sm-4 col-xs-5">
							<h4>Kode Pos</h4> 
						</div>
						<div class="col-md-1 col-sm-1 col-xs-2">
							<h4>:</h4> 
						</div>
						<div class="col-md-8 col-sm-7 col-xs-5">
							<h4>{{ $data['courier']['current_zipcode'] }}</h4> 
						</div>
					</div>					
					<div class="row">
						<div class="col-md-3 col-sm-4 col-xs-5">
							<h4>Alamat</h4> 
						</div>
						<div class="col-md-1 col-sm-1 col-xs-2">
							<h4>:</h4> 
						</div>
						<div class="col-md-8 col-sm-7 col-xs-5">
							<h4>{{ $data['courier']['current_address'] }}</h4> 
						</div>
					</div>
				</div>		
			</div>

			<div class="row clearfix m-b-md">&nbsp;</div>

			<div class="row">
				<div class="col-md-12 m-b-sm">
					<h3>Data Ongkos Kirim</h3>
				</div>
			</div>	

			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b-md">
					@include('page_elements.indexNavigation', [
						'newDataRoute' 		=> route('shop.courier.shippingcost.create', ['id' => $data['courier']['id'] ]),
						'filterDataRoute' 	=> route('shop.courier.index'),
						'newDataLabel'		=> "Import Data Ongkos Kirim",
						'searchLabel' 		=> 'cari kode pos',
						'filters'			=> []
					])
				</div>  
			</div>

			<div id="contentData">
				<div class="row">	
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						@include('page_elements.searchResult', ['closeSearchLink' => route('shop.sell.index') ])
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							</br>
							<table class="table table-bordered table-hover table-striped">
								<thead>
									<tr>
										<th class="text-center">No</th>
										<th class="text-center">Range Kode Pos</th>
										<th class="text-center">Biaya Pengiriman</th>
									</tr>
								</thead>	
								<tbody>
									@if (count($data['courier']['shippingcosts']) == 0)
										<tr>
											<td colspan="5">
												<p class="text-center">Tidak ada data</p>
											</td>
										</tr>
									@else
										@foreach($data['courier']['shippingcosts'] as $ctr => $cost)
										<tr>
											<td class="text-center">
												{{ ($paging->perPage() * ($paging->currentPage() - 1)) + $ctr + 1}}
											</td>
											<td class="text-center">{{ $cost['start_postal_code'] }} - {{ $cost['end_postal_code'] }}</td>
											<td class="text-center">@money_indo($cost['cost'])</td>
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
<!-- end of content	 -->
@stop