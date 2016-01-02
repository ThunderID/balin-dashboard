<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>CMS - BALIN.ID</title>

	<!-- Custom CSS -->
   {!! HTML::style(elixir('css/dashboard.css')) !!}
   <link rel="shortcut icon" href="{{ url('Balin/web/image/favicon.ico') }} "/>
</head>

<body>
	<div class="middle-box text-center loginscreen animated fadeInDown">
		<div>
			<div>
				{!! HTML::image('images/balin-white.png', 'alt', array( 'class' => 'nav-logo', 'style' => 'max-width: 170px; max-height:60px;' )) !!}
			<h4 style="color:black;">A D M I N I S T R A T O R</h4>
			<br><br>
			{{-- <p>Login in. To see page admin.</p> --}}
			@yield('content')
		</div>
	</div>

	<!-- cdn -->
	{!! HTML::style('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css') !!}
	
	<!-- jQuery -->
   	{!! HTML::script(elixir('js/dashboard.js')) !!}
</body>

</html>
