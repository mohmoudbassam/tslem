
$(function(){

  /* Navbar & Footer */
  var toggleUserMenu = false;
  $('.navbar .has-submenu > a').click(function(){
    var li = $(this).closest('li'),
    cu = 'ic-caret-up',
    cd = 'ic-caret-down';
    if(li.hasClass('active')){
      li.removeClass('active');
    }else {
      li.addClass('active');
    }
  });


  var toggleNavbar = false;
  $('.navbar .toggle').click(function(){
    toggleNavbar = !toggleNavbar;
    if (toggleNavbar) {
      $('body').addClass('nav-isCollapsed');
    }else {
      $('body').removeClass('nav-isCollapsed');
    }
  });
  function fixNavbar(){
    var navbar = $('.navbar');
    if ($(window).scrollTop() > 0) {
      navbar.addClass('fixed');
    } else {
      navbar.removeClass('fixed');
    }
  }
  $(window).scroll(function(){
    fixNavbar();
  });
  fixNavbar();

  /* Gallery */
  $("#gallery").unitegallery();
  /* Animations */
  const e=document.documentElement;

      (window.sr=ScrollReveal()).reveal(".feature, .testimonial", {
          duration: 600, distance: "50px", easing: "cubic-bezier(0.5, -0.01, 0, 1.005)", origin: "bottom", interval: 100
      }
      );
      const a=anime.timeline( {
          autoplay: !1
      }
      ),
      t=document.querySelector(".stroke-animation");
      t.setAttribute("stroke-dashoffset", anime.setDashoffset(t)),
      a.add( {
          targets:".stroke-animation", strokeDashoffset: {
              value: 0, duration: 2e3, easing: "easeInOutQuart"
          }
          , strokeWidth: {
              value: [0, 2], duration: 2e3, easing: "easeOutCubic"
          }
          , strokeOpacity: {
              value: [1, 0], duration: 1e3, easing: "easeOutCubic", delay: 1e3
          }
          , fillOpacity: {
              value: [0, 1], duration: 500, easing: "easeOutCubic", delay: 1300
          }
      }
      ).add( {
          targets:".fadeup-animation", offset:1300, translateY: {
              value:[100, 0], duration:1500, easing:"easeOutElastic", delay:function(e, a) {
                  return 150*a
              }
          }
          , opacity: {
              value:[0, 1], duration:200, easing:"linear", delay:function(e, a) {
                  return 150*a
              }
          }
      }
      ).add( {
          targets:".fadeleft-animation", offset:1300, translateX: {
              value:[40, 0], duration:400, easing:"easeOutCubic", delay:function(e, a) {
                  return 100*a
              }
          }
          , opacity: {
              value:[0, 1], duration:200, easing:"linear", delay:function(e, a) {
                  return 100*a
              }
          }
      }
      ),
      e.classList.add("anime-ready"),
      a.play()

});
/* Go to Dom element by scroll */
function goToByScroll(id,speed,scroll_wrapper) {
    var speed = (speed) ? speed : 300;
    var el = $('.navbar');
    if ($(id).offset()) {
        $(((scroll_wrapper) ? scroll_wrapper : 'html,body')).stop().animate({
            scrollTop: $(id).offset().top - ((el.length) ? el.outerHeight(true) + el.position().top + 20 : 0)
        },speed)
    }
}
