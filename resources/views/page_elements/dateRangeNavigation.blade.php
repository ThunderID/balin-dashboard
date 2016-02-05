<?php
	$errors = [];
	if(!isset($disabled)){
		$disabled = false;
	}

	if($disabled == false)
	{
		if(!isset($filterDataRoute)){
			// array push Link untuk cari data tidak ada
			array_push($errors, "Link untuk cari data tidak ada ( var : filterDataRoute )");
		}	
	}
?>

@if(count($errors) == 0)
		@if($disabled ==  false)
			<form action='javascript:void(0)' onSubmit="filterDateRange(this);">
		@endif
		<div class="row">
			<div class="col-md-2 col-sm-2 col-xs-4 text-center m-t-sm">
				Periode
			</div>
			<div class="col-md-3 col-sm-3 col-xs-8">
				<?php
					if(Input::get('start')){
						$start = Input::get('start');
					}else{
						$start = null;
					}
				?>
				@if($disabled ==  true)
					{!! Form::input('text', 'start', $start ,
							[
								'class'         => 'form-control',
								'placeholder'   => 'Tanggal Mulai',
								'required'      => 'required',
								'disabled'		=> 'disabled'
							]
					) !!} 
				@else
					{!! Form::input('text', 'start', $start ,
							[
								'class'         => 'form-control date-format',
								'placeholder'   => 'Tanggal Mulai',
								'required'      => 'required',
								'id'			=> 'start',
							]
					) !!} 
				@endif                                
			</div>

			<div class="hidden-lg hidden-md hidden-sm col-xs-12">
				&nbsp;
			</div>

			<div class="col-md-2 col-sm-2 col-xs-4 text-center m-t-sm">
				Sampai
			</div>
			<div class="col-md-3 col-sm-3 col-xs-8">
				<?php
					if(Input::get('end')){
						$end = Input::get('end');
					}else{
						$end = null;
					}
				?>				
				@if($disabled ==  true)
					{!! Form::input('text', 'end', $end ,
							[
								'class'         => 'form-control',
								'placeholder'   => 'Tanggal Akhir',
								'required'      => 'required',
								'disabled'		=> 'disabled'
							]
					) !!} 
				@else
					{!! Form::input('text', 'end', $end ,
							[
								'class'         => 'form-control date-format',
								'placeholder'   => 'Tanggal Akhir',
								'required'      => 'required',
								'id'			=> 'end',
							]
					) !!} 
				@endif                                
			</div>

			<div class="hidden-lg hidden-md hidden-sm col-xs-12">
				&nbsp;
			</div>

			<div class="col-md-1 col-sm-2 col-xs-12">
				@if($disabled ==  true)
					<a type="submit" class="btn btn-default btn-block disabled">Go</a>
				@else
					<button type="submit" class="btn btn-default btn-block">Go</button>
				@endif
			</div>

			<div class="col-md-1">
				<a class="btn btn-default" onClick="clearDateRange(this)" href="javascript:void(0)">
					<i class="fa fa-times"></i>
				</a>
			</div>
		</div>
		@if($disabled ==  false)
			</form>
		@endif
@else
<div class="row">
    <div class="col-lg-12">
        <div class="alert alert-danger">
        	<h4>Widget Index Navigation Error</h4>
            @foreach ($errors as $error)
                <p> {!! $error !!} </p>
            @endforeach
        </div>
    </div>
</div>
@endif


@section('script_plugin')
	@include('plugins.ajaxPage')
	@include('plugins.inputMask')
@append