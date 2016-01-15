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

	<!-- title sub-page -->
	<div class="row">
		<div class="col-md-12 m-b-md">
			<h2 style="margin-top:0px;">Detail Tag</h2>

			@include('pageElements.alertbox')
		</div>
	</div>
	<!-- end of title sub-page -->	
<!-- end of head -->

<!-- content -->
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b-md">
			<div class="row">
				<div class="col-md-12">
					<a class="btn btn-default pull-right"  href="{{ route('admin.tag.edit', ['id' => $data['id']] ) }}"> Edit Data </a>
				</div>
			</div>		

			<div class="row">
				<div class="col-md-5 col-sm-6 col-xs-11">
					<div class="row">

						<div class="col-md-6 col-sm-7 col-xs-5">
							<h4>Kelompok Tag</h4> 
						</div>
						<div class="col-md-1 col-sm-1 col-xs-2">
							<h4>:</h4> 
						</div>
						<div class="col-md-5 col-sm-3 col-xs-5">
							<h4>{{ isset($data['tag']['name']) ? $data['tag']['name'] : '_'  }}</h4> 
						</div>
					</div>
				</div>
			</div>	

			<div class="row">
				<div class="col-md-5 col-sm-6 col-xs-11">
					<div class="row">

						<div class="col-md-6 col-sm-7 col-xs-5">
							<h4>Nama Tag</h4> 
						</div>
						<div class="col-md-1 col-sm-1 col-xs-2">
							<h4>:</h4> 
						</div>
						<div class="col-md-5 col-sm-3 col-xs-5">
							<h4>{{ $data['name'] }}</h4> 
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-5 col-sm-6 col-xs-11">
					<div class="row">
						<div class="col-md-6 col-sm-7 col-xs-5">
							<h4>Jumlah Produk</h4> 
						</div>
						<div class="col-md-1 col-sm-1 col-xs-2">
							<h4>:</h4> 
						</div>
						<div class="col-md-5 col-sm-3 col-xs-5">
							<h4>{{ count($data['products']) }}</h4> 
						</div>
					</div>
				</div>
			</div>	
			<div class="row clearfix m-b-md">&nbsp;</div>
			<div class="row">
				<div class="col-md-12">
					<h4>Daftar Produk Dalam Label Ini</h4> 
				</div>
				<div class="col-md-12 m-t-sm m-b-lg">
					@include('pageElements.indexNavigation', [
						'newDataRoute' 		=> route('admin.product.create'),
						'filterDataRoute' 	=> route('admin.tag.show', ['id' => $data['id']])
					])	
					@include('pageElements.searchResult', [
						'closeSearchLink' 	=>  route('admin.tag.show', ['id' => $data['id']]) 
					])
				</div>		
				<div class="col-md-12">
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
								@if(count($data['products']) == 0)
									<tr>
										<td colspan="7" class="text-center">
											Tidak ada data
										</td>
									</tr>
								@else                                                                 
									@foreach($data['products'] as $ctr => $dt)
										<tr>
											<td class="text-center">{{ $ctr+1 }}</td>
											<td>
												{!! HTML::image($dt['thumbnail'], 'default', ['class' => 'img-responsive', 'style' => 'max-width:100px;']) !!}
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
		</div>
	</div>

<!-- end of content -->
@stop