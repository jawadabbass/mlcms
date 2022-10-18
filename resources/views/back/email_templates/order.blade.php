@extends('back.layouts.app',['title' => $title])text-start
@section('content')
    <aside class="right-side {{(session('leftSideBar') == 1)?'strech':''}}">
        <section class="content-header">
            <div class="row">
                <div class="col-md-8 col-sm-6">
                    <?php echo ModBC('Set Order',array($settingArr['contr_name']=>$settingArr['mainPageTitle']));?>
                </div>
                <div class="col-md-4 col-sm-6">
                    @include('back.common_views.quicklinks')
                </div>
            </div>
        </section>
        <section class="content">
            @if(\Session::has('added_action'))
                <div class="message-container">
                    <div class="callout callout-success">
                        <h4>New admin user has been created successfully.</h4>
                    </div>
                </div>
            @endif
            @if(\Session::has('update_action'))
                <div class="message-container">
                    <div class="callout callout-success">
                        <h4>Record has been updated successfully.</h4>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="box">
                        <div class="row">

                           
  <div class="col-sm-6 text-start"><h3 class="box-title">Set Order</h3></div>
  <div class="col-sm-6 text-end">
   
   
  
  
  </div>
  </div>


{{-- Search Area --}}
{{-- end Search Area --}}



                        <div>
                          <ul class="sorta ui-sortable">
                           


                                @if($result)
                                    @foreach($result as $row)
                                       <li id="recordsArray_<?php echo $row->$idf; ?>">
                                         @foreach($dataArr as $key=>$val)
                                       
{{-- Data DIV --}}

{!! ModTBuild($row->$key,$val[1],$settingArr['baseImg']) !!}


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
    </aside>
@endsection
@section('beforeBodyClose')
<script>var contr='{{$settingArr['contr_name']}}';</script>
<link href="{{base_url()}}back/mod/mod_css.css" rel="stylesheet">
<link href="{{base_url()}}back/mod/bootstrap-toggle.min.css" rel="stylesheet">
<link href="{{base_url()}}back/mod/mod_js.css" rel="stylesheet">
<script src="{{base_url()}}back/mod/bootstrap-toggle.min.js"></script>
    <script src="{{base_url()}}back/mod/mod_js.js"></script>
@endsection