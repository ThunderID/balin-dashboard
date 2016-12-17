@extends('page_templates.layout') 

@section('content')
<div class="container-fluid">
<!-- head -->
    @include('page_elements.createHeader', ['title' => 'Ubah Password '])    
<!-- end of head -->

<!-- body -->
    {!! Form::open(['url' => route('password.change.update'), 'method' => 'POST']) !!}
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="old_password">Password Lama</label>
					{!! Form::password('old_password', [
								'class'         => 'form-control', 
								'placeholder'   => 'Masukkan password lama',
								'tabindex'      => '1',
					]) !!}
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label for="password">Password</label>
					{!! Form::password('password', [
								'class'         => 'form-control', 
								'placeholder'   => 'Masukkan password baru',
								'tabindex'      => '2',
					]) !!}
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label for="password">Konfirmasi Password Baru</label>
					{!! Form::password('password_confirmation', [
								'class'         => 'form-control', 
								'placeholder'   => 'Ketik ulang password baru',
								'tabindex'      => '3',
					]) !!}
				</div>
			</div>
		</div>

		<div class="clearfix">&nbsp;</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group text-right">
					<button type="submit" class="btn btn-md btn-primary" tabindex="4">Simpan</button>
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