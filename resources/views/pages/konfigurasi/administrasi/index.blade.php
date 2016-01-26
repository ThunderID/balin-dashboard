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
										<a href="{{ route('admin.administrative.show', $dt['id']) }}"> Detail</a>,
										<a href="{{ route('admin.administrative.edit', $dt['id']) }}"> Edit</a>
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