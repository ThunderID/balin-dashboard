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
<!-- end of head -->

<!-- content -->
	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table table-hover">
					<thead>
						<tr>
							<th class="col-md-1 text-center">No.</th>
							<th class="col-md-3 text-center">Policy</th>
							<th class="col-md-3 text-center">Nilai</th>
							<th class="col-md-2 text-center">Tanggal</th>
							<th class="col-md-3 text-center">Kontrol</th>
						</tr>
					</thead>
					<tbody>
						@if(count($data['policy']['data']['data']) == 0)
							<tr>
								<td colspan="7" class="text-center">
									Tidak ada data
								</td>
							</tr>
						@else
							@foreach($data['policy']['data']['data'] as $key => $dt)
								<tr>
									<td class="text-center">
										{{ ($paging->perPage() * ($paging->currentPage() - 1)) + $key + 1}}
									</td>
									<td class="text-left">
										{{ str_replace('_', ' ', $dt['type']) }}
									</td>
									<td class="text-left">
										{{ $dt['value'] }}
									</td>
									<td class="text-center">
										@date_indo(new Carbon($dt['started_at']))
									</td>
									<td class="text-center">
										<a href="{{ route('config.policy.edit', $dt['id']) }}"> Edit</a>
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