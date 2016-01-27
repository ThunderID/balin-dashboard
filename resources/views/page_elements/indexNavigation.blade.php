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

	if(!isset($newDataRoute)){
		array_push($errors, "Link untuk data baru tidak ada ( var : newDataRoute )");
	}

	if(!isset($filterDataRoute)){
		array_push($errors, "Link untuk cari data tidak ada ( var : filterDataRoute )");
	}	
?>

@if(count($errors) == 0)
<div class="row">		
	<div class="col-md-8 col-sm-4 hidden-xs">
		@if($disabled == false)
			<a class="btn btn-default" href="{{ $newDataRoute }}"> {{$newDataLabel}} </a>
		@else
			<a class="btn btn-default disabled" href="#"> {{$newDataLabel}} </a>
		@endif
	</div>
    <div class="col-md-4 col-sm-8 col-xs-12">
		<form method="GET" action="{{ $filterDataRoute }}" accept-charset="UTF-8">
			<div class="row">
				<div class="col-md-2 col-sm-3 hidden-xs">
				</div>
				<div class="col-md-7 col-sm-6 col-xs-8" style="padding-right:2px;">
					{!! Form::input('text', 'q', Null ,
							[
								'class'         => 'form-control',
								'placeholder'   => $searchLabel,
								'required'      => 'required',
							]
					) !!} 
				</div>
				<div class="col-md-3 col-sm-3 col-xs-4" style="padding-left:2px;">
					<button type="submit" class="btn btn-default pull-right btn-block">Cari</button>
				</div>
			</div>
		</form>
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