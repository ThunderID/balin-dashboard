@extends('page_templates.layout') 

@section('content')
<div class="container-fluid">
<!-- head -->
    @include('page_elements.createHeader', ['title' => 'Data Pengiriman ' . $data['data']['ref_number'] ])    
<!-- end of head -->

<!-- body -->
    {!! Form::open(['url' => route('shop.shipping.store'), 'method' => 'POST']) !!}
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
			<div class="col-md-12">
				<div class="form-group">
					<label for="receipt_number">Nomor Resi Pengiriman</label>
					{!! Form::text('receipt_number', $data['data']['receipt_number'], [
								'class'        		=> 'form-control', 
								'tabindex'     		=> '2', 
								'placeholder'  		=> 'masukkan nomor resi',
					]) !!}
				</div>  
			</div>  
		</div> 

		<div class="clearfix">&nbsp;</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group text-right">
					<a href="{{ URL::route('admin.dashboard',['tab' => 'toko']) }}" class="btn btn-md btn-default" tabindex="13">Batal</a>
					<button type="submit" class="btn btn-md btn-primary" tabindex="3">Simpan</button>
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
    @include('plugins.select2', ['section' => 'transaction'])
@stop