<div class="col-md-12" style="text-align:right;">
	<?php
		$tmpPaging = $paging->appends(Input::all())->render();
		$paging = str_replace("href=", "onClick='ajaxPaging(this)' data-url=", $tmpPaging);
		$paging = preg_replace("/\[[^)]+\]/","[]",$paging);
	?>
	{!! $paging !!}
</div>	