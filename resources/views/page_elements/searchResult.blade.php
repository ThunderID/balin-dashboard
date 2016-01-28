@if(isset($searchResult))
</br>
<div class="row">
	<div class="col-md-12">
		Menampilkan data pencarian "{{$searchResult}}" (<a href="javascript:void(0)" onClick="ajaxClearSearch()">close</a>)
	</div>
</div>
@endif