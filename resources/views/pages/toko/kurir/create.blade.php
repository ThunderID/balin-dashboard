@extends('page_templates.layout') 

@section('content')
<div class="container-fluid">
<!-- head -->
    @include('pageElements.createHeader', ['title' => 'Data Kurir ' . $data['name'] ])    
<!-- end of head -->

<!-- body -->
	@if(!isset($data['id']))
    {!! Form::open(['url' => route('admin.courier.store'), 'method' => 'POST']) !!}
    @else
    {!! Form::open(['url' => route('admin.courier.update', $data['id']), 'method' => 'PATCH']) !!}
    @endif
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
			<div class="col-md-6">
				<div class="form-group">
					<label for="parent" class="text-capitalize">Nomor Telepon</label>
					{!! Form::text('phone', $data['current_phone'], [
								'class'         => 'form-control', 
								'tabindex'      => '2',
								'placeholder'   => 'Masukkan nomor telepon',
					]) !!}
				</div>              
			</div>						
			<div class="col-md-6">
				<div class="form-group">
					<label for="parent" class="text-capitalize">Kode Pos</label>
					{!! Form::text('zipcode', $data['current_zipcode'], [
								'class'         => 'form-control', 
								'tabindex'      => '3',
								'placeholder'   => 'Masukkan kode pos',
					]) !!}
				</div>              
			</div>						
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="name" class="text-capitalize">Alamat</label>
					{!! Form::textarea('address', $data['current_address'], [
								'class'         => 'form-control', 
								'required'      => 'required', 
								'rows'          => '3',
								'tabindex'      => '4',
								'style'         => 'resize:none;',
								'placeholder'   => 'Masukkan alamat'
						]) 
					!!}
				</div> 
			</div> 
		</div> 		
		<div class="row clearfix">&nbsp;</div>

		<div class="row">
            <div class="col-md-12 m-b-sm">
                <h4 class="sub-header">
                    Gambar
                </h4>
            </div>
        </div>
		<div class="row">
			<div class="col-md-2 col-sm-3 col-xs-12">
				<label for="thumbnail" class="text-capitalize">Preview</label>
				@if(is_null($data['thumbnail']))
					{!! HTML::image('https://pbs.twimg.com/profile_images/600060188872155136/st4Sp6Aw.jpg', 'default', ['class' => 'img-responsive']) !!}
				@else
					{!! HTML::image($data['thumbnail'], 'default', ['class' => 'img-responsive']) !!}
				@endif					
			</div>
			<div class="col-md-10 col-sm-9 col-xs-12">
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label for="thumbnail" class="text-capitalize">URL Image (320 X 463 px)</label>
							{!! Form::text('thumbnail', $data['thumbnail'], [
										'class'         => 'form-control', 
										'tabindex'      => '5',
										'placeholder'   => 'Masukkan url image thumbnail',
							]) !!}
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="logo" class="text-capitalize">URL Image (320 X 463 px)</label>
							{!! Form::text('image_xs', $data['image_xs'], [
										'class'         => 'form-control', 
										'tabindex'      => '6',
										'placeholder'   => 'Masukkan url image xs',
							]) !!}
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="logo" class="text-capitalize">URL Image (320 X 463 px)</label>
							{!! Form::text('image_sm', $data['image_sm'], [
										'class'         => 'form-control', 
										'tabindex'      => '7',
										'placeholder'   => 'Masukkan url image sm',
							]) !!}
						</div>
					</div>											
				</div>	
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label for="logo" class="text-capitalize">URL Image (772 X 1043 px)</label>
							{!! Form::text('image_md', $data['image_md'], [
										'class'         => 'form-control', 
										'tabindex'      => '8',
										'placeholder'   => 'Masukkan url image md',
							]) !!}
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="logo" class="text-capitalize">URL Image (992 X 1434 px)</label>
							{!! Form::text('image_lg', $data['image_lg'], [
										'class'         => 'form-control', 
										'tabindex'      => '9',
										'placeholder'   => 'Masukkan url image lg',
							]) !!}							
						</div>
					</div>
					<div class="col-md-4">
					</div>					
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