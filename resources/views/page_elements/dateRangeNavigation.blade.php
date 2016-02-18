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
		<div class="col-md-1 col-sm-1 col-xs-4 text-center m-t-sm">
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

		<div class="col-md-1 col-sm-1 col-xs-4 text-center m-t-sm">
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

		<div class="col-md-1 col-sm-1 hidden-xs" style="padding-right: 0px;">
			@if($disabled ==  true)
				<a type="submit" class="btn btn-default btn-block disabled">Go</a>
			@else
				<button type="submit" class="btn btn-default btn-block">Go</button>
			@endif
		</div>

		<div class="hidden-lg hidden-md hidden-sm col-xs-12">
			@if($disabled ==  true)
				<a type="submit" class="btn btn-default btn-block disabled">Go</a>
			@else
				<button type="submit" class="btn btn-default btn-block">Go</button>
			@endif
		</div>		

		<div class="col-md-1 col-sm-1 hidden-xs">
			<a id="clearbtn" class="btn btn-default" onClick="clearDateRange(this)" href="javascript:void(0)">
				<i class="fa fa-times"></i>
			</a>
		</div>

		@if(isset($sorts['titles']))
		<div class="hidden-lg hidden-md hidden-sm col-xs-6 m-t-sm" style="padding-right: 4px;">
		@else
		<div class="hidden-lg hidden-md hidden-sm col-xs-12 m-t-sm">
		@endif
			<a class="btn btn-default btn-block" onClick="clearDateRange(this)" href="javascript:void(0)">
				<i class="fa fa-times"></i>
			</a>
		</div>

		@if(isset($sorts['titles']))
			@if(Input::get('sort'))
				<?php $stat_sort = "active"; ?>
			@else
				<?php $stat_sort = null; ?>
			@endif
			<div class="col-md-2 col-sm-2 hidden-xs">
				<a class="btn btn-default {{ $stat_sort }} pull-right btn-block btn-sort"  data-toggle="collapse" data-target="#demo2">
					<i class="fa fa-caret-down"></i> &nbsp; Sort
				</a>	
			</div>
			<div class="hidden-lg hidden-md hidden-sm col-xs-6 m-t-sm" style="padding-left: 4px;">
				<a class="btn btn-default {{ $stat_sort }} pull-right btn-block"  data-toggle="collapse" data-target="#demo2">
					<i class="fa fa-sort-amount-asc"></i>
				</a>
			</div>
		@endif
	</div>
	@if($disabled ==  false)
		</form>
	@endif
	<div class="row">
    <div class="col-md-5 col-sm-4 hidden-xs">
    </div>
    <div class="col-md-7 col-sm-8 col-xs-12">
		<div class="row">
			<div id="demo2" class="collapse sort-panel">
				@if(isset($sorts['titles']))
				<div class="col-md-12 panel-body">
					<h2>Sort by</h2>

					<ul class="nav nav-tabs">
					@foreach($sorts['titles'] as $key => $title)
						@if($key == 0)
							<li class="active"><a data-toggle="tab" href="#menu_sort{{$key}}">{{ ucwords(str_replace('_', ' ', $title)) }}</a></li>
						@else
							<li><a data-toggle="tab" href="#menu_sort{{$key}}">{{ ucwords(str_replace('_', ' ', $title)) }}</a></li>
						@endif				
					@endforeach
					</ul>	

					<div class="tab-content col-md-12">
						@foreach($sorts['titles'] as $key => $title)
							@if($key == 0)
							<div  id="menu_sort{{$key}}" class="tab-pane m-t-md fade in active">
							@else
							<div  id="menu_sort{{$key}}" class="tab-pane m-t-md fade">							
							@endif

								<div id="sort-{{$key}}">
								@foreach($sorts[$title]['subtitle'] as $key => $data)
									@if(Input::get('sort'))	
										@if(in_array($sorts[$title]['code'][$key], [strtolower(Input::get('sort'))]))
											<a class="btn btn-default active ajaxDataSort" onClick="ajaxSorting(this)"  data-sort="{{ $sorts[$title]['code'][$key] }}"  href="javascript:void(0)">
											<i class="fa fa-check-circle"></i> 
										@else
											<a class="btn btn-default ajaxDataSort" onClick="ajaxSorting(this)"  data-sort="{{ $sorts[$title]['code'][$key] }}"  href="javascript:void(0)">
											<i class="fa fa-circle-thin"></i> 
										@endif
									@else
										<a class="btn btn-default ajaxDataSort" onClick="ajaxSorting(this)"  data-sort="{{ $sorts[$title]['code'][$key] }}"  href="javascript:void(0)">
										<i class="fa fa-circle-thin"></i> 						
									@endif								
										&nbsp; {{ ucwords($data) }} 
									</a>
								@endforeach
								</div>

							</div>
						@endforeach
					</div>
				</div>
				@endif
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
	$('.sort-panel').on('show.bs.collapse', function(e){
		$('.btn-sort').find('.fa').removeClass('fa-caret-down')
		$('.btn-sort').find('.fa').addClass('fa-caret-up')
		$('#demo').collapse('hide');
	});	

	$('.sort-panel').on('hide.bs.collapse', function(e){
		$('.btn-sort').find('.fa').removeClass('fa-caret-up')
		$('.btn-sort').find('.fa').addClass('fa-caret-down')
	});	

	$('#clearbtn').click(function() {
		$('.date-format').val('');
	});
@append

	
@section('script_plugin')
	@include('plugins.ajaxPage')
	@include('plugins.inputMask')
@append