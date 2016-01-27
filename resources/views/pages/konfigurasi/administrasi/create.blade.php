@extends('page_templates.layout') 

@section('content')
<div class="container-fluid">
<!-- head -->
    @include('page_elements.createHeader', ['title' => 'Data Admin ' . $data['data']['name'] ])    
<!-- end of head -->

<!-- body -->
	@if(isset(  $data['data']['id'] ))
    {!! Form::open(['url' => route('config.administrative.update', $data['data']['id']), 'method' => 'PATCH']) !!}
    @else
    {!! Form::open(['url' => route('config.administrative.store'), 'method' => 'POST']) !!}
    @endif
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="name">Nama</label>
					{!! Form::text('name', $data['data']['name'], [
								'class'         => 'form-control', 
								'placeholder'   => 'Masukkan nama',
								'tabindex'      => '1',
					]) !!}
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label for="name">Email</label>
					{!! Form::text('email', $data['data']['email'], [
								'class'         => 'form-control', 
								'placeholder'   => 'Masukkan email',
								'tabindex'      => '2',
					]) !!}
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label for="role">Role</label>
					{!! Form::select('role',  array('admin' => 'Admin', 'store_manager' => 'Manager Toko', 'staff' => 'Staff'), $data['data']['role'], [
								'class'         => 'form-control', 
								'tabindex'      => '3',
					]) !!}
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label for="password">Password</label>
					{!! Form::password('password', [
								'class'        		=> 'form-control', 
								'tabindex'     		=> '4', 
								'placeholder'  		=> 'password',
					]) !!}
				</div>  
			</div> 
			<div class="col-md-12">
				<div class="form-group">
					<label for="password_confirmation">Konfirmasi Password</label>
					{!! Form::password('password_confirmation', [
								'class'        		=> 'form-control', 
								'tabindex'     		=> '5', 
								'placeholder'  		=> 'konfirmasi password',
					]) !!}
				</div>  
			</div> 
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="is_active">Aktif</label>
					{!! Form::checkbox('is_active', $data['data']['is_active'], [
								'class'         => 'form-control',
								'tabindex'      => '6', 
					]) !!}
				</div>  
			</div>  
		</div>

		<div class="clearfix">&nbsp;</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group text-right">
					<a href="{{ URL::route('config.administrative.index') }}" class="btn btn-md btn-default" tabindex="8">Batal</a>
					<button type="submit" class="btn btn-md btn-primary" tabindex="7">Simpan</button>
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