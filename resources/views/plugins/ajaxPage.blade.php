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

	var periode = getParameterByName('periode', toUrl);

	if(toUrl.indexOf("?") != -1) {
		toUrl	= toUrl.substring(0, toUrl.indexOf('?'));
	}

	$("#demo").collapse('hide');

	toUrl 		= toUrl + "?q=" + q ;
	if(periode != null)
	{
		toUrl	= toUrl + '&periode=' + periode;
	}

	toUrl 		= toUrl.replace(/(sort)[^\&]+/, '');

	toUrl		= toUrl.replace(/(page)[^\&]+/, '');

	clearSort();

	ajaxPage(toUrl);
	window.history.pushState("", "", toUrl);
}
{{-- End of Search--}}


{{-- Search--}}
function ajaxFilterSearch(e) {
	var q 		= $(e).find('#data-search').val();

	if(q == ""){
		return false;
	}

	var url     = window.location.href;
	var toUrl;

	var url		= url.replace(/(q=)[^\&]+/, '');

	if(url.indexOf("?") == -1) {
		toUrl 	= url + "?q=" + q;
	}else{
		toUrl 	= url + "&q=" + q;
	}

	toUrl		= toUrl.replace('&&', '&');

	toUrl 		= toUrl.replace(/(sort)[^\&]+/, '');

	toUrl		= toUrl.replace(/(page)[^\&]+/, '');

	clearSort();

	ajaxPage(toUrl);
	window.history.pushState("", "", toUrl);
}
{{-- End of Search--}}


{{-- month year range search--}}
function ajaxMonthYearRange(e) {
	var q 		= $(e).find('#monthyear').val();

	if(q == ""){
		return false;
	}

	var toUrl	= window.location.href;

	if(toUrl.indexOf("?") != -1) {
		toUrl	= toUrl.substring(0, toUrl.indexOf('?'));
	}

	toUrl 		= toUrl + "?periode=" + q;

	toUrl 		= toUrl.replace(/(sort)[^\&]+/, '');

	toUrl		= toUrl.replace(/(page)[^\&]+/, '');

	clearSort();

	ajaxPage(toUrl);
	window.history.pushState("", "", toUrl);
}
{{-- End of month year range search--}}


{{-- Clear Search--}}
function ajaxClearSearch() {
	var toUrl	= window.location.href;

	if(toUrl.indexOf("periode=") == -1){
		if(toUrl.indexOf("?") != -1) {
			toUrl	= toUrl.substring(0, toUrl.indexOf('?'));
		}
	}else{
		if(toUrl.indexOf("?") != -1) {
			toUrl	= toUrl.replace(/(q=)[^\&]+/, '');
		}
	}

	toUrl 		= toUrl.replace(/(sort)[^\&]+/, '');

	toUrl		= toUrl.replace(/(page)[^\&]+/, '');

	toUrl		= toUrl.replace('&&', '&');
	toUrl		= toUrl.replace('?&', '?');

	$("#demo").collapse('hide');

	clearSort();

	ajaxPage(toUrl);
	window.history.pushState("", "", toUrl);	
}
{{-- End of Clear Search--}}


