<!-- variable -->
<!-- data-url 		: data url -->

<script>
{{-- Paging--}}
function ajaxPaging(e) {
	var toUrl = $(e).attr("data-url");
	ajaxPage(toUrl);
	window.history.pushState("", "", toUrl);
};
{{-- End of Paging--}}


{{-- Search--}}
function ajaxSearch(e) {
	console.log(e);Clear 

	var q 		= $(e).find('#data-search').val();

	if(q == ""){
		return false;
	}

	var toUrl	= window.location.href;

	if(toUrl.indexOf("?") != -1) {
		toUrl	= toUrl.substring(0, toUrl.indexOf('?'));
	}

	toUrl 		= toUrl + "?q=" + q;

	ajaxPage(toUrl);
	window.history.pushState("", "", toUrl);
}
{{-- End of Search--}}


{{-- Clear Search--}}
function ajaxClearSearch() {
	var toUrl	= window.location.href;

	if(toUrl.indexOf("?") != -1) {
		toUrl	= toUrl.substring(0, toUrl.indexOf('?'));
	}

	ajaxPage(toUrl);
	window.history.pushState("", "", toUrl);	
}
{{-- End of Clear Search--}}


{{-- Filter --}}
function ajaxFilter(e) {
	var type = $(e).attr("data-type");
	var filter = $(e).attr("data-filter");
 }
{{-- End of Filter --}}



{{--Ajax Paging --}}
function ajaxPage(toUrl) {
	$("#contentData").hide(400);
	$.ajax({
	   url: toUrl,
	   type:'GET',
	   success: function(data){
	    	$('#contentData').html($(data).find('#contentData').html());
			$("#contentData").show(400);
	   }
	});
};
{{-- End of Ajax Paging--}}

</script>
