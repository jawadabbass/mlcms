@php
    $field_counter = count(old('field_name', []));
    if($field_counter == 0){
        $field_counter = 1;
    }
    $fieldsStr = '';
    for ($counter = 1; $counter <= $field_counter; $counter++) {
        $hide_show = 'show';
        if($counter == 1){
            $hide_show = 'hide';
        }
        $fieldsStr .= generateModuleCodeFieldLabel($counter, $errors, old(), $hide_show);
    }
@endphp
@extends('back.layouts.app', ['title' => $title])
@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="row">
                <div class="col-md-5 col-sm-12">
                    <ol class="breadcrumb">
                        <li>
                            <a href="{{ base_url() . 'adminmedia' }}">
                                <i class="fas fa-tachometer-alt"></i> Home
                            </a>
                        </li>
                        <li class="active">
                            <a href="{{ base_url() . 'adminmedia/module-code-generator' }}">
                                Module Code Generator
                            </a>
                        </li>
                    </ol>
                </div>
                <div class="col-md-7 col-sm-12">
                    @include('back.common_views.quicklinks')
                </div>
            </div>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="box">
                        @include('flash::message')
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('generate.module.code') }}" method="POST" class="form-horizontal"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="field_counter" id="field_counter" value="{{ ++$field_counter }}" />
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-12 mb-3" id="fields_container">{!! $fieldsStr !!}</div>
                                    <div class="col-md-10 mb-3 text-end"><button type="button" class="btn btn-success"
                                            onclick="addField();">Add New Field</button></div>
                                    <div class="col-md-2 mb-3">&nbsp;</div>

                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Model Name:*</label>
                                        <input id="MODEL_NAME_STUB" name="MODEL_NAME_STUB"
                                            value="{{ old('MODEL_NAME_STUB', '') }}" type="text"
                                            class="form-control {{ hasError($errors, 'MODEL_NAME_STUB') }}"
                                            placeholder="CabinDimension">
                                        {!! showErrors($errors, 'MODEL_NAME_STUB') !!}
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Model Name Plural:*</label>
                                        <input id="MODEL_NAME_PLURAL_STUB" name="MODEL_NAME_PLURAL_STUB"
                                            value="{{ old('MODEL_NAME_PLURAL_STUB', '') }}" type="text"
                                            class="form-control {{ hasError($errors, 'MODEL_NAME_PLURAL_STUB') }}"
                                            placeholder="CabinDimensions">
                                        {!! showErrors($errors, 'MODEL_NAME_PLURAL_STUB') !!}
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Model Name With Space:*</label>
                                        <input id="MODEL_NAME_WITH_SPACE_STUB" name="MODEL_NAME_WITH_SPACE_STUB"
                                            value="{{ old('MODEL_NAME_WITH_SPACE_STUB', '') }}" type="text"
                                            class="form-control {{ hasError($errors, 'MODEL_NAME_WITH_SPACE_STUB') }}"
                                            placeholder="Cabin Dimension">
                                        {!! showErrors($errors, 'MODEL_NAME_WITH_SPACE_STUB') !!}
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Model Name Plural With Space:*</label>
                                        <input id="MODEL_NAME_PLURAL_WITH_SPACE_STUB"
                                            name="MODEL_NAME_PLURAL_WITH_SPACE_STUB"
                                            value="{{ old('MODEL_NAME_PLURAL_WITH_SPACE_STUB', '') }}" type="text"
                                            class="form-control {{ hasError($errors, 'MODEL_NAME_PLURAL_WITH_SPACE_STUB') }}"
                                            placeholder="Cabin Dimensions">
                                        {!! showErrors($errors, 'MODEL_NAME_PLURAL_WITH_SPACE_STUB') !!}
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Model Name Collection:*</label>
                                        <input id="MODEL_NAME_COLLECTION_STUB" name="MODEL_NAME_COLLECTION_STUB"
                                            value="{{ old('MODEL_NAME_COLLECTION_STUB', '') }}" type="text"
                                            class="form-control {{ hasError($errors, 'MODEL_NAME_COLLECTION_STUB') }}"
                                            placeholder="cabinDimensions">
                                        {!! showErrors($errors, 'MODEL_NAME_COLLECTION_STUB') !!}
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Controller Name:*</label>
                                        <input id="CONTROLLER_NAME_STUB" name="CONTROLLER_NAME_STUB"
                                            value="{{ old('CONTROLLER_NAME_STUB', '') }}" type="text"
                                            class="form-control {{ hasError($errors, 'CONTROLLER_NAME_STUB') }}"
                                            placeholder="CabinDimension">
                                        {!! showErrors($errors, 'CONTROLLER_NAME_STUB') !!}
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Admin Resources Folder Name:*</label>
                                        <input id="ADMIN_RESOURCES_STUB" name="ADMIN_RESOURCES_STUB"
                                            value="{{ old('ADMIN_RESOURCES_STUB', '') }}" type="text"
                                            class="form-control {{ hasError($errors, 'ADMIN_RESOURCES_STUB') }}"
                                            placeholder="cabin_dimensions">
                                        {!! showErrors($errors, 'ADMIN_RESOURCES_STUB') !!}
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Object Name:*</label>
                                        <input id="OBJECT_NAME_STUB" name="OBJECT_NAME_STUB"
                                            value="{{ old('OBJECT_NAME_STUB', '') }}" type="text"
                                            class="form-control {{ hasError($errors, 'OBJECT_NAME_STUB') }}"
                                            placeholder="cabinDimension">
                                        {!! showErrors($errors, 'OBJECT_NAME_STUB') !!}
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">DB Table Name:*</label>
                                        <input id="DB_TABLE_NAME_STUB" name="DB_TABLE_NAME_STUB"
                                            value="{{ old('DB_TABLE_NAME_STUB', '') }}" type="text"
                                            class="form-control {{ hasError($errors, 'DB_TABLE_NAME_STUB') }}"
                                            placeholder="cabin_dimensions">
                                        {!! showErrors($errors, 'DB_TABLE_NAME_STUB') !!}
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Main Field i.e TITLE or NAME:*</label>
                                        <input id="MAIN_FIELD_TITLE_OR_NAME_STUB" name="MAIN_FIELD_TITLE_OR_NAME_STUB"
                                            value="{{ old('MAIN_FIELD_TITLE_OR_NAME_STUB', '') }}" type="text"
                                            class="form-control {{ hasError($errors, 'MAIN_FIELD_TITLE_OR_NAME_STUB') }}"
                                            placeholder="title or name">
                                        {!! showErrors($errors, 'MAIN_FIELD_TITLE_OR_NAME_STUB') !!}
                                    </div>
                                    <div class="col-12 mb-4">
                                        <button type="submit"  class="btn btn-success">Generate Code</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.box -->
                    <!-- /.box -->
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    
@endsection
@section('beforeBodyClose')
    <script>
        function addField() {
            let field_counter = parseInt($('#field_counter').val());
            $('#field_counter').val(field_counter + 1);
            let str = `
                        <div class="row">
                            <div class="col-md-5 mb-1 field_${field_counter}">
                                <label class="form-label">Field Name:*</label>
                                <input name="field_name[]" value=""
                                    type="text"
                                    class="form-control {{ hasError($errors, 'field_name') }}"
                                    placeholder="student_name">
                                {!! showErrors($errors, 'field_name') !!}
                            </div>
                            <div class="col-md-5 mb-1 field_${field_counter}">
                                <label class="form-label">Field Label:*</label>
                                <input name="field_label[]" value=""
                                    type="text"
                                    class="form-control {{ hasError($errors, 'field_label') }}"
                                    placeholder="Student Name">
                                {!! showErrors($errors, 'field_label') !!}
                            </div>
                            <div class="col-md-2 mb-1 field_${field_counter} show">
                                <label class="form-label">&nbsp;</label><br/>
                                <button type="button" class="btn btn-danger" onclick="removeField(${field_counter});">Remove</button>
                            </div>
                        </div>`;
            $('#fields_container').append(str);
        }

        function removeField(field_counter) {
            $('.field_' + field_counter).remove();
        }
    </script>
@endsection
