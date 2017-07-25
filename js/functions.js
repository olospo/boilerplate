// Mobile Menu 

$(".mobile_menu").click(function() {
  $('nav.mobile').fadeToggle();
});

$(window).resize(function() { // Hide Mobile Menu if Browser window goes above 768px
  var width = $(this).width(); // The window width
  if (width > 768) {
    $('nav.mobile').hide();
  }
});