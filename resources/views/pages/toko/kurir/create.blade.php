@extends('page_templates.layout') 

@section('content')
<div class="container-fluid">
<!-- head -->
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b-md border-bottom">
			@include('pageElements.pagetitle')
			@include('pageElements.breadcrumb')
		</div>
	</div>
<!-- end of head -->

<!-- body -->
	@if(!isset($data['id']))
    {!! Form::open(['url' => route('admin.courier.update', $data['id']), 'method' => 'PATCH']) !!}
    @else
    {!! Form::open(['url' => route('admin.courier.store'), 'method' => 'POST']) !!}
    @endif
        {!! Form::hidden('address_id',$data['courier']['address']['id']) !!}    
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
                <h4 class="sub-header">
                    Data
                </h4>
            </div>
        </div>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="form-group">
					<label for="parent" class="text-capitalize">Nama</label>
					{!! Form::text('name', $data['name'], [
								'class'         => 'form-control', 
								'tabindex'      => '1',
								'placeholder'   => 'Masukkan nama',
					]) !!}
				</div>              
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label for="thumbnail" class="text-capitalize">URL Image (320 X 463 px)</label>
					{!! Form::text('thumbnail', null, [
								'class'         => 'form-control', 
								'tabindex'      => '2',
								'placeholder'   => 'Masukkan url image thumbnail',
					]) !!}
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="logo" class="text-capitalize">URL Image (320 X 463 px)</label>
					{!! Form::text('image_xs', null, [
								'class'         => 'form-control', 
								'tabindex'      => '3',
								'placeholder'   => 'Masukkan url image xs',
					]) !!}
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="logo" class="text-capitalize">URL Image (320 X 463 px)</label>
					{!! Form::text('image_sm', null, [
								'class'         => 'form-control', 
								'tabindex'      => '4',
								'placeholder'   => 'Masukkan url image sm',
					]) !!}
				</div>
			</div>											
		</div>
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label for="logo" class="text-capitalize">URL Image (772 X 1043 px)</label>
					{!! Form::text('image_md', null, [
								'class'         => 'form-control', 
								'tabindex'      => '5',
								'placeholder'   => 'Masukkan url image md',
					]) !!}
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="logo" class="text-capitalize">URL Image (992 X 1434 px)</label>
					{!! Form::text('image_lg', null, [
								'class'         => 'form-control', 
								'tabindex'      => '6',
								'placeholder'   => 'Masukkan url image lg',
					]) !!}							
				</div>
			</div>
			<div class="col-md-4">
			</div>					
		</div>

		<div class="row">
            <div class="col-md-12">
                <h4 class="sub-header">
                    Alamat
                </h4>
            </div>
        </div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="parent" class="text-capitalize">Phone</label>
					{!! Form::text('phone', $data['address']['phone'], [
								'class'         => 'form-control', 
								'tabindex'      => '7',
								'placeholder'   => 'Masukkan nomor telepon',
					]) !!}
				</div>              
			</div>						
			<div class="col-md-6">
				<div class="form-group">
					<label for="parent" class="text-capitalize">Kode Pos</label>
					{!! Form::text('zipcode', $data['address']['zipcode'], [
								'class'         => 'form-control', 
								'tabindex'      => '8',
								'placeholder'   => 'Masukkan kode pos',
					]) !!}
				</div>              
			</div>						
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="name" class="text-capitalize">Alamat</label>
					{!! Form::textarea('address', $data['address']['address'], [
								'class'         => 'form-control', 
								'required'      => 'required', 
								'rows'          => '3',
								'tabindex'      => '9',
								'style'         => 'resize:none;',
								'placeholder'   => 'Masukkan alamat'
						]) 
					!!}
				</div> 
			</div> 
		</div> 
		</br>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="form-group text-right">
					<a href="{{ URL::route('admin.courier.index') }}" class="btn btn-md btn-default" tabindex="10">Batal</a>
					<button type="submit" class="btn btn-md btn-primary" tabindex="11">Simpan</button>
				</div>
			</div>                                     
		</div>
	{!! Form::close() !!}
<!-- end of body -->
@stop