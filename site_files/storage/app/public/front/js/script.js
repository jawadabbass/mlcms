(function($) { 
"use strict";

$('[data-toggle="offcanvas"]').on('click', function () {
    $('.navbar-collapse').toggleClass('show');
    });



/* ================ Nav ================ */
    $('.fa-caret-down').on("click", function(e) {
        e.preventDefault();
        $(this).next().slideToggle('');
    });




 
/*MAGNIFIC POPUP JS*/

    $('.video-play').magnificPopup({
        type: 'iframe'
    });
    var magnifPopup = function() {
        $('.work-popup').magnificPopup({
            type: 'image',
            removalDelay: 300,
            mainClass: 'mfp-with-zoom',
            gallery: {
                enabled: true
            },
            zoom: {
                enabled: true, // By default it's false, so don't forget to enable it

                duration: 300, // duration of the effect, in milliseconds
                easing: 'ease-in-out', // CSS transition easing function

                // The "opener" function should return the element from which popup will be zoomed in
                // and to which popup will be scaled down
                // By defailt it looks for an image tag:
                opener: function(openerElement) {
                    // openerElement is the element on which popup was initialized, in this case its <a> tag
                    // you don't need to add "opener" option if this code matches your needs, it's defailt one.
                    return openerElement.is('img') ? openerElement : openerElement.find('img');
                }
            }
        });
    };

    /*Testimonials*/
 $(document).ready(function() { 
       $(".testimonials_list").owlCarousel({          
        loop:true,
      margin:0,
      nav:false,
      autoplay:true,
autoplayTimeout:3000,
      responsiveClass:true,
      responsive:{
       0:{
        items:1,
        nav:true
       },
       700:{
        items:1,
        nav:true
       },
       1170:{
        items:1,
        nav:true,
        loop:true
       }
      }
       
       
       }); 
     });
jQuery(function() {
        var path = window.location.href; // because the 'href' property of the DOM element is the absolute path
        $('ul a').each(function() {
         if (this.href === path) {
          $(this).addClass('active');
         }
        });
       });
    

// FAQ Accordion JS
    $('.accordion').find('.accordion-title').on('click', function(){
        $(this).toggleClass('active');
        $(this).next().slideToggle('fast');
        $('.accordion-content').not($(this).next()).slideUp('fast');
        $('.accordion-title').not($(this)).removeClass('active');       
    });

})(jQuery);