<?php $settingInformation = settingArr(); ?>
<!-- Preloader Start -->
<div class="se-pre-con"></div>
<!-- Preloader Ends -->
<!-- Start Header Top
    ============================================= -->
<div class="top-bar-area bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-8 address-info text-left">
                <div class="info box">
                    <ul>
                        <li>
                            <div class="icon"> <i class="fas fa-map-marker-alt"></i> </div>
                            {{-- <div class="info"> <span>Address</span> @php echo get_widget(70); @endphp </div> --}}
                        </li>
                        <li>
                            <div class="icon"> <i class="fas fa-envelope-open"></i> </div>
                            <div class="info"> <span>Email</span>
                                <a href="mailto:<?php echo $settingInformation['email']; ?>"><?php echo $settingInformation['email']; ?></a>
                            </div>
                        </li>
                        <li>
                            <div class="icon"> <i class="fas fa-phone"></i> </div>
                            <div class="info"> <span>Phone</span>                                
                                <a href="tel:<?php echo str_replace('-', '', $settingInformation['telephone']); ?>"><?php echo $settingInformation['telephone']; ?></a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4 social text-right">
                <ul>
                    @php echo social_media(); @endphp
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End Header Top -->
<!-- Header
    ============================================= -->
<header id="home">

    <!-- Start Navigation -->
    <nav class="navbar navbar-default navbar-sticky bootsnav">

        <!-- Start Top Search -->
        <div class="container">
            <div class="row">
                <div class="top-search">
                    <div class="input-group">
                        <form action="@php echo base_url().'blog/search' @endphp">
                            <input type="text" name="s" class="form-control" placeholder="Search">
                            <button type="submit"> <i class="fas fa-search"></i> </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Top Search -->

        <div class="container">

            <!-- Start Atribute Navigation -->
            <div class="attr-nav">
                <ul>
                    <li class="search"><a href="#"><i class="fa fa-search"></i></a></li>
                </ul>
            </div>
            <!-- End Atribute Navigation -->

            <!-- Start Header Navigation -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-bs-toggle="collapse" data-target="#navbar-menu"> <i
                        class="fa fa-bars"></i> </button>
                <a class="navbar-brand" href="{{ base_url() }}"> <img src="{{ asset_storage('front/img/logo.png') }}"
                        class="logo" alt="Logo"> </a>
            </div>
            <!-- End Header Navigation -->

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="navbar-menu">
                <ul class="nav navbar-nav navbar-right" data-in="#" data-out="#">

                    @php
                        
                        $isactive = Request::segment(1) == '' || Request::segment(1) == '/' ? ' active' : '';
                    @endphp
                    <li class="dropdown{{ $isactive }}"> <a href="{{ base_url() }}">Home</a> </li>
                    @php echo getDropDown(); @endphp
                    <!--<li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">Pages</a>
            <ul class="dropdown-menu">
              <li><a href="about-us.html">About us</a></li>
              <li><a href="login.html">login</a></li>
              <li><a href="register.html">register</a></li>
              <li><a href="contact.html">Contact</a></li>
              <li><a href="pricing-table.html">Pricing Table</a></li>
              <li><a href="faq.html">Faq</a></li>
              <li><a href="404.html">Error Page</a></li>
            </ul>
          </li>
          <li class="dropdown"> <a href="#" class="dropdown-toggle active" data-toggle="dropdown" >Gallery</a>
            <ul class="dropdown-menu">
              <li><a href="gallery.html">Our Gallery</a></li>
            </ul>
          </li>
          <li class="dropdown"> <a href="#" class="dropdown-toggle active" data-toggle="dropdown" >Services</a>
            <ul class="dropdown-menu">
              <li><a href="services.html">Services</a></li>
              <li><a href="services-details.html">Services Details</a></li>
            </ul>
          </li>
          <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" >Blog</a>
            <ul class="dropdown-menu">
              <li><a href="blog.html">Blog</a></li>
              <li><a href="blog-details.html">Single Details</a></li>
            </ul>
          </li>
          <li> <a href="contact.html">contact</a> </li>-->
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
    </nav>
    <!-- End Navigation -->

</header>
<!-- End Header -->
