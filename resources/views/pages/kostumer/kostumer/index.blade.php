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
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			@include('page_elements.indexNavigation', [
				'disabled'			=> true,
				'newDataRoute' 		=> '/',
				'filterDataRoute' 	=> route('customer.customer.index'),
				'searchLabel' 		=> 'cari nama',
				'filters'			=> []
			])
		</div>
	</div>

	<div id="contentData">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b-md">			
				@include('page_elements.searchResult', [
					'closeSearchLink' 	=> route('customer.customer.index') 
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
									<td colspan="7" class="text-center">
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
			@include('page_elements.ajaxPaging')
		</div>	
<!-- end of content -->

	</div>
</div>
@stop