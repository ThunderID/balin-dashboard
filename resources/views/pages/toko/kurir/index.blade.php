<?php
	dd($data['courier']['data']);
?>

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
							<th class="text-center">Logo</th>
							<th class="col-md-2 text-center">Nama</th>
							<th class="col-md-6 text-center">Alamat</th>
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
							@foreach($data['courier']['data'] as $dt)
								<tr>
									<td class="text-center">1</td>
									<td class="text-center"></td>
									<td>{{ $dt['name'] }}</td>
									<td>
										{{ $dt['address']['address'] }}
										</br>
										<i class="fa fa-phone"></i> {{ $dt['address']['phone'] }}
									</td>
									<td class="text-center">
										<a href="{{ route('admin.courier.show', $dt['id']) }}"> Detail</a>, 
										<a href="{{ route('admin.courier.edit', $dt['id']) }}"> Edit</a>, 
										<a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#courier_del"
											data-id="{{$dt['id']}}"
											data-title="Hapus Data Produk {{$dt['name']}}"
											data-action="{{ route('backend.settings.courier.destroy', $dt['id']) }}">
											Hapus
										</a>                                                                                      
									</td>    
								</tr>       
								<?php $ctr += 1; ?>                     
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
<!-- end of content -->

</div>
@stop