$(function () {
    $(window).scroll(function() {
      if ($(window).scrollTop() > 200) {
        // $('#nav').addClass('shadow');
        // $('#nav').addClass('fixed-top-in');
        $('#sticky-button').fadeIn(200);
      } else {
        // $('#nav').removeClass('shadow');
        // $('#nav').removeClass('fixed-top-in');
        $('#sticky-button').fadeOut(200);
      }
    });

    $('#sticky-button').on('click', function() {
      $('html,body').animate({scrollTop:0}, 500);
    });
});
