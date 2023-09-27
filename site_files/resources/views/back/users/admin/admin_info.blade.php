@extends('back.layouts.app',['title' => $title])
@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <section class="content-header">
            <div class="row">
                <div class="col-md-5 col-sm-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ admin_url() }}"><i class="fas fa-tachometer-alt"></i> Home</a></li>
                        <li class="active">Manage Admin Users</li>
                    </ol>
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
                        <div class="box-body table-responsive">
                            <div class="text-end" style="padding-bottom:2px;"></div>
                            <table id="example2" class="table table-bordered table-hover">
                                <tbody>
                                <tr>
                                    <td><h3>Super Admin can access following functionalities:</h3></td>
                                </tr>
                                @foreach($passArrSuperAdmin as $key=>$val)
                                    <tr>
                                        <td>
                                            <a target="_blank"
                                               href="{{ admin_url() . ''.$key }}">{{$val}}</a>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><h3>Sub-Admin can access following Functionalies:</h3></td>
                                </tr>
                                @foreach($passArrSubAdmin as $key=>$val)
                                    <tr>
                                        <td><a target="_blank"
                                               href="{{($key)}}">{{$val}}</a>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td></td>
                                </tr>
                                
                                <tr>
                                    <td><h3>Reps can access following Functionalies:</h3></td>
                                </tr>
                                @foreach($passArrReps as $key=>$val)
                                    <tr>
                                        <td><a target="_blank"
                                               href="{{($key)}}">{{$val}}</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection