$(document).ready(function() {

  $('map[name="icelandMap"]').imageMapResize();
  $('map[name="icelandMapMobile"]').imageMapResize();
  $('.btnbox-tabs').tabs();
  $(".tab-selection li").click(function () {
    $(".tab-selection li").removeClass("active");
    $(this).addClass("active");
    if ($(this).hasClass("tab-a") === true) {
        $(this).parents(".tabs-article-container").find(".tab-content").removeClass("active");
        $(this).parents(".tabs-article-container").find(".tab-content-a").addClass("active");
    } else if ($(this).hasClass("tab-b") === true) {
        $(this).parents(".tabs-article-container").find(".tab-content").removeClass("active");
        $(this).parents(".tabs-article-container").find(".tab-content-b").addClass("active");
    } else if ($(this).hasClass("tab-c") === true) {
        $(this).parents(".tabs-article-container").find(".tab-content").removeClass("active");
        $(this).parents(".tabs-article-container").find(".tab-content-c").addClass("active");
    } else if ($(this).hasClass("tab-d") === true) {
      $(this).parents(".tabs-article-container").find(".tab-content").removeClass("active");
      $(this).parents(".tabs-article-container").find(".tab-content-d").addClass("active");
    } else {
      $(this).parents(".tabs-article-container").find(".tab-content").removeClass("active");
      $(this).parents(".tabs-article-container").find(".tab-content-e").addClass("active");
    }
  });


  if($(window).width() < 420) {
    $(document).scroll(function() {
      var y = $(this).scrollTop();
      console.log(y)
      if (y > 1900 && y < 2100) {
        $('.discover-entry').addClass('mobile-active')
      }  
      if (y > 2100 && y < 2450) {
        $('.discover-entry').removeClass('mobile-active')
        $('.discover').addClass('mobile-active')
      }
      if (y > 2450 && y < 2950) {
        $('.discover').removeClass('mobile-active')
        $('.energy').addClass('mobile-active')
      }
      if (y > 2950 && y < 3400) {
        $('.energy').removeClass('mobile-active')
        $('.relationship-entry').addClass('mobile-active')
      }
      if (y > 3400 && y < 3900) {
        $('.relationship-entry').removeClass('mobile-active')
        $('.relationship').addClass('mobile-active')
      }
      if (y > 3900 && y < 4200) {
        $('.relationship').removeClass('mobile-active')
        $('.relationship-level').addClass('mobile-active')
      }
      if (y > 4200 && y < 4500) {
        $('.relationship-level').removeClass('mobile-active')
        $('.cases').addClass('mobile-active')
      } 
    });
  }

  //mobile menu
  $('.navbar-toggler').click(function (){
    $(this).toggleClass('collapsed');
    $(this).siblings('.navbar-collapse').toggleClass('show');
    $(this).attr('aria-expanded','true', 'false')
  })
})
$(document).on('click', '[data-toggle="lightbox"]', function(event) {
  event.preventDefault();
  $(this).ekkoLightbox();
});
