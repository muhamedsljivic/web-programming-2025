
$("main#spapp > section").height($(document).height() - 60);

var app = $.spapp({pageNotFound : 'not_found',
   defaultView: "#home",
  templateDir: "./views/"
}); // initialize

// define routes
app.route({
  view: 'sign_up',
});

app.route({
    view: 'log_in',
  });

  app.route({
    view: 'products',
  });

  app.route({
    view: 'single-product',
  });

  app.route({
    view: 'about_us',
  });

  app.route({
    view: 'contact',
  });
  app.route({
    view: 'cart',
  });
  app.route({
    view: 'wishlist',
  });
  
  
  app.route({
    view: 'users',
    onReady: function() {
      $(document).ready(function() {
          $('#myTable').DataTable();
      });

    }
  });
  app.route({
    view: 'categories-admin',
    onReady: function() {
      $(document).ready(function() {
          $('#myTable2').DataTable();
      });

    }
  });
  app.route({
    view: 'contact-us-admin',
    onReady: function() {
      $(document).ready(function() {
          $('#myTable3').DataTable();
      });

    }
  });
  app.route({
    view: 'products-admin',
    onReady: function() {
      $(document).ready(function() {
          $('#myTable4').DataTable();
      });

    }
  });
  app.route({
    view: 'orders-admin',
    onReady: function() {
      $(document).ready(function() {
          $('#myTable5').DataTable();
      });

    }
  });


app.route({
  view: 'home',
  onReady: function() {
    $("#home").append($.now() + ': Written when ready<br/>');

    // Initialize Owl Carousel on home
    (function ($) {
      "use strict";
      
      $('.owl-men-item').owlCarousel({
        items:5,
        loop:true,
        dots: true,
        nav: true,
        margin:30,
        responsive:{
          0:{ items:1 },
          600:{ items:2 },
          1000:{ items:3 }
        }
      });

      $('.owl-women-item').owlCarousel({
        items:5,
        loop:true,
        dots: true,
        nav: true,
        margin:30,
        responsive:{
          0:{ items:1 },
          600:{ items:2 },
          1000:{ items:3 }
        }
      });

      $('.owl-kid-item').owlCarousel({
        items:5,
        loop:true,
        dots: true,
        nav: true,
        margin:30,
        responsive:{
          0:{ items:1 },
          600:{ items:2 },
          1000:{ items:3 }
        }
      });

      // Scroll event handler
      $(window).scroll(function() {
        var scroll = $(window).scrollTop();
        var box = $('#top').height();
        var header = $('header').height();

        if (scroll >= box - header) {
          $("header").addClass("background-header");
        } else {
          $("header").removeClass("background-header");
        }
      });

      // Window Resize Mobile Menu Fix
      mobileNav();

      // Scroll animation init
      window.sr = new scrollReveal();

      // Menu Dropdown Toggle
      if($('.menu-trigger').length){
        $(".menu-trigger").on('click', function() {  
          $(this).toggleClass('active');
          $('.header-area .nav').slideToggle(200);
        });
      }

      // Menu elevator animation
    //   $('.scroll-to-section a[href*=\\#]:not([href=\\#])').on('click', function() {
    //     if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
    //       var target = $(this.hash);
    //       target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
    //       if (target.length) {
    //         var width = $(window).width();
    //         if(width < 991) {
    //           $('.menu-trigger').removeClass('active');
    //           $('.header-area .nav').slideUp(200);  
    //         }               
    //         $('html,body').animate({
    //           scrollTop: (target.offset().top) - 80
    //         }, 700);
    //         return false;
    //       }
    //     }
    //   });

      // Scroll to section functionality
      $(document).ready(function () {
        $('.scroll-to-section a').on('click', function () {
            $('.scroll-to-section a').removeClass('active');
            $(this).addClass('active');
        });
    });
    

      // Page loading animation
      $(window).on('load', function() {
        if($('.cover').length){
          $('.cover').parallax({
            imageSrc: $('.cover').data('image'),
            zIndex: '1'
          });
        }

        $("#preloader").animate({
          'opacity': '0'
        }, 600, function(){
          setTimeout(function(){
            $("#preloader").css("visibility", "hidden").fadeOut();
          }, 300);
        });
      });

      // Window Resize Mobile Menu Fix
      $(window).on('resize', function() {
        mobileNav();
      });

      // Window Resize Mobile Menu Fix
      function mobileNav() {
        var width = $(window).width();
        $('.submenu').on('click', function() {
          if(width < 767) {
            $('.submenu ul').removeClass('active');
            $(this).find('ul').toggleClass('active');
          }
        });
      }

    })(window.jQuery);

  }
});




// run app
app.run();

