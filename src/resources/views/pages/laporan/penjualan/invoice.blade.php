
<html>
	<head>
		<meta charset="utf-8">
		<title>Invoice</title>
	</head>
	<body>
		<header>
			<h1>Invoice #{{strtoupper($data['ref_number'])}}</h1>
		</header>
		<table style="width:100%">
			<tr>
				<td style="width:40%">Invoice ID</td>
				<td style="width:5%">:</td>
				<td style="width:55%">{{strtoupper($data['ref_number'])}}</td>
			</tr>
			<tr>
				<td style="width:40%">Issued by</td>
				<td style="width:5%">:</td>
				<td style="width:55%">@if(!empty($data['issuer'])) {{ucfirst(str_replace('.', ' ', $data['issuer']))}} @else Balin Web @endif</td>
			</tr>
			<tr>
				<td style="width:40%">Issued at</td>
				<td style="width:5%">:</td>
				<td style="width:55%">@date_indo(new Carbon($data['transact_at']))</td>
			</tr>
			<tr>
				<td style="width:40%">Issued to</td>
				<td style="width:5%">:</td>
				<td style="width:55%">{{$data['user']['name']}}</td>
			</tr>
		</table>
		<br>
		<br>
		<table style="width:100%" border="1">
			<tr>
				<td style="width:5%"><strong></strong></td>
				<td style="width:10%"><strong>SKU</strong></td>
				<td style="width:20%"><strong>Nama Barang</strong></td>
				<td style="width:5%"><strong>Qty</strong></td>
				<td style="width:15%"><strong>Harga</strong></td>
				<td style="width:15%"><strong>Diskon</strong></td>
				<td style="width:30%"><strong>Sub Total</strong></td>
			</tr>
			@if (count($data['transactiondetails']) == 0)
				<tr>
					<td colspan="7">
						<p style="text-align:center">Tidak ada data</p>
					</td>
				</tr>
			@else
				@foreach($data['transactiondetails'] as $ctr => $detail)
					<tr>
						<td style="text-align:center">
							{{($ctr+1)}}						
						</td>
						<td style="text-align:center">{{ $detail['varian']['sku'] }}</td>
						<td style="text-align:center">{{ $detail['varian']['product']['name'] }} {{ $detail['varian']['size'] }}</td>
						<td style="text-align:center">{{ $detail['quantity'] }}</td>
						<td style="text-align:right">@money_indo($detail['price'])</td>
						<td style="text-align:right">@money_indo($detail['discount'])</td>
						<td style="text-align:right">@money_indo($detail['quantity'] * ($detail['price'] - $detail['discount']))</td>
					</tr>
				@endforeach
				<tr>
					<td colspan="6">
						<strong>Biaya Kurir</strong> {{$data['shipment']['courier']['name']}}
					</td>
					<td style="text-align:right">
						@money_indo($data['shipping_cost'])
					</td>
				</tr>
				<tr>
					<td colspan="6">
						<strong>Potongan</strong> Point BALIN
					</td>
					<td style="text-align:right;text-color:red">
						@money_indo($data['point_discount'])
					</td>
				</tr>
				<tr>
					<td colspan="6">
						<strong>Potongan</strong> Voucher {{$data['voucher']['code']}}
					</td>
					<td style="text-align:right;text-color:red">
						@money_indo($data['voucher_discount'])
					</td>
				</tr>
				<tr>
					<td colspan="6">
						<strong>Pengenal Pembayaran</strong>
					</td>
					<td style="text-align:right;text-color:red">
						@money_indo($data['unique_number'])
					</td>
				</tr>
				<tr>
					<td colspan="6">
						<strong>Biaya</strong>
						@foreach($data['transactionextensions'] as $key => $value)
							<br/> {{$value['productextension']['name']}}
						@endforeach
					</td>
					<td style="text-align:right">
						@money_indo($data['extend_cost'])
					</td>
				</tr>
				<tr>
					<td colspan="6">
						<strong>Jumlah</strong> yang harus dibayarkan
					</td>
					<td style="text-align:right">
						@money_indo($data['amount'])
					</td>
				</tr>
			@endif
		</table>
		<br>
		<br>
		<h3>Pembayaran</h3>
		<table style="width:100%">
			<tr>
				<td style="width:40%">Payment Method</td>
				<td style="width:5%">:</td>
				<td style="width:55%">{{strtoupper($data['payment']['method'])}}</td>
			</tr>
		</table>

		<br>
		<br>
		<h3>Alamat Pengiriman</h3>
		<table style="width:100%">
			<tr>
				<td style="width:40%">Delivered To</td>
				<td style="width:5%">:</td>
				<td style="width:55%">{{strtoupper($data['shipment']['receiver_name'])}}</td>
			</tr>
			<tr>
				<td style="width:40%">Address</td>
				<td style="width:5%">:</td>
				<td style="width:55%">
					{{$data['shipment']['address']['address']}}, 
					<br>
					Kode Pos : {{$data['shipment']['address']['zipcode']}}, 
					<br>
					Nomor Telepon : {{$data['shipment']['address']['phone']}}
				</td>
			</tr>
		</table>

		<br>
		<br>
		<h3>Resi Pengiriman</h3>
		<table style="width:100%">
			<tr>
				<td style="width:40%">Nomor Resi</td>
				<td style="width:5%">:</td>
				<td style="width:55%">{{strtoupper($data['shipment']['receipt_number'])}}</td>
			</tr>
		</table>
	</body>
</html>