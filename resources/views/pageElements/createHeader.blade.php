<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b-md border-bottom">
		@include('pageElements.pagetitle')
		@include('pageElements.breadcrumb')
	</div>
</div>

<!-- title sub-page -->
<div class="row">
    <div class="col-md-12 m-b-md">
        <h4 class="sub-header">
            {{ ucwords($title) }}
        </h4>               

        @include('pageElements.alertbox')
    </div>
</div>
<!-- end of title sub-page -->  