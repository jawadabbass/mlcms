@extends('back.layouts.app', ['title' => config('Constants.SITE_NAME') . ' | Dashboard'])

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
    <aside class="right-side {{ session('leftSideBar') == 1 ? 'strech' : '' }}">
        <section class="content-header">
            <div class="row">
                <div class="col-md-8 col-sm-6">
                    <h1> Dashboard </h1>
                </div>
                <div class="col-md-4 col-sm-6">
                    @include('back.common_views.quicklinks')
                </div>
            </div>
        </section>
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
                <div class="col-md-12 text-end"><a href="{{ base_url() . 'adminmedia/news_page' }}" class="btn dsitebtn"
                        target="_blank"> Read Previous</a></div>
            </div>
        @endif
        <section class="content">
            <ul class="row dashlist">
                @php
                    $currentURL = url()->current();
                    $currentURL = rtrim($currentURL, '.html');
                    $currentURL = str_replace(base_url(), '', $currentURL);
                    $arrLinks = [];
                    $arrLinks = \App\Helpers\DashboardLinks::$arrLinks;
                @endphp
                @foreach ($arrLinks as $key => $val)                
                    @if (isset($val['user_type']) && in_array(auth()->user()->type, $val['user_type']))
                        <li><a target="{{ $val[3] == 'newtab' ? '_blank' : '' }}" href="{{ admin_url() . '' . $val[2] }}">
                                <i class="fa-solid awesome_style {{ $val[1] }}"></i>
                                @if (isset($adminAlerts[$key]) && $adminAlerts[$key] != '0' && $adminAlerts[$key] != '')
                                    <span class="badge">{{ $adminAlerts[$key] }}</span>
                                @endif <br>
                                {{ $val[0] }}
                            </a></li>
                    @endif
                @endforeach
            </ul>
        </section>
    </aside>
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
