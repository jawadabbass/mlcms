@extends('front.layout.app')
@section('beforeHeadClose')
    <link href="{{ asset_storage('') . 'module/blog/front/css/blog.css' }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    @php echo cms_edit_page("blog");@endphp
    {!! cms_page_heading('Blog') !!}
    <div class="about-wrap">
        <!-- Start Blog
                    ============================================= -->
        <div class="blog-area full-blog right-sidebar default-padding-20">
            <div class="container">
                <div class="row">
                    <div class="blog-items">
                        <div class="blog-content col-md-8">

                            @if (count($blogData) > 0)
                                @foreach ($blogData as $blogsValues)
                                    <!-- Single Item -->
                                    <div class="single-item item">
                                        <div class="thumb">
                                            <a href="{{ base_url() . 'blog/' . $blogsValues['post_slug'] }}">
                                                @if (!empty($blogsValues['featured_img']) && file_exists(storage_uploads('blog/' . $blogsValues['featured_img'])))
                                                    <img src="{{ asset_uploads('blog/' . $blogsValues['featured_img']) }}"
                                                        title="{{ $blogsValues['featured_img_title'] }}"
                                                        alt="{{ $blogsValues['featured_img_alt'] }}">
                                                @else
                                                    <img src="{{ asset_uploads('back/images/no_image.jpg') }}"
                                                        title="{{ $blogsValues['featured_img_title'] }}"
                                                        alt="{{ $blogsValues['featured_img_alt'] }}">
                                                @endif
                                            </a>
                                            <span class="post-formats"><i class="fas fa-image"></i></span>
                                        </div>
                                        <div class="info">
                                            <div class="cats">
                                                <!--<span><i class="fa fa-user"></i>{{ $blogsValues['admin_name'] }}</span>-->
                                            </div>
                                            <h3>
                                                <a href="{{ base_url() . 'blog/' . $blogsValues['post_slug'] }}">
                                                    @php echo $blogsValues['title']; @endphp</a>
                                            </h3>
                                            <p>
                                                @php
                                                    //echo substr($blogsValues['description'],0, 180)."...";
                                                @endphp
                                            </p>
                                            <div class="meta">
                                                <ul>
                                                    <li><i class="fas fa-calendar-alt"></i>
                                                        {{ date('M d, Y ', strtotime($blogsValues['dated'])) }} </li>
                                                </ul>
                                                <a href="{{ base_url() . 'blog/' . $blogsValues['post_slug'] }}">Read
                                                    More</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Single Item -->
                                @endforeach
                                <div class="clearfix"></div>
                            @else
                                <p style="text-align: center;">No Record Found</p>
                            @endif
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
                                                value="{{ request()->input('s', '') }}">
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
