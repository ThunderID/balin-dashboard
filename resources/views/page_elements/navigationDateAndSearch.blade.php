<div class="row">
	<div class="col-md-4">
		<div class="row">
			<form action='javascript:void(0)' onSubmit="ajaxMonthYearRange(this);">
				<div class="col-md-3">
					<h3 style="margin-top:7px;">Periode</h3>
				</div>
				<div class="col-md-7">
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
				<div class="col-md-2">
					<button type="submit" class="btn btn-default pull-right btn-block">Go</button>
				</div>
			</form>
		</div>
	</div>
	<div class="col-md-2">
	</div>
	<div class="col-md-6">
		<form action='javascript:void(0)' onSubmit="ajaxFilterSearch(this);">
			<div class="row">
				<div class="col-md-3">
				</div>
				<div class="col-md-7 col-sm-7 col-xs-4" style="padding-right:2px;">
					{!! Form::input('text', 'q', Null ,
							[
								'id'			=> 'data-search',
								'class'         => 'form-control',
								'placeholder'   => 'Cari Produk',
								'required'      => 'required',
							]
					) !!} 
				</div>
				<div class="col-md-2 col-sm-2 col-xs-3" style="padding-left:2px;">
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