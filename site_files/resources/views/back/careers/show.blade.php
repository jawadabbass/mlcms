@extends('back.layouts.app', ['title' => $title])
@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <section class="content-header">
            <div class="row">
                <div class="col-md-7 col-sm-12">
                    @include('back.common_views.quicklinks')
                </div>
            </div>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">
                                Career Application Details </code>
                            </h3>
                        </div>
                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td><strong>Job Title </strong></td>
                                            <td>{{ $data->careers_details ? $data->careers_details->heading : '' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>First Name </strong></td>
                                            <td>{{ $data->fname }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Last Name </strong></td>
                                            <td>{{ $data->lname }}</td>
                                        </tr>
                                        {{-- <tr>
        <td><strong>Date of Birth </strong></td>
        <td>{{$data->dob}}</td>
      </tr> --}}
                                        <tr>
                                            <td><strong>Address </strong></td>
                                            <td>{{ $data->address }}</td>
                                        </tr>
                                        {{-- <tr>
        <td><strong>Country</strong></td>
        <td>{{$data->country}}</td>
      </tr>
      <tr>
        <td><strong>Province</strong></td>
        <td>{{$data->province}}</td>
      </tr> --}}
                                        {{-- <tr>
        <td><strong>City</strong></td>
        <td>{{$data->city}}</td>
      </tr> --}}
                                        <tr>
                                            <td><strong>Email</strong></td>
                                            <td>{{ $data->email }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Phone</strong></td>
                                            <td>{{ $data->phone }}</td>
                                        </tr>
                                        {{-- <tr>
        <td><strong>Linkedin Profile</strong></td>
        <td>{{$data->linkedin_link}}</td>
      </tr> --}}
                                        {{-- <tr>
        <td><strong>Position Applied</strong></td>
        <td>{{$data->job_id}}</td>
      </tr> --}}
                                        {{-- <tr>
        <td><strong>Available Date</strong></td>
        <td>{{$data->available_date}}</td>
      </tr> --}}
                                        <tr>
                                            <td><strong>File</strong></td>
                                            <td><a target="_blank"
                                                    href="{{ asset_uploads('jobs_apply/' . $data->attachment) }}">{{ $data->attachment }}</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Message</strong></td>
                                            <td>{{ $data->cover_letter }}</td>
                                        </tr>

                                        <tr>
                                            <td><strong>Education</strong></td>
                                            <td>{{ $data->qualification }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Experience</strong></td>
                                            <td>{{ $data->experience }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('beforeBodyClose')
    <style type="text/css">
        .tracking-detail {
            padding: 3rem 0
        }

        #tracking {
            margin-bottom: 1rem
        }

        [class*=tracking-status-] p {
            margin: 0;
            font-size: 1.1rem;
            color: #fff;
            text-transform: uppercase;
            text-align: center
        }

        [class*=tracking-status-] {
            padding: 1.6rem 0
        }

        .tracking-status-intransit {
            background-color: #65aee0
        }

        .tracking-status-outfordelivery {
            background-color: #f5a551
        }

        .tracking-status-deliveryoffice {
            background-color: #f7dc6f
        }

        .tracking-status-delivered {
            background-color: #4cbb87
        }

        .tracking-status-attemptfail {
            background-color: #b789c7
        }

        .tracking-status-error,
        .tracking-status-exception {
            background-color: #d26759
        }

        .tracking-status-expired {
            background-color: #616e7d
        }

        .tracking-status-pending {
            background-color: #ccc
        }

        .tracking-status-inforeceived {
            background-color: #214977
        }

        .tracking-list {
            border: 1px solid #e5e5e5
        }

        .tracking-item {
            border-left: 1px solid #e5e5e5;
            position: relative;
            padding: 2rem 1.5rem .5rem 2.5rem;
            font-size: .9rem;
            margin-left: 3rem;
            min-height: 5rem
        }

        .tracking-item:last-child {
            padding-bottom: 4rem
        }

        .tracking-item .tracking-date {
            margin-bottom: .5rem
        }

        .tracking-item .tracking-date span {
            color: #888;
            font-size: 85%;
            padding-left: .4rem
        }

        .tracking-item .tracking-content {
            padding: .5rem .8rem;
            background-color: #f4f4f4;
            border-radius: .5rem
        }

        .tracking-item .tracking-content span {
            display: block;
            color: #888;
            font-size: 85%
        }

        .tracking-item .tracking-icon {
            line-height: 2.6rem;
            position: absolute;
            left: -1.3rem;
            width: 2.6rem;
            height: 2.6rem;
            text-align: center;
            border-radius: 50%;
            font-size: 1.1rem;
            background-color: #fff;
            color: #fff
        }

        .tracking-item .tracking-icon.status-sponsored {
            background-color: #f68
        }

        .tracking-item .tracking-icon.status-delivered {
            background-color: #4cbb87
        }

        .tracking-item .tracking-icon.status-outfordelivery {
            background-color: #f5a551
        }

        .tracking-item .tracking-icon.status-deliveryoffice {
            background-color: #f7dc6f
        }

        .tracking-item .tracking-icon.status-attemptfail {
            background-color: #b789c7
        }

        .tracking-item .tracking-icon.status-exception {
            background-color: #d26759
        }

        .tracking-item .tracking-icon.status-inforeceived {
            background-color: #214977
        }

        .tracking-item .tracking-icon.status-intransit {
            color: #e5e5e5;
            border: 1px solid #e5e5e5;
            font-size: .6rem
        }

        @media(min-width:992px) {
            .tracking-item {
                margin-left: 8rem
            }

            .tracking-item .tracking-date {
                position: absolute;
                left: -10rem;
                width: 7.5rem;
                text-align: right
            }

            .tracking-item .tracking-date span {
                display: block
            }

            .tracking-item .tracking-content {
                padding: 0;
                background-color: transparent
            }
        }
    </style>
    <script type="text/javascript">
        function loadmorediv() {
            $(".tracking-item").slice(0, 10).show();
            $(".tracking-item:hidden").slice(0, 10).slideDown();
            if ($(".tracking-item:hidden").length == 0) {
                $("#loadMore").fadeOut('slow');
            }
        }
    </script>
@endsection
