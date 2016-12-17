<?php
		$policies = 
					[
						'expired_cart' => ' + 1 day', 
						'expired_paid' => ' - 2 days', 
						'expired_shipped' => '+ 5 days', 
						'expired_point' => '+ 1 year', 
						'referral_royalty' => '10000', 
						'invitation_royalty' => '50000', 
						'limit_unique_number' => '100', 
						'expired_link_duration' => '+ 2 hours', 
						'first_quota' => '10', 
						'downline_purchase_bonus' => '10000', 
						'downline_purchase_bonus_expired' => ' + 3 months', 
						'downline_purchase_quota_bonus' => '1', 
						'voucher_point_expired' => '+ 3 months', 
						'welcome_gift' => '10000', 
						'critical_stock' => '2', 
						'min_margin' => '50000', 
						'item_for_one_package' => '2',
					];
?>
@extends('page_templates.layout') 

@section('content')
<div class="container-fluid">
<!-- head -->
    @include('page_elements.createHeader', ['title' => 'Data Policy ' . str_replace('_', ' ',$data['data']['type']) ])    
<!-- end of head -->

<!-- body -->
	@if(isset(  $data['data']['id'] ))
    {!! Form::open(['url' => route('config.policy.update', $data['data']['id']), 'method' => 'PATCH']) !!}
    @else
    {!! Form::open(['url' => route('config.policy.store'), 'method' => 'POST']) !!}
    @endif
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="value">Nilai</label>
					{!! Form::text('value', $data['data']['value'], [
								'class'         => 'form-control', 
								'placeholder'   => 'ex : '.(isset($policies[$data['data']['type']]) ? $policies[$data['data']['type']] : ''),
								'tabindex'      => '1',
					]) !!}
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label for="started_at">Berlaku Mulai</label>
					{!! Form::text('started_at', $data['data']['started_at'], [
								'class'         => 'form-control date-time-format',
								'tabindex'      => '2', 
								'placeholder'   => 'Isikan tanggal dan waktu berlaku'
					]) !!}
				</div>  
			</div>  
		</div>

		<div class="clearfix">&nbsp;</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group text-right">
					<a href="{{ URL::route('config.policy.index') }}" class="btn btn-md btn-default" tabindex="4">Batal</a>
					<button type="submit" class="btn btn-md btn-primary" tabindex="3">Simpan</button>
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