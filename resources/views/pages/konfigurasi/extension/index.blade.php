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
				'newDataRoute' 		=> route('config.extension.create'),
				'filterDataRoute' 	=> route('config.extension.index'),
				'filters'			=> [],
				'sorts'				=> $sorts,
			])
		</div>
	</div>

	<div id="contentData">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b-md">
				@include('page_elements.searchResult', [
					'closeSearchLink' => route('config.extension.index') 
				])
			</div>  
		</div>
		</br> 	
<!-- end of head -->

<!-- content -->
		<div class="row">
			<div class="col-lg-12">
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th class="text-center">No.</th>
								<th class="col-md-2 text-left">Preview</th>
								<th class="col-md-3">Nama</th>
								<th class="col-md-3 text-center">Harga</th>
								<th class="col-md-1 text-center">Active</th>
								<th class="col-md-2 text-center">Kontrol</th>
							</tr>
						</thead>
						<tbody>
							@if(count($data['extension']['data']) == 0)
								<tr>
									<td colspan="6" class="text-center">
										Tidak ada data
									</td>
								</tr>
							@else                                                                 
								@foreach($data['extension']['data'] as $key => $dt)
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
											@money_indo($dt['price'])
										</td>
										<td class="text-center">
											@if($dt['is_active'])
												<i class="fa fa-check"></i>
											@endif
										</td>
										<td class="text-center">
											<a href="{{ route('config.extension.show', $dt['id']) }}"> Detail</a>, 
											<a href="{{ route('config.extension.edit', $dt['id']) }}"> Edit</a>, 
											<a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#extension_del"
												data-id="{{$dt['id']}}"
												data-title="Hapus Data Produk Extension {{$dt['name']}}"
												data-action="{{ route('config.extension.destroy', $dt['id']) }}">
												Hapus
											</a>                                                                                      
										</td>    
									</tr>       
								@endforeach 
								
								@include('page_elements.modaldelete', [
										'modal_id'      => 'extension_del', 
										'modal_route'   => 'config.extension.destroy'
								])
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