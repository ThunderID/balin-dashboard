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

	if(!isset($filters['titles'])){
		array_push($errors, "Data filter tidak ada ( var : filters['titles' => ['a','n'], 'a' => ['a.1', 'a.n'],'n' => []] )");
	}
?>

<div id="filters">
@if(count($errors) == 0)
<div class="row">		
	<div class="col-md-7 col-sm-4 hidden-xs">
		@if($disabled == false)
			<a class="btn btn-default" href="{{ $newDataRoute }}"><i class="fa fa-plus"></i>&nbsp; {{$newDataLabel}} </a>
		@else
			<a class="btn btn-default disabled" href="#"><i class="fa fa-plus"></i>&nbsp; {{$newDataLabel}} </a>
		@endif
	</div>
	<div class="hidden-lg hidden-md hidden-sm col-xs-12 m-b-md">
		@if($disabled == false)
			<a class="btn btn-default" href="{{ $newDataRoute }}"><i class="fa fa-plus"></i>&nbsp; {{$newDataLabel}}</a>
		@else
			<a class="btn btn-default disabled" href="#"><i class="fa fa-plus"></i>&nbsp; {{$newDataLabel}}</a>
		@endif			
	</div>
    <div class="col-md-5 col-sm-8 col-xs-12">
		<form onSubmit="ajaxSearch(this);">
			<div class="row">
				<div class="col-md-7 col-sm-7 col-xs-4" style="padding-right:2px;">
					{!! Form::input('text', 'q', Null ,
							[
								'id'			=> 'data-search',
								'class'         => 'form-control',
								'placeholder'   => $searchLabel,
								'required'      => 'required',
							]
					) !!} 
				</div>
				<div class="col-md-2 col-sm-2 col-xs-3" style="padding-left:2px;">
					<button type="submit" class="btn btn-default pull-right btn-block"><i class="fa fa-search"></i></button>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-5" style="padding-left:2px;">
					@if(isset($filters['titles']))
						@foreach($filters['titles'] as $key => $title)
							@if(Input::get(strtolower($title)))
								<?php $filterActivated = true ?>
							@endif
						@endforeach

						@if(isset($filterActivated))
						<a class="btn btn-default active pull-right btn-block" data-toggle="collapse" data-target="#demo"><i class="fa fa-caret-down"></i> &nbsp; Filter</a>
						@else
						<a class="btn btn-default pull-right btn-block" data-toggle="collapse" data-target="#demo"><i class="fa fa-caret-down"></i> &nbsp; Filter</a>
						@endif
					@else
						<a class="btn btn-default pull-right btn-block" data-toggle="collapse" data-target="#demo"><i class="fa fa-caret-down"></i> &nbsp; Filter</a>
					@endif
				</div>				
			</div>
		</form>
		<div class="row">
			<div id="demo" class="collapse">
				<div class="col-md-12 panel-body">
					<h2 class="m-t-sm">Pilih Filter</h2>
					<ul class="nav nav-tabs">
					@if(isset($filters['titles']))
						@foreach($filters['titles'] as $key => $title)
							@if($key == 0)
								<li class="active"><a data-toggle="tab" href="#menu{{$key}}">{{ ucwords($title) }}</a></li>
							@else
								<li><a data-toggle="tab" href="#menu{{$key}}">{{ ucwords($title) }}</a></li>
							@endif
						@endforeach
					@endif
					</ul>

					<div class="tab-content col-md-12">
						@if(isset($filters['titles']))
							@foreach($filters['titles'] as $key => $title)
							@if($key == 0)
							<div id="menu{{$key}}" class="tab-pane m-t-md fade in active">
							@else
							<div id="menu{{$key}}" class="tab-pane m-t-md fade">							
							@endif
							@foreach($filters[$title] as $data)
								@if(Input::get(strtolower($title)))	
									@if(in_array($data, Input::get(strtolower($title))))
										<a class="btn btn-default active ajaxDataFilter" onClick="ajaxFilter(this)" data-togle="on" data-filter="{{ $data }}" data-type="{{$title}}" href="javascript:void(0)">
										<i class="fa fa-check-circle"></i>
									@else
										<a class="btn btn-default ajaxDataFilter" onClick="ajaxFilter(this)" data-togle="off" data-filter="{{ $data }}" data-type="{{$title}}" href="javascript:void(0)">
										<i class="fa fa-circle-thin"></i> 
									@endif
								@else
									<a class="btn btn-default ajaxDataFilter" onClick="ajaxFilter(this)" data-togle="off" data-filter="{{ $data }}" data-type="{{$title}}" href="javascript:void(0)">
									<i class="fa fa-circle-thin"></i> 
								@endif
									&nbsp; {{ ucwords(str_replace("-", " ", $data)) }} 
								</a>
							@endforeach
							</div>	
							@endforeach
						@endif
					</div>
				</div>
			</div>
		</div>
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
</div>
