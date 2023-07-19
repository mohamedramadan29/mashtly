
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

  $('.search  .options input[type="checkbox"]').change(function () {
    var selectedOption = $(this).siblings('label').text().trim();
    var icon = '<i class="fa fa-check"></i>'; // Replace with the desired icon class
    $('.selected_search').html(selectedOption + ' ' + icon);
  });

  // select bracnhese in barch button

  $(document).ready(function () {
    var optionsVisiblebrach = false;

    $('#brach_orders').click(function (event) {
      event.stopPropagation(); // Prevent the event from bubbling up to the document
      $(".select_plants .all_cat").toggle();
      optionsVisiblebrach = !optionsVisiblebrach;
    });

    $(document).click(function (event) {
      if (!$(event.target).closest('.all_cat').length && optionsVisiblebrach) {
        $(".select_plants .all_cat").hide();
        optionsVisiblebrach = false;
      }
    });
  });
  
  // to increase decrease proucts
 
    // استهلال العناصر من الواجهة
    const decreaseButtons = document.querySelectorAll('.decrease-btn');
    const increaseButtons = document.querySelectorAll('.increase-btn');
    const quantityInputs = document.querySelectorAll('.quantity-input');

    // إضافة مستمعي الأحداث
    decreaseButtons.forEach((button) => {
        button.addEventListener('click', decreaseQuantity);
    });

    increaseButtons.forEach((button) => {
        button.addEventListener('click', increaseQuantity);
    });

    quantityInputs.forEach((input) => {
        input.addEventListener('change', updateQuantity);
    });

    // وظيفة زيادة الكمية
    function increaseQuantity(event) {
        const quantityInput = event.target.parentNode.querySelector('.quantity-input');
        let quantity = parseInt(quantityInput.value);
        quantity = isNaN(quantity) ? 1 : quantity;
        quantityInput.value = quantity + 1;
    }

    // وظيفة نقص الكمية
    function decreaseQuantity(event) {
        const quantityInput = event.target.parentNode.querySelector('.quantity-input');
        let quantity = parseInt(quantityInput.value);
        quantity = isNaN(quantity) ? 1 : quantity;
        quantity = quantity > 1 ? quantity - 1 : 1;
        quantityInput.value = quantity;
    }

    // وظيفة تحديث الكمية عندما يتم إدخال قيمة يدويًا
    function updateQuantity(event) {
        const quantityInput = event.target;
        let quantity = parseInt(quantityInput.value);
        quantity = isNaN(quantity) ? 1 : quantity;
        quantity = quantity < 1 ? 1 : quantity;
        quantityInput.value = quantity;
    }
// end decrease and increase 
})(jQuery);