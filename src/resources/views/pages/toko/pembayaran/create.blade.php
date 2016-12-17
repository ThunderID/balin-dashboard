@extends('page_templates.layout') 

@section('content')
<div class="container-fluid">
<!-- head -->
    @include('page_elements.createHeader', ['title' => 'Data Pembayaran ' . $data['data']['account_name'] ])    
<!-- end of head -->

<!-- body -->
    {!! Form::open(['url' => route('shop.pay.store'), 'method' => 'POST']) !!}
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="payment">Jumlah Bayar</label>
					{!! Form::text('transaction_id', null, [
								'class'         => 'select-payment', 
								'tabindex'      => '1',
								'id'            => 'find_payment',
								'style'         => 'width:100%',
					]) !!}
				</div>  
			</div> 
			<div class="col-md-12">
				<div class="form-group">
					<label for="method">Metode Pembayaran</label>
					{!! Form::text('method', $data['data']['method'], [
								'class'        		=> 'form-control', 
								'tabindex'     		=> '2', 
								'placeholder'  		=> 'ex : transfer bank',
					]) !!}
				</div>  
			</div>  
			<div class="col-md-12">
				<div class="form-group">
					<label for="destination">Bank</label>
					{!! Form::text('destination', $data['data']['destination'], [
								'class'        		=> 'form-control', 
								'tabindex'     		=> '3', 
								'placeholder'  		=> 'bca, mandiri, ...',
					]) !!}
				</div>  
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label for="account_name">Nama Pengirim</label>
					{!! Form::text('account_name', $data['data']['account_name'], [
								'class'        		=> 'form-control', 
								'tabindex'     		=> '4', 
								'placeholder'  		=> 'nama pengirim',
					]) !!}
				</div>  
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label for="account_number">Nomor Akun</label>
					{!! Form::text('account_number', $data['data']['account_number'], [
								'class'        		=> 'form-control', 
								'tabindex'     		=> '5', 
								'placeholder'  		=> 'nomor akun pengirim',
					]) !!}
				</div>  
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="ondate">Tanggal Transfer</label>
					{!! Form::text('ondate', $data['data']['ondate'], [
								'class'         => 'form-control date-time-format',
								'tabindex'      => '6', 
								'placeholder'   => 'Isikan tanggal dan waktu expired'
					]) !!}
				</div>  
			</div> 		
		</div>

		<div class="clearfix">&nbsp;</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group text-right">
					<a href="{{ URL::route('admin.dashboard',['tab' => 'toko']) }}" class="btn btn-md btn-default" tabindex="13">Batal</a>
					<button type="submit" class="btn btn-md btn-primary" tabindex="7">Simpan</button>
				</div>        
			</div>        
		</div> 
    {!! Form::close() !!}
<!-- end of body -->

</div>
@stop

@section('scripts')
	<!-- preload select2 payment -->
    var preload_data_payment = [];
    @if(isset($data['data']['id']))
        var id                      = '{{ $data['data']['id'] }}';
        var text                    = '@money_indo($data['data']['bills'])';
        preload_data_payment.push({ id: id, text: text});
    @endif
	<!-- end of preload select2 payment -->
@stop


@section('script_plugin')
    @include('plugins.select2', ['section' => 'payment', 'max_input' => 1])
	@include('plugins.summerNote')
	@include('plugins.inputMask')
@stop