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
				'newDataRoute' 		=> route('admin.courier.create'),
				'filterDataRoute' 	=> route('admin.courier.index')
			])
			@include('pageElements.searchResult', [
				'closeSearchLink' => route('admin.courier.index') 
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
							<th class="text-center">No.</th>
							<th class="col-md-2 text-left">Logo</th>
							<th class="col-md-3">Nama</th>
							<th class="col-md-4 text-center">Alamat</th>
							<th class="col-md-2 text-center">Kontrol</th>
						</tr>
					</thead>
					<tbody>
						@if(count($data['courier']['data']) == 0)
							<tr>
								<td colspan="5" class="text-center">
									Tidak ada data
								</td>
							</tr>
						@else                                                                 
							@foreach($data['courier']['data'] as $key => $dt)
								<tr>
									<td class="text-center">
										{{ ($paging->perPage() * ($paging->currentPage() - 1)) + $key + 1}}
									</td>
									<td class="text-center">
										@if(is_null($dt['thumbnail']))
											{!! HTML::image('https://pbs.twimg.com/profile_images/600060188872155136/st4Sp6Aw.jpg', 'default', ['class' => 'img-responsive', 'style' => 'width:100px;height:144px;']) !!}
										@else
											{!! HTML::image($dt['thumbnail'], 'default', ['class' => 'img-responsive', 'style' => 'max-width:100px;']) !!}
										@endif
									</td>
									<td>{{ $dt['name'] }}</td>
									<td class="text-center">
										{{ $dt['current_address'] }} - {{ $dt['current_zipcode'] }}
										</br>
										<i class="fa fa-phone"></i> {{ $dt['current_phone'] }}
									</td>
									<td class="text-center">
										<a href="{{ route('admin.courier.show', $dt['id']) }}"> Detail</a>, 
										<a href="{{ route('admin.courier.edit', $dt['id']) }}"> Edit</a>, 
										<a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#courier_del"
											data-id="{{$dt['id']}}"
											data-title="Hapus Data Kurir {{$dt['name']}}"
											data-action="{{ route('admin.courier.destroy', $dt['id']) }}">
											Hapus
										</a>                                                                                      
									</td>    
								</tr>       
							@endforeach 
							
							@include('pageElements.modalDelete', [
									'modal_id'      => 'courier_del', 
									'modal_route'   => 'admin.courier.destroy'
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