@extends('back.layouts.app', ['title' => $title])
@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <section class="content-header">
            <div class="row">
                <div class="col-md-5 col-sm-12">
                    <?php echo ModBC('Set Order', [$settingArr['contr_name'] => $settingArr['mainPageTitle']]); ?>
                </div>
                <div class="col-md-7 col-sm-12">
                    @include('back.common_views.quicklinks')
                </div>
            </div>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="box">
                        <div class="row">
                            <div class="col-sm-6 text-start">
                                <h3 class="box-title">Set Order</h3>
                            </div>
                            <div class="col-sm-6 text-end">
                            </div>
                        </div>
                        {{-- Search Area --}}
                        {{-- end Search Area --}}
                        <div>
                            <ul class="sorta ui-sortable">
                                @if ($result)
                                    @foreach ($result as $row)
                                        <li id="recordsArray_<?php echo $row->$idf; ?>">
                                            @foreach ($dataArr as $key => $val)
                                                {{-- Data DIV --}}
                                                {!! ModTBuild($row->$key, $val[1], $settingArr['baseImg']) !!}
                                            @endforeach
                                        </li>
                                    @endforeach
                                @else
                                    <div class="alert alert-danger">Sorry no record available.</div>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('beforeBodyClose')
    <script>
        var contr = '{{ $settingArr['contr_name'] }}';
    </script>
    <link href="{{ asset_storage('') }}back/mod/mod_css.css" rel="stylesheet">
    <link href="{{ asset_storage('') }}back/mod/bootstrap-toggle.min.css" rel="stylesheet">
    <link href="{{ asset_storage('') }}back/mod/mod_js.css" rel="stylesheet">
    <script src="{{ asset_storage('') }}back/mod/bootstrap-toggle.min.js"></script>
    <script src="{{ asset_storage('') }}back/mod/mod_js.js"></script>
@endsection
