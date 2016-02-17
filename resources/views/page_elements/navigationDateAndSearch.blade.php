<div class="row">
	<div class="col-md-5 col-sm-4 col-xs-12">
		<form action='javascript:void(0)' onSubmit="ajaxMonthYearRange(this);">
			<div class="row">
				<div class="col-md-3 col-sm-12 col-xs-12">
					<h3 style="margin-top:7px;">Periode</h3>
				</div>
				<div class="col-md-6 col-sm-8 col-xs-8" style="padding-right:2px;">
					@if(Input::get('periode'))
					<?php 
						$range = Input::get('periode');
					?>
					@else
					<?php
						$range = date('m-Y');
					?>
					@endif
					{!! Form::input('text', 'periode', $range,  [
						'class'         => 'form-control month-year-format',
						'placeholder'   => 'mm-yyyy',
						'id'			=> 'monthyear'
					]) !!}
				</div>
				<div class="col-md-3 col-sm-4 col-xs-4" style="padding-left:2px;">
					<button type="submit" class="btn btn-default pull-right btn-block">Go</button>
				</div>
			</div>
		</form>
	</div>
<!-- 	<div class="col-md-2 col-sm-1 col-xs-12 m-b-md">
	</div> -->
	<div class="col-md-7 col-sm-8 col-xs-12" id="filters">
		<form action='javascript:void(0)' onSubmit="ajaxFilterSearch(this);">
			<div class="row">
				<div class="hidden-lg hidden-md col-sm-12 hidden-xs">
					<h3 style="margin-top:7px;">&nbsp;</h3>
				</div>
				<div class="col-md-3 col-sm-3 hidden-xs">
				</div>
				<div class="col-md-7 col-sm-7 col-xs-8" style="padding-right:2px;">
					{!! Form::input('text', 'q', Null ,
							[
								'id'			=> 'data-search',
								'class'         => 'form-control',
								'placeholder'   => 'Cari Produk',
								'required'      => 'required',
							]
					) !!} 
				</div>
				<div class="col-md-2 col-sm-2 col-xs-4" style="padding-left:2px;">
					<button type="submit" class="btn btn-default pull-right btn-block"><i class="fa fa-search"></i></button>
				</div>
			</div>
		</form>
	</div>
	</div>
</div>


@section('script_plugin')
	@include('plugins.ajaxPage')
	@include('plugins.inputMask')
@append