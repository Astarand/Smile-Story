(function ($) {
  ('use strict');

  var $window = $(window);
  var $body = $('body');

  /* Preloader Effect */
  $window.on('load', function () {
    $('.preloader').fadeOut(600);
  });

  /* Sticky Header */
  if ($('.active-sticky-header').length) {
    $window.on('resize', function () {
      setHeaderHeight();
    });

    function setHeaderHeight() {
      $('header.main-header').css(
        'height',
        $('header .header-sticky').outerHeight(),
      );
    }

    $(window).on('scroll', function () {
      var fromTop = $(window).scrollTop();
      setHeaderHeight();
      var headerHeight = $('header .header-sticky').outerHeight();
      $('header .header-sticky').toggleClass(
        'hide',
        fromTop > headerHeight + 100,
      );
      $('header .header-sticky').toggleClass('active', fromTop > 600);
    });
  }

  /* Slick Menu JS */
  $('#menu').slicknav({
    label: '',
    prependTo: '.responsive-menu',
  });

  if ($("a[href='#top']").length) {
    $("a[href='#top']").click(function () {
      $('html, body').animate({ scrollTop: 0 }, 'slow');
      return false;
    });
  }

  /* Hero Slider Layout JS */
  const hero_slider_layout = new Swiper('.hero-slider-layout .swiper', {
    slidesPerView: 1,
    speed: 1000,
    spaceBetween: 0,
    loop: true,
    autoplay: {
      delay: 4000,
    },
    pagination: {
      el: '.hero-pagination',
      clickable: true,
    },
  });

  /* testimonial Slider JS */
  if ($('.testimonial-slider').length) {
    const testimonial_slider = new Swiper('.testimonial-slider .swiper', {
      slidesPerView: 1,
      speed: 1000,
      spaceBetween: 30,
      loop: true,
      autoplay: {
        delay: 5000,
      },
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      navigation: {
        nextEl: '.testimonial-button-next',
        prevEl: '.testimonial-button-prev',
      },
      breakpoints: {
        768: {
          slidesPerView: 2,
        },
        991: {
          slidesPerView: 3,
        },
      },
    });
  }

  /* Service Single Image Carousel JS */
  if ($('.service-single-slider').length) {
    const service_single_slider = new Swiper('.service-single-slider .swiper', {
      slidesPerView: 1,
      speed: 1000,
      spaceBetween: 10,
      loop: true,
      autoplay: {
        delay: 5000,
      },
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      navigation: {
        nextEl: '.service-single-button-next',
        prevEl: '.service-single-button-prev',
      },
    });
  }

  /* Skill Bar */
  if ($('.skills-progress-bar').length) {
    $('.skills-progress-bar').waypoint(
      function () {
        $('.skillbar').each(function () {
          $(this)
            .find('.count-bar')
            .animate(
              {
                width: $(this).attr('data-percent'),
              },
              2000,
            );
        });
      },
      {
        offset: '50%',
      },
    );
  }

  /* Youtube Background Video JS */
  if ($('#herovideo').length) {
    var myPlayer = $('#herovideo').YTPlayer();
  }

  /* Init Counter */
  if ($('.counter').length) {
    $('.counter').counterUp({ delay: 6, time: 3000 });
  }

  /* Image Reveal Animation */
  if ($('.reveal').length) {
    gsap.registerPlugin(ScrollTrigger);
    let revealContainers = document.querySelectorAll('.reveal');
    revealContainers.forEach((container) => {
      let image = container.querySelector('img');
      let tl = gsap.timeline({
        scrollTrigger: {
          trigger: container,
          toggleActions: 'play none none none',
        },
      });
      tl.set(container, {
        autoAlpha: 1,
      });
      tl.from(container, 1, {
        xPercent: -100,
        ease: Power2.out,
      });
      tl.from(image, 1, {
        xPercent: 100,
        scale: 1,
        delay: -1,
        ease: Power2.out,
      });
    });
  }

  /* Text Effect Animation */
  if ($('.text-anime-style-1').length) {
    let staggerAmount = 0.05,
      translateXValue = 0,
      delayValue = 0.5,
      animatedTextElements = document.querySelectorAll('.text-anime-style-1');

    animatedTextElements.forEach((element) => {
      let animationSplitText = new SplitText(element, { type: 'chars, words' });
      gsap.from(animationSplitText.words, {
        duration: 1,
        delay: delayValue,
        x: 20,
        autoAlpha: 0,
        stagger: staggerAmount,
        scrollTrigger: { trigger: element, start: 'top 85%' },
      });
    });
  }

  if ($('.text-anime-style-2').length) {
    let staggerAmount = 0.03,
      translateXValue = 20,
      delayValue = 0.1,
      easeType = 'power2.out',
      animatedTextElements = document.querySelectorAll('.text-anime-style-2');

    animatedTextElements.forEach((element) => {
      let animationSplitText = new SplitText(element, { type: 'chars, words' });
      gsap.from(animationSplitText.chars, {
        duration: 1,
        delay: delayValue,
        x: translateXValue,
        autoAlpha: 0,
        stagger: staggerAmount,
        ease: easeType,
        scrollTrigger: { trigger: element, start: 'top 85%' },
      });
    });
  }

  if ($('.text-anime-style-3').length) {
    let animatedTextElements = document.querySelectorAll('.text-anime-style-3');

    animatedTextElements.forEach((element) => {
      //Reset if needed
      if (element.animation) {
        element.animation.progress(1).kill();
        element.split.revert();
      }

      element.split = new SplitText(element, {
        type: 'lines,words,chars',
        linesClass: 'split-line',
      });
      gsap.set(element, { perspective: 400 });

      gsap.set(element.split.chars, {
        opacity: 0,
        x: '50',
      });

      element.animation = gsap.to(element.split.chars, {
        scrollTrigger: { trigger: element, start: 'top 90%' },
        x: '0',
        y: '0',
        rotateX: '0',
        opacity: 1,
        duration: 1,
        ease: Back.easeOut,
        stagger: 0.02,
      });
    });
  }

  /* Parallaxie js */
  var $parallaxie = $('.parallaxie');
  if ($parallaxie.length && $window.width() > 991) {
    if ($window.width() > 768) {
      $parallaxie.parallaxie({
        speed: 0.55,
        offset: 0,
      });
    }
  }

  /* Zoom Gallery screenshot */
  $('.gallery-items').magnificPopup({
    delegate: 'a',
    type: 'image',
    closeOnContentClick: false,
    closeBtnInside: false,
    mainClass: 'mfp-with-zoom',
    image: {
      verticalFit: true,
    },
    gallery: {
      enabled: true,
    },
    zoom: {
      enabled: true,
      duration: 300, // don't foget to change the duration also in CSS
      opener: function (element) {
        return element.find('img');
      },
    },
  });

  /* Contact form validation */
  /* Contact form validation */
  $(document).ready(function () {
    var $contactform = $('#contactForm');

    $contactform.validator({ focus: false }).on('submit', function (event) {
      if (!event.isDefaultPrevented()) {
        event.preventDefault();
        submitForm();
      }
    });

    function submitForm() {
      // Serialize form data
      var formData = $contactform.serialize();

      /* Ajax call to submit form */
      $.ajax({
        type: 'POST',
        url: 'contact-submit.php', // Update this to your PHP file path
        data: formData,
        dataType: 'text',
        success: function (response) {
          if (response.trim() === 'success') {
            formSuccess();
          } else {
            submitMSG(false, response);
          }
        },
        error: function (xhr, status, error) {
          // Handle AJAX errors
          console.error('AJAX Error:', status, error);
          submitMSG(false, 'An error occurred. Please try again later.');
        },
      });
    }

    function formSuccess() {
      // Reset the form fields
      $contactform[0].reset();

      // Display success message
      submitMSG(true, 'Message Sent Successfully!');
    }

    function submitMSG(isValid, msg) {
      var msgClasses = isValid ? 'h3 text-success' : 'h3 text-danger';
      $('#msgSubmit').removeClass().addClass(msgClasses).text(msg).fadeIn();

      // Optional: Hide the message after 5 seconds
      setTimeout(function () {
        $('#msgSubmit').fadeOut();
      }, 5000);
    }
  });

  /* Contact form validation end */

  /* Appointment form validation */
  var $appointmentForm = $('#appointmentForm');
  $appointmentForm.validator({ focus: false }).on('submit', function (event) {
    if (!event.isDefaultPrevented()) {
      event.preventDefault();
      submitappointmentForm();
    }
  });

  function submitappointmentForm() {
    /* Ajax call to submit form */
    $.ajax({
      type: 'POST',
      url: 'form-appointment.php',
      data: $appointmentForm.serialize(),
      success: function (text) {
        if (text == 'success') {
          appointmentformSuccess();
        } else {
          appointmentsubmitMSG(false, text);
        }
      },
    });
  }

  function appointmentformSuccess() {
    $appointmentForm[0].reset();
    appointmentsubmitMSG(true, 'Message Sent Successfully!');
  }

  function appointmentsubmitMSG(valid, msg) {
    if (valid) {
      var msgClasses = 'h3 text-success';
    } else {
      var msgClasses = 'h3 text-danger';
    }
    $('#msgSubmit').removeClass().addClass(msgClasses).text(msg);
  }
  /* Appointment form validation end */

  /* Interactive Process Layout Start */
  var element = $('.interactive');
  if (element.hasClass('interactive-process-layout')) {
    var items = element.find('.interactive-inner-process');
    if (items.length) {
      items.on({
        mouseenter: function () {
          var index = $(this).data('index'),
            targetImg = element.find(`.interactive-process-image.img-${index}`);

          if ($(this).hasClass('activate')) return;

          items.removeClass('activate');
          $(this).addClass('activate');

          element.find('.interactive-process-image').removeClass('show');
          targetImg.addClass('show');
        },
        mouseleave: function () {
          //stuff to do on mouse leave
        },
      });
    }
  }
  /* Interactive Process Layout End */

  /* Animated Wow Js */
  new WOW().init();

  /* Popup Video */
  if ($('.popup-video').length) {
    $('.popup-video').magnificPopup({
      type: 'iframe',
      mainClass: 'mfp-fade',
      removalDelay: 160,
      preloader: false,
      fixedContentPos: true,
    });
  }
})(jQuery);