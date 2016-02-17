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
			@endif			
		</div>
	</div>


    {!! Form::open(['url' => route('shop.packing.store'), 'method' => 'POST']) !!}
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="transaction">Nomor Nota Transaksi</label>
					{!! Form::text('transaction_id', null, [
								'class'         => 'select-transaction', 
								'tabindex'      => '1',
								'id'            => 'find_transaction',
								'style'         => 'width:100%',
					]) !!}
				</div>  
			</div> 
		</div> 

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

@section('scripts')
	<!-- preload select2 transaction -->
    var preload_data_transaction = [];
    @if(isset($data['data']['id']))
        var id                      = '{{ $data['data']['id'] }}';
        var text                    = '{{ $data['data']['ref_number'] }}';
        preload_data_transaction.push({ id: id, text: text});
    @endif
	<!-- end of preload select2 transaction -->
@stop


@section('script_plugin')
    @include('plugins.select2', ['section' => 'transaction', 'max_input' => 1])
@stop