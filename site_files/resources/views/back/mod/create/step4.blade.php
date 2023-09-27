@extends('back.layouts.app', ['title' => $title, 'heading' => 'Functions'])
@section('bc')
    <?php echo ModBC('Detail', [$settingArr['contr_name'] => $settingArr['mainPageTitle']]); ?>
@endsection
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body table-responsive">

                        <div class="col-sm-12">
                            <form id="validatethis1" name="myForm" method="post"
                                action="{{ admin_url() }}mod/step/4/{{ $mod }}" onsubmit="return formSubmit();"
                                enctype="multipart/form-data">
                                @csrf
                                <a class="btn btn-info" href="javascript:;"
                                    onclick="document.forms['myForm'].submit();">Generate Code NOW <i
                                        class="fas fa-laptop-code"></i>s</a>






                                <div class="row">
                                    <div class="col-sm-6"></div>
                                    <div class="col-sm-6"></div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div>
@endsection
