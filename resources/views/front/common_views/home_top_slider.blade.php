<div id="main" role="main" class="slider">
    <div class="flexslider">
        <ul class="slides">
            {{--@if($get_all_banner)--}}
                @foreach($get_all_banner as $get_all_ban)
                    <li>
                        <img height="320"
                             src="{{ base_url() }}uploads/module/banner/{{ $get_all_ban->featured_img}}"  title="{{ $get_all_ban->featured_img_title }}" alt="{{ $get_all_ban->featured_img_alt }}"/>
                        <div class="sliderTxt">
                            <div class="container">
                                @php echo $get_all_ban->content @endphp
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </li>
                @endforeach
            {{--@endif--}}
            <div style="clear:both;"></div>
        </ul>
    </div>
</div>