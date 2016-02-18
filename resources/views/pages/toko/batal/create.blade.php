@extends('page_templates.layout') 

@section('content')
<div class="container-fluid">
<!-- head -->
    @include('page_elements.createHeader', ['title' => 'Data Transaksi Dibatalkan ' . $data['data']['ref_number'] ])    
<!-- end of head -->

<!-- body -->
	<div class="row">
		<div class="col-md-12">

		@if(isset($data['data']['id']))
			<div class="row">
				<div class="col-md-7 col-sm-10 col-xs-11">

					<div class="row">

						<div class="col-md-3 col-sm-5 col-xs-5">
							<h4>Nama</h4> 
						</div>
						<div class="col-md-1 col-sm-1 col-xs-2">
							<h4>:</h4> 
						</div>
						<div class="col-md-8 col-sm-6 col-xs-5">
							<h4>{{ $data['data']['user']['name'] }}</h4> 
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-7 col-sm-10 col-xs-11">

					<div class="row">

						<div class="col-md-3 col-sm-5 col-xs-5">
							<h4>Email</h4> 
						</div>
						<div class="col-md-1 col-sm-1 col-xs-2">
							<h4>:</h4> 
						</div>
						<div class="col-md-8 col-sm-6 col-xs-5">
							<h4>{{ $data['data']['user']['email'] }}</h4> 
						</div>
					</div>
				</div>
			</div>			

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
		@endif

		<div class="clearfix">&nbsp;</div>

	    {!! Form::open(['url' => route('shop.cancelorder.store'), 'method' => 'POST']) !!}
	    {!! Form::hidden('transaction_id', $data['data']['id']) !!}
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label for="notes">Alasan Pembatalan</label>
						{!! Form::textarea('notes', $data['data']['notes'], [
									'class'        		=> 'form-control', 
									'tabindex'     		=> '1', 
									'placeholder'  		=> 'Alasan Pembatalan',
									'style'				=> 'resize:none;',
									'rows'				=> 3
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
</div>
@stop

@section('scripts')
	<!-- preload select2 transaction -->
    var preload_data_transaction = [];
    @if(isset($data['data']['transactions']))
	    @foreach($data['data']['transactions'] as $transaction)
	        var id                      = {{$transaction['transaction_id']}};
	        var text                    = '{{$transaction['ref_number']}}';
	        preload_data_transaction.push({ id: id, text: text});
	    @endforeach
	@elseif(Input::get('transaction_id') && Input::get('transaction'))    
        var id                      = '{{ Input::get('transaction_id') }}';
        var text                    = '{{ ucwords(str_replace('_', ' ', Input::get('transaction'))) }}';
        preload_data_transaction.push({ id: id, text: text});
    @endif
	<!-- end of preload select2 transaction -->
@stop


@section('script_plugin')
    @include('plugins.select2', ['section' => 'transaction'])
@stop