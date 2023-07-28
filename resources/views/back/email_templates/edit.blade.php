@extends('back.layouts.app', ['title' => $title])
@section('loader_div')
    <div class="loadscreen" id="preloader">
        <div class="loader spinner-bubble spinner-bubble-primary">
        </div>
    </div>
@endsection
@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <section class="content-header">
            <div class="row">
                <div class="col-md-8 col-sm-6">
                    <ol class="breadcrumb">
                        <li><a href="{{ admin_url() }}"> <i class="fas fa-tachometer-alt"></i> Home </a></li>
                        <li><a href="{{ route('email_templates.index') }}">Manage Email Template</a></li>
                        <li class="active">Edit Email Template</li>
                    </ol>
                </div>
                <div class="col-md-4 col-sm-6"> @include('back.common_views.quicklinks') </div>
            </div>
        </section>
        <section class="content">
            <div class="row">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>
                                    {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (\Session::has('update_action'))
                    <div class="message-container">
                        <div class="callout callout-success">
                            <h4>
                                New Template has been added successfully.
                            </h4>
                        </div>
                    </div>
                @endif
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">
                                Edit Email Template
                            </h3>
                        </div>
                        <form id="validatethis" name="myForm" method="post"
                            action="{{ route('email_template_update_save', $row->ID) }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label>Title Of Template</label>
                                    <input type="text" name="title" class="form-control" value="{{ $row->Title }}"
                                        required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label>Subject</label>
                                    <input type="text" name="Subject" class="form-control" required
                                        value="{{ $row->Subject }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label>Please Select Icon</label>
                                    <select class="form-control" style="font-family: 'FontAwesome', 'sans-serif'"
                                        name="icon_sign_email">
                                        <option value="fa-align-left">&#xf036; </option>
                                        <option value="fa-align-right">&#xf038; </option>
                                        <option value="fa-amazon">&#xf270; </option>
                                        <option value="fa-ambulance">&#xf0f9; </option>
                                        <option value="fa-anchor">&#xf13d; </option>
                                        <option value="fa-android">&#xf17b; </option>
                                        <option value="fa-angellist">&#xf209; </option>
                                        <option value="fa-angle-double-down">&#xf103; </option>
                                        <option value="fa-angle-double-left">&#xf100; </option>
                                        <option value="fa-angle-double-right">&#xf101; </option>
                                        <option value="fa-angle-double-up">&#xf102; </option>
                                        <option value="fa-angle-left">&#xf104; </option>
                                        <option value="fa-angle-right">&#xf105; </option>
                                        <option value="fa-angle-up">&#xf106; </option>
                                        <option value="fa-apple">&#xf179; </option>
                                        <option value="fa-archive">&#xf187; </option>
                                        <option value="fa-area-chart">&#xf1fe; </option>
                                        <option value="fa-arrow-circle-down">&#xf0ab; </option>
                                        <option value="fa-arrow-circle-left">&#xf0a8; </option>
                                        <option value="fa-arrow-circle-o-down">&#xf01a; </option>
                                        <option value="fa-arrow-circle-o-left">&#xf190; </option>
                                        <option value="fa-arrow-circle-o-right">&#xf18e; </option>
                                        <option value="fa-arrow-circle-o-up">&#xf01b; </option>
                                        <option value="fa-arrow-circle-right">&#xf0a9; </option>
                                        <option value="fa-arrow-circle-up">&#xf0aa; </option>
                                        <option value="fa-arrow-down">&#xf063; </option>
                                        <option value="fa-arrow-left">&#xf060; </option>
                                        <option value="fa-arrow-right">&#xf061; </option>
                                        <option value="fa-arrow-up">&#xf062; </option>
                                        <option value="fa-arrows">&#xf047; </option>
                                        <option value="fa-arrows-alt">&#xf0b2; </option>
                                        <option value="fa-arrows-h">&#xf07e; </option>
                                        <option value="fa-arrows-v">&#xf07d; </option>
                                        <option value="fa-asterisk">&#xf069; </option>
                                        <option value="fa-at">&#xf1fa; </option>
                                        <option value="fa-automobile">&#xf1b9; </option>
                                        <option value="fa-backward">&#xf04a; </option>
                                        <option value="fa-balance-scale">&#xf24e; </option>
                                        <option value="fa-ban">&#xf05e;</option>
                                        <option value="fa-bank">&#xf19c;</option>
                                        <option value="fa-bar-chart">&#xf080; </option>
                                        <option value="fa-bar-chart-o">&#xf080; </option>
                                        <option value="fa-battery-full">&#xf240; </option>
                                        <option value="fa-behance">&#xf1b4; </option>
                                        <option value="fa-behance-square">&#xf1b5; </option>
                                        <option value="fa-bell">&#xf0f3; </option>
                                        <option value="fa-bell-o">&#xf0a2; </option>
                                        <option value="fa-bell-slash">&#xf1f6; </option>
                                        <option value="fa-bell-slash-o">&#xf1f7; </option>
                                        <option value="fa-bicycle">&#xf206; </option>
                                        <option value="fa-binoculars">&#xf1e5; </option>
                                        <option value="fa-birthday-cake">&#xf1fd; </option>
                                        <option value="fa-bitbucket">&#xf171; </option>
                                        <option value="fa-bitbucket-square">&#xf172; </option>
                                        <option value="fa-bitcoin">&#xf15a; </option>
                                        <option value="fa-black-tie">&#xf27e; </option>
                                        <option value="fa-bold">&#xf032; </option>
                                        <option value="fa-bolt">&#xf0e7; </option>
                                        <option value="fa-bomb">&#xf1e2; </option>
                                        <option value="fa-book">&#xf02d; </option>
                                        <option value="fa-bookmark">&#xf02e; </option>
                                        <option value="fa-bookmark-o">&#xf097; </option>
                                        <option value="fa-briefcase">&#xf0b1; </option>
                                        <option value="fa-btc">&#xf15a; </option>
                                        <option value="fa-bug">&#xf188; </option>
                                        <option value="fa-building">&#xf1ad; </option>
                                        <option value="fa-building-o">&#xf0f7; </option>
                                        <option value="fa-bullhorn">&#xf0a1; </option>
                                        <option value="fa-bullseye">&#xf140; </option>
                                        <option value="fa-bus">&#xf207; </option>
                                        <option value="fa-cab">&#xf1ba; </option>
                                        <option value="fa-calendar">&#xf073; </option>
                                        <option value="fa-camera">&#xf030;</option>
                                        <option value="fa-car">&#xf1b9; </option>
                                        <option value="fa-caret-up">&#xf0d8; </option>
                                        <option value="fa-cart-plus">&#xf217; </option>
                                        <option value="fa-cc">&#xf20a; </option>
                                        <option value="fa-cc-amex">&#xf1f3; </option>
                                        <option value="fa-cc-jcb">&#xf24b; </option>
                                        <option value="fa-cc-paypal">&#xf1f4; </option>
                                        <option value="fa-cc-stripe">&#xf1f5; </option>
                                        <option value="fa-cc-visa">&#xf1f0; </option>
                                        <option value="fa-chain">&#xf0c1; </option>
                                        <option value="fa-check">&#xf00c; </option>
                                        <option value="fa-chevron-left">&#xf053; </option>
                                        <option value="fa-chevron-right">&#xf054; </option>
                                        <option value="fa-chevron-up">&#xf077; </option>
                                        <option value="fa-child">&#xf1ae; </option>
                                        <option value="fa-chrome">&#xf268; </option>
                                        <option value="fa-circle">&#xf111; </option>
                                        <option value="fa-circle-o">&#xf10c; </option>
                                        <option value="fa-circle-o-notch">&#xf1ce; </option>
                                        <option value="fa-circle-thin">&#xf1db; </option>
                                        <option value="fa-clipboard">&#xf0ea; </option>
                                        <option value="fa-clock-o">&#xf017; </option>
                                        <option value="fa-clone">&#xf24d; </option>
                                        <option value="fa-close">&#xf00d;</option>
                                        <option value="fa-cloud">&#xf0c2; </option>
                                        <option value="fa-cloud-download">&#xf0ed; </option>
                                        <option value="fa-cloud-upload">&#xf0ee; </option>
                                        <option value="fa-cny">&#xf157; </option>
                                        <option value="fa-code">&#xf121; </option>
                                        <option value="fa-code-fork">&#xf126; </option>
                                        <option value="fa-codepen">&#xf1cb; </option>
                                        <option value="fa-coffee">&#xf0f4; </option>
                                        <option value="fa-cog">&#xf013; </option>
                                        <option value="fa-cogs">&#xf085; </option>
                                        <option value="fa-columns">&#xf0db; </option>
                                        <option value="fa-comment">&#xf075; </option>
                                        <option value="fa-comment-o">&#xf0e5; </option>
                                        <option value="fa-commenting">&#xf27a; </option>
                                        <option value="fa-commenting-o">&#xf27b; </option>
                                        <option value="fa-comments">&#xf086; </option>
                                        <option value="fa-comments-o">&#xf0e6; </option>
                                        <option value="fa-compass">&#xf14e; </option>
                                        <option value="fa-compress">&#xf066; </option>
                                        <option value="fa-connectdevelop">&#xf20e; </option>
                                        <option value="fa-contao">&#xf26d; </option>
                                        <option value="fa-copy">&#xf0c5; </option>
                                        <option value="fa-copyright">&#xf1f9;</option>
                                        <option value="fa-creative-commons">&#xf25e; </option>
                                        <option value="fa-credit-card">&#xf09d; </option>
                                        <option value="fa-crop">&#xf125; </option>
                                        <option value="fa-crosshairs">&#xf05b; </option>
                                        <option value="fa-css3">&#xf13c; </option>
                                        <option value="fa-cube">&#xf1b2; </option>
                                        <option value="fa-cubes">&#xf1b3; </option>
                                        <option value="fa-cut">&#xf0c4; </option>
                                        <option value="fa-cutlery">&#xf0f5; </option>
                                        <option value="fa-tachometer-alt">&#xf0e4; </option>
                                        <option value="fa-dashcube">&#xf210; </option>
                                        <option value="fa-database">&#xf1c0; </option>
                                        <option value="fa-dedent">&#xf03b; </option>
                                        <option value="fa-delicious">&#xf1a5; </option>
                                        <option value="fa-desktop">&#xf108; </option>
                                        <option value="fa-deviantart">&#xf1bd; </option>
                                        <option value="fa-diamond">&#xf219; </option>
                                        <option value="fa-digg">&#xf1a6; </option>
                                        <option value="fa-dollar">&#xf155; </option>
                                        <option value="fa-download">&#xf019; </option>
                                        <option value="fa-dribbble">&#xf17d; </option>
                                        <option value="fa-dropbox">&#xf16b; </option>
                                        <option value="fa-drupal">&#xf1a9; </option>
                                        <option value="fa-edit">&#xf044; </option>
                                        <option value="fa-eject">&#xf052; </option>
                                        <option value="fa-ellipsis-h">&#xf141; </option>
                                        <option value="fa-ellipsis-v">&#xf142; </option>
                                        <option value="fa-empire">&#xf1d1; </option>
                                        <option value="fa-envelope">&#xf0e0; </option>
                                        <option value="fa-envelope-o">&#xf003; </option>
                                        <option value="fa-eur">&#xf153; </option>
                                        <option value="fa-euro">&#xf153; </option>
                                        <option value="fa-exchange">&#xf0ec; </option>
                                        <option value="fa-exclamation">&#xf12a; </option>
                                        <option value="fa-exclamation-circle">&#xf06a; </option>
                                        <option value="fa-exclamation-triangle">&#xf071; </option>
                                        <option value="fa-expand">&#xf065; </option>
                                        <option value="fa-expeditedssl">&#xf23e; </option>
                                        <option value="fa-external-link">&#xf08e; </option>
                                        <option value="fa-external-link-square">&#xf14c; </option>
                                        <option value="fa-eye">&#xf06e; </option>
                                        <option value="fa-eye-slash">&#xf070; </option>
                                        <option value="fa-eyedropper">&#xf1fb; </option>
                                        <option value="fa-facebook">&#xf09a; </option>
                                        <option value="fa-facebook-f">&#xf09a; </option>
                                        <option value="fa-facebook-official">&#xf230; </option>
                                        <option value="fa-facebook-square">&#xf082; </option>
                                        <option value="fa-fast-backward">&#xf049;</option>
                                        <option value="fa-fast-forward">&#xf050; </option>
                                        <option value="fa-fax">&#xf1ac; </option>
                                        <option value="fa-feed">&#xf09e; </option>
                                        <option value="fa-female">&#xf182; </option>
                                        <option value="fa-fighter-jet">&#xf0fb; </option>
                                        <option value="fa-file">&#xf15b; </option>
                                        <option value="fa-file-archive-o">&#xf1c6; </option>
                                        <option value="fa-file-audio-o">&#xf1c7; </option>
                                        <option value="fa-file-code-o">&#xf1c9; </option>
                                        <option value="fa-file-excel-o">&#xf1c3; </option>
                                        <option value="fa-file-image-o">&#xf1c5; </option>
                                        <option value="fa-file-movie-o">&#xf1c8;</option>
                                        <option value="fa-file-o">&#xf016; </option>
                                        <option value="fa-file-pdf-o">&#xf1c1; </option>
                                        <option value="fa-file-photo-o">&#xf1c5; </option>
                                        <option value="fa-file-picture-o">&#xf1c5; </option>
                                        <option value="fa-file-powerpoint-o">&#xf1c4; </option>
                                        <option value="fa-file-sound-o">&#xf1c7; </option>
                                        <option value="fa-file">&#xf15c; </option>
                                        <option value="fa-file-o">&#xf0f6; </option>
                                        <option value="fa-file-video-o">&#xf1c8; </option>
                                        <option value="fa-file-word-o">&#xf1c2; </option>
                                        <option value="fa-file-zip-o">&#xf1c6; </option>
                                        <option value="fa-files-o">&#xf0c5; </option>
                                        <option value="fa-film">&#xf008; </option>
                                        <option value="fa-filter">&#xf0b0; </option>
                                        <option value="fa-fire">&#xf06d; </option>
                                        <option value="fa-fire-extinguisher">&#xf134;</option>
                                        <option value="fa-firefox">&#xf269; </option>
                                        <option value="fa-flag">&#xf024; </option>
                                        <option value="fa-flag-checkered">&#xf11e; </option>
                                        <option value="fa-flag-o">&#xf11d; </option>
                                        <option value="fa-flash">&#xf0e7; </option>
                                        <option value="fa-flask">&#xf0c3; </option>
                                        <option value="fa-flickr">&#xf16e; </option>
                                        <option value="fa-floppy-o">&#xf0c7; </option>
                                        <option value="fa-folder">&#xf07b; </option>
                                        <option value="fa-folder-o">&#xf114; </option>
                                        <option value="fa-folder-open">&#xf07c; </option>
                                        <option value="fa-folder-open-o">&#xf115; </option>
                                        <option value="fa-font">&#xf031; </option>
                                        <option value="fa-fonticons">&#xf280; </option>
                                        <option value="fa-forumbee">&#xf211; </option>
                                        <option value="fa-forward">&#xf04e; </option>
                                        <option value="fa-foursquare">&#xf180; </option>
                                        <option value="fa-frown-o">&#xf119; </option>
                                        <option value="fa-futbol-o">&#xf1e3; </option>
                                        <option value="fa-gamepad">&#xf11b; </option>
                                        <option value="fa-gavel">&#xf0e3; </option>
                                        <option value="fa-gbp">&#xf154; </option>
                                        <option value="fa-ge">&#xf1d1; </option>
                                        <option value="fa-gear">&#xf013; </option>
                                        <option value="fa-gears">&#xf085; </option>
                                        <option value="fa-genderless">&#xf22d; </option>
                                        <option value="fa-get-pocket">&#xf265; </option>
                                        <option value="fa-gg">&#xf260; </option>
                                        <option value="fa-gg-circle">&#xf261; </option>
                                        <option value="fa-gift">&#xf06b;</option>
                                        <option value="fa-git">&#xf1d3; </option>
                                        <option value="fa-git-square">&#xf1d2; </option>
                                        <option value="fa-github">&#xf09b; </option>
                                        <option value="fa-github-alt">&#xf113;</option>
                                        <option value="fa-github-square">&#xf092;</option>
                                        <option value="fa-gittip">&#xf184; </option>
                                        <option value="fa-glass">&#xf000; </option>
                                        <option value="fa-globe">&#xf0ac; </option>
                                        <option value="fa-google">&#xf1a0; </option>
                                        <option value="fa-google-plus">&#xf0d5; </option>
                                        <option value="fa-google-plus-square">&#xf0d4; </option>
                                        <option value="fa-google-wallet">&#xf1ee; </option>
                                        <option value="fa-graduation-cap">&#xf19d; </option>
                                        <option value="fa-gratipay">&#xf184; </option>
                                        <option value="fa-group">&#xf0c0; </option>
                                        <option value="fa-h-square">&#xf0fd; </option>
                                        <option value="fa-hacker-news">&#xf1d4; </option>
                                        <option value="fa-hand-grab-o">&#xf255; </option>
                                        <option value="fa-hand-lizard-o">&#xf258; </option>
                                        <option value="fa-hand-o-down">&#xf0a7; </option>
                                        <option value="fa-hand-o-left">&#xf0a5; </option>
                                        <option value="fa-hand-o-right">&#xf0a4; </option>
                                        <option value="fa-hand-o-up">&#xf0a6; </option>
                                        <option value="fa-hand-paper-o">&#xf256; </option>
                                        <option value="fa-hand-peace-o">&#xf25b; </option>
                                        <option value="fa-hand-pointer-o">&#xf25a;</option>
                                        <option value="fa-hand-rock-o">&#xf255; </option>
                                        <option value="fa-hand-scissors-o">&#xf257; </option>
                                        <option value="fa-hand-spock-o">&#xf259; </option>
                                        <option value="fa-hand-stop-o">&#xf256; </option>
                                        <option value="fa-hdd-o">&#xf0a0; </option>
                                        <option value="fa-header">&#xf1dc; </option>
                                        <option value="fa-headphones">&#xf025; </option>
                                        <option value="fa-heart">&#xf004; </option>
                                        <option value="fa-heart-o">&#xf08a; </option>
                                        <option value="fa-heartbeat">&#xf21e; </option>
                                        <option value="fa-history">&#xf1da;</option>
                                        <option value="fa-home">&#xf015; </option>
                                        <option value="fa-hospital-o">&#xf0f8; </option>
                                        <option value="fa-hotel">&#xf236; </option>
                                        <option value="fa-hourglass">&#xf254; </option>
                                        <option value="fa-hourglass-1">&#xf251; </option>
                                        <option value="fa-hourglass-2">&#xf252;</option>
                                        <option value="fa-hourglass-3">&#xf253; </option>
                                        <option value="fa-hourglass-end">&#xf253; </option>
                                        <option value="fa-hourglass-half">&#xf252; </option>
                                        <option value="fa-hourglass-o">&#xf250; </option>
                                        <option value="fa-hourglass-start">&#xf251; </option>
                                        <option value="fa-houzz">&#xf27c; </option>
                                        <option value="fa-html5">&#xf13b; </option>
                                        <option value="fa-i-cursor">&#xf246; </option>
                                        <option value="fa-ils">&#xf20b; </option>
                                        <option value="fa-image">&#xf03e; </option>
                                        <option value="fa-inbox">&#xf01c; </option>
                                        <option value="fa-indent">&#xf03c; </option>
                                        <option value="fa-industry">&#xf275; </option>
                                        <option value="fa-info">&#xf129; </option>
                                        <option value="fa-info-circle">&#xf05a; </option>
                                        <option value="fa-inr">&#xf156; </option>
                                        <option value="fa-instagram">&#xf16d; </option>
                                        <option value="fa-institution">&#xf19c;</option>
                                        <option value="fa-internet-explorer">&#xf26b;</option>
                                        <option value="fa-intersex">&#xf224;</option>
                                        <option value="fa-ioxhost">&#xf208; </option>
                                        <option value="fa-italic">&#xf033;</option>
                                        <option value="fa-joomla">&#xf1aa;</option>
                                        <option value="fa-jpy">&#xf157;</option>
                                        <option value="fa-jsfiddle">&#xf1cc; </option>
                                        <option value="fa-key">&#xf084; </option>
                                        <option value="fa-keyboard-o">&#xf11c;</option>
                                        <option value="fa-krw">&#xf159; </option>
                                        <option value="fa-language">&#xf1ab; </option>
                                        <option value="fa-laptop">&#xf109; </option>
                                        <option value="fa-lastfm">&#xf202; </option>
                                        <option value="fa-lastfm-square">&#xf203; </option>
                                        <option value="fa-leaf">&#xf06c; </option>
                                        <option value="fa-leanpub">&#xf212; </option>
                                        <option value="fa-legal">&#xf0e3; </option>
                                        <option value="fa-lemon-o">&#xf094; </option>
                                        <option value="fa-level-down">&#xf149; </option>
                                        <option value="fa-level-up">&#xf148; </option>
                                        <option value="fa-life-bouy">&#xf1cd; </option>
                                        <option value="fa-life-buoy">&#xf1cd; </option>
                                        <option value="fa-life-ring">&#xf1cd; </option>
                                        <option value="fa-life-saver">&#xf1cd; </option>
                                        <option value="fa-lightbulb-o">&#xf0eb;</option>
                                        <option value="fa-line-chart">&#xf201; </option>
                                        <option value="fa-link">&#xf0c1; </option>
                                        <option value="fa-linkedin">&#xf0e1; </option>
                                        <option value="fa-linkedin-square">&#xf08c; </option>
                                        <option value="fa-linux">&#xf17c; </option>
                                        <option value="fa-list">&#xf03a; </option>
                                        <option value="fa-list-alt">&#xf022; </option>
                                        <option value="fa-list-ol">&#xf0cb; </option>
                                        <option value="fa-list-ul">&#xf0ca;</option>
                                        <option value="fa-location-arrow">&#xf124; </option>
                                        <option value="fa-lock">&#xf023; fa-lock</option>
                                        <option value="fa-long-arrow-down">&#xf175; </option>
                                        <option value="fa-long-arrow-left">&#xf177; </option>
                                        <option value="fa-long-arrow-right">&#xf178;</option>
                                        <option value="fa-long-arrow-up">&#xf176; </option>
                                        <option value="fa-magic">&#xf0d0; </option>
                                        <option value="fa-magnet">&#xf076; </option>
                                        <option value="fa-mars-stroke-v">&#xf22a; </option>
                                        <option value="fa-maxcdn">&#xf136; </option>
                                        <option value="fa-meanpath">&#xf20c; </option>
                                        <option value="fa-medium">&#xf23a;</option>
                                        <option value="fa-medkit">&#xf0fa; </option>
                                        <option value="fa-meh-o">&#xf11a; </option>
                                        <option value="fa-mercury">&#xf223; </option>
                                        <option value="fa-microphone">&#xf130; </option>
                                        <option value="fa-mobile">&#xf10b; </option>
                                        <option value="fa-motorcycle">&#xf21c; </option>
                                        <option value="fa-mouse-pointer">&#xf245; </option>
                                        <option value="fa-music">&#xf001; </option>
                                        <option value="fa-navicon">&#xf0c9; </option>
                                        <option value="fa-neuter">&#xf22c; </option>
                                        <option value="fa-newspaper-o">&#xf1ea; </option>
                                        <option value="fa-opencart">&#xf23d; </option>
                                        <option value="fa-openid">&#xf19b; </option>
                                        <option value="fa-opera">&#xf26a; </option>
                                        <option value="fa-outdent">&#xf03b; </option>
                                        <option value="fa-pagelines">&#xf18c; </option>
                                        <option value="fa-paper-plane-o">&#xf1d9; </option>
                                        <option value="fa-paperclip">&#xf0c6; </option>
                                        <option value="fa-paragraph">&#xf1dd; </option>
                                        <option value="fa-paste">&#xf0ea; </option>
                                        <option value="fa-pause">&#xf04c; </option>
                                        <option value="fa-paw">&#xf1b0; </option>
                                        <option value="fa-paypal">&#xf1ed; </option>
                                        <option value="fa-edit">&#xf040; </option>
                                        <option value="fa-edit-square-o">&#xf044; </option>
                                        <option value="fa-phone">&#xf095; </option>
                                        <option value="fa-photo">&#xf03e; </option>
                                        <option value="fa-picture-o">&#xf03e; </option>
                                        <option value="fa-pie-chart">&#xf200; </option>
                                        <option value="fa-pied-piper">&#xf1a7; </option>
                                        <option value="fa-pied-piper-alt">&#xf1a8; </option>
                                        <option value="fa-pinterest">&#xf0d2; </option>
                                        <option value="fa-pinterest-p">&#xf231; </option>
                                        <option value="fa-pinterest-square">&#xf0d3; </option>
                                        <option value="fa-plane">&#xf072; </option>
                                        <option value="fa-play">&#xf04b; </option>
                                        <option value="fa-play-circle">&#xf144; </option>
                                        <option value="fa-play-circle-o">&#xf01d; </option>
                                        <option value="fa-plug">&#xf1e6; </option>
                                        <option value="fa-plus">&#xf067; </option>
                                        <option value="fa-plus-circle">&#xf055; </option>
                                        <option value="fa-plus-square">&#xf0fe; </option>
                                        <option value="fa-plus-square-o">&#xf196; </option>
                                        <option value="fa-power-off">&#xf011; </option>
                                        <option value="fa-print">&#xf02f; </option>
                                        <option value="fa-puzzle-piece">&#xf12e; </option>
                                        <option value="fa-qq">&#xf1d6; </option>
                                        <option value="fa-qrcode">&#xf029; </option>
                                        <option value="fa-question">&#xf128; </option>
                                        <option value="fa-question-circle">&#xf059; </option>
                                        <option value="fa-quote-left">&#xf10d;</option>
                                        <option value="fa-quote-right">&#xf10e; </option>
                                        <option value="fa-ra">&#xf1d0; </option>
                                        <option value="fa-random">&#xf074; </option>
                                        <option value="fa-rebel">&#xf1d0; </option>
                                        <option value="fa-recycle">&#xf1b8; </option>
                                        <option value="fa-reddit">&#xf1a1; </option>
                                        <option value="fa-reddit-square">&#xf1a2; </option>
                                        <option value="fa-sync">&#xf021; </option>
                                        <option value="fa-registered">&#xf25d; </option>
                                        <option value="fa-remove">&#xf00d; </option>
                                        <option value="fa-renren">&#xf18b; </option>
                                        <option value="fa-reorder">&#xf0c9; </option>
                                        <option value="fa-repeat">&#xf01e; </option>
                                        <option value="fa-reply">&#xf112; </option>
                                        <option value="fa-reply-all">&#xf122;</option>
                                        <option value="fa-retweet">&#xf079;</option>
                                        <option value="fa-rmb">&#xf157; </option>
                                        <option value="fa-road">&#xf018; </option>
                                        <option value="fa-rocket">&#xf135; </option>
                                        <option value="fa-rotate-left">&#xf0e2; </option>
                                        <option value="fa-rotate-right">&#xf01e; </option>
                                        <option value="fa-rouble">&#xf158; </option>
                                        <option value="fa-rss">&#xf09e; </option>
                                        <option value="fa-rss-square">&#xf143; </option>
                                        <option value="fa-rub">&#xf158; </option>
                                        <option value="fa-ruble">&#xf158; </option>
                                        <option value="fa-rupee">&#xf156; </option>
                                        <option value="fa-safari">&#xf267; </option>
                                        <option value="fa-sliders">&#xf1de; </option>
                                        <option value="fa-slideshare">&#xf1e7; </option>
                                        <option value="fa-smile-o">&#xf118; </option>
                                        <option value="fa-sort-asc">&#xf0de; </option>
                                        <option value="fa-sort-desc">&#xf0dd; </option>
                                        <option value="fa-sort-down">&#xf0dd; </option>
                                        <option value="fa-spinner">&#xf110; </option>
                                        <option value="fa-spoon">&#xf1b1; </option>
                                        <option value="fa-spotify">&#xf1bc; </option>
                                        <option value="fa-square">&#xf0c8; </option>
                                        <option value="fa-square-o">&#xf096; </option>
                                        <option value="fa-star">&#xf005; </option>
                                        <option value="fa-star-half">&#xf089; </option>
                                        <option value="fa-stop">&#xf04d; </option>
                                        <option value="fa-subscript">&#xf12c;</option>
                                        <option value="fa-tablet">&#xf10a; </option>
                                        <option value="fa-tachometer">&#xf0e4; </option>
                                        <option value="fa-tag">&#xf02b; </option>
                                        <option value="fa-tags">&#xf02c; </option>
                                    </select>
                                </div>
                            </div>
                            <div class="modalpadding">
                                <div id="user_email_area">
                                    <div class="row" style="margin-top:10px;">
                                        <div class="col-sm-12">
                                            <label for="User Email Body:">User Email Body:</label>
                                            @php
                                                $arr1 = explode(',', '{CLIENT_NAME}');
                                                $arr2 = explode(',', '{NAME}');
                                                //  $arr3=explode(',','{TITLE}');
                                                $arr4 = explode(',', '{COMPANY E-MAIL}');
                                                $arr = array_merge($arr1, $arr2, $arr4);
                                                foreach ($arr as $kk => $vv) {
                                                    echo '<code style="cursor: pointer;"  data-bs-toggle="tooltip" title="Click to insert ' . $vv . '" onclick="insertIntoCkeditor(\'user_body\', \'' . $vv . '\')">' . $vv . '</code>, ';
                                                }
                                            @endphp
                                            <textarea name="user_body" id="user_body" class="form-control" required="">
                                {{ $row->user_body }}
                              </textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">&nbsp;</div>
                                    <div class="col-sm-6"> </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-7"><a href="{{ route('email_templates.index') }}"
                                            class="btn btn-link"><i class="fas fa-angle-double-left"
                                                aria-hidden="true"></i> Back</a></div>
                                    <div class="col-md-5 text-end">
                                        <input type="hidden" name="idd" value="0" />
                                        <button type="submit" class="btn btn-success subm">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
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
    <link href="{{ asset('back/mod/mod_css.css') }}" rel="stylesheet">
    <link href="{{ asset('back/mod/bootstrap-toggle.min.css') }}" rel="stylesheet">
    <script src="{{ asset('back/mod/bootstrap-toggle.min.js') }}"></script>
    <script src="{{ asset('back/mod/mod_js.js') }}"></script>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $("#user_email_active").change(function(e) {
                if ($(this).prop('checked')) {
                    $("#user_email_area").slideDown();
                } else {
                    $("#user_email_area").slideUp();
                }
            });
        });
    </script>
@endsection
