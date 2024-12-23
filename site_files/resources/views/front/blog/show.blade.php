@extends('front.layout.app')
@section('beforeHeadClose')
    <link href="{{ asset_storage('') . 'module/blog/front/css/blog.css' }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    @php echo cms_edit_page("blog",$blog_post_details->id);@endphp
    {!! cms_page_heading($blog_post_details->title) !!}
    <div class="about-wrap">
        <!-- Start Blog
            ============================================= -->
        <div class="blog-area single full-blog right-sidebar full-blog default-padding-20">
            <div class="container">
                <div class="row">
                    <div class="blog-items">
                        <div class="blog-content col-md-8">
                            <div class="item">
                                <!-- Start Post Thumb -->
                                <div class="thumb">
                                    @if (
                                        !empty($blog_post_details->featured_img) &&
                                            file_exists(storage_uploads('blog/' . $blog_post_details->featured_img)))
                                        <img src="{{ asset_uploads('blog/' . $blog_post_details->featured_img) }}"
                                            title="{{ $blog_post_details->featured_img_title }}"
                                            alt="{{ $blog_post_details->featured_img_alt }}">
                                    @else
                                        <img src="{{ asset_uploads('back/images/no_image.jpg') }}"
                                            title="{{ $blog_post_details->featured_img_title }}"
                                            alt="{{ $blog_post_details->featured_img_alt }}">
                                    @endif
                                    <span class="post-formats"><i class="fas fa-image"></i></span>
                                </div>
                                <!-- Start Post Thumb -->
                                <div class="info content-box">
                                    <div class="meta">
                                        <div class="date">
                                            <i class="fas fa-calendar-alt"></i> 29 Feb, 2019
                                        </div>
                                    </div>

                                    <h3>{{ $blog_post_details->title }}
                                    </h3>
                                    @php echo $blog_post_details->description @endphp
                                    <div class="comments-form">
                                        <div class="title">
                                            <h4>Leave a comments</h4>
                                        </div>
                                        <form action="#" class="contact-comments">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <!-- Name -->
                                                        <input name="name" class="form-control" placeholder="Name *"
                                                            type="text">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <!-- Email -->
                                                        <input name="email" class="form-control" placeholder="Email *"
                                                            type="email">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group comments">
                                                        <!-- Comment -->
                                                        <textarea class="form-control" placeholder="Comment"></textarea>
                                                    </div>
                                                    <div class="form-group full-width submit">
                                                        <button type="submit">
                                                            Post Comments
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- End Comments Form -->
                            </div>
                        </div>
                    </div>
                    <!-- Start Sidebar -->
                    <div class="sidebar col-md-4">
                        <aside>
                            <div class="sidebar-item search">
                                <div class="title">
                                    <h4>Search</h4>
                                </div>
                                <div class="sidebar-info">
                                    <form method="GET" action="{{ base_url() . 'blog/search' }}">
                                        <input type="text" class="form-control" name="s"
                                            value="{{ \Session::get('search_blog') }}">
                                        <input type="submit" value="search" id="blog_search_btn">
                                    </form>
                                </div>
                            </div>
                            <div class="sidebar-item category">
                                <div class="title">
                                    <h4>category list</h4>
                                </div>
                                <div class="sidebar-info">
                                    <ul>
                                        @foreach ($blog_categories as $blog_catValues)
                                            <li>
                                                <a
                                                    href="{{ base_url() . 'blog/category/' . $blog_catValues['cate_slug'] . '' }}">{{ $blog_catValues['cate_title'] }}</a>
                                            </li>
                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                        </aside>
                    </div>
                    <!-- End Start Sidebar -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Blog -->
    </div>
@endsection
