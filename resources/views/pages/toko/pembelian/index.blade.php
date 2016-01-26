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
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<table class="table table-bordered table-hover table-striped">
					<thead>
						<tr>
							<th class="text-center">
								No.
							</th>
							<th class="col-md-2 text-left">
								#
							</th>
							<th class="col-md-4">
								Nama Customer
							</th>
							<th class="col-md-2 text-center">
								Tagihan
							</th>
							<th class="col-md-2 text-center">
								Status
							</th>
							<th class="text-center">
								Kontrol
							</th>							
						</tr>
					</thead>
					<tbody>
						@if(count($data['sale']['data']['data']) == 0)
							<tr>
								<td colspan="6" class="text-center">
									Tidak ada data
								</td>
							</tr>
						@else                                                                 
							@foreach($data['sale']['data']['data'] as $key => $dt)
								<tr>
									<td class="text-center">
										{{ ($paging->perPage() * ($paging->currentPage() - 1)) + $key + 1}}
									</td>
									<td>
										{{ $dt['ref_number'] }}
									</td>
									<td>
										{{ $dt['user']['name'] }}
									</td>
									<td class="text-right">
										@money_indo($dt['bills'])
									</td>
									<td class="text-center">
										{{$dt['status']}}
									</td>
									<td class="text-center">
										<a href="{{ route('admin.sell.show', $dt['id']) }}"> Detail</a>,
										<a href="{{ route('admin.sell.edit', $dt['id']) }}"> Edit</a> 
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
