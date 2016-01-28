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

	$filters = 	[
					'titles' => ['Tag', 'Kategori', 'Label'],
					'Tag' 	=> ['abc','cde'],
					'Kategori' 	=> ['1abc','1cde'],
					'Label' 	=> ['2abc','2cde'],
				];
?>

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
					<a class="btn btn-default pull-right btn-block" data-toggle="collapse" data-target="#demo"><i class="fa fa-caret-down"></i> &nbsp; Filter</a>
				</div>				
			</div>
		</form>
		<div class="row">
			<div id="demo" class="collapse">
				<div class="col-md-12 panel-body">
					<h2 class="m-t-sm">Pilih Filter</h2>
					<ul class="nav nav-tabs">
					@if(isset($filters))
						@foreach($filters['titles'] as $key => $title)
							@if($key == 0)
								<li class="active"><a data-toggle="tab" href="#menu{{$key}}">{{$title}}</a></li>
							@else
								<li><a data-toggle="tab" href="#menu{{$key}}">{{$title}}</a></li>
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
									<a class="btn btn-default ajaxDataFilter" onClick="ajaxFilter(this)" data-filter="{{ $data }}" data-type="{{$title}}" href="javascript:void(0)">
									@if(Input::get(strtolower($title)))	
										@if(in_array($data, Input::get(strtolower($title))))
											<i class="fa fa-check-circle"></i>
										@else
											<i class="fa fa-circle-thin"></i> 
										@endif
									@else
										<i class="fa fa-circle-thin"></i> 
									@endif
										&nbsp; {{$data}} 
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

@section('scripts')
function filterData() {
	$("#contentData").hide(1000);
	$.ajax({
	   url:'{{ route('goods.product.index', ['page' => '2']) }}',
	   type:'GET',
	   success: function(data){
	       $('#contentData').html($(data).find('#contentData').html());
			$("#contentData").show(1000);
	   }
	});
};
@append