{{-- Filter --}}
function ajaxFilter(e) {
	var type 	= $(e).attr("data-type").toLowerCase();
	var filter 	= $(e).attr("data-filter").toLowerCase();	

	var url     = window.location.href;

	url 		= url.replace('%C2%BD', '½');

	if(url.indexOf(type + "[]=" + filter) == -1){
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

	var id 		= $(e).parent().attr('id');

	var url     = window.location.href;
	var toUrl;

	url			= url.replace(/(page=)[^\&]+/, '');

	if(url.indexOf("?") == -1) {
		toUrl 	= url + "?" + type + "[]=" + filter;
	}else{
		toUrl 	= url + "&" + type + "[]=" + filter;
	}

	toUrl 		= toUrl.replace(/(sort)[^\&]+/, '');

	toUrl		= toUrl.replace('?&', '?');
	toUrl		= toUrl.replace('&&', '&');

	$(e).addClass("active");
	$(e).find(".fa").removeClass("fa-circle-thin");
	$(e).find(".fa").addClass("fa-refresh fa-spin");

	clearSort();

	ajaxPage(toUrl, id);

	window.history.pushState("", "", toUrl);
}
{{-- End of Add Filter --}}


{{-- Add Filter_Date_Range --}}
function filterDateRange(e){
	var url     = window.location.href;

	var toUrl	= url.substring(0, url.indexOf('?'));

	var start	= $(e).find('#start').val();
	var end		= $(e).find('#end').val();

	if(start == "" || end == ""){
		return false;
	}	

	toUrl 		= toUrl + '?' + 'start=' + start + '&' + 'end=' + end; 

	toUrl 		= toUrl.replace(/(sort)[^\&]+/, '');

	toUrl		= toUrl.replace(/(page)[^\&]+/, '');

	clearSort();

	ajaxPage(toUrl);

	window.history.pushState("", "", toUrl);
}
{{-- End Of Filter_Date_Range --}}


{{-- Clear Filter_Date_Range --}}
function clearDateRange(e){
	var url     = window.location.href;

	var toUrl	= url.substring(0, url.indexOf('?'));
	
	if(url.indexOf("start") != -1){
		toUrl 		= toUrl.replace(/(sort)[^\&]+/, '');

		toUrl		= toUrl.replace(/(page)[^\&]+/, '');

		clearSort();

		ajaxPage(toUrl);

		window.history.pushState("", "", toUrl);
	} else {
		return false;
	}
}
{{-- Clear Filter_Date_Range --}}


{{-- Add Filter Periode --}}
function filterPeriode(e){
	var q 		= $(e).find('#monthyear').val();

	if(q == ""){
		return false;
	}

	var url		= window.location.href;

	var toUrl	= url.replace(/(periode)[^\&]+/, '');

	if(url.indexOf("?") == -1) {
		toUrl 	= toUrl + "?periode[]=" + q;
	}else{
		toUrl 	= toUrl + "&periode[]=" + q;
	}

	toUrl 		= toUrl.replace(/(sort)[^\&]+/, '');

	toUrl		= toUrl.replace(/(page)[^\&]+/, '');

	toUrl		= toUrl.replace('?&', '?');
	toUrl		= toUrl.replace('&&', '&');

	clearSort();

	ajaxPage(toUrl);
	window.history.pushState("", "", toUrl);	
}
{{-- End of Filter Periode --}}


{{-- Clear Filter Periode--}}
function ajaxClearPeriode() {
	var url		= window.location.href;

	if(url.indexOf("&periode") != -1) {
		var toUrl		= url.replace(/(&periode)[^\&]+/, '');
	} else if(url.indexOf("periode") != -1){
		var toUrl		= url.replace(/(periode)[^\&]+/, '');
	} else {
		return false;
	}

	toUrl 		= toUrl.replace(/(sort)[^\&]+/, '');

	toUrl		= toUrl.replace(/(page)[^\&]+/, '');

	clearMonthYear();
	clearSort();

	ajaxPage(toUrl);
	window.history.pushState("", "", toUrl);	
}
{{-- End of Clear Filter Periode--}}


{{-- Remove Filter --}}
function ajaxRemoveFilter(e) {
	var type 	= $(e).attr("data-type").toLowerCase();
	var filter 	= $(e).attr("data-filter").toLowerCase();
	filter 		= filter.replace(" ","%20"); 

	var url     = window.location.href;
	url 		= url.replace('%C2%BD', '½');

	var toRemove= type + "[]=" + filter;
	var toUrl	= url.replace(toRemove, '');	

	toUrl 		= toUrl.replace(/(sort)[^\&]+/, '');

	toUrl		= toUrl.replace(/(page)[^\&]+/, '');

	toUrl		= toUrl.replace('?&', '?');

	$(e).removeClass("active");
	$(e).find(".fa").removeClass("fa-check-circle");
	$(e).find(".fa").addClass("fa-refresh fa-spin");

	var id 		= $(e).parent().attr('id');

	clearSort();

	ajaxPage(toUrl, id);
	window.history.pushState("", "", toUrl);
 }
{{-- End of Filter --}}


{{-- Sorting --}}
function ajaxSorting(e) {
	var type 	= $(e).attr("data-sort").toLowerCase();

	var url     = window.location.href;

	if(url.indexOf("sort=" + type) == -1){
		ajaxAddSort(e);
	}else{
		ajaxRemoveSort(e);
	}
}
{{-- End of Sorting --}}

{{-- add Sorting --}}
function ajaxAddSort(e) {
	var type 	= $(e).attr("data-sort").toLowerCase();
	var id 		= $(e).parent().attr('id');

	var url     = window.location.href;
	var toUrl	= url.replace(/(sort)[^\&]+/, '');

	toUrl 		= toUrl.replace(/(page)[^\&]+/, '');

	if(toUrl.indexOf("?") == -1) {
		toUrl 	= toUrl + "?sort=" + type;
	}else{
		toUrl 	= toUrl + "&sort=" + type;
	}	

	toUrl		= toUrl.replace('?&', '?');
	toUrl		= toUrl.replace('??', '?');
	toUrl		= toUrl.replace('&&', '&');

	clearSort();

	$(e).addClass("active");
	$(e).find(".fa").removeClass("fa-circle-thin");
	$(e).find(".fa").addClass("fa-refresh fa-spin");

	ajaxPage(toUrl, id);
	window.history.pushState("", "", toUrl);
}
{{-- end of add Sorting --}}


{{-- remove Sorting --}}
function ajaxRemoveSort(e) {
	var type 	= $(e).attr("data-sort").toLowerCase();
	var id 		= $(e).parent().attr('id');

	var url     = window.location.href;
	var toUrl	= url.replace(/(sort)[^\&]+/, '');

	toUrl		= toUrl.replace('?&', '?');
	toUrl		= toUrl.replace('&&', '&');

	$(e).removeClass("active");
	$(e).find(".fa").removeClass("fa-check-circle");
	$(e).find(".fa").addClass("fa-refresh fa-spin");

	ajaxPage(toUrl, id);
	window.history.pushState("", "", toUrl);	
}
{{-- end of remove Sorting --}}


{{--Ajax Paging --}}
function ajaxPage(toUrl,e) {
	$("#contentData").hide(400);
	$.ajax({
	   	url: toUrl,
	   	type:'GET',
	   	success: function(data){
	    	$('#contentData').html($(data).find('#contentData').html());
	    	$('#filters').html($(data).find('#filters').html());
	    	$('#' + e).html($(data).find('#' + e).html());
			$("#contentData").show(400);
			$("#filters").show(400);
			$("#" + e).show(400);
			tmpData = data;
	   	},
	   	error: function(){
	   		var error = "</br></br><h2 class='text-center m-t-md'>Terjadi masalah penerimaan data, silahkan muat ulang halaman</h2>";

	    	$('#contentData').html(error);
			$("#contentData").show(400);
	   	}
	});	
};
{{-- End of Ajax Paging--}}

{{-- UI--}}
	function clearMonthYear(){
		$('#monthyear').val("");
	}

	function clearSort(){
		$('.ajaxDataSort').removeClass("active");
		$('.ajaxDataSort').find(".fa").removeClass("fa-check-circle");
		$('.ajaxDataSort').find(".fa").removeClass("fa-spin");
		$('.ajaxDataSort').find(".fa").addClass("fa-circle-thin");
	}
{{-- End of UI--}}

{{-- Functions --}}
	function getParameterByName(name, url) {
	    if (!url) url = window.location.href;
	    name = name.replace(/[\[\]]/g, "\\$&");
	    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
	        results = regex.exec(url);
	    if (!results) return null;
	    if (!results[2]) return '';
	    return decodeURIComponent(results[2].replace(/\+/g, " "));
	}
{{-- end of Functions --}}

</script>
