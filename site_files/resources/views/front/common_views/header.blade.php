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
                <a class="navbar-brand" href="{{ base_url() }}"> <img src="{{ asset_storage('front/images/logo.png') }}"
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
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
    </nav>
    <!-- End Navigation -->

</header>
<!-- End Header -->
