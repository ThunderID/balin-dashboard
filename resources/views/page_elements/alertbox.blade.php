@if(Session::has('msg') || $errors->any())
	<div class="row">
	    <div class="col-lg-12">
	        <div class="alert alert-{{Session::get('msg-type')}} alert-dismissable m-b-none" style="margin-top: 7px;">
	            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                @if(Session::has('msg'))
	                {!!Session::get('msg')!!}
	                @if(Session::has('msg-action') && Session::has('msg-title'))
	                	<a href="{!! Session::get('msg-action') !!}">
	                		{!! Session::get('msg-title') !!}
	                	</a>
	                @endif
                @else
    	            @foreach ($errors->all('<p>:message</p>') as $error)
		                {!! $error !!}
		            @endforeach
                @endif
	        </div>
	    </div>
	</div>
@endif