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
				'newDataRoute' 		=> route('admin.customer.create'),
				'filterDataRoute' 	=> route('admin.customer.index')
			])
			@include('pageElements.searchResult', [
				'closeSearchLink' 	=> route('admin.customer.index') 
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
							<th class="col-md-2 text-center">Kode Referral</th>
							<th class="col-md-1 text-center">Total Reference</th>
							<th class="col-md-2 text-center">Total Poin</th>
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
									<td class="text-left">
										{{ $dt['code_referral'] }}
									</td>
									<td class="text-center">
										{{ $dt['total_reference'] }}
									</td>
									<td class="text-right">
										@money_indo($dt['total_point'])
									</td>
									<td class="text-right">
										<a href="{{ route('admin.customer.show', $dt['id']) }}"> Detail</a>
									</td>
								</tr>
							@endforeach 
						@endif
				
					</tbody>
				</table>
			</div>
		</div>
	</div>
<!-- end of content -->

</div>
@stop