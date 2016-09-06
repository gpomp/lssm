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

  $('form').submit(global.checkForm);
}

global.initScrollLinks = function() {
  $('a.scroll').click(global.scrollClick);
}

global.scrollClick = function(event) {
  event.preventDefault();
  var name = $(this).attr('href').substring(1);
  var target = $('a[name=' + name + ']'); 

  console.log('scroll click', parseInt(target.offset().top - 65) + "px");

  $('body,html').stop().animate({ scrollTop: parseInt(target.offset().top - 65) + "px" }, '500', 'swing');
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

global.checkForm = function(event) {
  var isSubmit = true;
  var errors = $();
  $(this).find(".mandatory").each(function(index) {
    console.log($(this).val());
    if(!$(this).val() || $(this).val().length == 0) {
      isSubmit = false;
      errors = $(errors).add($(this));
    }

    if($(this).hasClass("email") && !global.validateEmail($(this).val())) {
      isSubmit = false;
      errors = $(errors).add($(this));
    }
  });

  if(!isSubmit) {
    event.preventDefault();
    $(errors).each(function(index) {
      $(this).addClass("error");
    });


    $('form .error').focus(function() {
      console.log('error');
      $(this).removeClass("error");
    });
  } else {
    $("#submit-form").prop('disabled', true);
  }
}

global.validateEmail = function(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

global.checkScroll = function(event) {
  if($(window).scrollTop() > 400) {
    if(!$("header.banner").hasClass('small')) {
      var height = $("header.banner").height();
      $("header.banner").addClass('small');
      $("body").addClass('header-small').css("padding-top", height + "px");

    }    
  } else {
    if($("header.banner").hasClass('small')) {
      $("header.banner").removeClass('small');
      $("body").removeClass('header-small').css("padding-top", "0px");
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
    maxHeight = Math.max($(this).height() + 50, maxHeight);
  });
  $(".formule-explain .grid-block").height(maxHeight);
}

formule.initForm = function() {
  $("#formule-form").validate({
    submitHandler: function(form) {
      // do other things for a valid form
      
      $("#submit-form").prop('disabled', true);
      form.submit();
    }
  });
}


$(document).ready(function() {
  if($("body").hasClass('page-formule')) {
    formule.init();
  } else if($("body").hasClass('home')) {
    home.init();
  } else if($("body").hasClass('box')) {
    $("#box-form").validate({
      submitHandler: function(form) {
        // do other things for a valid form
        form.submit();
      }
    });
  }

  global.initSwiper();

  global.init();

});
