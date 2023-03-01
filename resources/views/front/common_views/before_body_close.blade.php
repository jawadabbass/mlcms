<!-- jQuery Frameworks
    ============================================= -->
<script src="{{ asset('front/js/jquery-1.12.4.min.js') }}"></script>
<script src="{{ asset('front/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('front/js/equal-height.min.js') }}"></script>
<script src="{{ asset('front/js/jquery.appear.js') }}"></script>
<script src="{{ asset('front/js/jquery.easing.min.js') }}"></script>
<script src="{{ asset('front/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('front/js/modernizr.custom.13711.js') }}"></script>
<script src="{{ asset('front/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('front/js/wow.min.js') }}"></script>
<script src="{{ asset('front/js/progress-bar.min.js') }}"></script>
<script src="{{ asset('front/js/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('front/js/imagesloaded.pkgd.min.js') }}"></script>
<script src="{{ asset('front/js/count-to.js') }}"></script>
<script src="{{ asset('front/js/bootsnav.js') }}"></script>
<script src="{{ asset('front/js/main.js') }}"></script>
<script src="{{ asset('lib/jquery-validation/dist/jquery.validate.min.js') }}"></script>
<script src="{{ asset('lib/jquery-validation/dist/additional-methods.min.js') }}"></script>
<script src="{{ asset('lib/inputmask/dist/jquery.inputmask.js') }}"></script>
<script src="{{ asset('lib/sweetalert/sweetalert2.all.min.js') }}"></script>
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
