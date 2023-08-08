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
        <section class="content-header">
            <div class="row">
                <div class="col-md-5 col-sm-12">
                    <h1> Latest News and Updates </h1>
                </div>
                <div class="col-md-7 col-sm-12">
                    @include('back.common_views.quicklinks')
                </div>
            </div>
        </section>
        <!-- Main content -->
        <!--Newsletters Archive Start-->
        <div class="archiveWrp">
            <ul>
                @foreach ($news as $newsItem)
                    <li>
                        {{ date('d F', strtotime($newsItem->dated)) . ':' }} {{ $newsItem->title }}
                        <a href="javascript:updateStatus({{ $newsItem->id . ',"' . $newsItem->link . '"' }})">Read
                            More</a>
                        <span class="pull-right"
                            style="display: {{ $newsItem->read_status == 0 ? 'block' : 'none' }};color: #4aa9e9" id="unread">
                            {{ 'Unread' }} </span>
                        <span class="pull-right"
                            style="display: {{ $newsItem->read_status == 0 ? 'none' : 'block' }};color: #3abfa3"
                            id="read"> {{ 'Read' }} </span>
                    </li>
                @endforeach
            </ul>
        </div>
        {{ $news->links() }}
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
