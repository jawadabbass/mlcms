@extends('back.layouts.app', ['title' => $title, 'heading' => 'Detail'])
@section('bc')
    <?php echo ModBC('Detail', [$settingArr['contr_name'] => $settingArr['mainPageTitle']]); ?>
@endsection
@section('content')
    <div class="content-wrapper pl-3 pr-2">

        <section class="content">
            <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="card p-2">
                        <div class=" card-body table-responsive">
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
