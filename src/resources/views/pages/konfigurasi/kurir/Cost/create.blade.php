@extends('page_templates.layout') 

@section('content')
<div class="container-fluid">
<!-- head -->
    @include('page_elements.createHeader', ['title' => 'Import Data Ongkos Kirim ' . $data['name'] ])    
<!-- end of head -->

<!-- body -->
    {!! Form::open(['url' => route('shop.courier.shippingcost.import', ['id' =>  $data['id']]), 'files' => true]) !!}
		<div class="row m-t-md m-b-lg">
			<div class="col-md-12">
				<h3>1. Upload file:</h3> 
				<div class="col-md-4">
	            <div class="form-group">
					<input class="form-control" type="file" name="file" />
					<p class="text-right">* File CSV</p>
				</div>
				</div>
			</div>
		</div>
		<div class="row m-t-md">
			<div class="col-md-12">
				<h3>2. Import Data</h3> 
				<div class="col-md-12">
					<button type="submit" class="btn btn-md btn-primary" tabindex="12">Import</button>
				</div>
			</div>
		</div>
    {!! Form::close() !!}
<!-- end of body -->
</div>
@stop
