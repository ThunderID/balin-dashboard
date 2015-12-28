<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">
		<title>CMS - BALIN.ID</title>

		<!-- local only -->
		{!! HTML::style('css/font-awesome.min.css') !!}

		<!-- Custom CSS -->
	   {!! HTML::style(elixir('css/dashboard.css')) !!}
	   <link rel="shortcut icon" href="{{ url('Balin/web/image/favicon.ico') }} "/>
	</head>

	<body>
		<div class="wrapper white-bg border-bottom">
			@include('pageElements.topbar')
		</div>


		<div class="wrapper white-bg">
			@include('pageElements.alertbox')
			@yield('content')			
		</div>
					

		<!-- modals -->
		@yield('modals')

		<!-- cdn -->
		{!! HTML::style('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css') !!}
		
		<!-- jQuery -->
	   	{!! HTML::script(elixir('js/dashboard.js')) !!}

		<!-- jQuery -->
		<script type="text/javascript">
			@yield('scripts')
		</script>
		
		@yield('script_plugin')
	</body>
</html>
