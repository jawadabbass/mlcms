@extends('front.layout.app')
@section('content')
    <div class="about-wrap">
        <div class="breadcrumb-area shadow dark bg-fixed text-center text-light"
            style="background-image: url(<?php echo base_url(); ?>front/img/banner/23.jpg);">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <h1>Google Calendar</h1>
                        <ul class="breadcrumb">
                            <li><a href="#"><i class="fas fa-home"></i> Home</a></li>
                            <li class="active">Google Calendar</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="contact-area default-padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                    
                        <iframe src="https://calendar.google.com/calendar/embed?src={{ env('GOOGLE_CALENDAR_ID') }}&ctz=Asia%2FKarachi" style="border: 0" width="800" height="600" frameborder="0" scrolling="no"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
