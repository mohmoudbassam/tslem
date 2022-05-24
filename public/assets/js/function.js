(function ($) {
  "use-strict";


  $(window).on("load", function () {
    $(".loader-page").fadeOut(500);
    wow = new WOW({
      animateClass: "animated",
      offset: 50,
    });
    wow.init();
  });

  /*------------------------------------
        menu mobile
    --------------------------------------*/
  $(".header-mobile__toolbar,.mobile-menu-overlay,.main-header .btn-close-header-mobile").on("click", function () {
    $(".menu--mobile").toggleClass("menu-mobile-active");
  });





    /*------------------------------------
		Fixed Head And Scroll page
	--------------------------------------*/
    $(window).scroll(function () {
      $(".section").each(function () {
        if ($(window).scrollTop() > $(this).offset().top - 80) {
          var blockID = $(this).attr("id");
          $(".main-header .main-menu li a").removeClass("active");
          $('.main-header .main-menu li a[data-scroll="' + blockID + '"]').addClass(
            "active"
          );
        }
      });
    });

    $(".main-header a[data-scroll] ").click(
      function (e) {
        e.preventDefault();

        $(".menu--mobile").removeClass("menu-mobile-active");

        $("html, body").animate(
          {
            scrollTop: $("#" + $(this).data("scroll")).offset().top - 70,
          },
          1100
        );
      }
    );



    
  $(window).scroll(function () {
    fixedHeader();
  });
  $(window).on("load", function () {
    fixedHeader();
  });



    /*------------------------------------
        COUNTER
    --------------------------------------*/
  if ($("#counter").length > 0) {
    var a = 0;
    $(window).scroll(function() {
        var oTop = $('#counter').offset().top - window.innerHeight;
        if (a == 0 && $(window).scrollTop() > oTop) {
            $('.counter-value').each(function() {
                var $this = $(this),
                    countTo = $this.attr('data-count');
                $({
                    countNum: $this.text()
                }).animate({
                        countNum: countTo
                    },
    
                    {
                        duration: 2000,
                        easing: 'swing',
                        step: function() {
                            $this.text(Math.floor(this.countNum));
                        },
                        complete: function() {
                            $this.text(this.countNum);
                            //alert('finished');
                        }
    
                    });
            });
            a = 1;
        }
    });
  }
})(jQuery);



function fixedHeader() {
  var $menu = $('.main-header');
  if ($(window).scrollTop() > 70) {
     $menu.addClass('fixed-header');
 } else {
     $menu.removeClass('fixed-header');
 }
}




var swiper = new Swiper(".swiper", {
  slidesPerView: 1,
  speed: 1500,
  spaceBetween: 10,
  navigation: {
    nextEl: ".swiper-next",
    prevEl: ".swiper-prev",
  },
  breakpoints: {
    0: {
      slidesPerView: 1.3,
    },
    576: {
      slidesPerView: 1.8,
    },
    992: {
      slidesPerView: 4,
    }
  },
});
