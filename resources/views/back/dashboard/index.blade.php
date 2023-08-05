@extends('back.layouts.app', ['title' => FindInsettingArr('business_name') . ' | Dashboard'])
@section('beforeHeadClose')
    <style>
        .archiveWrp ul {
            list-style: none;
            margin: 0 0 0 0;
            padding: 0;
        }
        .archiveWrp ul li {
            background: #fff;
            padding: 10px;
            font-size: 14px;
            margin-bottom: 10px;
            border-left: 2px solid #4aa9e9;
            box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.1);
        }
        .archiveWrp ul li a {
            color: #4aa9e9;
            text-decoration: underline
        }
    </style>
@endsection
@section('content')
    <div class="content-wrapper pl-3 pr-2">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        @include('back.common_views.quicklinks')
                    </div><!-- /.col -->
                    <div class="col-sm-12">@include('flash::message')</div>
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        @if ($news != null && count($news) > 0)
                            <div class="container">
                                @foreach ($news as $newsItem)
                                    <div class="adm-Aleart bdronly">
                                        <span>{{ date('d F Y', strtotime($newsItem->dated)) . '' }}</span>
                                        <strong class="shake"><a
                                                href="javascript:updateStatus({{ $newsItem->id . ',"' . $newsItem->link . '"' }})"
                                                class="readmore">{{ $newsItem->title }}</a></strong>
                                        <a href="javascript:updateStatus({{ $newsItem->id . ',"' . $newsItem->link . '"' }})"
                                            class="readmore">Read More</a>
                                    </div>
                                @endforeach
                            </div>
                            <div class="row" style="margin-bottom: 15px !important;">
                                <div class="col-md-12 text-end"><a href="{{ base_url() . 'adminmedia/news_page' }}"
                                        class="btn dsitebtn" target="_blank"> Read Previous</a></div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row">
                    @php
                        $currentURL = url()->current();
                        $currentURL = rtrim($currentURL, '.html');
                        $currentURL = str_replace(base_url(), '', $currentURL);
                        $arrLinks = [];
                        $beforeLinks = \App\Helpers\DashboardLinks::$beforeModuleLinks;
                        $arrLinksModule = \App\Helpers\DashboardLinks::get_cms_modules('dashboard');
                        $afterLinks = \App\Helpers\DashboardLinks::$afterModuleLinks;
                        $arrLinks = array_merge($beforeLinks, $arrLinksModule, $afterLinks);
                        $bgClasses = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'dark'];
                        $bgClassCounter = 0;
                    @endphp
                    @foreach ($arrLinks as $key => $val)
                        @if (isset($val['user_type']) && in_array(auth()->user()->type, $val['user_type']))
                            <div class="col-md-4">
                                <a target="{{ $val[3] == 'newtab' ? '_blank' : '' }}" style="color: unset;"
                                                href="{{ admin_url() . '' . $val[2] }}">
                                <div class="small-box bg-{{ $bgClasses[$bgClassCounter++] }}">
                                    <div class="inner">
                                        <h5>
                                            @if (isset($adminAlerts[$key]) && $adminAlerts[$key] != '0' && $adminAlerts[$key] != '')
                                                <span class="badge">{{ $adminAlerts[$key] }}</span>
                                            @endif <br>{{ $val[0] }}
                                        </h5>
                                    </div>
                                    <div class="icon">
                                        <i class="fas {{ $val[1] }}"></i>
                                    </div>
                                    <span class="small-box-footer">
                                        {{ $val[0] }} <i class="fas fa-arrow-circle-right"></i>
                                    </span>
                                </div>
                            </a>
                            </div>
                        @endif
                        @php
                            if ($bgClassCounter == 7) {
                                $bgClassCounter = 0;
                            }
                        @endphp
                    @endforeach
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
@endsection
@section('beforeBodyClose')
    <script>
        function updateStatus(id, link) {
            window.open('https://medialinkers.com/pms/newsupdate/newsmain/' + link);
            url = "{{ base_url() }}adminmedia/news_update?id=" + id;
            $.ajax({
                url: url,
                type: "GET",
                success: function(data) {
                    console.log(data);
                    $("#unread").css('display', 'none');
                    $("#read").css('display', 'block');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                    console.log(textStatus);
                    console.log(errorThrown);
                    alert('Error adding / update data');
                }
            });
        }
    </script>
@endsection
