

(function($) {
	/*BACKGROUND IMAGE JS*/
	$(".background_bg").each(function() {
		var attr = $(this).attr('data-img-src');
		if (typeof attr !== typeof undefined && attr !== false) {
			$(this).css('background-image', 'url(' + attr + ')');
		}
	});
	
	/*MENU JS*/
	//Main navigation scroll spy for shadow
	$(window).on('scroll', function() {
		var scroll = $(window).scrollTop();

	    if (scroll >= 113) {
					$('header.fixed-top').addClass('nav-fixed');
					$('header.fixed-top').next('div').css('margin-top','180px');
	    } else {
					$('header.fixed-top').removeClass('nav-fixed');
					$('header.fixed-top').next('div').css('margin-top','0');
	    }
			if($(window).width() < 767) {
				if (scroll >= 113) {
					$('header.fixed-top').addClass('nav-fixed');
					$('header.fixed-top').next('div').css('margin-top','130px');
	    } else {
					$('header.fixed-top').removeClass('nav-fixed');
					$('header.fixed-top').next('div').css('margin-top','0');
	    }
			}
	});
	
	//Show Hide dropdown-menu Main navigation 
	$( document ).on('ready', function () {
		$( '.dropdown-menu a.dropdown-toggler' ).on( 'click', function () {
			//var $el = $( this );
			//var $parent = $( this ).offsetParent( ".dropdown-menu" );
			if ( !$( this ).next().hasClass( 'show' ) ) {
				$( this ).parents( '.dropdown-menu' ).first().find( '.show' ).removeClass( "show" );
			}
			var $subMenu = $( this ).next( ".dropdown-menu" );
			$subMenu.toggleClass( 'show' );
			
			$( this ).parent( "li" ).toggleClass( 'show' );
	
			$( this ).parents( 'li.nav-item.dropdown.show' ).on( 'hidden.bs.dropdown', function () {
				$( '.dropdown-menu .show' ).removeClass( "show" );
			} );
			
			return false;
		});
	});
	
	//Hide Navbar Dropdown After Click On Links
	var navBar = $(".header_wrap");
	var navbarLinks = navBar.find(".navbar-collapse ul li a.page-scroll");

    $.each( navbarLinks, function() {

      var navbarLink = $(this);

        navbarLink.on('click', function () {
          navBar.find(".navbar-collapse").collapse('hide');
		  $("header").removeClass("active");
        });

    });
	
	//Main navigation Active Class Add Remove
	$('.navbar-toggler').on('click', function() {
		$("header").toggleClass("active");
		if($('.search-overlay').hasClass('open'))
		{
			$(".search-overlay").removeClass('open');
			$(".search_trigger").removeClass('open');
		}
	});
	
	$('.sidetoggle').on('click', function () {
		$(this).addClass('open');
		$('body').addClass('sidetoggle_active');
		$('.sidebar_menu').addClass('active');
		$("body").append('<div id="header-overlay" class="header-overlay"></div>');
	});
	
	/*SCROLLUP JS*/
	$(window).on('scroll', function() {
		if ($(this).scrollTop() > 750) {
			$('.scrollup').fadeIn();
		} else {
			$('.scrollup').fadeOut();
		}
	});
	// $(window).on('scroll', function() {
	// 	if ($(this).scrollTop() > 650) {
	// 		$('.fixed-img').fadeIn();
	// 		$('.discount-icon').fadeIn();
	// 	} else {
	// 		$('.fixed-img').fadeOut();
	// 		$('.discount-icon').fadeOut();
	// 	}
	// });
	$(".scrollup").on('click', function (e) {
		e.preventDefault();
		$('html, body').animate({
			scrollTop: 0
		}, 600);
		return false;
	});
	
	/*SLIDER JS*/
	function carousel_slider() {
		$('.carousel_slider').each( function() {
			var $carousel = $(this);
			$carousel.owlCarousel({
				dots : $carousel.data("dots"),
				loop : $carousel.data("loop"),
				items: $carousel.data("items"),
				margin: $carousel.data("margin"),
				mouseDrag: $carousel.data("mouse-drag"),
				touchDrag: $carousel.data("touch-drag"),
				autoHeight: $carousel.data("autoheight"),
				center: $carousel.data("center"),
				nav: $carousel.data("nav"),
				rewind: $carousel.data("rewind"),
				navText: ['<i class="ion-ios-arrow-left"></i>', '<i class="ion-ios-arrow-right"></i>'],
				autoplay : $carousel.data("autoplay"),
				animateIn : $carousel.data("animate-in"),
				animateOut: $carousel.data("animate-out"),
				autoplayTimeout : $carousel.data("autoplay-timeout"),
				smartSpeed: $carousel.data("smart-speed"),
				responsive: $carousel.data("responsive")
			});	
		});
	}
	
	$(document).on("ready", function() {
		carousel_slider();
	});	
})(jQuery);