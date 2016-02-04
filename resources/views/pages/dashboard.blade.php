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
			<h3>Pekerjaan Hari Ini</h3>
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
						<a href="#barang" aria-controls="barang" role="tab" data-toggle="tab">Barang ({{$data['warehouse']['count']}})</a>
					</li>
					<li role="presentation">
						<a href="#toko" aria-controls="toko" role="tab" data-toggle="tab">Toko ({{$data['shipped']['count'] + $data['packed']['count'] + $data['paid']['count'] + $data['wait']['count']}})</a>
					</li>
					 <li role="presentation">
						<a href="#laporan" aria-controls="tab" role="tab" data-toggle="tab">Laporan (0)</a>
					</li>
					<li role="presentation">
						<a href="#pengaturan" aria-controls="tab" role="tab" data-toggle="tab">Pengaturan (0)</a>
					</li>
					<li role="presentation">
						<a href="#customer" aria-controls="tab" role="tab" data-toggle="tab">Customer (0)</a>
					</li>
					<li role="presentation">
						<a href="#promosi" aria-controls="tab" role="tab" data-toggle="tab">Promosi (0)</a>
					</li>                    
				</ul>
		<!-- end of nav tabs -->
			
		<!-- Tab panes -->
				<div class="tab-content">
			<!-- tab barang -->
					<div role="tabpanel" class="tab-pane active" id="barang">
						<div class="panel-group" id="accordionBarang" style="margin-top:5px;">
							
							<div class="panel panel-default dahboard-list">
								<a data-toggle="collapse" data-parent="#accordionBarang" href="#collapseb1">
									<div class="panel-heading">
										<h4 class="panel-title">
											Re-Stok Produk ({{$data['warehouse']['count']}})
										</h4>
									</div>
								</a>
								<div id="collapseb1" class="panel-collapse collapse">
		                            <table class="table table-bordered table-hover table-striped">
		                                <tbody>
											@forelse($data['warehouse']['data'] as $key => $value)
												<tr>
			                                        <td class="col-xs-1" style="padding-left: 25px !important;">
			                                            {{ $key + 1 }}
			                                        </td>
			                                        <td>
			                                            {{$value['product']['name']}}
			                                        </td>
			                                        <td class="col-xs-1"><a href="{{route('shop.buy.create', ['pid' => $value['product']['id']])}}">Kerjakan</a></td>
												</tr>
											@empty
												<tr>
			                                        <td class="col-xs-1" style="padding-left: 25px !important;">
			                                            Tidak ada pekerjaan untuk sekarang.
			                                        </td>
			                                    </tr>
											@endforelse
		                                </tbody>
		                            </table> 
								</div>
							</div>

						</div>
					</div>
			<!-- end of tab barang -->

			<!-- tab toko -->
					<div role="tabpanel" class="tab-pane" id="toko">
						<div class="panel-group" id="accordionToko" style="margin-top:5px;">
							
							<div class="panel panel-default dahboard-list">
								
								<a data-toggle="collapse" data-parent="#accordionToko" href="#collapset1">
									<div class="panel-heading">
										<h4 class="panel-title">
											Validasi Bayar ({{$data['wait']['count']}})
										</h4>
									</div>
								</a>
								<div id="collapset1" class="panel-collapse collapse">
		                            <table class="table table-bordered table-hover table-striped">
		                                <tbody>
											@forelse($data['wait']['data'] as $key => $value)
												<tr>
			                                        <td class="col-xs-1" style="padding-left: 25px !important;">
			                                            {{ $key + 1 }}
			                                        </td>
			                                        <td>
														[{{$value['ref_number']}}] {{$value['user']['name']}} -  @money_indo($value['amount'])
			                                        </td>
			                                        <td class="col-xs-1"><a href="{{route('shop.pay.create')}}">Validasi</a></td>
			                                    </tr>
											@empty
												<tr>
			                                        <td class="col-xs-1" style="padding-left: 25px !important;">
			                                            Tidak ada pekerjaan untuk sekarang.
			                                        </td>
			                                    </tr>
											@endforelse
		                                </tbody>
		                            </table> 
								</div>

							</div>

							<div class="panel panel-default dahboard-list">
								
								<a data-toggle="collapse" data-parent="#accordionToko" href="#collapset2">
									<div class="panel-heading">
										<h4 class="panel-title">
											Packing ({{$data['paid']['count']}})
										</h4>
									</div>
								</a>
								<div id="collapset2" class="panel-collapse collapse">
		                            <table class="table table-bordered table-hover table-striped">
		                                <tbody>
											@forelse($data['paid']['data'] as $key => $value)
												<tr>
			                                        <td class="col-xs-1" style="padding-left: 25px !important;">
			                                            {{ $key + 1 }}
			                                        </td>
			                                        <td>
														[{{$value['ref_number']}}] {{$value['user']['name']}} -  @money_indo($value['amount'])
			                                        </td>
			                                        <td class="col-xs-1"><a href="{{route('shop.packing.create')}}">Kerjakan</a></td>
			                                    </tr>
											@empty
												<tr>
			                                        <td class="col-xs-1" style="padding-left: 25px !important;">
			                                            Tidak ada pekerjaan untuk sekarang.
			                                        </td>
			                                    </tr>
											@endforelse
		                                </tbody>
		                            </table> 
								</div>
								
							</div>	

							<div class="panel panel-default dahboard-list">
								
								<a data-toggle="collapse" data-parent="#accordionToko" href="#collapset3">
									<div class="panel-heading">
										<h4 class="panel-title">
											Kirim Barang ({{$data['packed']['count']}})
										</h4>
									</div>
								</a>
								<div id="collapset3" class="panel-collapse collapse">
		                            <table class="table table-bordered table-hover table-striped">
		                                <tbody>
											@forelse($data['packed']['data'] as $key => $value)
												<tr>
			                                        <td class="col-xs-1" style="padding-left: 25px !important;">
			                                            {{ $key + 1 }}
			                                        </td>
			                                        <td>
														[{{$value['ref_number']}}] {{$value['user']['name']}} -  @money_indo($value['amount'])
			                                        </td>
			                                        <td class="col-xs-1"><a href="{{route('shop.shipping.create')}}">Kirim Barang</a></td>
			                                    </tr>
											@empty
												<tr>
			                                        <td class="col-xs-1" style="padding-left: 25px !important;">
			                                            Tidak ada pekerjaan untuk sekarang.
			                                        </td>
			                                    </tr>
											@endforelse
		                                </tbody>
		                            </table> 
								</div>
								
							</div>														

							<div class="panel panel-default dahboard-list">
								
								<a data-toggle="collapse" data-parent="#accordionToko" href="#collapset4">
									<div class="panel-heading">
										<h4 class="panel-title">
											Transaksi Selesai ({{$data['shipped']['count']}})
										</h4>
									</div>
								</a>
								<div id="collapset4" class="panel-collapse collapse">
		                            <table class="table table-bordered table-hover table-striped">
		                                <tbody>
											@forelse($data['shipped']['data'] as $key => $value)
												<tr>
			                                        <td class="col-xs-1" style="padding-left: 25px !important;">
			                                            {{ $key + 1 }}
			                                        </td>
			                                        <td>
														[{{$value['ref_number']}}] {{$value['user']['name']}} -  @money_indo($value['amount'])
			                                        </td>
			                                        <td class="col-xs-1"><a href="{{route('shop.completeorder.create')}}">Kerjakan</a></td>
			                                    </tr>
											@empty
												<tr>
			                                        <td class="col-xs-1" style="padding-left: 25px !important;">
			                                            Tidak ada pekerjaan untuk sekarang.
			                                        </td>
			                                    </tr>
											@endforelse
		                                </tbody>
		                            </table> 
								</div>
								
							</div>		

						</div>
					</div>
			<!-- end of tab toko -->

			<!-- tab laporan -->
					<div role="tabpanel" class="tab-pane" id="laporan">
						<div class="panel-group" id="accordionLaporan" style="margin-top:5px;">
                            <table class="table table-bordered table-hover table-striped">
                                <tbody>
									<tr>
	                                    <td class="col-xs-1" style="padding-left: 25px !important;">
	                                        Tidak ada pekerjaan untuk sekarang.
	                                    </td>
	                                </tr>
	                            </tbody>
	                         </table>                                	
						</div>
					</div>
			<!-- end of tab laporan -->

			<!-- tab pengaturan -->
					<div role="tabpanel" class="tab-pane" id="pengaturan">
						<div class="panel-group" id="accordionPengaturan" style="margin-top:5px;">
                            <table class="table table-bordered table-hover table-striped">
                                <tbody>
									<tr>
	                                    <td class="col-xs-1" style="padding-left: 25px !important;">
	                                        Tidak ada pekerjaan untuk sekarang.
	                                    </td>
	                                </tr>
	                            </tbody>
	                         </table> 
						</div>
					</div>
			<!-- end of tab pengaturan -->

			<!-- tab customer -->
					<div role="tabpanel" class="tab-pane" id="customer">
						<div class="panel-group" id="accordionCustomer" style="margin-top:5px;">
                            <table class="table table-bordered table-hover table-striped">
                                <tbody>
									<tr>
	                                    <td class="col-xs-1" style="padding-left: 25px !important;">
	                                        Tidak ada pekerjaan untuk sekarang.
	                                    </td>
	                                </tr>
	                            </tbody>
	                         </table> 
						</div>
					</div>
			<!-- end of tab customer -->
					

			<!-- tab promosi -->
					<div role="tabpanel" class="tab-pane" id="promosi">
						<div class="panel-group" id="accordionPromosi" style="margin-top:5px;">
                            <table class="table table-bordered table-hover table-striped">
                                <tbody>
									<tr>
	                                    <td class="col-xs-1" style="padding-left: 25px !important;">
	                                        Tidak ada pekerjaan untuk sekarang.
	                                    </td>
	                                </tr>
	                            </tbody>
	                         </table> 
						</div>
					</div>					
			<!-- end of tab promosi -->

				</div>
		<!-- end of tab panes -->

			</div>
		</div>
	</div>
	<!-- end of pekerjaan hari ini -->

	
<!-- end of content -->
</div>
@stop