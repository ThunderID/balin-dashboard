@extends('page_templates.layout')
@section('content')
<?php
	$from = Session::get('from');
?>
<div class="container-fluid">
<!-- head -->
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b-md border-bottom">
			@include('page_elements.pagetitle')
			@include('page_elements.breadcrumb')
		</div>
	</div>
<!-- end of head -->

<!-- content -->
	<!-- pekerjaan hari ini -->
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h3>Konfigurasi Website</h3>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			@include('page_elements.alertbox')
		</div>
	</div>

	<div class="row clearfix">
		&nbsp;
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b-xs">
			<div role="tabpanel">
		<!-- Nav tabs -->
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="{{ ($from == null || $from == 'banner') ? 'active' : '' }}">
						<a href="#banner" aria-controls="banner" role="tab" data-toggle="tab">Banner</a>
					</li>
					<li role="presentation" class="{{ ($from == 'ig') ? 'active' : '' }}">
						<a href="#instagram" aria-controls="instagram" role="tab" data-toggle="tab">Instagram</a>
					</li>
					<li role="presentation" class="{{ ($from == 'slider') ? 'active' : '' }}">
						<a href="#slider" aria-controls="slider" role="tab" data-toggle="tab">Slider</a>
					</li>
					<li role="presentation" class="{{ ($from == 'toko') ? 'active' : '' }}">
						<a href="#toko" aria-controls="toko" role="tab" data-toggle="tab">Store Info</a>
					</li>
					@foreach($data['storepage']['data']['data'] as $key => $value)
						 <li role="presentation" class="{{ ($from == $value['type']) ? 'active' : '' }}">
							<a href="#{{$value['type']}}" aria-controls="{{$value['type']}}" role="tab" data-toggle="tab">{{ucwords(str_replace('_', ' ', $value['type']))}}</a>
						</li>
					@endforeach
				</ul>
		<!-- end of nav tabs -->
			
		<!-- Tab panes -->
				<div class="tab-content">
					<!-- tab banner -->
					<div role="tabpanel" class="tab-pane {{ ($from == null || $from == 'banner') ? 'active' : '' }}" id="banner">
						<div class="panel-group" id="accordionbanner" style="margin-top:5px;">
							<h2>Banner Baru</h2>
							<div class="table-responsive">
								<table class="table">
									<tbody>									    								
									    {!! Form::open(['url' => route('config.website.store' , ['type' => 'banner', 'from' => 'banner'])]) !!}
									    <tr>
									    	<td class="col-md-4">
												<h4 class="m-t-sm">Link Gambar</h4>
												{!! Form::text('image', null, [
																'class'        		=> 'form-control', 
													]) !!}
											</td>
											<td class="col-md-4">
												<h4 class="m-t-sm">Caption</h4>
												{!! Form::text('caption', null, [
																'class'        		=> 'form-control', 
													]) !!}
											</td>
											<td class="col-md-4">
												<h4 class="m-t-sm text-left">Action</h4>
												{!! Form::text('url', null, [
																'class'        		=> 'form-control', 
													]) !!}
											</td>
										</tr>
										<tr>
									    	<td class="col-md-4">
												<h4 class="m-t-sm">Position</h4>
												{!! Form::text('position', null, [
																'class'        		=> 'form-control', 
													]) !!}
											</td>
											<td class="col-md-4">
												<h4 class="m-t-sm text-left">Mulai</h4>
												{!! Form::text('started_at', null, [
																'class'        		=> 'date-time-format form-control', 
													]) !!}
											</td>
											<td class="col-md-4 text-right">
												<h4 class="m-t-sm">&nbsp;</h4>
												<button type="submit" class="btn btn-md btn-primary" tabindex="3"><i class="fa fa-plus"></i> &nbsp; Tambah</button>
											</td>
											
										</tr>
									    {!! Form::close() !!}
									</tbody>
								</table>
							</div>

							<div class="row clearfix">
								&nbsp;
							</div>
							<h2>Data Banner</h2>
							<div class="table-responsive">
								<table class="table table-hover">
									<thead>										
										<tr>
											<th class="col-md-6 text-left">Banner</th>
											<th class="col-md-2 text-center">Tanggal Tampil</th>
											<th class="col-md-2 text-center">Status</th>
											<th class="col-md-2 text-center">Kontrol</th>
										</tr>
									</thead>
									<tbody>									    								
										@forelse($data['banner']['data']['data'] as $key => $dt)
											{!! Form::open(['url' => route('config.website.update', ['id' => $dt['id'], 'image' => $dt['thumbnail'], 'from' => 'banner'] ), 'method' => 'PATCH']) !!}
												<tr>
													<td class="text-left col-sm-6">
														<h4 class="m-t-md">Action Link</h4>
														<?php $image = json_decode($dt['value'], true);?>
														<p>{{isset($image['action_url']) ? $image['action_url'] : '' }}</p>
														<h4 class="m-t-md">Caption</h4>
														<p>{{isset($image['caption']) ? $image['caption'] : '' }}</p>
														<img class="img img-responsive col-sm-12" src="{{$dt['thumbnail']}}" alt="">
														<p><i>source : </i> {{$dt['thumbnail']}}</p>
													</td>
													<td class="text-center">
														<h4 class="m-t-md text-left">Mulai</h4>
														<?php
															$date  = Carbon::createFromFormat('Y-m-d H:i:s', $dt['started_at'])->format('d-m-Y H:i');
														?>
														{!! Form::text('started_at', $date, [
																		'class'        		=> 'date-time-format form-control', 
															]) !!}
													</td>													
													<td class="text-center">
														<h4 class="m-t-md">&nbsp;</h4>
														@if(strtotime($dt['started_at']) <= strtotime('now'))
															<h4 class="m-t-md" style="color:green;">
																Live
															</h4>
														@else
															<h4 class="m-t-md">
																Waiting
															</h4>
														@endif
													</td>
													<td class="text-center">
														<h4 class="m-t-md">&nbsp;</h4>
														<button type="submit" class="btn btn-md btn-primary" tabindex="3">Simpan</button>
														<a class="btn btn-danger" href="javascript:void(0);"  data-backdrop="static" data-keyboard="false" data-toggle="modal"
														data-target="#banner_del"
														data-id="{{$dt['id']}}"
														data-title="Hapus Data banner"
														data-action="{{  route('config.website.banner.delete', ['id' => $dt['id']] ) }}">	
															<i class="fa fa-times"></i>
														</a>
													</td>
												</tr>
										    {!! Form::close() !!}
											@include('page_elements.modaldelete', [
													'modal_id'      => 'banner_del', 
													'modal_route'   => route('config.website.banner.delete', ['id' => $dt['id']] )
											])											    
										@empty 
											<tr>
												<td colspan="4" class="text-center">
													Tidak ada data
												</td>
											</tr>
										@endforelse 
									</tbody>
								</table>
							</div>
						</div>
					</div>
			<!-- end of tab banner -->
			<!-- tab instagram -->
					<div role="tabpanel" class="tab-pane {{ ($from == 'ig') ? 'active' : '' }}" id="instagram">
						<div class="panel-group" id="accordioninstagram" style="margin-top:5px;">
							<h2>Instagram Baru</h2>
							<div class="table-responsive">
								<table class="table">
									<tbody>									    								
									    {!! Form::open(['url' => route('config.website.store' , ['type' => 'banner_instagram', 'from' => 'ig'] )]) !!}
									    <tr>
									    	<td class="col-md-4">
												<h4 class="m-t-sm">Link Gambar</h4>
												{!! Form::text('image', null, [
																'class'        		=> 'form-control', 
													]) !!}
											</td>
											<td class="col-md-4">
												<h4 class="m-t-sm text-left">Action</h4>
												{!! Form::text('url', null, [
																'class'        		=> 'form-control', 
													]) !!}
											</td>
											<td class="col-md-2">
												<h4 class="m-t-sm text-left">Mulai</h4>
												{!! Form::text('started_at', null, [
																'class'        		=> 'date-time-format form-control', 
													]) !!}
											</td>
											<td class="col-md-2 text-center">
												<h4 class="m-t-sm">&nbsp;</h4>
												<button type="submit" class="btn btn-md btn-primary" tabindex="3"><i class="fa fa-plus"></i> &nbsp; Tambah</button>
											</td>
										</tr>
									    {!! Form::close() !!}
									</tbody>
								</table>
							</div>

							<div class="row clearfix">
								&nbsp;
							</div>
							<h2>Data Instagram</h2>
							<div class="table-responsive">
								<table class="table table-hover">
									<thead>										
										<tr>
											<th class="col-md-6 text-left">Instagram</th>
											<th class="col-md-2 text-center">Tanggal Tampil</th>
											<th class="col-md-2 text-center">Status</th>
											<th class="col-md-2 text-center">Kontrol</th>
										</tr>
									</thead>
									<tbody>									    								
										@forelse($data['instagram']['data']['data'] as $key => $dt)
											{!! Form::open(['url' => route('config.website.update', ['id' => $dt['id'], 'image' => $dt['thumbnail'] , 'from' => 'ig' ] ), 'method' => 'PATCH']) !!}
												<tr>
													<td class="text-left col-sm-6">
														<h4 class="m-t-md">Action Link</h4>
														<?php $image = json_decode($dt['value'], true);?>
														<p>{{isset($image['action']) ? $image['action'] : '' }}</p>
														<img class="img img-responsive col-sm-12" src="{{$dt['thumbnail']}}" alt="">
														<p><i>source : </i> {{$dt['thumbnail']}}</p>
													</td>
													<td class="text-center">
														<h4 class="m-t-md text-left">Mulai</h4>
														<?php
															$date  = Carbon::createFromFormat('Y-m-d H:i:s', $dt['started_at'])->format('d-m-Y H:i');
														?>
														{!! Form::text('started_at', $date, [
																		'class'        		=> 'date-time-format form-control', 
															]) !!}
													</td>													
													<td class="text-center">
														<h4 class="m-t-md">&nbsp;</h4>
														@if(strtotime($dt['started_at']) <= strtotime('now'))
															<h4 class="m-t-md" style="color:green;">
																Live
															</h4>
														@else
															<h4 class="m-t-md">
																Waiting
															</h4>
														@endif
													</td>
													<td class="text-center">
														<h4 class="m-t-md">&nbsp;</h4>
														<button type="submit" class="btn btn-md btn-primary" tabindex="3">Simpan</button>
														<a class="btn btn-danger" href="javascript:void(0);"  data-backdrop="static" data-keyboard="false" data-toggle="modal"
														data-target="#instagram_del"
														data-id="{{$dt['id']}}"
														data-title="Hapus Data instagram"
														data-action="{{  route('config.website.banner.delete', ['id' => $dt['id']] ) }}">	
															<i class="fa fa-times"></i>
														</a>
													</td>
												</tr>
										    {!! Form::close() !!}
											@include('page_elements.modaldelete', [
													'modal_id'      => 'instagram_del', 
													'modal_route'   => route('config.website.banner.delete', ['id' => $dt['id']] )
											])											    
										@empty 
											<tr>
												<td colspan="4" class="text-center">
													Tidak ada data
												</td>
											</tr>
										@endforelse 
									</tbody>
								</table>
							</div>
						</div>
					</div>
			<!-- end of tab instagram -->
			<!-- tab slider -->
					<div role="tabpanel" class="tab-pane {{ ($from == 'slider') ? 'active' : '' }}" id="slider">
						<div class="panel-group" id="accordionslider" style="margin-top:5px;">
							<h2>Slider Baru</h2>
							<div class="table-responsive">
								<table class="table">
									<tbody>									    								
									    {!! Form::open(['url' => route('config.website.store' , ['type' => 'slider', 'from' => 'slider']) ]) !!}
									    <tr>
									    	<td class="col-md-4">
												<h4 class="m-t-sm">Link Gambar</h4>
												{!! Form::text('image', null, [
																'class'        		=> 'form-control', 
													]) !!}
											</td>
											<td class="col-md-4">
												<h4 class="m-t-sm text-left">Action</h4>
												{!! Form::text('url', null, [
																'class'        		=> 'form-control', 
													]) !!}
											</td>
											<td class="col-md-2">
												<h4 class="m-t-sm text-left">Mulai</h4>
												{!! Form::text('started_at', null, [
																'class'        		=> 'date-time-format form-control', 
													]) !!}
											</td>
											<td class="col-md-2 text-center">
												<h4 class="m-t-sm">&nbsp;</h4>
												<button type="submit" class="btn btn-md btn-primary" tabindex="3"><i class="fa fa-plus"></i> &nbsp; Tambah</button>
											</td>
										</tr>
									    {!! Form::close() !!}
									</tbody>
								</table>
							</div>

							<div class="row clearfix">
								&nbsp;
							</div>
							<h2>Data Slider</h2>
							<div class="table-responsive">
								<table class="table table-hover">
									<thead>										
										<tr>
											<th class="col-md-6 text-left">Slider</th>
											<th class="col-md-2 text-center">Tanggal Tampil</th>
											<th class="col-md-2 text-center">Status</th>
											<th class="col-md-2 text-center">Kontrol</th>
										</tr>
									</thead>
									<tbody>									    								
										@forelse($data['slider']['data']['data'] as $key => $dt)
											{!! Form::open(['url' => route('config.website.update', ['id' => $dt['id'], 'image' => $dt['thumbnail'], 'from' => 'slider'] ), 'method' => 'PATCH']) !!}
												<tr>
													<td class="text-left col-sm-6">
														<h4 class="m-t-md">Action Link</h4>
														<?php $image = json_decode($dt['value'], true);?>
														<p>{{isset($image['button']['slider_button_url']) ? $image['button']['slider_button_url'] : '' }}</p>
														<img class="img img-responsive col-sm-12" src="{{$dt['thumbnail']}}" alt="">
														<p><i>source : </i> {{$dt['thumbnail']}}</p>
													</td>
													<td class="text-center">
														<h4 class="m-t-md text-left">Mulai</h4>
														<?php
															$date  = Carbon::createFromFormat('Y-m-d H:i:s', $dt['started_at'])->format('d-m-Y H:i');
														?>
														{!! Form::text('started_at', $date, [
																		'class'        		=> 'date-time-format form-control', 
															]) !!}
													</td>													
													<td class="text-center">
														<h4 class="m-t-md">&nbsp;</h4>
														@if(strtotime($dt['started_at']) <= strtotime('now'))
															<h4 class="m-t-md" style="color:green;">
																Live
															</h4>
														@else
															<h4 class="m-t-md">
																Waiting
															</h4>
														@endif
													</td>
													<td class="text-center">
														<h4 class="m-t-md">&nbsp;</h4>
														<button type="submit" class="btn btn-md btn-primary" tabindex="3">Simpan</button>
														<a class="btn btn-danger" href="javascript:void(0);"  data-backdrop="static" data-keyboard="false" data-toggle="modal"
														data-target="#slider_del"
														data-id="{{$dt['id']}}"
														data-title="Hapus Data Slider"
														data-action="{{  route('config.website.slider.delete', ['id' => $dt['id']] ) }}">	
															<i class="fa fa-times"></i>
														</a>
													</td>
												</tr>
										    {!! Form::close() !!}
											@include('page_elements.modaldelete', [
													'modal_id'      => 'slider_del', 
													'modal_route'   => route('config.website.slider.delete', ['id' => $dt['id']] )
											])											    
										@empty 
											<tr>
												<td colspan="4" class="text-center">
													Tidak ada data
												</td>
											</tr>
										@endforelse 
									</tbody>
								</table>
							</div>
						</div>
					</div>
			<!-- end of tab slider -->

			<!-- tab toko -->
					<div role="tabpanel" class="tab-pane {{ ($from == 'toko') ? 'active' : '' }}" id="toko">
						<div class="panel-group" id="accordionToko" style="margin-top:5px;">
							<div class="table-responsive">
								<table class="table table-hover">
									<tbody>
										@forelse($data['storeinfo']['data']['data'] as $key => $dt)
										    {!! Form::open(['url' => route('config.website.update', ['id' => $dt['id'], 'from' => 'toko']), 'method' => 'PATCH']) !!}
												<tr>
													<td class="text-left">
														{{ucwords(str_replace('_', ' ', $dt['type']))}}
													</td>
													@if($dt['type']=='bank_information')
													<td class="text-center">
															{!! Form::textarea('value', $dt['value'], [
																		'class'        		=> 'summernote form-control', 
															]) !!}
													</td>
													@else
													<td class="text-center">
															{!! Form::text('value', $dt['value'], [
																		'class'        		=> 'form-control', 
															]) !!}
													</td>
													@endif
													<td class="text-center">
														<button type="submit" class="btn btn-md btn-primary" tabindex="3">Simpan</button>
													</td>
												</tr>
										    {!! Form::close() !!}
										@empty 
											<tr>
												<td colspan="4" class="text-center">
													Tidak ada data
												</td>
											</tr>
										@endforelse 
									</tbody>
								</table>
							</div>
						</div>
					</div>
			<!-- end of tab toko -->

			<!-- tab {{$value['type']}} -->
				@foreach($data['storepage']['data']['data'] as $key => $value)
					<div role="tabpanel" class="tab-pane {{ ($from == $value['type']) ? 'active' : '' }}" id="{{$value['type']}}">
						<div class="panel-group" id="accordion{{$value['type']}}" style="margin-top:5px;">
							{!! Form::open(['url' => route('config.website.update', ['id' => $value['id'], 'from' => $value['type']] ), 'method' => 'PATCH']) !!}
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											{!! Form::textarea('value', $value['value'], [
														'class'        		=> 'summernote form-control', 
											]) !!}
										</div>
										<div class="form-group text-right">
											<button type="submit" class="btn btn-md btn-primary" tabindex="3">Simpan</button>
										</div>
									</div>
								</div>
						    {!! Form::close() !!}
						</div>
					</div>
				@endforeach
			<!-- end of tab {{$value['type']}} -->

				</div>
		<!-- end of tab panes -->

			</div>
		</div>
	</div>
	<!-- end of pekerjaan hari ini -->

<!-- end of content -->
</div>
@stop


@section('script_plugin')
	@include('plugins.summerNote')
	@include('plugins.inputMask')
@stop