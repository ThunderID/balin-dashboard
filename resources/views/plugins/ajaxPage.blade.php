<!-- variable -->
<!-- data-url 		: data url -->

<script>
var tmpData;

{{-- Paging--}}
function ajaxPaging(e) {
	var toUrl = $(e).attr("data-url");
	ajaxPage(toUrl);
	window.history.pushState("", "", toUrl);
};
{{-- End of Paging--}}


{{-- Search--}}
function ajaxSearch(e) {
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
	var togle 	= $(e).attr("data-togle").toLowerCase();

	if(togle == "off"){
		ajaxAddFilter(e);
	}else{
		ajaxRemoveFilter(e);
	}
 }
{{-- End of Filter --}}


{{-- Add Filter --}}
function ajaxAddFilter(e){
	var type 	= $(e).attr("data-type").toLowerCase();
	var filter 	= $(e).attr("data-filter").toLowerCase();

	var url     = window.location.href;
	var toUrl;

	var url		= url.replace(/(page=)[^\&]+/, '');

	if(url.indexOf("?") == -1) {
		toUrl 	= url + "?" + type + "[]=" + filter;
	}else{
		toUrl 	= url + "&" + type + "[]=" + filter;
	}

	$(e).addClass("active");
	$(e).find(".fa").removeClass("fa-circle-thin");
	$(e).find(".fa").addClass("fa-check-circle");

	ajaxPage(toUrl);

	window.history.pushState("", "", toUrl);
}
{{-- End of Add Filter --}}


{{-- Remove Filter --}}
function ajaxRemoveFilter(e) {
	var type 	= $(e).attr("data-type").toLowerCase();
	var filter 	= $(e).attr("data-filter").toLowerCase();
	var url     = window.location.href;

	var toRemove = "&" + type + "[]=" + filter;
	var toUrl	= url.replace(toRemove, '');

	toRemove 	= type + "[]=" + filter;
	toUrl		= toUrl.replace(toRemove, '');

	toUrl		= toUrl.replace('?&', '?');

	$(e).removeClass("active");
	$(e).find(".fa").removeClass("fa-check-circle");
	$(e).find(".fa").addClass("fa-circle-thin");

	ajaxPage(toUrl);
	window.history.pushState("", "", toUrl);
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
	    	$('#filters').html($(data).find('#filters').html());
			$("#contentData").show(400);
			$("#filters").show(400);
			tmpData = data;
	   	}
	});
};
{{-- End of Ajax Paging--}}

</script>
