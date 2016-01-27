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
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			@include('page_elements.alertbox')
		</div>
	</div>	

	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b-md">
			@include('page_elements.indexNavigation', [
				'newDataRoute' 		=> route('goods.price.create'),
				'newDataLabel'		=> 'Harga Baru',
				'filterDataRoute' 	=> route('goods.price.index'),
				'searchLabel'		=> 'Cari Nama Produk'
			])
			@include('page_elements.searchResult', [
				'closeSearchLink' 	=> route('goods.price.index') 
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
							<th class="text-center">
								No.
							</th>
							<th class="col-md-2 text-left">
								Thumbnail
							</th>
							<th class="col-md-3">
								Nama Produk
							</th>
							<th class="col-md-1 text-center">
								UPC
							</th>
							<th class="col-md-2 text-right">
								Harga
							</th>
							<th class="col-md-2 text-right">
								Harga Promo
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
							@foreach($data['product']['data']['data'] as $key => $dt)						
							<tr>
								<td class="text-left">
									{{ ($paging->perPage() * ($paging->currentPage() - 1)) + $key + 1}}
								</td>

								<td class="text-left">
									@if(is_null($dt['thumbnail']))
										{!! HTML::image('https://pbs.twimg.com/profile_images/600060188872155136/st4Sp6Aw.jpg', 'default', ['class' => 'img-responsive', 'style' => 'width:100px;height:144px;']) !!}
									@else
										{!! HTML::image($dt['thumbnail'], 'default', ['class' => 'img-responsive', 'style' => 'max-width:100px;']) !!}
									@endif									
								</td>

								<td class="text-left">
									{{ $dt['name'] }}
								</td>

								<td class="text-center">
									{{ $dt['upc'] }}
								</td>							

								<td class="text-right">
									 @money_indo($dt['price'])
								</td>								

								<td class="text-right">
									 @money_indo($dt['promo_price'])
								</td>

								<td class="text-center">
									<a href="{{ route('goods.price.show', ['productId' => $dt['id']]) }}"> Detail</a>
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