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
			@include('pageElements.indexNavigation', [
				'newDataRoute' 		=> route('admin.point.create'),
				'filterDataRoute' 	=> route('admin.point.index')
			])
			@include('pageElements.searchResult', [
				'closeSearchLink' 	=> route('admin.point.index') 
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
							<th class="col-md-4 text-center">Nama Customer</th>
							<th class="col-md-2 text-center">Expire</th>
							<th class="col-md-2 text-center">Jumlah Poin</th>
							<th class="text-center col-md-3">Notes</th>
						</tr>
					</thead>
					<tbody>
						@if(count($data['point']['data']['data']) == 0)
							<tr>
								<td colspan="5" class="text-center">
									Tidak ada data
								</td>
							</tr>
						@else
							@foreach($data['point']['data']['data'] as $key => $dt)
								<tr>
									<td class="text-center">
										{{ ($paging->perPage() * ($paging->currentPage() - 1)) + $key + 1}}
									</td>
									<td class="text-left">
										{{ $dt['user']['name'] }}
									</td>
									<td class="text-left">
										@datetime_indo(new Carbon($dt['expired_at']))
									</td>
									<td class="text-right">
										@money_indo($dt['amount'])
									</td>
									<td class="text-right">
										{{$dt['notes']}}
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