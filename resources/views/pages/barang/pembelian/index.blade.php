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
				'newDataRoute' 		=> route('shop.buy.create'),
				'filterDataRoute' 	=> route('shop.buy.index'),
				'searchLabel' 		=> 'cari nomor nota',
				'filters'			=> ['titles' => ['periode']],
				'sorts'				=> $sorts,
			])
		</div>
	</div>


	<div id="contentData">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b-md">
				@include('page_elements.searchResult', ['closeSearchLink' => route('shop.buy.index') ])
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
								<th class="col-md-2">
									Tanggal
								</th>
								<th class="col-md-2 text-left">
									No Nota
								</th>
								<th class="col-md-2">
									Nama Supplier
								</th>
								<th class="col-md-2 text-center">
									Total
								</th>
								<th class="col-md-2 text-center">
									Status
								</th>
								<th class="col-md-1 text-center">
									Kontrol
								</th>							
							</tr>
						</thead>
						<tbody>
							@if(count($data['purchase']['data']['data']) == 0)
								<tr>
									<td colspan="6" class="text-center">
										Tidak ada data
									</td>
								</tr>
							@else                                                                 
								@foreach($data['purchase']['data']['data'] as $key => $dt)
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
											{{ $dt['supplier']['name'] }}
										</td>
										<td class="text-right">
											@money_indo($dt['amount'])
										</td>
										<td class="text-center">
											{{$dt['status']}}
										</td>
										<td class="text-center">
											<a href="{{ route('shop.buy.show', $dt['id']) }}"> Detail</a>,
											<a href="{{ route('shop.buy.edit', $dt['id']) }}"> Edit</a> 
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
