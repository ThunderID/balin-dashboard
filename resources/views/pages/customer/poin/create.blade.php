@extends('page_templates.layout') 

@section('content')
<div class="container-fluid">
<!-- head -->
    @include('page_elements.createHeader', ['title' => 'Data Point ' . $data['data']['name'] ])    
<!-- end of head -->

<!-- body -->
	@if(isset(  $data['data']['id'] ))
    {!! Form::open(['url' => route('admin.point.update', $data['data']['id']), 'method' => 'PATCH']) !!}
    @else
    {!! Form::open(['url' => route('admin.point.store'), 'method' => 'POST']) !!}
    @endif
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="customer">Kostumer</label>
					{!! Form::text('customer', null, [
								'class'         => 'select-customer', 
								'tabindex'      => '1',
								'id'            => 'find_customer',
								'style'         => 'width:100%',
					]) !!}
				</div>  
			</div> 
			<div class="col-md-12">
				<div class="form-group">
					<label for="amount">Amount</label>
					{!! Form::text('amount', $data['data']['amount'], [
								'class'        		=> 'form-control money', 
								'tabindex'     		=> '2', 
								'placeholder'  		=> 'jumlah',
					]) !!}
				</div>  
			</div>  
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="expired">Expired</label>
					{!! Form::text('expired_at', $data['data']['expired_at'], [
								'class'         => 'form-control date-time-format',
								'tabindex'      => '3', 
								'placeholder'   => 'Isikan tanggal dan waktu expired'
					]) !!}
				</div>  
			</div> 		
			<div class="col-md-12">
				<div class="form-group">
					<label for="notes">Notes</label>
					{!! Form::textarea('notes', $data['data']['notes'], [
								'class'         => 'form-control', 
								'placeholder'   => 'Masukkan notes',
								'rows'          => '1',
								'tabindex'      => '4',
								'style'         => 'resize:none;',
					]) !!}
				</div>
			</div>
		</div>

		<div class="clearfix">&nbsp;</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group text-right">
					<a href="{{ URL::route('admin.point.index') }}" class="btn btn-md btn-default" tabindex="13">Batal</a>
					<button type="submit" class="btn btn-md btn-primary" tabindex="12">Simpan</button>
				</div>        
			</div>        
		</div> 
    {!! Form::close() !!}
<!-- end of body -->

</div>
@stop

@section('scripts')
	<!-- preload select2 customer -->
    var preload_data_customer = [];
    @if(isset($data['data']['customers']))
	    @foreach($data['data']['customers'] as $customer)
	        var id                      = {{$customer['id']}};
	        var text                    = '{{$customer['name']}}';
	        preload_data_customer.push({ id: id, text: text});
	    @endforeach
	@elseif(Input::get('customer_id') && Input::get('customer'))    
        var id                      = '{{ Input::get('customer_id') }}';
        var text                    = '{{ ucwords(str_replace('_', ' ', Input::get('customer'))) }}';
        preload_data_customer.push({ id: id, text: text});
    @endif
	<!-- end of preload select2 customer -->
@stop


@section('script_plugin')
    @include('plugins.select2', ['section' => 'customer'])
	@include('plugins.summerNote')
	@include('plugins.inputMask')
@stop