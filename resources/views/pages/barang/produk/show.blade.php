<?php
	$dt = $data['product']['data'];
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
<!-- end of head -->

<!-- content -->
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b-md">
			<div class="row">
				<div class="col-md-12">
					<h3>Data Produk</h3>
				</div>
			</div>			
			<div class="row">
				<div class="col-md-6">
					<div class="row">
						<div class="col-md-10">
						</div>
						<div class="col-md-2">
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
							<h5>
								<strong>UPC</strong> 
								{{ $dt['upc'] }}
							</h5> 							
							<h5>
								<strong>Harga</strong> 
								@money_indo($dt['price'])
								<span><a href="{{ route('admin.price.show', ['pid' => $dt['id']]) }}">[ Histori Harga ]</a></span>
							</h5> 
							<h5><strong>Harga Promo</strong> @money_indo($dt['price'])</h5>
							<h5><strong>Label &nbsp;</strong>
								@foreach($dt['labels'] as $lable)
					                <label class="label label-success">{{ str_replace('_', ' ', ucfirst($lable['lable'] ) )}}</label> &nbsp;
								@endforeach
							</h5>
							</br>
							<h5>
								<i class = "fa fa-folder"></i>
								@foreach($dt['categories'] as $key => $value)
									@if($key!=0)
										,
									@endif
									<a href="{{route('backend.settings.category.show', $value['id'])}}">{!! $value['name'] !!}</a>
								@endforeach
								<br/>
								<br/>
								<i class = "fa fa-tags"></i>
								@foreach($dt['tags'] as $key => $value)
									@if($key!=0)
										,
									@endif
									<a href="{{route('backend.settings.tag.show', $value['id'])}}">{!! $value['name'] !!}</a>
								@endforeach
							</h5>
							</br>
						</div>
					</div>
				</div>
			</div>

			<div class="row clearfix m-b-md">&nbsp;</div>

			<div class="row">
				<div class="col-md-12">
					<h3>Varian Produk</h3>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<a class="btn btn-default" href="#">Varian Baru</a>
					<div class="table-responsive">
						</br>
						<table class="table table-bordered table-hover table-striped">
							<thead>
								<tr>
									<th class="text-center">No</th>
									<th class="text-center">Ukuran</th>
									<th class="text-center">Stok Display</th>
									<th class="text-center">Stok Gudang</th>
									<th class="text-center">Stok Dibayar</th>
									<th class="text-center">Stok Dipesan</th>
									<th class="text-center">Kontrol</th>
								</tr>
							</thead>
							<tbody>
								@if (count($dt['varians']) == 0)
									<tr>
										<td colspan="7">
											<p class="text-center">Tidak ada data</p>
										</td>
									</tr>
								@else
									@foreach($dt['varians'] as $ctr => $product)
										<tr>
											<td class="text-center">{{ $ctr+1 }}</td>
											<td class="text-left">{{ $product['size'] }} <br/> [SKU {{ $product['sku']  }}]</td>
											<td class="text-right">{{ $product['current_stock'] }}
												@if($product['current_stock'] < $stock->value && $data->varians()->count())
												<br/>
												<a href="{{ route('backend.data.transaction.create', ['type' => 'buy']) }}">Stok Barang</a>
												@endif
											</td>
											<td class="text-right">{{ $product['inventory_stock'] }}</td>
											<td class="text-right">{{ $product['reserved_stock'] }}</td>
											<td class="text-right">{{ $product['on_hold_stock'] }}</td>
											<td class="text-center"> 
												<a href="{{ route('backend.data.product.varian.show', ['pid' => $id, 'id' => $product['id'] ]) }}"> Detail</a>,
												<a href="{{ route('backend.data.product.varian.edit', ['pid' => $id, 'id' => $product['id'] ]) }}"> Edit</a>,
												
												<a href="javascript:void(0);" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#var_del"
													data-id="{{$data['id']}}"
													data-title="Hapus Data Produk Varian {{$product['size']}}"
													data-action="{{ route('backend.data.product.varian.destroy', ['pid' => $id, 'id' => $product['id']]) }}">
													Hapus
												</a> 								  
											</td>
										</tr>
									@endforeach
									@include('widgets.pageelements.formmodaldelete', [
											'modal_id'      => 'var_del', 
											'modal_route'   => route('backend.data.product.varian.destroy', 0)
									])					
								@endif
							</tbody>
						</table>
					</div>
				</div>
			</div>

			<div class="row clearfix">&nbsp;</div>

			<div class="row">
				<div class="col-md-12">
					<h3>Data Supplier</h3>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					@if(!isset($suppliers[0]))
						<p class="m-l-sm m-t-sm text-left">Tidak ada supplier</p>
					@else
						<ul>
						@foreach($suppliers as $key => $value)
							<li>
								{!! $value['supplier_name'] !!} <a href="{{route('backend.data.supplier.show', $value['supplier_id'])}}"> detail </a>
							</li>
						@endforeach
						</ul>
					@endif
				</div>
			</div>

		</div>
	</div>
<!-- end of content -->
@stop

@section('scripts')
	$(document).ready(function() {
		$('.galery').hide().fadeIn('slow');
		$('.galery').attr("class","img img-responsive canvasSource");
	});

	function clickNext() {
		$('#car-btn-next').trigger("click");
	}

	function clickPrev() {
		$('#car-btn-prev').trigger("click");
	}
@stop

@section('script_plugin')
	@include('plugins.owlCarousel')
@stop