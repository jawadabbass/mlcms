@extends('front.layout.app')
@section('beforeHeadClose')
    <link href="{{ base_url() . 'module/blog/front/css/blog.css' }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    @php echo cms_edit_page("blog",$blog_post_details->ID);@endphp
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
                                    @if (!empty($blog_post_details->featured_img) &&
                                        file_exists(public_path('/uploads/blog/' . $blog_post_details->featured_img)))
                                        <img src="{{ base_url() . 'uploads/blog/' . $blog_post_details->featured_img }}" title="{{ $blog_post_details->featured_img_title }}" alt="{{ $blog_post_details->featured_img_alt }}">
                                    @else
                                        <img src="{{ base_url() . 'back/images/no_image.jpg' }}" title="{{ $blog_post_details->featured_img_title }}" alt="{{ $blog_post_details->featured_img_alt }}">
                                    @endif
                                    <!--<img src="assets/img/blog/v1.jpg" alt="Thumb">-->
                                    <span class="post-formats"><i class="fas fa-image"></i></span>
                                </div>
                                <!-- Start Post Thumb -->
                                <div class="info content-box">
                                    <div class="meta">
                                        <!--<div class="cats">
                                            <a href="#">Business</a>
                                            <a href="#">Assets</a>
                                        </div>-->
                                        <div class="date">
                                            <i class="fas fa-calendar-alt"></i> 29 Feb, 2019
                                        </div>
                                    </div>

                                    <h3>{{ $blog_post_details->title }}
                                    </h3>
                                    @php echo $blog_post_details->description @endphp
                                    <!-- Start Post Tag
                                    <div class="post-tags share">
                                        <div class="tags">
                                            <span>Tags: </span>
                                            <a href="#">Consulting</a>
                                            <a href="#">Planing</a>
                                            <a href="#">Business</a>
                                            <a href="#">Fashion</a>
                                        </div>
                                    </div>
                                    End Post Tags -->
                                    <!-- Start Author Post
                                    <div class="author-bio">
                                        <div class="avatar">
                                            <img src="assets/img/team/7.jpg" alt="Author">
                                        </div>
                                        <div class="content">
                                            <p>
                                                Supply as so period it enough income he genius. Themselves acceptance bed sympathize get dissimilar way admiration son. Design for are edward regret met lovers. This are calm case roof and.
                                            </p>
                                            <h4> - Jonkey Rotham</h4>
                                        </div>
                                    </div>
                                    End Author Post -->
                                    <!-- Start Comments Form
                                    <div class="comments-area">
                                        <div class="comments-title">
                                            <h4>
                                                5 comments
                                            </h4>
                                            <div class="comments-list">
                                                <div class="commen-item">
                                                    <div class="avatar">
                                                        <img src="assets/img/team/4.jpg" alt="Author">
                                                    </div>
                                                    <div class="content">
                                                        <h5>Jonathom Doe</h5>
                                                        <div class="comments-info">
                                                            <p>July 15, 2018</p> <a href="#"><i class="fa fa-reply"></i>Reply</a>
                                                        </div>
                                                        <p>
                                                            Delivered ye sportsmen zealously arranging frankness estimable as. Nay any article enabled musical shyness yet sixteen yet blushes. Entire its the did figure wonder off.
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="commen-item reply">
                                                    <div class="avatar">
                                                        <img src="assets/img/team/5.jpg" alt="Author">
                                                    </div>
                                                    <div class="content">
                                                        <h5>Spark Lee</h5>
                                                        <div class="comments-info">
                                                            <p>July 15, 2018</p> <a href="#"><i class="fa fa-reply"></i>Reply</a>
                                                        </div>
                                                        <p>
                                                            Delivered ye sportsmen zealously arranging frankness estimable as. Nay any article enabled musical shyness yet sixteen yet blushes. Entire its the did figure wonder off.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>-->
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
