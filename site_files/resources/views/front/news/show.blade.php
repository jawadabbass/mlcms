@extends('front.layout.app')
@section('content')
    {!! cms_page_heading($news->title) !!}
    <div class="about-wrap default-padding-20">
        <div class="container">
            <div class="col-sm-10">
                <ul class="new-service row">
                    <li class="col-sm-12">
                        <div class="date">{{ date_formats($news->news_date_time, 'd') }}
                            <span>{{ date_formats($news->news_date_time, 'M') }}</span>
                            <div class="year">{{ date_formats($news->news_date_time, 'Y') }}</div>
                        </div>
                        <div class="head">
                            <a
                                href="{{ url('/news-details/' . $news->id . '/' . Str::slug($news->title)) }}">{{ $news->title }}</a>
                        </div>
                        <p>{!! $news->description !!}</p>
                    </li>
                </ul>
                <div class="paginationWrap pull-right" style="">
                </div>
            </div>
            <div class="col-sm-2">
                <div class="collaps">
                    <h1 class="newstitle">News Archives</h1>
                    <ul class="monthlynews">
                        @php
                            $currentYear = date('Y');
                            $newsYear = 0;
                            $firstYear = 0;
                            $firstMonthActive = false;
                        @endphp
                        @foreach ($newsArchive as $data)
                            <?php
                            $newYear = false;
                            if ($newsYear != $data->newsyear) {
                                $newYear = true;
                                if ($newsYear == 0) {
                                    $firstYear = $newsYear;
                                }
                                if ($newsYear != $firstYear) {
                                    echo '</ul>';
                                }
                                $newsYear = $data->newsyear;
                            } ?>
                            @if ($newYear)
                                <li>
                                    <h4 {{ $firstMonthActive == false ? 'id="first_year_display_text"' : '' }}>
                                        {{ $newsYear }}</h4>
                                    <ul class="showhide"
                                        @if ($firstMonthActive == false) @php
                                            echo 'id="first_year_display"';
                                            $firstMonthActive = true;
                                        @endphp @endif
                                        @endif
                                        <li>
                                            <a
                                                href="{{ base_url() . 'news/' . $data->newsyear . '/' . $data->newsmonthno }} ">
                                                @php echo $data->newsmonth . '<span>(' . $data->newscount . ')</span>'; @endphp
                                            </a>
                                        </li>
                            @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('beforeBodyClose')
    <script>
        /**Collaps**/
        jQuery(function($) {
            $(document).ready(function() {
                $('.collaps h4').each(function() {
                    var tis = $(this),
                        state = false,
                        answer = tis.next('.showhide').hide().css('height', 'auto').slideUp();
                    tis.click(function() {
                        state = !state;
                        answer.slideToggle(state);
                        tis.toggleClass('active', state);
                    });
                });
                $("#first_year_display_text").trigger('click');
            });
        });
    </script>
@endsection
