@extends('page_templates.layout') 

@section('content')
<div class="container-fluid">
<!-- head -->
    @include('page_elements.createHeader', ['title' => 'Data Transaksi Terkirim ' . $data['data']['ref_number'] ])    
<!-- end of head -->

<!-- body -->
    {!! Form::open(['url' => route('shop.completeorder.store'), 'method' => 'POST']) !!}
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
					<label for="notes">Catatan Penerima</label>
					{!! Form::text('notes', $data['data']['notes'], [
								'class'        		=> 'form-control', 
								'tabindex'     		=> '2', 
								'placeholder'  		=> 'Nama Penerima',
					]) !!}
				</div>  
			</div>  
		</div> 

		<div class="clearfix">&nbsp;</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group text-right">
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
    @include('plugins.select2', ['section' => 'transaction'])
@stop