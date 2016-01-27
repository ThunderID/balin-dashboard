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
			<h2 style="margin-top:0px;">Detail Kurir</h2>

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
					<a class="btn btn-default pull-right"  href="{{ route('admin.courier.edit', ['id' => $data['courier']['id']] ) }}"> Edit Data </a>
				</div>
			</div>			

			<div class="row">
				<div class="col-md-6 col-sm-5">
					<div class="row m-b-md m-t-md">
						<div class="col-md-6">
							@if(is_null($data['courier']['thumbnail']))
								{!! HTML::image('https://pbs.twimg.com/profile_images/600060188872155136/st4Sp6Aw.jpg', 'default', ['class' => 'img-responsive']) !!}
							@else
								{!! HTML::image($data['courier']['thumbnail'], 'default', ['class' => 'img-responsive']) !!}
							@endif						
						</div>
					</div>
				</div>
				<div class="col-md-6 col-sm-7 product-info">
					<div class="row">
						<div class="col-md-12">
							<h2 style="margin-top:0px;">{{ ucwords($data['courier']['name']) }}</h2>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3 col-sm-4 col-xs-5">
							<h4>No. Telepon</h4> 
						</div>
						<div class="col-md-1 col-sm-1 col-xs-2">
							<h4>:</h4> 
						</div>
						<div class="col-md-8 col-sm-7 col-xs-5">
							<h4>{{ $data['courier']['current_phone'] }}</h4> 
						</div>
					</div>
					<div class="row">
						<div class="col-md-3 col-sm-4 col-xs-5">
							<h4>Kode Pos</h4> 
						</div>
						<div class="col-md-1 col-sm-1 col-xs-2">
							<h4>:</h4> 
						</div>
						<div class="col-md-8 col-sm-7 col-xs-5">
							<h4>{{ $data['courier']['current_zipcode'] }}</h4> 
						</div>
					</div>					
					<div class="row">
						<div class="col-md-3 col-sm-4 col-xs-5">
							<h4>Alamat</h4> 
						</div>
						<div class="col-md-1 col-sm-1 col-xs-2">
							<h4>:</h4> 
						</div>
						<div class="col-md-8 col-sm-7 col-xs-5">
							<h4>{{ $data['courier']['current_address'] }}</h4> 
						</div>
					</div>
				</div>		
			</div>

			<div class="row clearfix m-b-md">&nbsp;</div>

			<div class="row">
				<div class="col-md-12">
					<h3>Data Pengiriman</h3>
				</div>
			</div>	

			<div class="row">
				<div class="col-md-12">
					<div class="table-responsive">
						</br>
						<table class="table table-bordered table-hover table-striped">
							<thead>
								<tr>
									<th class="text-center">No</th>
									<th class="text-center">Nomor Resi</th>
									<th class="text-center">Nota Transaksi</th>
									<th class="text-center">Tanggal Kirim</th>
									<th class="text-center col-md-2">Kontrol</th>
								</tr>
							</thead>	
							<tbody>
								@if (count($data['recents']) == 0)
									<tr>
										<td colspan="5">
											<p class="text-center">Tidak ada data</p>
										</td>
									</tr>
								@else
									@foreach($data['recents'] as $ctr => $recent)
										<td class="text-center">{{ $ctr+1 }}</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
									@endforeach
								@endif	
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- end of content	 -->
@stop