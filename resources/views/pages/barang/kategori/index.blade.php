@extends('page_templates.layout')
@section('content')
<div class="container-fluid">
<!-- head -->
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b-md border-bottom">
			@include('page_elements.pagetitle')
			@include('page_elements.breadcrumb')
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b-md">
			@include('page_elements.alertbox')
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			@include('page_elements.indexNavigation', [
				'newDataRoute' 		=> route('goods.category.create'),
				'filterDataRoute' 	=> route('goods.category.index'),
				'filters'			=> []
			])
		</div>
	</div>

	<div id="contentData">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12 m-b-md">
				@include('page_elements.searchResult', [
					'closeSearchLink' 	=> route('goods.category.index') 
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
											<a href="{{ route('goods.category.show',  $dt['id']) }}"> Detail</a>,
											<a href="{{ route('goods.category.edit', ['id' => $dt['id']]) }}"> Edit</a>, 
											<a href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#category_del"
												data-id="{{$dt['id']}}"
												data-title="Hapus Data category {{$dt['name']}}"
												data-action="{{ route('goods.category.destroy', $dt['id']) }}">
												Hapus
											</a>                                                                                 
										</td>    
									</tr>
								@endforeach 
								@include('page_elements.modaldelete', [
									'modal_id'      => 'category_del', 
									'modal_route'   => 'page_elements.modalDelete'
								])                                    
							@endif
						</tbody>
					</table> 
				</div>                 
			</div>
		</div>
		<div class="row">
			@include('page_elements.ajaxPaging')
		</div>		
<!-- end of content -->

	</div>					
</div>					
@stop