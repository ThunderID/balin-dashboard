{{-- 
	Readme
	------
	Utk filter non periode : filters['titles' => ['a','n'], 'a' => ['a.1', 'a.n'],'n' => []] )
	utk filter periode : filters['titles' => ['periode']];
--}}


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

	if(!isset($filters)){
		array_push($errors, "Data filter tidak ada ( var : filters['titles' => ['a','n'], 'a' => ['a.1', 'a.n'],'n' => []] )");
	}
?>

@if(count($errors) == 0)
<div class="row">		
	<div class="col-md-6 col-sm-5 hidden-xs">
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
    <div class="col-md-6 col-sm-7 col-xs-12">
		<form action='javascript:void(0)' onSubmit="ajaxSearch(this);">
			<div class="row" id="filters">
				@if(!isset($filters['titles']))
				<div class="col-md-3 col-sm-3 col-xs-5">
				</div>
				@endif
				<div class="col-md-7 col-sm-6 col-xs-5" style="padding-right:2px;">
					{!! Form::input('text', 'q', Null ,
							[
								'id'			=> 'data-search',
								'class'         => 'form-control',
								'placeholder'   => $searchLabel,
								'required'      => 'required',
							]
					) !!} 
				</div>
				<div class="col-md-2 col-sm-2 col-xs-2" style="padding-left:2px;">
					<button type="submit" class="btn btn-default pull-right btn-block" onClick="clearMonthYear()"><i class="fa fa-search"></i></button>
				</div>
				@if(isset($filters['titles']))
				<div class="col-md-3 col-sm-4 col-xs-5" style="padding-left:2px;">
					@foreach($filters['titles'] as $key => $title)
						@if(Input::get(strtolower($title)))
							<?php $filterActivated = true ?>
						@endif
					@endforeach
						@if(isset($filterActivated))
						<a class="btn btn-default active pull-right btn-block btn-filter" data-toggle="collapse" data-target="#demo">
							<i class="fa fa-caret-down"></i> &nbsp; Filter
						</a>
						@else
						<a class="btn btn-default pull-right btn-block btn-filter" data-toggle="collapse" data-target="#demo">
							<i class="fa fa-caret-down"></i> &nbsp; Filter
						</a>
					@endif
				</div>				
				@endif
			</div>
		</form>
		<div class="row">
			<div id="demo" class="collapse filter-panel">
				@if(isset($filters['titles']))
				<div class="col-md-12 panel-body">
					<h2 class="m-t-sm">Pilih Filter</h2>

					<ul class="nav nav-tabs">
					@foreach($filters['titles'] as $key => $title)
						@if($key == 0)
							<li class="active"><a data-toggle="tab" href="#menu{{$key}}">{{ ucwords($title) }}</a></li>
						@else
							<li><a data-toggle="tab" href="#menu{{$key}}">{{ ucwords($title) }}</a></li>
						@endif
					@endforeach
					</ul>

					<div class="tab-content col-md-12">
						@foreach($filters['titles'] as $key => $title)
							@if($title != 'periode')
								@if($key == 0)
								<div id="menu{{$key}}" class="tab-pane m-t-md fade in active">
								@else
								<div id="menu{{$key}}" class="tab-pane m-t-md fade">							
								@endif
								<div id="filter-{{$key}}">
								@foreach($filters[$title] as $key => $data)
									@if(Input::get(strtolower($title)))	
										@if(in_array(strtolower($data), Input::get(strtolower($title))))
											<a class="btn btn-default active ajaxDataFilter" onClick="ajaxFilter(this)"  data-filter="{{ str_replace(' ', '%20', $data) }}" data-type="{{$title}}" href="javascript:void(0)">
											<i class="fa fa-check-circle"></i>
										@else
											<a class="btn btn-default ajaxDataFilter" onClick="ajaxFilter(this)" data-filter="{{ str_replace(' ', '%20', $data) }}" data-type="{{$title}}" href="javascript:void(0)">
											<i class="fa fa-circle-thin"></i> 
										@endif
									@else
										<a class="btn btn-default ajaxDataFilter" onClick="ajaxFilter(this)" data-filter="{{ str_replace(' ', '%20', $data) }}" data-type="{{$title}}" href="javascript:void(0)">
										<i class="fa fa-circle-thin"></i> 
									@endif
										&nbsp; {{ $data }} 
									</a>
								@endforeach
								</div>	
								</div>	
							@else
								<div id="menu{{$key}}" class="tab-pane m-t-md fade in active">
									<div class="row">
										<form action='javascript:void(0)' onSubmit="filterPeriode(this);">
											<div class="col-sm-8 col-xs-7">
												<?php
													$tmp = Input::get('periode');
													if(count($tmp) > 0)
													{
														$dt = $tmp[0];
													}
													else
													{
														$dt = null;
													}
												?>
												{!! Form::input('text', 'periode', $dt,  [
													'class'         => 'form-control month-year-format',
													'placeholder'   => 'mm-yyyy',
													'id'			=> 'monthyear'
												]) !!}
											</div>
											<div class="col-sm-2 col-xs-3">
												<button type="submit" class="btn btn-default pull-right btn-block">Go</button>
											</div>
											<div class="col-sm-2 col-xs-2">
												<a class="btn btn-default" onClick="ajaxClearPeriode(this)" href="javascript:void(0)">
													<i class="fa fa-times"></i>
												</a>
											</div>								
										</form>
									</div>
								</div>	
							@endif
						@endforeach
					</div>
				</div>
				@endif
			</div>
		</div>
		<div class="row">
			<div id="demo2" class="collapse sort-panel">
				<div class="col-md-12 panel-body">
					<h2>Sort by</h2>
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
	$('.filter-panel').on('show.bs.collapse', function(e){
		$('.btn-filter').find('.fa').removeClass('fa-caret-down')
		$('.btn-filter').find('.fa').addClass('fa-caret-up')
		$('#demo2').collapse('hide');
	});

	$('.filter-panel').on('hide.bs.collapse', function(e){
		$('.btn-filter').find('.fa').removeClass('fa-caret-up')
		$('.btn-filter').find('.fa').addClass('fa-caret-down')
	});	

	$('.sort-panel').on('show.bs.collapse', function(e){
		$('.btn-sort').find('.fa').removeClass('fa-caret-down')
		$('.btn-sort').find('.fa').addClass('fa-caret-up')
		$('#demo').collapse('hide');
	});	

	$('.sort-panel').on('hide.bs.collapse', function(e){
		$('.btn-sort').find('.fa').removeClass('fa-caret-up')
		$('.btn-sort').find('.fa').addClass('fa-caret-down')
	});	

@append

@section('script_plugin')
	@include('plugins.ajaxPage')
	@include('plugins.inputMask')
@append