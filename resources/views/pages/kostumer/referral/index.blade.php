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
			@include('page_elements.indexNavigation', [
				'disabled' 			=> true,
				'newDataRoute' 		=> '/',
				'filterDataRoute' 	=> route('customer.referral.index')
			])
			@include('page_elements.searchResult', [
				'closeSearchLink' 	=> route('customer.referral.index') 
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
							<th class="col-md-1 text-center">No.</th>
							<th class="col-md-2 text-center">Nama</th>
							<th class="col-md-2 text-center">Email</th>
							<th class="col-md-2 text-center">Total Referral</th>
							<th class="col-md-3 text-center">Referral</th>
							<th class="text-center col-md-2">Kontrol</th>
						</tr>
					</thead>
					<tbody>
						@if(count($data['customer']['data']['data']) == 0)
							<tr>
								<td colspan="11" class="text-center">
									Tidak ada data
								</td>
							</tr>
						@else
							@foreach($data['customer']['data']['data'] as $key => $dt)
								<tr>
									<td class="text-center">
										{{ ($paging->perPage() * ($paging->currentPage() - 1)) + $key + 1}}
									</td>
									<td class="text-left">
										{{ $dt['name'] }}
									</td>
									<td class="text-left">
										{{ $dt['email'] }}
									</td>
									<td class="text-center">
										{{ $dt['total_reference'] }}
									</td>
									<td class="text-center">
										@foreach($dt['myreferrals'] as $key => $value)
											<p>{{$value['user']['name']}}</p>
										@endforeach
									</td>
									<td class="text-center">
										<a href="{{ route('customer.customer.show', $dt['id']) }}"> Detail</a>
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