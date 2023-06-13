
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

  // select planet type
  $('.select_search').click(function () {
    $(this).next(".options").toggle();
    $(this).find('i').toggleClass('fa-chevron-up fa-chevron-down');
  });

  // select main dropdown options
  $(document).ready(function () {
    var optionsVisible = false;

    $('#search_orders').click(function (event) {
      event.stopPropagation(); // Prevent the event from bubbling up to the document
      $(".search .options").toggle();
      optionsVisible = !optionsVisible;
    });

    $(document).click(function (event) {
      if (!$(event.target).closest('.search').length && optionsVisible) {
        $(".search .options").hide();
        optionsVisible = false;
      }
    });

  });
    $('.options input[type="checkbox"]').change(function () {
      var selectedOption = $(this).siblings('label').text().trim();
      var icon = '<i class="fa fa-check"></i>'; // Replace with the desired icon class
      $('.selected_search').html(selectedOption + ' ' + icon);
    });

  })(jQuery);