@extends('page_templates.layout')
@section('content')
<div class="container-fluid">

{{-- Head --}}
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b-md border-bottom">
			@include('page_elements.pagetitle')
			@include('page_elements.breadcrumb')
		</div>
	</div>
{{-- End of head --}}

{{-- Content --}}
	{{-- Pekerjaan hari ini --}}
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h3>Pekerjaan Hari Ini</h3>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b-md">
			@include('page_elements.alertbox')
		</div>
	</div>	

	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b-xs">
			<div role="tabpanel">
		{{-- Nav tabs --}}
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active">
						<a href="#toko" id="trig_toko" aria-controls="toko" role="tab" data-toggle="tab">
							Toko ({{$data['shipped']['count'] + $data['packed']['count'] + $data['paid']['count'] + $data['wait']['count']}})
						</a>
					</li>
					<li role="presentation">
						<a href="#barang" id="trig_barang" aria-controls="barang" role="tab" data-toggle="tab">
							Barang ({{$data['warehouse']['count']}})
						</a>
					</li>
					 <li role="presentation">
						<a href="#laporan" id="trig_laporan" aria-controls="tab" role="tab" data-toggle="tab">
							Laporan (0)
						</a>
					</li>
					<li role="presentation">
						<a href="#pengaturan" id="trig_pengaturan" aria-controls="tab" role="tab" data-toggle="tab">
							Pengaturan (0)
						</a>
					</li>
					<li role="presentation">
						<a href="#customer" id="trig_customer" aria-controls="tab" role="tab" data-toggle="tab">
							Customer (0)
						</a>
					</li>
					<li role="presentation">
						<a href="#promosi" id="" aria-controls="tab" role="tab" data-toggle="tab">
							Promosi (0)
						</a>
					</li>                    
				</ul>
		{{-- End of nav tabs --}}

		{{-- Tab panes --}}
				<div class="tab-content">
			{{-- Toko --}}
					<div role="tabpanel" class="tab-pane active" id="toko">
						<div class="panel-group" style="margin-top:5px;">

				{{-- Validasi bayar --}}
							<div class="panel panel-default dahboard-list">
								<a data-toggle="collapse" data-target="#collapse_toko_1">
									<div class="panel-heading">
										<h4 class="panel-title">
											Validasi Bayar ({{$data['wait']['count']}})
										</h4>
									</div>
								</a>
								<div id="collapse_toko_1" class="collapse {{$data['wait']['count'] > 0?'in':'yes'}}">
		                            <table class="table table-hover">
		                                <tbody>
											@forelse($data['wait']['data'] as $key => $value)
												<tr>
			                                        <td class="col-xs-1" style="padding-left: 25px !important;">
			                                            {{ $key + 1 }}
			                                        </td>
			                                        <td>
														<p>[{{$value['ref_number']}}] {{$value['user']['name']}}</p>
														<p>@money_indo($value['amount'])</p>
			                                        </td>
			                                        <td class="col-xs-1"><a href="{{route('shop.pay.create', ['id' => $value['id']])}}">Validasi</a></td>
			                                    </tr>
											@empty
												<tr>
			                                        <td class="col-xs-1 text-center" style="padding-left: 25px !important;">
			                                            Tidak ada pekerjaan untuk sekarang.
			                                        </td>
			                                    </tr>
											@endforelse
		                                </tbody>
		                            </table> 
								</div>
							</div>
				{{-- End of validasi bayar --}}


				{{-- Packing --}}
							<div class="panel panel-default dahboard-list">
								<a data-toggle="collapse" data-target="#collapse_toko_2">
									<div class="panel-heading">
										<h4 class="panel-title">
											Packing ({{$data['paid']['count']}})
										</h4>
									</div>
								</a>
								<div id="collapse_toko_2" class="collapse {{ ($data['paid']['count'] > 0)?'in':'' }}">
		                            <table class="table table-hover">
		                                <tbody>
											@forelse($data['paid']['data'] as $key => $value)
												<tr>
			                                        <td class="col-xs-1" style="padding-left: 25px !important;">
			                                            {{ $key + 1 }}
			                                        </td>
			                                        <td>
														<p>[{{$value['ref_number']}}] {{$value['user']['name']}}</p>
														<p>{{ $value['product_notes'] }}</p>
			                                        </td>
			                                        <td class="col-xs-1"><a href="{{route('shop.packing.create', ['id' => $value['id']])}}">Kerjakan</a></td>
			                                    </tr>
											@empty
												<tr>
			                                        <td class="col-xs-1 text-center" style="padding-left: 25px !important;">
			                                            Tidak ada pekerjaan untuk sekarang.
			                                        </td>
			                                    </tr>
											@endforelse
		                                </tbody>
		                            </table> 
								</div>
							</div>
				{{-- End of packing --}}

				{{-- Kirim --}}
							<div class="panel panel-default dahboard-list">
								<a data-toggle="collapse" href="#collapse_toko_3">
									<div class="panel-heading">
										<h4 class="panel-title">
											Kirim Barang ({{$data['packed']['count']}})
										</h4>
									</div>
								</a>
								<div id="collapse_toko_3" class="collapse {{ ($data['packed']['count'] > 0)?'in':'' }}">
		                            <table class="table table-hover">
		                                <tbody>
											@forelse($data['packed']['data'] as $key => $value)
												<tr>
			                                        <td class="col-xs-1" style="padding-left: 25px !important;">
			                                            {{ $key + 1 }}
			                                        </td>
			                                        <td>
														<p>[{{$value['ref_number']}}] {{$value['user']['name']}}</p>
														<p>{{ $value['address_notes'] }}</p>
			                                        </td>
			                                        <td class="col-xs-1"><a href="{{route('shop.shipping.create', ['id' => $value['id']])}}">Kirim Barang</a></td>
			                                    </tr>
											@empty
												<tr>
			                                        <td class="col-xs-1 text-center" style="padding-left: 25px !important;">
			                                            Tidak ada pekerjaan untuk sekarang.
			                                        </td>
			                                    </tr>
											@endforelse
		                                </tbody>
		                            </table> 
								</div>
							</div>
				{{-- End of kirim --}}

				{{-- Barang diterima --}}
							<div class="panel panel-default dahboard-list">
								<a data-toggle="collapse"  href="#collapse_toko_4">
									<div class="panel-heading">
										<h4 class="panel-title">
											Validasi barang diterima ({{$data['shipped']['count']}})
										</h4>
									</div>
								</a>
								<div id="collapse_toko_4" class="panel-collapse collapse {{ ($data['shipped']['count'] > 0)?'in':'' }}">
		                            <table class="table table-hover">
		                                <tbody>
											@forelse($data['shipped']['data'] as $key => $value)
												<tr>
			                                        <td class="col-xs-1" style="padding-left: 25px !important;">
			                                            {{ $key + 1 }}
			                                        </td>
			                                        <td>
														<p>[{{$value['ref_number']}}] {{$value['user']['name']}}</p>
														<p>No. Resi Pengiriman : {{$value['shipping_notes']}}</p>
			                                        </td>
			                                        <td class="col-xs-1"><a href="{{route('shop.completeorder.create', ['id' => $value['id']])}}">Validasi</a></td>
			                                    </tr>
											@empty
												<tr>
			                                        <td class="col-xs-1 text-center" style="padding-left: 25px !important;">
			                                            Tidak ada pekerjaan untuk sekarang.
			                                        </td>
			                                    </tr>
											@endforelse
		                                </tbody>
		                            </table> 
								</div>
							</div>		
				{{-- End of barang diterima --}}

						</div>
					</div>
			{{-- End of tab toko --}}

			{{-- Tab barang --}}
					<div role="tabpanel" class="tab-pane" id="barang">
						<div class="panel-group" style="margin-top:5px;">

				{{-- Restock barang --}}
							<div class="panel panel-default dahboard-list">
								<a data-toggle="collapse" href="#collapse_barang_1">
									<div class="panel-heading">
										<h4 class="panel-title">
											Re-Stok Produk ({{$data['warehouse']['count']}})
										</h4>
									</div>
								</a>
								<div id="collapse_barang_1" class="collapse {{ ($data['warehouse']['count'] > 0)?'in':'' }}">
		                            <table class="table table-hover">
		                                <tbody>
											@forelse($data['warehouse']['data'] as $key => $value)
												<tr>
			                                        <td class="col-xs-1" style="padding-left: 25px !important;">
			                                            {{ $key + 1 }}
			                                        </td>
			                                        <td>
			                                            {{$value['product']['name']}}
			                                        </td>
			                                        <td class="col-xs-1">
			                                        	<a href="{{route('shop.buy.create', ['pid' => $value['product_id'], 'vid' => $value['id'], 'ref' => 'dashboard'])}}">
			                                        		Kerjakan
			                                        	</a>
			                                        </td>
												</tr>
											@empty
												<tr>
			                                        <td class="col-xs-1 text-center" style="padding-left: 25px !important;">
			                                            Tidak ada pekerjaan untuk sekarang.
			                                        </td>
			                                    </tr>
											@endforelse
		                                </tbody>
		                            </table> 
								</div>
							</div>
				{{-- End of restock barang --}}

						</div>
					</div>
			{{-- End of tab barang --}}

			{{-- Tab laporan --}}
					<div role="tabpanel" class="tab-pane" id="laporan">
						<div class="panel-group" style="margin-top:5px;">

				{{-- None --}}
							<div class="panel panel-default dahboard-list">
	                            <table class="table table-hover">
	                                <tbody>
										<tr>
		                                    <td class="col-xs-1 text-center" style="padding-left: 25px !important;">
		                                        Tidak ada pekerjaan untuk sekarang.
		                                    </td>
		                                </tr>
		                            </tbody>
		                         </table>                                	
							</div>
				{{-- End of none --}}

						</div>
					</div>
			{{-- End of tab laporan --}}

			{{-- Tab pengaturan --}}
					<div role="tabpanel" class="tab-pane" id="pengaturan">
						<div class="panel-group" style="margin-top:5px;">

				{{-- None --}}
							<div class="panel panel-default dahboard-list">
	                            <table class="table table-hover">
	                                <tbody>
										<tr>
		                                    <td class="col-xs-1 text-center" style="padding-left: 25px !important;">
		                                        Tidak ada pekerjaan untuk sekarang.
		                                    </td>
		                                </tr>
		                            </tbody>
		                         </table> 
							</div>
				{{-- End of none --}}

						</div>
					</div>
			{{-- End of tab pengaturan --}}

			{{-- Tab customer --}}
					<div role="tabpanel" class="tab-pane" id="customer">
						<div class="panel-group" style="margin-top:5px;">

				{{-- None --}}
							<div class="panel panel-default dahboard-list">
	                            <table class="table table-hover">
	                                <tbody>
										<tr>
		                                    <td class="col-xs-1 text-center" style="padding-left: 25px !important;">
		                                        Tidak ada pekerjaan untuk sekarang.
		                                    </td>
		                                </tr>
		                            </tbody>
		                        </table> 
							</div>
				{{-- End of none --}}

						</div>
					</div>
			{{-- End of tab customer --}}

			{{-- Tab promosi --}}
					<div role="tabpanel" class="tab-pane" id="promosi">
						<div class="panel-group" style="margin-top:5px;">

				{{-- None --}}
							<div class="panel panel-default dahboard-list">
	                            <table class="table table-hover">
	                                <tbody>
										<tr>
		                                    <td class="col-xs-1 text-center" style="padding-left: 25px !important;">
		                                        Tidak ada pekerjaan untuk sekarang.
		                                    </td>
		                                </tr>
		                            </tbody>
		                         </table> 
	                        </div>
				{{-- End of none --}}

						</div>
					</div>	
			{{-- End of tab promosi --}}

				</div>
		{{-- End of tab panes --}}

			</div>
		</div>
	</div>
	{{-- End of pekerjaan hari ini --}}
{{-- End of content --}}

</div>
@stop

@section('scripts')
	@if(Input::get('tab'))
	$( document ).ready(function() {
	    $('#trig_{!! Input::get('tab') !!}').click();

	    var url     = '{{ URL::route('admin.dashboard') }}';
		window.history.pushState("", "", url);
	});
	@endif
@append