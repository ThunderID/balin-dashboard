<?php
	$dt = $data['product']['data'];
?>

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

	<!-- title sub-page -->
	<div class="row">
		<div class="col-md-12 m-b-md">
			<h2 style="margin-top:0px;">Data Produk</h2>

			@include('page_elements.alertbox')
		</div>
	</div>
	<!-- end of title sub-page -->

<!-- end of head -->

<!-- content -->
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b-md">
			<div class="row">
				<div class="col-md-12">
					<a class="btn btn-default pull-right m-l-sm"  href="{{ route('goods.price.show', ['pid' => $dt['id']]) }}"> Manage Harga </a>	
					<a class="btn btn-default pull-right"  href="{{ route('goods.product.edit', ['id' => $dt['id']] ) }}"> Edit Data </a>
				</div>
				<div class="hidden-lg hidden-md col-sm-12 col-xs-12 m-b-md">
				</div>				
			</div>			
			<div class="row">
				<div class="col-md-6 m-b-md">
					<div class="row">
						<div class="col-md-offset-10 col-md-2">
							<a href="javascript:clickNext();"><i class="fa fa-angle-right fa-lg pull-right"></i></a>
							&nbsp;
							<a href="javascript:clickPrev();"><i class="fa fa-angle-left fa-lg pull-right"></i></a>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="owl-carousel gallery-product">
								@foreach ($dt['images'] as $i => $img)
									<img class="img img-responsive canvasSource hidden galery" src="{{$img['image_xs']}}" alt="">
								@endforeach
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-6 product-info">
					<div class="row">
						<div class="col-md-12">
							<h2 style="margin-top:0px;">{{ ucwords($dt['name']) }}</h2>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12 col-sm-6 col-xs-11">
							<div class="row">
								<div class="col-md-3 col-sm-7 col-xs-5">
									<h4>UPC</h4> 
								</div>
								<div class="col-md-1 col-sm-1 col-xs-2">
									<h4>:</h4> 
								</div>
								<div class="col-md-8 col-sm-3 col-xs-5">
									<h4>{{ $dt['upc'] }}</h4> 
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12 col-sm-6 col-xs-11">
							<div class="row">
								<div class="col-md-3 col-sm-7 col-xs-5">
									<h4>Harga</h4> 
								</div>
								<div class="col-md-1 col-sm-1 col-xs-2">
									<h4>:</h4> 
								</div>
								<div class="col-md-8 col-sm-3 col-xs-5">
									<h4>
										@money_indo($dt['price'])
									</h4>
								</div>
							</div>
						</div>
					</div>		

					<div class="row">
						<div class="col-md-12 col-sm-6 col-xs-11">
							<div class="row">
								<div class="col-md-3 col-sm-7 col-xs-5">
									<h4>Harga Promo</h4> 
								</div>
								<div class="col-md-1 col-sm-1 col-xs-2">
									<h4>:</h4> 
								</div>
								<div class="col-md-8 col-sm-3 col-xs-5">
									<h4>@money_indo($dt['promo_price'])</h4> 
								</div>
							</div>
						</div>
					</div>								
							
					<div class="row">
						<div class="col-md-12 col-sm-6 col-xs-11">
							<div class="row">
								<div class="col-md-3 col-sm-7 col-xs-5">
									<h4>Label</h4> 
								</div>
								<div class="col-md-1 col-sm-1 col-xs-2">
									<h4>:</h4> 
								</div>
								<div class="col-md-8 col-sm-3 col-xs-5">
									@foreach($dt['labels'] as $lable)
						                <label class="label label-default">{{ str_replace('_', ' ', ucfirst($lable['lable'] ) )}}</label>
									@endforeach
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12 col-sm-6 col-xs-11">
							<div class="row">
								<div class="col-md-3 col-sm-7 col-xs-5">
									<h4>Kategori</h4> 
								</div>
								<div class="col-md-1 col-sm-1 col-xs-2">
									<h4>:</h4> 
								</div>
								<div class="col-md-8 col-sm-3 col-xs-5">
									@foreach($dt['categories'] as $category)
						                <label class="label label-default">{{ str_replace('_', ' ', ucfirst($category['name'] ) )}}</label>
									@endforeach									
								</div>
							</div>
						</div>
					</div>		

					<div class="row">
						<div class="col-md-12 col-sm-6 col-xs-11">
							<div class="row">
								<div class="col-md-3 col-sm-7 col-xs-5">
									<h4>Tag</h4> 
								</div>
								<div class="col-md-1 col-sm-1 col-xs-2">
									<h4>:</h4> 
								</div>
								<div class="col-md-8 col-sm-3 col-xs-5">
									@foreach($dt['tags'] as $tag)
						                <label class="label label-default">{{ str_replace('_', ' ', ucfirst($tag['slug'] ) )}}</label>
									@endforeach									
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>

			<div class="row clearfix m-b-md">&nbsp;</div>

			<div class="row">
				<div class="col-md-12">
					<h3>Stok Produk</h3>
				</div>
			</div>

			<div class="row">
				<div class="col-md-3">
					<div class="panel panel-list panel-default">
						<div class="panel-heading">Stok Display</div>
						<div class="panel-body">
							<h4 class="m-r-sm m-t-sm text-right">
								@if($dt['current_stock'])
									{!! $dt['current_stock'] !!}
								@else
									0
								@endif
							</h4>
						</div>
					</div>
				</div>

				<div class="col-md-3">
					<div class="panel panel-list panel-default">
						<div class="panel-heading">Stok Gudang</div>
						<div class="panel-body">
							<h4 class="m-r-sm m-t-sm text-right">
								@if($dt['inventory_stock'])
									{!! $dt['inventory_stock'] !!}
								@else
									0
								@endif
							</h4>
						</div>
					</div>
				</div>

				<div class="col-md-3">
					<div class="panel panel-list panel-default">
						<div class="panel-heading">Stok Dibayar</div>
						<div class="panel-body">
							<h4 class="m-r-sm m-t-sm text-right">
								@if($dt['reserved_stock'])
									{!! $dt['reserved_stock'] !!}
								@else
									0
								@endif						
							</h4>
						</div>
					</div>
				</div>

				<div class="col-md-3">
					<div class="panel panel-list panel-default">
						<div class="panel-heading">Stok Dipesan</div>
						<div class="panel-body">
							<h4 class="m-r-sm m-t-sm text-right">
								@if($dt['on_hold_stock'])
									{!! $dt['on_hold_stock'] !!}
								@else
									0
								@endif						
							</h4>
						</div>
					</div>
				</div>		
			</div>		

			<div class="row clearfix m-b-sm">&nbsp;</div>

			<div class="row">
				<div class="col-md-12">
					<h3>Ukuran Produk</h3>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<a class="btn btn-default" href="{{ route('goods.varian.create', ['pid' => $dt['id']] ) }}"><i class="fa fa-plus"></i>&nbsp;Ukuran Baru</a>
					<div class="table-responsive">
						</br>
						<table class="table table-hover">
							<thead>
								<tr>
									<th class="text-center">No</th>
									<th class="text-center">Ukuran</th>
									<th class="text-center">SKU</th>
									<th class="text-center">Stok Display</th>
									<th class="text-center">Stok Gudang</th>
									<th class="text-center">Stok Dibayar</th>
									<th class="text-center">Stok Dipesan</th>
									<th class="text-center col-md-2">Kontrol</th>
								</tr>
							</thead>
							<tbody>
								@if (count($dt['varians']) == 0)
									<tr>
										<td colspan="8">
											<p class="text-center">Tidak ada data</p>
										</td>
									</tr>
								@else
									@foreach($dt['varians'] as $ctr => $product)
										<tr>
											<td class="text-center">{{ $ctr+1 }}</td>
											<td class="text-center">{{ $product['size'] }}</td>
											<td class="text-center">{{ $product['sku'] }}</td>
											<td class="text-center">{{ $product['current_stock'] }}
											</td>
											<td class="text-center">{{ $product['inventory_stock'] }}</td>
											<td class="text-center">{{ $product['reserved_stock'] }}</td>
											<td class="text-center">{{ $product['on_hold_stock'] }}</td>
											<td class="text-center"> 
												<a href="{{ route( 'goods.varian.show', ['pid' => $dt['id'] , 'id' => $product['id']] ) }}"> Detail</a>,
												<a href="{{ route( 'goods.varian.edit', ['pid' => $dt['id'] , 'id' => $product['id']] ) }}"> Edit</a>,
												<a href="javascript:void(0);" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#var_del"
													data-id="{{$product['id']}}"
													data-title="Hapus Varian Ukuran {{$product['size']}}"
													data-action="{{ route('goods.varian.destroy', ['pid' => $dt['id'], 'id' => $product['id']]) }}">
													Hapus
												</a> 												
											</td>
										</tr>
									@endforeach
									@include('page_elements.modaldelete', [
											'modal_id'      => 'var_del', 
											'modal_route'   => route('goods.varian.destroy', 0)
									])									
								@endif
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- end of content -->
@stop

@section('scripts')
	$(document).ready(function() {
		$('.galery').attr("class","img img-responsive canvasSource");
		$('.galery').hide().fadeIn('slow');
	});

	function clickNext() {
		$('#car-btn-next').trigger("click");
	}

	function clickPrev() {
		$('#car-btn-prev').trigger("click");
	}
@append

@section('script_plugin')
	@include('plugins.owlCarousel')
@stop