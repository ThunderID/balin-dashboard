@extends('page_templates.layout_auth') 

@section('content')
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			@include('page_elements.alertbox')
		</div>
	</div>	
	{!! Form::open(['url' => route('auth.dologin'), 'class' => 'm-t']) !!}	
		<div class="form-group">
			{!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Email', 'required' => 'required', 'autofocus' => 'autofocus']) !!}
		</div>
		<div class="form-group">
			{!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password', 'required' => 'required']) !!}
		</div>
		<button type="submit" class="btn btn-primary block full-width m-b">Login</button>

		{{-- <a href="#"><small>Forgot password?</small></a> --}}
	{!! Form::close() !!}
@stop