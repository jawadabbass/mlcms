@extends('back.layouts.app', ['title' => $title])
@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <section class="content-header">
            <div class="row">
                <div class="col-md-8 col-sm-6">
                    <?php echo ModBC('Detail', [$settingArr['contr_name'] => $settingArr['mainPageTitle']]); ?>
                </div>
                <div class="col-md-4 col-sm-6">
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


                            <ul class="list-group">

                                <li class="main_title titletop">
                                    <h4>Detail</h4>
                                </li>

                                <?php
foreach($arrFields as $key=>$val){

    ?>
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-md-2 col-sm-4 col-xs-5"><strong><?php echo $val[0]; ?></strong>:</div>
                                        <div class="col-md-10 col-sm-8 col-xs-7"><?php echo ModTBuild($row[$key], $val[1], $settingArr['baseImg']); ?></div>
                                    </div>
                                </li>

                                <?php }?>
                            </ul>


                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
