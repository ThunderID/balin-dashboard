@if(Session::has('msg') || $errors->any())
	<div class="row">
	    <div class="col-lg-12">
	        <div class="alert alert-{{Session::get('msg-type')}} alert-dismissable">
	            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                @if(Session::has('msg'))
	                {!!Session::get('msg')!!}
                @else
    	            @foreach ($errors->all('<p>:message</p>') as $error)
		                {!! $error !!}
		            @endforeach
                @endif
	        </div>
	    </div>
	</div>
@endif