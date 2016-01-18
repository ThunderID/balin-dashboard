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
			@include('pageElements.alertbox')
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b-md">
			@include('pageElements.indexNavigation', [
				'newDataRoute' 		=> route('admin.category.create'),
				'filterDataRoute' 	=> route('admin.category.index')
			])
			@include('pageElements.searchResult', [
				'closeSearchLink' 	=> route('admin.category.index') 
			])
		</div>
	</div>
	</br> 

<!-- end of head -->

<!-- content -->
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
			<div class="table-responsive">
				<table class="table table-bordered table-hover table-striped">
					<thead>
						<tr>
							<th colspan="2">Nama Kategori</th>
							<th class="text-center col-md-2">Kontrol</th>
						</tr>
					</thead>
					<tbody>
						@if (count($data['category']['data']) == 0)
							<tr>
								<td colspan="6" class="text-center">
									Tidak ada data
								</td>
							</tr>
						@else                                                                                           
							@foreach ($data['category']['data'] as $dt)
								<tr>
									<td>
										@if ($dt['category_id'] == 0)
											<i class="fa fa-circle" style="font-size:5px; margin-left:5px;"></i>
										@endif
									</td>
									<td class="col-md-10">
										<p class="text-capitalize">
											@for ($i = 0; $i < substr_count($dt['path'],','); $i++)
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											@endfor
											{{$dt['name']}}
										</p>
									</td>
									<td class="text-center">
										<a href="{{ route('admin.category.show',  $dt['id']) }}"> Detail</a>,
										<a href="{{ route('admin.category.edit', ['id' => $dt['id']]) }}"> Edit</a>, 
										<a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#category_del"
											data-id="{{$dt['id']}}"
											data-title="Hapus Data category {{$dt['name']}}"
											data-action="{{ route('admin.category.destroy', $dt['id']) }}">
											Hapus
										</a>                                                                                 
									</td>    
								</tr>
							@endforeach 
							@include('pageElements.modaldelete', [
								'modal_id'      => 'category_del', 
								'modal_route'   => 'pageElements.modalDelete'
							])                                    
						@endif
					</tbody>
				</table> 
			</div>                 
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 hollow-pagination" style="text-align:right;">
			{!! $paging->appends(Input::all())->render() !!}
		</div>	
	</div>		
<!-- end of content -->

</div>					
@stop