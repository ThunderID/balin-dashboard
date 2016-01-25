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
				'newDataRoute' 		=> route('admin.voucher.create'),
				'filterDataRoute' 	=> route('admin.voucher.index')
			])
			@include('pageElements.searchResult', [
				'closeSearchLink' 	=> route('admin.voucher.index') 
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
							<th class="col-md-2 text-center">Code</th>
							<th class="col-md-3 text-center">Masa Berlaku</th>
							<th class="col-md-2 text-center">Type</th>
							<th class="col-md-1 text-center">Nilai</th>
							<th class="col-md-1 text-center">Quota</th>
							<th class="col-md-2 text-center">Kontrol</th>
						</tr>
					</thead>
					<tbody>
						@if(count($data['voucher']['data']['data']) == 0)
							<tr>
								<td colspan="4" class="text-center">
									Tidak ada data
								</td>
							</tr>
						@else
							@foreach($data['voucher']['data']['data'] as $key => $dt)
								<tr>
									<td class="text-center">
										{{ ($paging->perPage() * ($paging->currentPage() - 1)) + $key + 1}}
									</td>
									<td class="text-left">
										{{ $dt['code'] }}
									</td>
									<td class="text-center">
										@datetime_indo(new Carbon($dt['started_at']))
										@datetime_indo(new Carbon($dt['expired_at']))
									</td>
									<td class="text-left">
										{{ str_replace('_', ' ', $dt['type']) }}
									</td>
									<td class="text-right">
										@money_indo($dt['value'])
									</td>
									<td class="text-right">
										{{ $dt['quota'] }}
									</td>
									<td class="text-center">
										<!-- <a href="{{ route('admin.voucher.show', $dt['id']) }}"> Detail</a>, -->
										<a href="{{ route('admin.voucher.edit', $dt['id']) }}"> Edit</a>, 
										<a href="javascript:void(0);" data-backdrop="static" data-keyboard="false" data-toggle="modal" 
											data-target="#voucher_del"
											data-id="{{$dt['id']}}"
											data-title="Hapus Data Voucher {{$dt['code']}}"
											data-action="{{ route('admin.voucher.destroy', $dt['id']) }}">
											Hapus
										</a>
									</td>    
								</tr>       
							@endforeach 

							@include('pageElements.modaldelete', [
									'modal_id'      => 'voucher_del', 
									'modal_route'   => route('admin.voucher.destroy')
							])						

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