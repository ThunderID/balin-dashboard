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

    <!-- title sub-page -->
    <div class="row">
        <div class="col-md-12 m-b-md">
            <h4 class="sub-header">
                Data Kategori {{ $data['name'] }}
            </h4>               

            @include('pageElements.alertbox')
        </div>
    </div>
    <!-- end of title sub-page -->   
<!-- end of head -->

<!-- body -->
	@if(!isset($data['id']))
    {!! Form::open(['url' => route('admin.category.store'), 'method' => 'POST']) !!}
    @else
    {!! Form::open(['url' => route('admin.category.update', $data['id']), 'method' => 'PATCH']) !!}
    @endif
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="parent" class="text-capitalize">Kelompok Kategori</label>
                    {!! Form::text('parent', $data['category_id'], [
                                'class'         => 'select-category', 
                                'tabindex'      => '1', 
                                'id'            => 'find_category',
                                'placeholder'   => 'Kosongkan bila tidak ada',
                                'style'         => 'width:100%'
                    ]) !!}
                </div>              
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="name" class="text-capitalize">Nama Kategori</label>
                    {!! Form::text('name', $data['name'], [
                                'class'         => 'form-control', 
                                'required'      => 'required', 
                                'tabindex'      => '2',
                                'placeholder'   => 'Masukkan nama kategori'
                    ]) !!}
                </div>   
                </br>
                <div class="form-group text-right">
                    <a href="{{ URL::route('admin.category.index') }}" class="btn btn-md btn-default" tabindex="3">Batal</a>
                    <button type="submit" class="btn btn-md btn-primary" tabindex="4">Simpan</button>
                </div>
            </div>                                          
        </div>
    {!! Form::close() !!}
<!-- end of body -->
@stop

@section('scripts')
    var preload_data_category = [];
    @if($data['category_id'])
        var id                      = {!! $data['category_id'] !!};
        var text                    = "{!! $data['category']['name'] !!}";
        preload_data_category.push({ id: id, text: text});
    @else
        var preload_data_category   = [];
    @endif
@stop

@section('script_plugin')
    @include('plugins.select2', ['max_input' => 1, 'section' => 'category'])
@stop