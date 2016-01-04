jQuery.extend(jQuery.validator.messages, {
  required: "Ce champs doit être rempli.",
  remote: "Please fix this field.",
  email: "Entrez un email valide.",
  url: "Please enter a valid URL."
});

var global = {};

global.init = function() {
  global.initAccordion();
  global.initScrollLinks();

  $(window).scroll(global.checkScroll);
}

global.initScrollLinks = function() {
  $('a.scroll').click(global.scrollClick);
}

global.scrollClick = function(event) {
  event.preventDefault();
  var name = $(this).attr('href').substring(1);
  var target = $('a[name=' + name + ']');

  $('body').stop().animate({ scrollTop: target.offset().top - 65 }, '500', 'swing');
}

global.initSwiper = function() {
  $(".swiper-content").each(function() {
    var swipeCtn = $(this);
    var mySwiper = new Swiper ($(this).find('.swiper-container').get(0), {
      // Optional parameters
      loop: true,
      
      // If we need pagination
      pagination: swipeCtn.find('.swiper-pagination').get(0),
      
      // Navigation arrows
      nextButton: swipeCtn.find('.swiper-button-next').get(0),
      prevButton: swipeCtn.find('.swiper-button-prev').get(0),
      onImagesReady: function(swiper) {
        var maxHeight = 0;
        $(swiper.container).find('.swiper-slide').each(function() {
          maxHeight = Math.max($(this).height(), maxHeight);
        });

        $(swiper.container).find('.swiper-slide').height(maxHeight);
      }
    });
  });

  
}

global.initAccordion = function() {
  $(".accordion .acc-ctn .acc-cta").click(global.clickAccCTA);
}

global.clickAccCTA = function(event) {
  event.preventDefault();
  $(".accordion .acc-ctn").removeClass('open');
  $(this).parent().addClass('open');
}

global.checkScroll = function(event) {
  if($(window).scrollTop() > 436) {
    if(!$("header.banner").hasClass('small')) {
      $("header.banner").addClass('small');
    }    
  } else {
    if($("header.banner").hasClass('small')) {
      $("header.banner").removeClass('small');
    }
  }
}

var home = {};

home.init = function() {
  $(window).resize(home.resize);
  home.resize();
}

home.resize = function() {
  console.log('resize');
  var ratio = $(window).width() / 1920;
  $(".banner-video iframe").height(1080 * ratio);
}

var formule = {};
 
formule.init = function() { 
  formule.initForm();

  var maxHeight = 0;

  $(".formule-explain .grid-block").each(function() {
    maxHeight = Math.max($(this).height(), maxHeight);
  });
  $(".formule-explain .grid-block").height(maxHeight);
}

formule.initForm = function() {
  $("#formule-form").validate();
}


$(document).ready(function() {
  if($("body").hasClass('page-formule')) {
    formule.init();
  } else if($("body").hasClass('home')) {
    home.init();
  } else if($("body").hasClass('box')) {
    $("#box-form").validate();
  }

  global.initSwiper();

  global.init();

});
