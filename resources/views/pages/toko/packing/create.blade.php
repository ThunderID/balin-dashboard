@extends('page_templates.layout') 

@section('content')
<div class="container-fluid">
<!-- head -->
    @include('page_elements.createHeader', ['title' => 'Data Packing ' . $data['data']['ref_number'] ])    
<!-- end of head -->

<!-- body -->
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b-md">
			@if(isset($data['data']['id']))
				<div class="row">
					<div class="col-md-7 col-sm-10 col-xs-11">

						<div class="row">

							<div class="col-md-3 col-sm-5 col-xs-5">
								<h4>No. Nota</h4> 
							</div>
							<div class="col-md-1 col-sm-1 col-xs-2">
								<h4>:</h4> 
							</div>
							<div class="col-md-8 col-sm-6 col-xs-5">
								<h4>{{ $data['data']['ref_number'] }}</h4> 
							</div>
						</div>
					</div>
				</div>			
				<div class="row">
					<div class="col-md-7 col-sm-10 col-xs-11">

						<div class="row">

							<div class="col-md-3 col-sm-5 col-xs-5">
								<h4>Total Bayar</h4> 
							</div>
							<div class="col-md-1 col-sm-1 col-xs-2">
								<h4>:</h4> 
							</div>
							<div class="col-md-8 col-sm-6 col-xs-5">
								<h4>@money_indo($data['data']['amount'])</h4> 
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-7 col-sm-10 col-xs-11">
						<div class="row">

							<div class="col-md-3 col-sm-5 col-xs-5">
								<h4>Item</h4> 
							</div>
							<div class="col-md-1 col-sm-1 col-xs-2">
								<h4>:</h4> 
							</div>
							<div class="col-md-8 col-sm-6 col-xs-5">
								@foreach($data['data']['transactiondetails'] as $detail)
									<h4>{{ $detail['varian']['product']['name'] }} {{ $detail['varian']['size'] }} ({{$detail['quantity']}} Pcs)</h4> 
								@endforeach
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-7 col-sm-10 col-xs-11">
						<div class="row">

							<div class="col-md-3 col-sm-5 col-xs-5">
								<h4>Alamat</h4> 
							</div>
							<div class="col-md-1 col-sm-1 col-xs-2">
								<h4>:</h4> 
							</div>
							<div class="col-md-8 col-sm-6 col-xs-5">
								<h4>{{ $data['data']['shipment']['receiver_name']}} - {{ $data['data']['shipment']['address']['phone']}}</h4> 
								<h4>{{ $data['data']['shipment']['address']['address']}}</h4> 
								<h4>{{ $data['data']['shipment']['address']['zipcode']}}</h4> 
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-7 col-sm-10 col-xs-11">
						<div class="row">

							<div class="col-md-3 col-sm-5 col-xs-5">
								<h4>Kartu Ucapan</h4> 
							</div>
							<div class="col-md-1 col-sm-1 col-xs-2">
								<h4>:</h4> 
							</div>
							<div class="col-md-8 col-sm-6 col-xs-5">
								<?php
								// <h4>{{ $data['data']['shipment']['cards']}}}</h4> 
								?>
							</div>
						</div>
					</div>
				</div>					
			@endif			
		</div>
	</div>


    {!! Form::open(['url' => route('shop.packing.store'), 'method' => 'POST']) !!}
	    {!! Form::hidden('transaction_id', $data['data']['id']) !!}
		<div class="clearfix">&nbsp;</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group text-right">
					<a href="{{ URL::route('admin.dashboard',['tab' => 'toko']) }}" class="btn btn-md btn-default" tabindex="13">Batal</a>
					<button type="submit" class="btn btn-md btn-primary" tabindex="12">Simpan</button>
				</div>        
			</div>        
		</div> 
    {!! Form::close() !!}
<!-- end of body -->

</div>
@stop