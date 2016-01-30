<script>

function change_button_add(e)
{
	var btn 			= '';
	var btn_template 	= $(e).parent();

	e.remove();
	btn 				+= '<a href="javascript:;" class="btn btn-sm btn-default m-t-mds btn-del"><i class="fa fa-minus"></i></a>';

	btn_template.html(btn);
	$('.btn-del').click(function() {template_del_product($(this))});
}

@if($section == "product")
	$('.btn-del').click(function() {template_del_product($(this))});
	function template_del_product(e)
	{
		e.parent().parent().parent().parent().parent().remove();
		$('.wizard .content').animate({ height: $('.body.current').outerHeight() }, "slow");
		$('.btn-del').click(function() {template_del_product($(this))});
		// calculate_total_transaction();
	}

	// section product create
	$('.btn-add-image').click(function() {template_add_image($(this));});
	function template_add_image(e)
	{
		var default_val 	= $('#tmplt').find('.default').val();
		var tmp 			= $('#tmplt').clone();

		tmp.find('.default').val(default_val);

		$('#template-image').append(tmp);
		change_button_add(e);

		$('#default select').val($('.fieldsetwrapper select').val());
		$('.btn-add-image').click(function() {template_add_image($(this));});
	}
	// end of section product create
@endif

@if($section == "buy")
	$('.btn-del').click(function() {template_del_product($(this))});
	function template_del_product(e)
	{
		e.parent().parent().parent().parent().remove();
		$('.wizard .content').animate({ height: $('.body.current').outerHeight() }, "slow");
		$('.btn-del').click(function() {template_del_product($(this))});
		// calculate_total_transaction();
	}

	// section detail create
	$('.btn-add-details').click(function() {template_add_details($(this));});
	function template_add_details(e)
	{
		var default_val 	= $('#tmplt').find('.default').val();
		var tmp 			= $('#tmplt').clone();

		tmp.find('.default').val(default_val);

		$('#template-details').append(tmp);
		change_button_add(e);

		$('#default select').val($('.fieldsetwrapper select').val());

		$(".money").inputmask({ rightAlign: false, alias: "numeric", prefix: 'IDR ', radixPoint: '', placeholder: "", autoGroup: !0, digitsOptional: !1, groupSeparator: '.', groupSize: 3, repeat: 15 });              
		$('.btn-add-details').click(function() {template_add_details($(this));});
	}
	// end of section detail create	
@endif


</script>