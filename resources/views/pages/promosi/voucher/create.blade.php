@extends('page_templates.layout') 

@section('content')
<div class="container-fluid">
<!-- head -->
    @include('pageElements.createHeader', ['title' => 'Data Voucher ' . $data['data']['code'] ])    
<!-- end of head -->

<!-- body -->
	@if(isset(  $data['data']['id'] ))
    {!! Form::open(['url' => route('admin.voucher.update', $data['data']['id']), 'method' => 'PATCH']) !!}
    @else
    {!! Form::open(['url' => route('admin.voucher.store'), 'method' => 'POST']) !!}
    @endif
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="code">Kode Voucher</label>
					{!! Form::text('code', $data['data']['code'], [
								'class'         => 'form-control', 
								'placeholder'   => 'Masukkan code',
								'tabindex'      => '1',
					]) !!}
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label for="type">Type</label>
					{!! Form::select('type',  array('free_shipping_cost' => 'Gratis Ongkir', 'debit_point' => 'Debit Poin', 'promo_referral' => 'Promo Referral'), $data['data']['type'], [
								'class'         => 'form-control', 
								'tabindex'      => '2',
					]) !!}
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label for="amount">Nilai</label>
					{!! Form::text('value', $data['data']['value'], [
								'class'        		=> 'form-control money', 
								'tabindex'     		=> '3', 
								'placeholder'  		=> 'jumlah',
					]) !!}
				</div>  
			</div> 
			<div class="col-md-12">
				<div class="form-group">
					<label for="quota">Quota</label>
					{!! Form::text('quota', $data['data']['quota'], [
								'class'        		=> 'form-control', 
								'tabindex'     		=> '4', 
								'placeholder'  		=> 'jumlah quota',
					]) !!}
				</div>  
			</div> 
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="expired">Berlaku Mulai</label>
					{!! Form::text('started_at', $data['data']['started_at'], [
								'class'         => 'form-control date-time-format',
								'tabindex'      => '5', 
								'placeholder'   => 'Isikan tanggal dan waktu berlaku'
					]) !!}
				</div>  
			</div>  
			<div class="col-md-6">
				<div class="form-group">
					<label for="expired">Hingga</label>
					{!! Form::text('expired_at', $data['data']['expired_at'], [
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
					<a href="{{ URL::route('admin.voucher.index') }}" class="btn btn-md btn-default" tabindex="13">Batal</a>
					<button type="submit" class="btn btn-md btn-primary" tabindex="12">Simpan</button>
				</div>        
			</div>        
		</div> 
    {!! Form::close() !!}
<!-- end of body -->

</div>
@stop

@section('script_plugin')
	@include('plugins.summerNote')
	@include('plugins.inputMask')
@stop