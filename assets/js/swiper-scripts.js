( function( $ ) {
	'use strict';
  if($(".singleListingSlider").length > 0){
    new Swiper(".singleListingSlider", {
        spaceBetween: 0,   
        loop: true,
        loopFillGroupWithBlank: false,
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev",
        },
        pagination: {
          el: ".swiper-pagination",
          clickable: true,
        },
    });
  }
  
  var mySwiperCarousel = new Swiper(".swiperCarousel", {
    slidesPerView: 3,
    spaceBetween: 30,   
    loop: false,
    loopFillGroupWithBlank: false,    
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
      dynamicBullets: true,
    },
    breakpoints: {
      240: {
        slidesPerView: 1,
      },
      768: {
        slidesPerView: 2,
      },
      992: {
        slidesPerView: 3,
      },
      1024: {
        slidesPerView: 3,
      },
    },
  });
 
  $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (event) {
    var paneTarget = $(event.target).attr('href');
    var $thePane = $('.tab-pane' + paneTarget);
    var paneIndex = $thePane.index();
    if ($thePane.find('.swiperCarousel').length > 0 && 0 === $thePane.find('.swiper-slide-active').length) {
      mySwiperCarousel[paneIndex].update();
    }
  });


  
}( jQuery ) );
