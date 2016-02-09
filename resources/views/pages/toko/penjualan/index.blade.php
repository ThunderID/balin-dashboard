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
				'disabled' 			=> true,
				'newDataRoute' 		=> '/',
				'filterDataRoute' 	=> route('shop.sell.index'),
				'searchLabel' 		=> 'cari nomor nota',
				'filters'			=> $filters
			])
		</div>  
	</div>

	<div id="contentData">
		<div class="row">			
			@include('page_elements.searchResult', ['closeSearchLink' => route('shop.sell.index') ])
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
								<th class="col-md-2">
									Tanggal
								</th>
								<th class="col-md-2 text-left">
									No Nota
								</th>
								<th class="col-md-2">
									Nama Customer
								</th>
								<th class="col-md-2 text-center">
									Tagihan
								</th>
								<th class="col-md-1 text-center">
									Status
								</th>
								<th class="col-md-2 text-center">
									Kontrol
								</th>							
							</tr>
						</thead>
						<tbody>
							@if(count($data['sale']['data']['data']) == 0)
								<tr>
									<td colspan="7" class="text-center">
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
											@date_indo(new Carbon($dt['transact_at']))
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
											<a href="{{ route('shop.sell.show', $dt['id']) }}"> Detail</a>
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

