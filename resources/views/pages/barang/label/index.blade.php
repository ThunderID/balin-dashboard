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
			@include('page_elements.indexNavigation', [
				'disabled'			=> 'false',
				'newDataRoute' 		=> '/',
				'filterDataRoute' 	=> route('goods.label.index'),
			])			
			@include('page_elements.searchResult', ['closeSearchLink' => route('goods.label.index') ])
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
							<th class="col-md-1">No.</th>							
							<th>Nama Tag</th>
							<th class="text-center col-md-2">Kontrol</th>
						</tr>
					</thead>                            
					<tbody>
						@if(count($data['data']) == 0)
							<tr>
								<td colspan="6" class="text-center">
									Tidak ada data
								</td>
							</tr>
						@else                                                                                           
							@foreach ($data['data'] as $key => $dt)
								<tr>
									<td>
										{{ ($paging->perPage() * ($paging->currentPage() - 1)) + $key + 1}}
									</td>
									<td class="col-md-10">
										<p class="text-capitalize">
											{{$dt['name']}}
										</p>
									</td>
									<td class="text-center">
										<a href="{{ route('goods.label.show',  $dt['id']) }}"> Detail</a>                                                                              
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