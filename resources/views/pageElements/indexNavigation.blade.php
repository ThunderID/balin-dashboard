<?php
	$errors = [];
	if(!isset($disabled)){
		$disabled = false;
	}

	if(!isset($newDataLabel)){
		$newDataLabel = 'Data Baru';
	}

	if(!isset($searchLabel)){
		$searchLabel = 'Cari Data';
	}

	if($disabled == false)
	{
		if(!isset($newDataRoute)){
			array_push($errors, "Link untuk data baru tidak ada ( var : newDataRoute )");
		}

		if(!isset($filterDataRoute)){
			array_push($errors, "Link untuk cari data tidak ada ( var : filterDataRoute )");
		}	
	}
?>

@if(count($errors) == 0)
<div class="row">		
	<div class="col-md-8 col-sm-4 hidden-xs">
		@if($disabled ==  false)
			<a class="btn btn-default" href="{{ $newDataRoute }}"> {{$newDataLabel}} </a>
		@else
			<a class="btn btn-default disabled" href="#"> {{$newDataLabel}} </a>
		@endif
	</div>
    <div class="col-md-4 col-sm-8 col-xs-12">
		@if($disabled ==  false)
			<form method="GET" action="{{ $filterDataRoute }}" accept-charset="UTF-8">
		@endif
		<div class="row">
			<div class="col-md-2 col-sm-3 hidden-xs">
			</div>
			<div class="col-md-7 col-sm-6 col-xs-8" style="padding-right:2px;">
				@if($disabled ==  true)
					{!! Form::input('text', 'q', Null ,
							[
								'class'         => 'form-control',
								'placeholder'   => $searchLabel,
								'required'      => 'required',
								'disabled'		=> 'disabled'
							]
					) !!} 
				@else
					{!! Form::input('text', 'q', Null ,
							[
								'class'         => 'form-control',
								'placeholder'   => $searchLabel,
								'required'      => 'required',
							]
					) !!} 
				@endif                                
			</div>
			<div class="col-md-3 col-sm-3 col-xs-4" style="padding-left:2px;">
				@if($disabled ==  true)
					<a type="submit" class="btn btn-default pull-right btn-block disabled">Cari</a>
				@else
					<button type="submit" class="btn btn-default pull-right btn-block">Cari</button>
				@endif
			</div>
		</div>
		@if($disabled ==  false)
			</form>
		@endif
	</div>
</div>	
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