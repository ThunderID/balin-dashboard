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
			@include('page_elements.indexNavigation', [
				'newDataRoute' 		=> route('config.administrative.create'),
				'filterDataRoute' 	=> route('config.administrative.index'),
				'searchLabel' 		=> 'cari nama',
				'filters'			=> $filters,
			])
		</div>
	</div>

	<div id="contentData">
		<div class="row">			
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b-md">				
				@include('page_elements.searchResult', ['closeSearchLink' => route('config.administrative.index') ])
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
								<th class="col-md-3 text-center">Nama</th>
								<th class="col-md-3 text-center">Email</th>
								<th class="col-md-2 text-center">Role</th>
								<th class="col-md-3 text-center">Kontrol</th>
							</tr>
						</thead>
						<tbody>
							@if(count($data['admin']['data']['data']) == 0)
								<tr>
									<td colspan="7" class="text-center">
										Tidak ada data
									</td>
								</tr>
							@else
								@foreach($data['admin']['data']['data'] as $key => $dt)
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
											{{ str_replace('_', ' ', $dt['role']) }}
										</td>
										<td class="text-center">
											<a href="{{ route('config.administrative.show', $dt['id']) }}"> Detail</a>,
											<a href="{{ route('config.administrative.edit', $dt['id']) }}"> Edit</a>
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
		</div>	
<!-- end of content -->

	</div>
</div>
@stop