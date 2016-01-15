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
                Data Tag {{ $data['name'] }}
            </h4>               

            @include('pageElements.alertbox')
        </div>
    </div>
    <!-- end of title sub-page -->      
<!-- end of head -->

<!-- body -->
	@if(!isset($data['id']))
    {!! Form::open(['url' => route('admin.tag.store'), 'method' => 'POST']) !!}
    @else
    {!! Form::open(['url' => route('admin.tag.update', $data['id']), 'method' => 'PATCH']) !!}
    @endif
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="category_id" class="text-capitalize">Kelompok Tag</label>
                    {!! Form::text('category_id', $data['category_id'], [
                                'class'         => 'select-tag', 
                                'tabindex'      => '1', 
                                'id'            => 'find_tag',
                                'placeholder'   => 'Kosongkan bila tidak ada',
                                'style'         => 'width:100%'
                    ]) !!}
                </div>              
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="name" class="text-capitalize">Nama Tag</label>
                    {!! Form::text('name', $data['name'], [
                                'class'         => 'form-control', 
                                'required'      => 'required', 
                                'tabindex'      => '2',
                                'placeholder'   => 'Masukkan nama tag'
                    ]) !!}
                </div>   
                </br>
                <div class="form-group text-right">
                    <a href="{{ URL::route('admin.tag.index') }}" class="btn btn-md btn-default" tabindex="3">Batal</a>
                    <button type="submit" class="btn btn-md btn-primary" tabindex="4">Simpan</button>
                </div>
            </div>                                          
        </div>
    {!! Form::close() !!}
<!-- end of body -->
@stop


@section('scripts')
    var preload_data_tag            = [];
    @if($data['category_id'])
        var id                      = {!! $data['category_id'] !!};
        var text                    = '{!! $data['tag']['name'] !!}';
        preload_data_tag.push({ id: id, text: text});
    @else
        var preload_data_tag        = [];
    @endif
@stop


@section('script_plugin')
    @include('plugins.select2', ['max_input' => 1, 'section' => 'tag'])
@stop
