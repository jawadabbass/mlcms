<!-- jQuery Frameworks
    ============================================= -->
<script src="{{ asset_storage('front/js/jquery-1.12.4.min.js') }}"></script>
<script src="{{ asset_storage('front/js/bootstrap.min.js') }}"></script>
<script src="{{ asset_storage('front/js/equal-height.min.js') }}"></script>
<script src="{{ asset_storage('front/js/jquery.appear.js') }}"></script>
<script src="{{ asset_storage('front/js/jquery.easing.min.js') }}"></script>
<script src="{{ asset_storage('front/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset_storage('front/js/modernizr.custom.13711.js') }}"></script>
<script src="{{ asset_storage('front/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset_storage('front/js/wow.min.js') }}"></script>
<script src="{{ asset_storage('front/js/progress-bar.min.js') }}"></script>
<script src="{{ asset_storage('front/js/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset_storage('front/js/imagesloaded.pkgd.min.js') }}"></script>
<script src="{{ asset_storage('front/js/count-to.js') }}"></script>
<script src="{{ asset_storage('front/js/bootsnav.js') }}"></script>
<script src="{{ asset_storage('front/js/main.js') }}"></script>
<script src="{{ asset_storage('lib/jquery-validation/dist/jquery.validate.min.js') }}"></script>
<script src="{{ asset_storage('lib/jquery-validation/dist/additional-methods.min.js') }}"></script>
<script src="{{ asset_storage('lib/inputmask/dist/jquery.inputmask.js') }}"></script>
<script src="{{ asset_storage('lib/sweetalert/sweetalert2.all.min.js') }}"></script>
<script defer src="https://cdn.jsdelivr.net/npm/img-comparison-slider@8/dist/index.js"></script>
<script>
    function scrollToErrors(idCls = '#formValidationErrors') {
        if ($(idCls).length > 0) {
            setTimeout(
                function() {
                    $('html, body').animate({
                        scrollTop: $(idCls).offset().top
                    }, 1000);
                }, 800);
        }
    }
    $(document).ready(function() {
        scrollToErrors();
    });
</script>
