@extends('page_templates.layout_auth') 

@section('content')
	{!! Form::open(['url' => route('backend.dologin'), 'class' => 'm-t']) !!}	
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