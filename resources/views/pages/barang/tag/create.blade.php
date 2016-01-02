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
<!-- end of head -->

<!-- body -->
	@if(!isset($data['id']))
    {!! Form::open(['url' => route('admin.tag.update', $data['id']), 'method' => 'PATCH']) !!}
    @else
    {!! Form::open(['url' => route('admin.tag.store'), 'method' => 'POST']) !!}
    @endif
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="parent" class="text-capitalize">Kelompok Tag</label>
                    {!! Form::text('parent', $data['category_id'], [
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

@section('script')
    var preload_data = [];
    @if($data['category_id'])
        var preload_data_tag    = [];
        var id              = {!! $data['category_id'] !!};
        var text            = "{!! $data['category']['name'] !!}";
        preload_data_tag.push({ id: id, text: text});
    @else
        var preload_data_tag    = [];
    @endif
@stop

@section('script_plugin')
    @include('plugins.select2')
@stop