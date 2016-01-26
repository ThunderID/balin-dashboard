@extends('page_templates.layout') 

@section('content')
<div class="container-fluid">
<!-- head -->
    @include('pageElements.createHeader', ['title' => 'Data Transaksi Terkirim ' . $data['data']['ref_number'] ])    
<!-- end of head -->

<!-- body -->
	@if(isset(  $data['data']['id'] ))
    {!! Form::open(['url' => route('admin.finishedTransaction.update', $data['data']['id']), 'method' => 'PATCH']) !!}
    @else
    {!! Form::open(['url' => route('admin.finishedTransaction.store'), 'method' => 'POST']) !!}
    @endif
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="transaction"># Pesanan</label>
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
					<a href="{{ URL::route('admin.finishedTransaction.index') }}" class="btn btn-md btn-default" tabindex="13">Batal</a>
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