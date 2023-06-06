
(function ($) {
  "use strict";
  if (window.location.href.indexOf("index") > -1) {
    $("#index").addClass("active");
  }

  if (window.location.href.indexOf("travels") > -1) {
    $("#travels").addClass("active");
  }
  if (window.location.href.indexOf("products") > -1) {
    $("#products").addClass("active");
  }
  if (window.location.href.indexOf("contact_us") > -1) {
    $("#contact_us").addClass("active");
  }
  if (window.location.href.indexOf("login") > -1) {
    $("#login").addClass("active");
  }
  if (window.location.href.indexOf("register") > -1) {
    $("#register").addClass("active");
  }
  if (window.location.href.indexOf("profile") > -1) {
    $("#profile").addClass("active");
  }

  $(".select2").select2();
 

})(jQuery);