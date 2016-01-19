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
				'newDataRoute' 		=> route('admin.product.create'),
				'filterDataRoute' 	=> route('admin.product.index')
			])
			@include('pageElements.searchResult', ['closeSearchLink' => route('admin.product.index') ])
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
							<th class="text-center">
								No.
							</th>
							<th class="col-md-2 text-left">
								Thumbnail
							</th>
							<th class="col-md-4">
								Nama Produk
							</th>
							<th class="col-md-2 text-center">
								UPC
							</th>
							<th class="col-md-2 text-center">
								Stok
							</th>
							<th class="text-center">
								Kontrol
							</th>							
						</tr>
					</thead>
					<tbody>
						@if(count($data['product']['data']['data']) == 0)
							<tr>
								<td colspan="7" class="text-center">
									Tidak ada data
								</td>
							</tr>
						@else                                                                 
							@foreach($data['product']['data']['data'] as $dt)
								<tr>
									<td class="text-center">
										no
									</td>
									<td>
										@if(is_null($dt['thumbnail']))
											{!! HTML::image('https://pbs.twimg.com/profile_images/600060188872155136/st4Sp6Aw.jpg', 'default', ['class' => 'img-responsive', 'style' => 'width:100px;height:144px;']) !!}
										@else
											{!! HTML::image($dt['thumbnail'], 'default', ['class' => 'img-responsive', 'style' => 'max-width:100px;']) !!}
										@endif
									</td>
									<td>
										{{ $dt['name'] }}
									</td>
									<td class="text-center">
										{{ $dt['upc'] }}
									</td>
									<td class="text-center">
										{{$dt['current_stock']}}
									</td>
									<td class="text-center">
										<a href="{{ route('admin.product.show', $dt['id']) }}"> Detail</a>,
										<a href="{{ route('admin.product.edit', $dt['id']) }}"> Edit</a>, 
										<a href="javascript:void(0);" data-backdrop="static" data-keyboard="false" data-toggle="modal" 
											data-target="#product_del"
											data-id="{{$dt['id']}}"
											data-title="Hapus Data Produk {{$dt['name']}}"
											data-action="{{ route('admin.product.destroy', $dt['id']) }}">
											Hapus
										</a>                                                                                      
									</td>    
								</tr>       
							@endforeach 

							@include('pageElements.modalDelete', [
									'modal_id'      => 'product_del', 
									'modal_route'   => route('admin.product.destroy')
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