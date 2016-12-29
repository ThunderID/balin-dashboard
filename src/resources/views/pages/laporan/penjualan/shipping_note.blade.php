<html>
	<head>
		<meta charset="utf-8">
		<title>Shipping Note</title>
	</head>
	<body>
		<table style="width:50%" border="1">
			<tr>
				<td>
					<table style="width:100%">
						<tr>
							<td style="width:95%"><strong>Kepada YTH</strong></td>
							<td style="width:5%">{!! HTML::image('http://drive.thunder.id/file/public/4/1/2015/11/14/09/logo.jpg', 'default', ['style' => 'width:100px;text-align:right']) !!}</td>
						</tr>
						<tr>
							<td colspan="2" style="width:100%"><strong>{{strtoupper($data['user']['name'])}}</strong></td>
						</tr>
						@if(!empty($data['shipment']['address']['phone']))
						<tr>
							<td colspan="2" style="width:100%"><strong>({{$data['shipment']['address']['phone']}})</strong></td>
						</tr>
						@endif
						<tr>
							<td colspan="2" style="width:100%"><strong>{{$data['shipment']['address']['address']}} ({{$data['shipment']['address']['zipcode']}}) </strong></td>
						</tr>
					</table>
			</td>
		</tr>
	</body>
</html>