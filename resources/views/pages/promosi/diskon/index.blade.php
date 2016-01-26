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
				'newDataRoute' 		=> route('admin.product.create'),
				'filterDataRoute' 	=> route('admin.discount.index')
			])
			@include('pageElements.searchResult', ['closeSearchLink' => route('admin.discount.index') ])
		</div>
	</div>
	</br> 	
<!-- end of head -->

	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<table class="table table-bordered table-hover table-striped">
					<thead>
						<tr>
							<th class="col-md-1 text-center">
								No.
							</th>
							<th class="col-md-2 text-left">
								Thumbnail
							</th>
							<th class="col-md-2">
								Nama Produk
							</th>
							<th class="col-md-2 text-center">
								Harga Normal
							</th>
							<th class="col-md-2 text-center">
								Harga Promo
							</th>
							<th class="col-md-2 text-center">
								Diskon
							</th>
							<th class="col-md-1 text-center">
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
									<td class="text-center">
										{{ ($paging->perPage() * ($paging->currentPage() - 1)) + $key + 1}}
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
										@money_indo($dt['price'])
									</td>
									<td class="text-center">
										@money_indo($dt['promo_price'])
									</td>
									<td class="text-center">
										@money_indo($dt['price'] - $dt['promo_price'])
									</td>
									<td class="text-center">
										<a href="{{ route('admin.product.show', $dt['id']) }}"> Detail</a>
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