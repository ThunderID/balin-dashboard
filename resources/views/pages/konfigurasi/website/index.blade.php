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
					<li role="presentation" class="active">
						<a href="#slider" aria-controls="slider" role="tab" data-toggle="tab">Slider</a>
					</li>
					<li role="presentation">
						<a href="#toko" aria-controls="toko" role="tab" data-toggle="tab">Store Info</a>
					</li>
					@foreach($data['storepage']['data']['data'] as $key => $value)
						 <li role="presentation">
							<a href="#{{$value['type']}}" aria-controls="{{$value['type']}}" role="tab" data-toggle="tab">{{ucwords(str_replace('_', ' ', $value['type']))}}</a>
						</li>
					@endforeach
				</ul>
		<!-- end of nav tabs -->
			
		<!-- Tab panes -->
				<div class="tab-content">
			<!-- tab slider -->
					<div role="tabpanel" class="tab-pane active" id="slider">
						<div class="panel-group" id="accordionslider" style="margin-top:5px;">
							<div class="table-responsive">
								<table class="table table-bordered table-hover table-striped">
									<thead>
										<tr>
											<th class="text-center" colspan="3">Slider Baru</th>
										</tr>
									</thread>
									<tbody>									    								
									    {!! Form::open(['url' => route('config.website.store' , ['type' => 'slider'])]) !!}
									    <tr>
									    	<td class="col-md-6">
												<h4 class="m-t-sm">Link Gambar</h4>
												{!! Form::text('image', null, [
																'class'        		=> 'form-control', 
													]) !!}
											</td>
											<td class="col-md-4">
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
							<div class="table-responsive">
								<table class="table table-bordered table-hover table-striped">
									<thead>
										<tr>
											<th class="text-center" colspan="4">Data Slider</th>
										</tr>										
										<tr>
											<th class="col-md-6 text-center">Slider</th>
											<th class="col-md-2 text-center">Tanggal Tampil</th>
											<th class="col-md-2 text-center">Status</th>
											<th class="col-md-2 text-center">Kontrol</th>
										</tr>
									</thead>
									<tbody>									    								
										@forelse($data['slider']['data']['data'] as $key => $dt)
											{!! Form::open(['url' => route('config.website.update', ['id' => $dt['id'], 'image' => $dt['image']['thumbnail']] ), 'method' => 'PATCH']) !!}
												<tr>
													<td class="text-left">
														<h4 class="m-t-md">Link Gambar</h4>
														<p>{{$dt['image']['thumbnail']}}</p>
														<h4 class="m-t-md">Preview</h4>
														<img class="img img-responsive" src="{{$dt['image']['thumbnail']}}" alt="">
													</td>
													<td class="text-center">
														<h4 class="m-t-md text-left">Mulai</h4>
														<?php
															$date  = Carbon::createFromFormat('Y-m-d H:i:s', $dt['started_at'])->format('d-m-Y H:i');
															var_dump($dt['ended_at']);
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
														<a class="btn btn-danger" href="{{route('config.website.slider.delete', ['id' => $dt['id']] )}}">
															<i class="fa fa-times"></i>
														</a>
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
			<!-- end of tab slider -->

			<!-- tab toko -->
					<div role="tabpanel" class="tab-pane" id="toko">
						<div class="panel-group" id="accordionToko" style="margin-top:5px;">
							<div class="table-responsive">
								<table class="table table-bordered table-hover table-striped">
									<tbody>
										@forelse($data['storeinfo']['data']['data'] as $key => $dt)
										    {!! Form::open(['url' => route('config.website.update', $dt['id']), 'method' => 'PATCH']) !!}
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
					<div role="tabpanel" class="tab-pane" id="{{$value['type']}}">
						<div class="panel-group" id="accordion{{$value['type']}}" style="margin-top:5px;">
							{!! Form::open(['url' => route('config.website.update', $value['id']), 'method' => 'PATCH']) !!}
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