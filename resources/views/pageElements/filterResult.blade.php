@if(isset($searchResult))
</br>
<div class="row">
	<div class="col-md-12">
		Menampilkan data filter : "{{$searchResult}}" (<a href="{{ $closeSearchLink }}">close</a>)
	</div>
</div>
@endif