@extends('page_templates.layout')
@section('content')
<div class="container-fluid">
<!-- head -->
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b-md border-bottom">
			@include('pageElements.pagetitle')
			@include('pageElements.breadcrumb')
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b-md">
			@include('pageElements.indexNavigation', [
				'newDataRoute' 		=> route('admin.point.create'),
				'filterDataRoute' 	=> route('admin.point.index')
			])
			@include('pageElements.searchResult', [
				'closeSearchLink' 	=> route('admin.point.index') 
			])
		</div>
	</div>
	</br>
<!-- end of head -->

<!-- content -->
	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
				<table class="table table-bordered table-hover table-striped">
					<thead>
						<tr>
							<th class="col-md-1 text-left">No.</th>							
							<th class="col-md-6 text-left">Nama Customer</th>
							<th class="col-md-3 text-center">Jumlah Poin</th>
							<th class="text-center col-md-2">Kontrol</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="text-left">
								nomer
							</td>

							<td class="text-left">
								nama
							</td>

							<td class="text-center">
								poin
							</td>

							<td class="text-right">
								
							</td>																		
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
<!-- end of content -->

</div>
@stop