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
			<form method="GET" action="{{ $filterDataRoute }}" accept-charset="UTF-8">
		@endif
		<div class="row">
			<div class="col-md-2 col-sm-2 col-xs-4 text-center m-t-sm">
				Periode
			</div>
			<div class="col-md-3 col-sm-3 col-xs-8">
				@if($disabled ==  true)
					{!! Form::input('text', 'start', Null ,
							[
								'class'         => 'form-control',
								'placeholder'   => 'Cari label',
								'required'      => 'required',
								'disabled'		=> 'disabled'
							]
					) !!} 
				@else
					{!! Form::input('text', 'start', Null ,
							[
								'class'         => 'form-control',
								'placeholder'   => 'Cari label',
								'required'      => 'required',
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
				@if($disabled ==  true)
					{!! Form::input('text', 'end', Null ,
							[
								'class'         => 'form-control',
								'placeholder'   => 'Cari label',
								'required'      => 'required',
								'disabled'		=> 'disabled'
							]
					) !!} 
				@else
					{!! Form::input('text', 'end', Null ,
							[
								'class'         => 'form-control',
								'placeholder'   => 'Cari label',
								'required'      => 'required',
							]
					) !!} 
				@endif                                
			</div>

			<div class="hidden-lg hidden-md hidden-sm col-xs-12">
				&nbsp;
			</div>

			<div class="col-md-2 col-sm-2 col-xs-12">
				@if($disabled ==  true)
					<a type="submit" class="btn btn-default pull-right btn-block disabled">Go</a>
				@else
					<button type="submit" class="btn btn-default pull-right btn-block">Go</button>
				@endif
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