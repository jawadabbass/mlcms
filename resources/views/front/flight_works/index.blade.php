@php
use App\Models\Back\FleetPlanePassengerCapacity;
use App\Models\Back\FleetPlaneBaggageCapacity;
use App\Models\Back\FleetPlaneCabinDimension;
use App\Models\Back\FleetPlanePerformance;
use App\Models\Back\FleetPlaneCabinAmenity;
use App\Models\Back\FleetPlaneSafety;
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Interar">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="FLight Works">
    <meta name="keywords" content="FLight Works" />
    <title>Flight Works</title>
    <link href="{{ asset('flight_works/images/favicon.png') }}" rel="shortcut icon" type="image/png">
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{ asset('flight_works/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('flight_works/css/responsive.css') }}">
</head>

<body>
    <!-- Header Area Start -->
    <header class="header-style-01">
        <nav class="main-menu sticky-header">
            <div class="main-menu-wrapper">
                <div class="main-menu-logo">
                    <a href="#">
                        <img src="{{ asset('flight_works') }}/images/logo-light.svg" width="165" height="72"
                            alt="logo">
                    </a>
                </div>
                <div class="ms-auto d-flex">
                    <ul class="main-nav-menu">
                        <li><a href="index.html">Private Air Charter</a></li>
                        <li><a href="#">Aircraft Management</a></li>
                        <li><a href="#">Government Services</a></li>
                        <li><a href="#">Aircraft Sales and Services</a></li>
                        <li><a href="#">Technical Services</a></li>
                    </ul>
                    <a href="#" class="user-login"><i class="fas fa-user"></i> Login</a>
                    <a href="#" class="mobile-nav-toggler">
                        <span></span>
                        <span></span>
                        <span></span>
                    </a>
                    <a href="#" class="other-nav-toggler">
                        <span></span>
                        <span></span>
                        <span></span>
                    </a>
                </div>
            </div>
        </nav>
    </header>
    <!-- Header Area End -->
    <!-- Page Title Start -->
    <section class="page-title-section">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="breadcrumb-area">
                        <h2 class="page-title">{{ $fleetPlaneObj->plane_name }}</h2>
                        <ul class="breadcrumbs-link">
                            <li><a href="#">Home</a></li>
                            <li><a href="#">Services</a></li>
                            <li class="active">{{ $fleetPlaneObj->plane_name }} </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Page Title End -->
    <!-- Service Details Section Start -->
    <section class="service-details-page pdt-10 pdb-70 pdb-lg-75">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-3 sidebar-right">
                    @if (!empty($fleetPlaneObj->spec_sheet))
                        <div class="specsheet mrb-30">
                            <h3>Spec Sheet</h3>
                            <a href="{{ asset('uploads/fleet_planes/'.$fleetPlaneObj->spec_sheet) }}" target="_blank" title="Spec sheet of {{ $fleetPlaneObj->plane_name }}"><i class="fas fa-download"></i> Download</a>
                        </div>
                    @endif

                    <div class="service-nav-menu mrb-30">
                        <div class="service-link-list">
                            <ul>
                                <li><a href="#"><i class="fa fa-chevron-right"></i>Overview</a></li>
                                @foreach ($fleetCategories as $fleetCategoryObj)
                                    <li class="mainli {{ $fleetCategoryObj->id == $fleetCategoryId ? 'active' : '' }}">
                                        <a href="javascript:void(0);"><i
                                                class="fa fa-chevron-right"></i>{{ $fleetCategoryObj->title }}</a>
                                        <ul class="subul"
                                            style="{{ $fleetCategoryObj->id == $fleetCategoryId ? '' : 'display:none;' }}">
                                            @foreach ($fleetCategoryObj->fleetPlanes as $fleetPlaneObj2)
                                                <li
                                                    class="subli {{ $fleetPlaneObj2->id == $fleetPlaneId ? 'active' : '' }}">
                                                    <a
                                                        href="{{ url('flight-works/' . $fleetCategoryObj->id . '/' . $fleetPlaneObj2->id . '/' . Illuminate\Support\Str::slug($fleetPlaneObj2->plane_name)) }}">{{ $fleetPlaneObj2->plane_name }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="sidebar-widget-need-help">
                        <div class="need-help-icon">
                            <span class="webexflaticon base-icon-phone-call"></span>
                        </div>
                        <h4 class="need-help-title">Get In Touch</h4>
                        <div class="need-help-contact">
                            <p class="mrb-5">Please Contact With Us</p>
                            <a href="tel:+971 565744785">+1.770.422.7375</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-9">
                    <div class="service-detail-text">
                        <div class="owl-carousel service_2col text-left mrb-30">
                            <div class="testimonial-item">
                                <div class="testimonial-thumb">
                                    <img class="img-full" src="{!! App\Helpers\ImageUploader::print_image_src($fleetPlaneObj->image, 'fleet_planes') !!}"
                                        alt="Image of {{ $fleetPlaneObj->plane_name }}"
                                        title="Image of {{ $fleetPlaneObj->plane_name }}">
                                </div>
                            </div>
                            @foreach ($fleetPlaneObj->planeImages as $planeImageObj)
                                <div class="testimonial-item">
                                    <div class="testimonial-thumb">
                                        <img class="img-full" src="{!! App\Helpers\ImageUploader::print_image_src($planeImageObj->image, 'fleet_planes') !!}"
                                            alt="Image of {{ $fleetPlaneObj->plane_name }}"
                                            title="Image of {{ $fleetPlaneObj->plane_name }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="whatinc row">
                            <div class="col-lg-4 col-md-4">
                                <div class="incbox">
                                    <h4>Passenger Capacity</h4>
                                    <ul>
                                        @foreach ($passengerCapacities as $passengerCapacityObj)
                                            @php
                                                $fleetPlanePassengerCapacityObj = FleetPlanePassengerCapacity::getFleetPlanePassengerCapacity($fleetPlaneObj->id, $passengerCapacityObj->id);
                                            @endphp
                                            @if (!empty($fleetPlanePassengerCapacityObj->value))
                                                <li>{{ $passengerCapacityObj->title }}:
                                                    <strong>
                                                        {{ $fleetPlanePassengerCapacityObj->value }}
                                                        @if (!empty($fleetPlanePassengerCapacityObj->hint))
                                                            <a href="javascript:void(0);" class="text-basic"
                                                                data-bs-toggle="popover"
                                                                data-bs-trigger="hover focus"
                                                                data-bs-title="{{ $passengerCapacityObj->title }}"
                                                                data-bs-content="{{ $fleetPlanePassengerCapacityObj->hint }}">?</a>
                                                        @endif
                                                    </strong>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="incbox">
                                    <h4>Cabin Dimensions</h4>
                                    <ul>
                                        @foreach ($cabinDimensions as $cabinDimensionObj)
                                            @php
                                                $fleetPlaneCabinDimensionObj = FleetPlaneCabinDimension::getFleetPlaneCabinDimension($fleetPlaneObj->id, $cabinDimensionObj->id);
                                            @endphp
                                            @if (!empty($fleetPlaneCabinDimensionObj->value))
                                                <li>{{ $cabinDimensionObj->title }}:
                                                    <strong>
                                                        {{ $fleetPlaneCabinDimensionObj->value }}
                                                        @if (!empty($fleetPlaneCabinDimensionObj->hint))
                                                            <a href="javascript:void(0);" class="text-basic"
                                                                data-bs-toggle="popover"
                                                                data-bs-trigger="hover focus"
                                                                data-bs-title="{{ $cabinDimensionObj->title }}"
                                                                data-bs-content="{{ $fleetPlaneCabinDimensionObj->hint }}">?</a>
                                                        @endif
                                                    </strong>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="incbox">
                                    <h4>Baggage Capacity</h4>
                                    <ul>
                                        @foreach ($baggageCapacities as $baggageCapacityObj)
                                            @php
                                                $fleetPlaneBaggageCapacityObj = FleetPlaneBaggageCapacity::getFleetPlaneBaggageCapacity($fleetPlaneObj->id, $baggageCapacityObj->id);
                                            @endphp
                                            @if (!empty($fleetPlaneBaggageCapacityObj->value))
                                                <li>{{ $baggageCapacityObj->title }}:
                                                    <strong>
                                                        {{ $fleetPlaneBaggageCapacityObj->value }}
                                                        @if (!empty($fleetPlaneBaggageCapacityObj->hint))
                                                            <a href="javascript:void(0);" class="text-basic"
                                                                data-bs-toggle="popover"
                                                                data-bs-trigger="hover focus"
                                                                data-bs-title="{{ $baggageCapacityObj->title }}"
                                                                data-bs-content="{{ $fleetPlaneBaggageCapacityObj->hint }}">?</a>
                                                        @endif
                                                    </strong>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="incbox">
                                    <h4>Performance</h4>
                                    <ul>
                                        @foreach ($performances as $performanceObj)
                                            @php
                                                $fleetPlanePerformanceObj = FleetPlanePerformance::getFleetPlanePerformance($fleetPlaneObj->id, $performanceObj->id);
                                            @endphp
                                            @if (!empty($fleetPlanePerformanceObj->value))
                                                <li>{{ $performanceObj->title }}:
                                                    <strong>
                                                        {{ $fleetPlanePerformanceObj->value }}
                                                        @if (!empty($fleetPlanePerformanceObj->hint))
                                                            <a href="javascript:void(0);" class="text-basic"
                                                                data-bs-toggle="popover"
                                                                data-bs-trigger="hover focus"
                                                                data-bs-title="{{ $performanceObj->title }}"
                                                                data-bs-content="{{ $fleetPlanePerformanceObj->hint }}">?</a>
                                                        @endif
                                                    </strong>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="incbox">
                                    <h4>Cabin Amenities</h4>
                                    <ul>
                                        @foreach ($cabinAmenities as $cabinAmenityObj)
                                            @php
                                                $fleetPlaneCabinAmenityObj = FleetPlaneCabinAmenity::getFleetPlaneCabinAmenity($fleetPlaneObj->id, $cabinAmenityObj->id);
                                            @endphp
                                            @if (!empty($fleetPlaneCabinAmenityObj->value))
                                                <li>{{ $cabinAmenityObj->title }}:
                                                    <strong>
                                                        {{ $fleetPlaneCabinAmenityObj->value }}
                                                        @if (!empty($fleetPlaneCabinAmenityObj->hint))
                                                            <a href="javascript:void(0);" class="text-basic"
                                                                data-bs-toggle="popover"
                                                                data-bs-trigger="hover focus"
                                                                data-bs-title="{{ $cabinAmenityObj->title }}"
                                                                data-bs-content="{{ $fleetPlaneCabinAmenityObj->hint }}">?</a>
                                                        @endif
                                                    </strong>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="incbox">
                                    <h4>Safety</h4>
                                    <ul>
                                        @foreach ($safeties as $safetyObj)
                                            @php
                                                $fleetPlaneSafetyObj = FleetPlaneSafety::getFleetPlaneSafety($fleetPlaneObj->id, $safetyObj->id);
                                            @endphp
                                            @if (!empty($fleetPlaneSafetyObj->value))
                                                <li>{{ $safetyObj->title }}:
                                                    <strong>
                                                        {{ $fleetPlaneSafetyObj->value }}
                                                        @if (!empty($fleetPlaneSafetyObj->hint))
                                                            <a href="javascript:void(0);" class="text-basic"
                                                                data-bs-toggle="popover"
                                                                data-bs-trigger="hover focus"
                                                                data-bs-title="{{ $safetyObj->title }}"
                                                                data-bs-content="{{ $fleetPlaneSafetyObj->hint }}">?</a>
                                                        @endif
                                                    </strong>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @if(str_contains($fleetPlaneObj->description, '</p>'))
                        {!! $fleetPlaneObj->description !!}
                        <p class="mrb-40"></p>
                        @else
                        <p class="mrb-40">{!! $fleetPlaneObj->description !!}</p>
                        @endif
                        
                        
                        @if (!empty($fleetPlaneObj->layout_image))
                            <img src="{!! App\Helpers\ImageUploader::print_image_src($fleetPlaneObj->layout_image, 'fleet_planes') !!}" alt="Layout of {{ $fleetPlaneObj->plane_name }}"
                                title="Layout of {{ $fleetPlaneObj->plane_name }}">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Service Details Section End -->
    <!-- Footer Area Start -->
    <footer class="footer footerbg">
        <div class="footer-main-area">
            <div class="container">
                <div class="row ">
                    <div class="col-xl-3 col-lg-3">
                        <div class="widget footer-widget mrr-30 mrr-md-0">
                            <h5 class="widget-title text-white mrb-30">Corporate Headquarters Atlanta, GA</h5>
                            <address class="mrb-0 pt-3">
                                <div class="ctft"><i class="fas fa-phone-alt"></i> <a
                                        href="#"><span>Phone</span>+1.770.422.7375</a></div>
                                <div class="ctft"><i class="fas fa-fax"></i> <a
                                        href="#"><span>Fax</span>+1.770.499.0912</a></div>
                                <div class="ctft"><i class="fas fa-map-marker-alt"></i> <a href="#"> 1755
                                        McCollum Parkway NW<br>
                                        Entrance C<br>
                                        Kennesaw, GA 30144</a></div>
                            </address>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3">
                        <div class="widget footer-widget mrr-30 mrr-md-0">
                            <h5 class="widget-title text-white mrb-30">Executive Terminal Atlanta, GA</h5>
                            <address class="mrb-0 pt-3">
                                <div class="ctft"><i class="fas fa-phone-alt"></i> <a
                                        href="#"><span>Phone</span>+1.770.422.7375</a></div>
                                <div class="ctft"><i class="fas fa-fax"></i> <a
                                        href="#"><span>Fax</span>+1.770.499.0912</a></div>
                                <div class="ctft"><i class="fas fa-map-marker-alt"></i> <a href="#">McCollum
                                        Field (KRYY)<br>
                                        Entrance C<br>
                                        1755 McCollum Parkway NW<br>
                                        Kennesaw, GA 30144</a></div>
                            </address>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3">
                        <div class="widget footer-widget mrr-30 mrr-md-0">
                            <h5 class="widget-title text-white mrb-30">Executive Terminal Washington DC</h5>
                            <address class="mrb-0 pt-3">
                                <div class="ctft"><i class="fas fa-phone-alt"></i> <a
                                        href="#"><span>Phone</span>+1.770.422.7375</a></div>
                                <div class="ctft"><i class="fas fa-fax"></i> <a
                                        href="#"><span>Fax</span>+1.770.499.0912</a></div>
                                <div class="ctft"><i class="fas fa-map-marker-alt"></i> <a href="#"> Manassas
                                        Regional Airport (KHEF) <br>
                                        10791 James Payne Court<br>
                                        Manassas, VA 20110</a></div>
                            </address>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6">
                        <div class="widget footer-widget">
                            <h5 class="widget-title text-white mrb-30">Additional Locations</h5>
                            <ul class="footer-widget-list pt-3">
                                <li><a href="#">Atlanta, GA (KPDK)</a></li>
                                <li><a href="#">Kennesaw, GA (KRYY)</a></li>
                                <li><a href="#">Savannah, GA (KSAV)</a></li>
                                <li><a href="#">Tulsa, OK (KTUL)</a></li>
                                <li><a href="#">Greensboro, NC (KGSO)</a></li>
                                <li><a href="#">Miami, FL (KOPF)</a></li>
                                <li><a href="#">Washington, DC. (KHEF)</a></li>
                                <li><a href="#">Oklahoma City, OK (KOKC)</a></li>
                                <li><a href="#">Orlando, FL (KMCO)</a></li>
                                <li><a href="#">Bedford, MA (KBED)</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12">
                        <div class="footertagline">We are an equal opportunity employer. It is our policy to provide
                            equal opportunity to all applicants and to prohibit any discrimination because of race,
                            color, religion, sex, sexual orientation or gender identity, national origin, age, marital
                            status, genetic information, disability or protected veteran status.
                        </div>
                    </div>
                </div>
                <div class="pdt-10 pdb-10 footer-copyright-area">
                    <div class="copytext">
                        <ul class="social-list">
                            <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                        </ul>
                        <span>Copyright © 2022 FlightWorks, Inc. | All rights reserved.</span>
                        <span class="pdl-10 pdr-10">|</span> <a href="#">Privacy Policy</a> <span
                            class="pdl-10 pdr-10">-</span> <a href="#">Employee Login</a>
                        <span class="credit ms-auto">Site Credits: <a href="https://www.medialinkers.com"
                                target="_blank">MediaLinkers</a></span>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Area End -->
    <!-- Mobile Nav Sidebar Content Start -->
    <div class="mobile-nav-wrapper">
        <div class="mobile-nav-overlay mobile-nav-toggler"></div>
        <div class="mobile-nav-content">
            <a href="#" class="mobile-nav-close mobile-nav-toggler">
                <span></span>
                <span></span>
            </a>
            <div class="logo-box">
                <a href="index-3.html" aria-label="logo image">
                    <img src="{{ asset('flight_works') }}/images/logo-light.svg" width="165" height="72"
                        alt="logo">
                </a>
            </div>
            <div class="mobile-nav-container"></div>
            <ul class="list-items mobile-sidebar-contact">
                <li><span class="fa fa-map-marker-alt mrr-10 text-primary-color"></span>121 King Street, Australia</li>
                <li><span class="fas fa-envelope mrr-10 text-primary-color"></span><a
                        href="mailto:example@gmail.com">example@gmail.com</a></li>
                <li><span class="fas fa-phone-alt mrr-10 text-primary-color"></span><a href="tel:123456789">+12 345
                        666 789</a></li>
            </ul>
        </div>
    </div>
    <!-- Mobile Nav Sidebar Content End -->
    <!-- other Nav Sidebar Content Start -->
    <div class="other-nav-wrapper">
        <div class="mobile-nav-overlay mobile-nav-toggler"></div>
        <div class="mobile-nav-content">
            <a href="#" class="mobile-nav-close other-nav-toggler">
                <span></span>
                <span></span>
            </a>
            <div class="logo-box">
                <a href="#" aria-label="logo image">
                    <img src="{{ asset('flight_works') }}/images/logo-light.svg" width="165" height="72"
                        alt="logo">
                </a>
            </div>
            <div class="other-nav-container">
                <ul class="mobile-menu-list">
                    <li><a href="index.html">Home</a></li>
                    <li><a href="#">About Us</a>
                        <ul class="d-block">
                            <li><a href="#">The FlightWorks Difference</a></li>
                            <li><a href="#">Our Team</a></li>
                            <li><a href="#">Careers</a></li>
                            <li><a href="#">Affiliations</a></li>
                            <li><a href="#">White Papers</a></li>
                            <li><a href="#">News</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">Client Login</a></li>
                    <li><a href="#">Employee Login</a></li>
                </ul>
            </div>
            <ul class="list-items mobile-sidebar-contact">
                <li><span class="fa fa-map-marker-alt mrr-10 text-primary-color"></span>1755 McCollum Parkway NW
                    Entrance C
                    Kennesaw, GA 30144</li>
                <li><span class="fas fa-phone-alt mrr-10 text-primary-color"></span><a
                        href="tel:123456789">+1.770.422.7375</a></li>
            </ul>
        </div>
    </div>
    <!-- Mobile Nav Sidebar Content End -->
    <!-- Back to Top Start -->
    <div class="anim-scroll-to-top">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>
    <!-- Back to Top end -->
    <!-- Integrated important scripts here -->
    <script src="{{ asset('flight_works/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('flight_works/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('flight_works/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('flight_works/js/jquery.appear.min.js') }}"></script>
    <script src="{{ asset('flight_works/js/wow.min.js') }}"></script>
    <script src="{{ asset('flight_works/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('flight_works/js/jquery.event.move.js') }}"></script>
    <script src="{{ asset('flight_works/js/jquery.twentytwenty.js') }}"></script>
    <script src="{{ asset('flight_works/js/tilt.jquery.min.js') }}"></script>
    <script src="{{ asset('flight_works/js/magnific-popup.min.js') }}"></script>
    <script src="{{ asset('flight_works/js/backtotop.js') }}"></script>
    <script src="{{ asset('flight_works/js/trigger.js') }}"></script>
    <script>
        const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
        const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))
        $('.mainli').on('click', function() {
            $('.mainli').removeClass('active');
            $('.subli').removeClass('active');
            $('.subul').hide('slow');
            $(this).addClass('active');
            $(this).children('.subul').hide('slow');
            $(this).children('.subul').show('slow');
        });
    </script>
</body>

</html>
