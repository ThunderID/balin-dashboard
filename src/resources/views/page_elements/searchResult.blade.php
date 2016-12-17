@if(isset($searchResult))
</br>
	<div class="row">
	    <div class="col-lg-12">
	        <div class="alert alert-info m-b-none" style="margin-top: 7px;">
				Menampilkan data pencarian "{{$searchResult}}" (<a href="javascript:void(0)" onClick="ajaxClearSearch()">close</a>)
	        </div>
	    </div>
	</div>
@endif