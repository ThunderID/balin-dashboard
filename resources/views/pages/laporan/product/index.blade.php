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
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b-md">
			@include('page_elements.indexNavigation', [
				'newDataRoute' 		=> route('admin.report.soldproduct'),
				'filterDataRoute' 	=> route('admin.report.soldproduct'),
				'searchLabel' 		=> 'dd-mm-yyyy to dd-mm-yyyy'
			])
			@include('page_elements.searchResult', ['closeSearchLink' => route('admin.report.soldproduct') ])
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
							<th class="col-md-4 text-center">
								Nama Barang
							</th>
							<th class="col-md-3 text-center">
								Size
							</th>
							<th class="col-md-4 text-center">
								Item Terjual
							</th>
						</tr>
					</thead>
					<tbody>
						@if(count($data['report']['data']['data']) == 0)
							<tr>
								<td colspan="4" class="text-center">
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
										{{ $dt['product']['name'] }}
									</td>
									<td class="text-center">
										{{ $dt['size'] }}
									</td>
									<td class="text-center">
										{{ $dt['sold_item'] }}
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
