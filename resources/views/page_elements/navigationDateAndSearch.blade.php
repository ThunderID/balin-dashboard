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
</div>


@section('script_plugin')
	@include('plugins.ajaxPage')
	@include('plugins.inputMask')
@append