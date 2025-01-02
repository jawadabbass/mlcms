<!-- Start Footer
    ============================================= -->
<footer class="bg-dark">
    <!-- Start Footer Top -->
    <div class="footer-top bg-gray">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-4 logo"> <a href="#"><img src="{{ asset_storage('front/images/logo.png') }}"
                            alt="Logo"></a> </div>
                <div class="col-md-8 col-sm-8 form text-end">
                    @if (\Session::has('added_subscriber'))
                        <div class="message-container-subscriber">
                            Thank You For Subscribing.
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="subscriber-error text-center">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="addSubscriber" method="post">
                        @csrf
                        <div class="input-group stylish-input-group">
                            <input type="email" placeholder="Enter your e-mail here" class="form-control"
                                name="email" required="required">
                            <span class="input-group-addon">
                                <button type="submit"> Subscribe <i class="fa fa-paper-plane"></i> </button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Footer Top -->
    <div class="container">
        <div class="row">
            <div class="f-items default-padding-20">

                <!-- Single Item -->
                <div class="col-md-4 equal-height item">
                    <div class="f-item">
                        <h4>About</h4>
                        {!! get_widget(92) !!}
                        <div class="social">
                            <ul>
                                @php echo social_media(); @endphp
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- End Single Item -->
                <!-- Single Item -->
                <div class="col-md-4 equal-height item">
                    <div class="f-item link">
                        <h4>Services</h4>
                        <ul>
                            @php
                                $get_all_services = \App\Models\Back\Service::where('is_featured', 1)->active()->sorted()->get();
                            @endphp
                            @if (count($get_all_services) > 0)
                                @foreach ($get_all_services as $services)
                                    <li><a
                                            href="{{ url('services/'.$services->slug) }}">{{ $services->title }}</a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
                <!-- End Single Item -->
                <!-- Single Item -->
                <div class="col-md-4 equal-height item">
                    <div class="f-item recent-post">
                        <h4>Recent Posts</h4>
                        @php $blogData=get_latest_blog(); @endphp
                        <ul>
                            @foreach ($blogData as $blog)
                                <li>
                                    <div class="thumb"> <a href="{{ url('blog/'.$blog->post_slug) }}"> <img
                                                src="{{ asset_uploads('blog/' . $blog->featured_img) }}"  title="{{ $blog->featured_img_title }}" alt="{{ $blog->featured_img_alt }}">
                                        </a> </div>
                                    <div class="info"> <a href="{{ url('blog/'.$blog->post_slug) }}">{{ $blog->title }}</a>
                                        <div class="meta-title"> <span class="post-date">
                                                @php echo date('d M, y',strtotime($blog->dated)); @endphp </span> - By <a
                                                href="#">{{ $blog->author->name }}</a> </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <!-- End Single Item -->
            </div>
        </div>
    </div>
    <!-- Start Footer Bottom -->
    <div class="footer-bottom bg-dark text-light">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p>&copy; Copyright {{ date('Y') }}. All Rights Reserved by <a href="https://www.medialinkers.com">Medialinkers</a></p>
                </div>
                <div class="col-md-6 text-end link">                    
                    <ul>
                        @php echo getDropDown('footer'); @endphp
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Footer Bottom -->
</footer>
<!-- End Footer -->
