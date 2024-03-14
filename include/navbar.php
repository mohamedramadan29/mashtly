<div class="main_navbar">
  <div class="top_header">
    <div class="container">
      <style>
        .moving-text {

          animation: moveText 19s linear infinite;
        }

        .moving-text p {
          color: #fff;
          padding: 5px;
          text-align: center;
          font-size: 14px;
          line-height: 2;
        }
      </style>
      <div class="moving-text-container">
        <div class="moving-text">
          <p> <span style="background-color: #dc3545 !important;padding: 2px;border-radius: 4px;margin-left: 10px;"> تنبيه: </span> الموقع حاليا يعمل بنسخة تجريبية جديدة. المرجو التواصل مع الدعم في حال واجهتكم أي مشاكل تقنية </p>
        </div>
      </div>
    </div>
  </div>
  <div class="top_header">
    <div class="container">
      <div class="data">
        <div class="speed_contact">
          <p>للتواصل السريع أو الاستفسارات 0530047542 </p>
        </div>
        <div class='country'> <img src="<?php echo $uploads ?>/sudia_logo.png" alt=""> السعودية </div>
      </div>
    </div>
  </div>
  <div class="middel_header">
    <div class="container">
      <div class="data">
        <div class="row d-flex align-items-center">
          <div class="col-lg-2">
            <div class="logo">
              <a href="http://localhost/mashtly/index">
                <img src="<?php echo $uploads ?>/logo.png" alt="">
              </a>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="search">
              <form action="http://localhost/mashtly/search" method="get" class='form-group'>
                <div class="box">
                  <div class="box2">
                    <input type="text" name='search' value="<?php if (isset($_REQUEST['search'])) echo $_REQUEST['search']; ?>" placeholder="اكتب كلمة البحث…" class="form-control">

                  </div>
                  <div class='box3'>
                    <button type='submit'> البحث المتقدم <img src="<?php echo $uploads ?>/search.png" alt=""> </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class='col-lg-4'>
            <div class="info">
              <div class="cart">
                <a href="http://localhost/mashtly/cart">

                  <span class="cart_count count_carts"> </span>

                  <img src="<?php echo $uploads ?>/shopping-cart.png" alt="">
                </a>
              </div>
              <div class="heart">
                <a href="http://localhost/mashtly/profile/favorite">
                  <img src="<?php echo $uploads ?>/heart.png" alt="">
                </a>
              </div>
              <div class="sign_in">
                <?php
                if (isset($_SESSION['user_id'])) {
                  $stmt = $connect->prepare("SELECT * FROM users WHERE id = ?");
                  $stmt->execute(array($_SESSION['user_id']));
                  $user_data = $stmt->fetch();
                  $user_name = $user_data['user_name'];
                ?>
                  <div class="user_account">
                    <div class="image">
                      <img src="<?php echo $uploads ?>/user.svg" alt="">
                    </div>
                    <div>
                      <span> مرحبا بك </span>
                      <h4> <?php echo $user_name; ?> <i class="fa fa-chevron-down"> </i></h4>
                    </div>
                    <div class="links">
                      <ul class="list-unstyled">
                        <li> <img src="<?php echo $uploads ?>/purches.svg" alt=""> <a href="http://localhost/mashtly/profile/purchase">مشترياتي</a> </li>
                        <li> <img src="<?php echo $uploads ?>/address.svg" alt=""> <a href="http://localhost/mashtly/profile/address">عناويني</a> </li>
                        <li> <img src="<?php echo $uploads ?>/return.svg" alt=""> <a href="http://localhost/mashtly/profile/purchase">الإرجاع</a> </li>
                        <li> <img src="<?php echo $uploads ?>/profile_payment.svg" alt=""> <a href="http://localhost/mashtly/profile/payment">طرق الدفع </a> </li>
                        <li> <img src="<?php echo $uploads ?>/cart.svg" alt=""> <a href="http://localhost/mashtly/cart">سلة الشراء </a> </li>
                        <li> <img src="<?php echo $uploads ?>/heart_profile.svg" alt=""> <a href="http://localhost/mashtly/profile/favorite"> المفضلة </a> </li>
                        <li> <img src="<?php echo $uploads ?>/change.svg" alt=""> <a href="http://localhost/mashtly/profile/change_password"> تغيير كلمة المرور </a> </li>
                        <li> <img src="<?php echo $uploads ?>/edit_data.svg" alt=""> <a href="http://localhost/mashtly/profile/edit_data"> تعديل بياناتي </a> </li>
                        <li> <i class="fa fa-log"></i> <a style="color: red; padding-right:15px" href="http://localhost/mashtly/logout"> تسجيل خروج </a> </li>
                      </ul>
                    </div>
                  </div>
                <?php
                } else {
                ?>
                  <a href="http://localhost/mashtly/login"> <img src="<?php echo $uploads ?>/sign-in.png" alt=""> تسجيل الدخول </a>
                <?php
                }
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="mobile_middel_header middel_header">
    <div class="container">
      <div class="data">
        <div class="row d-flex align-items-center">
          <div class="col-4">
            <div class="logo">
              <a href="index">
                <img src="<?php echo $uploads ?>/logo.png" alt="">
              </a>
            </div>
          </div>
          <div class='col-6'>
            <div class="info">
              <div class="cart">
                <a href="http://localhost/mashtly/cart">
                  <?php
                  // get all product from user cart
                  $stmt = $connect->prepare("SELECT * FROM cart WHERE cookie_id = ?");

                  $stmt->execute(array($cookie_id));
                  $count_carts = $stmt->rowCount();
                  $allitems = $stmt->fetchAll();
                  if ($count_carts > 0) {
                  ?>
                    <span class="cart_count count_carts"> <?php echo $count_carts; ?> </span>
                  <?php
                  }
                  ?>
                  <img width="24px" src="<?php echo $uploads ?>/shopping-cart.png" alt="">

                </a>
              </div>
              <div class="heart">
                <a href="http://localhost/mashtly/profile/favorite">
                  <img width="24px" src="<?php echo $uploads ?>/heart.png" alt="">
                </a>
              </div>

              <!-- <div class="sign_in">
                <a href="#"> <img src="<?php echo $uploads ?>/sign-in.png" alt=""> تسجيل الدخول </a>
              </div> -->

              <div class="sign_in">
                <?php
                if (isset($_SESSION['user_id'])) {
                  $stmt = $connect->prepare("SELECT * FROM users WHERE id = ?");
                  $stmt->execute(array($_SESSION['user_id']));
                  $user_data = $stmt->fetch();
                  $user_name = $user_data['user_name'];
                ?>
                  <div class="user_account">
                    <div class="image">
                      <img style="width:23px" src="<?php echo $uploads ?>/user.svg" alt="">
                    </div>
                    <!-- <div>
                      <span> مرحبا بك </span>
                      <h4> <?php echo $user_name; ?> <i class="fa fa-chevron-down"> </i></h4>
                    </div> -->
                    <div class="links">
                      <ul class="list-unstyled">
                        <li> <img src="<?php echo $uploads ?>/purches.svg" alt=""> <a href="http://localhost/mashtly/profile/purchase">مشترياتي</a> </li>
                        <li> <img src="<?php echo $uploads ?>/address.svg" alt=""> <a href="http://localhost/mashtly/profile/address">عناويني</a> </li>
                        <li> <img src="<?php echo $uploads ?>/return.svg" alt=""> <a href="http://localhost/mashtly/profile/purchase">الإرجاع</a> </li>
                        <!-- <li> <img src="<?php echo $uploads ?>/profile_payment.svg" alt=""> <a href="http://localhost/mashtly/profile/payment">طرق الدفع </a> </li> -->
                        <li> <img src="<?php echo $uploads ?>/cart.svg" alt=""> <a href="http://localhost/mashtly/cart">سلة الشراء </a> </li>
                        <li> <img src="<?php echo $uploads ?>/heart_profile.svg" alt=""> <a href="http://localhost/mashtly/profile/favorite"> المفضلة </a> </li>
                        <li> <img src="<?php echo $uploads ?>/change.svg" alt=""> <a href="http://localhost/mashtly/profile/change_password"> تغيير كلمة المرور </a> </li>
                        <li> <img src="<?php echo $uploads ?>/edit_data.svg" alt=""> <a href="http://localhost/mashtly/profile/edit_data"> تعديل بياناتي </a> </li>
                        <li> <i class="fa fa-log"></i> <a style="color: red; padding-right:15px" href="http://localhost/mashtly/logout"> تسجيل خروج </a> </li>
                      </ul>
                    </div>
                  </div>
                <?php
                } else {
                ?>
                  <div class="user_account">
                    <div class="image">
                      <a style="text-decoration: none; background-color:transparent; padding:0;" href="http://localhost/mashtly/login">
                        <img style="width:23px" src="<?php echo $uploads ?>/user.svg" alt="">
                      </a>
                    </div>
                  </div>
                  <!-- <a href="http://localhost/mashtly/login"> <img src="<?php echo $uploads ?>/sign-in.png" alt=""> تسجيل الدخول </a> -->
                <?php
                }
                ?>
              </div>

            </div>
          </div>
          <div class='col-2'>
            <nav class="navbar" style="padding: 0;">

              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"><i class='fa fa-bars'></i></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="http://localhost/mashtly"> <img src="<?php echo $uploads ?>/home.svg" alt="">
                      الرئيسية </a>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="http://localhost/mashtly/categories" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      التصنيفات
                    </a>

                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <?php
                      $stmt = $connect->prepare("SELECT * FROM categories");
                      $stmt->execute();
                      $allcategories = $stmt->fetchAll();
                      foreach ($allcategories as $category) {
                      ?>
                        <li><a class="dropdown-item" href="http://localhost/mashtly/product-category/<?php echo $category['slug']; ?>"> <?php echo $category['name'] ?> </a></li>
                      <?php
                      }
                      ?>
                    </ul>
                  </li>
                  <li class="nav-item nav_badge">
                    <span class="badge badge-danger"> جديد </span>
                    <a class="nav-link" href="http://localhost/mashtly/shop"> تصفح حسب احتياجاتك </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="http://localhost/mashtly/big_orders"> الطلبات الكبيرة </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="http://localhost/mashtly/landscap"> تنسيق الحدائق </a>
                  </li>
                  <!-- <li class="nav-item">
                      <a class="nav-link" href="http://localhost/mashtly/import_service"> خدمات الاستيراد </a>
                    </li> -->
                  <!-- <li class="nav-item">
                      <a class="nav-link" href="http://localhost/mashtly/gifts"> الهدايا </a>
                    </li> -->
                  <li class="nav-item">
                    <a class="nav-link" href="http://localhost/mashtly/blog"> المدونة </a>
                  </li>
                  <!--
                    <li class="nav-item">
                      <a class="nav-link" href="#"> زراعة الاسطح </a>
                    </li>
              -->
                  <li class="nav-item">
                    <a class="nav-link" href="http://localhost/mashtly/contact"> تواصل معنا </a>
                  </li>
                </ul>
              </div>

            </nav>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="middel_header mobile_middel_header bottom_search">
    <div class="container">
      <div class="data">
        <div class="row d-flex align-items-center">
          <div class="col-12">
            <div class="search">
              <form action="http://localhost/mashtly/search" method="get" class='form-group'>
                <div class="box">
                  <div class="box2">
                    <input type="text" name='search' value="<?php if (isset($_REQUEST['search'])) echo $_REQUEST['search']; ?>" placeholder="اكتب كلمة البحث…" class="form-control">

                  </div>
                  <div class='box3'>
                    <button type='submit'> البحث المتقدم <img src="<?php echo $uploads ?>/search.png" alt=""> </button>
                  </div>
                </div>
              </form>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="http://localhost/mashtly"> <img src="<?php echo $uploads ?>/home.svg" alt=""> الرئيسية </a>
          </li>
          <li class="nav-item category_links">
            <a class="nav-link" aria-current="page" href="http://localhost/mashtly/categories"> التصنيفات <i class="fa fa-chevron-down"></i></a>
            <div class="links">
              <ul class="list-unstyled">
                <div class="row">
                  <?php
                  $stmt = $connect->prepare("SELECT * FROM categories");
                  $stmt->execute();
                  $allcategories = $stmt->fetchAll();
                  foreach ($allcategories as $category) {
                  ?>
                    <div class="col-3">
                      <a style="color: #000;" href="http://localhost/mashtly/product-category/<?php echo $category['slug']; ?>">
                        <li> <?php echo $category['name'] ?> </li>
                      </a>
                    </div>
                  <?php
                  }
                  ?>

                </div>
              </ul>
            </div>
          </li>
          <li class="nav-item nav_badge">
            <span class="badge badge-danger"> جديد </span>
            <a class="nav-link" href="http://localhost/mashtly/shop"> تصفح حسب احتياجاتك </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="http://localhost/mashtly/big_orders"> الطلبات الكبيرة </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="http://localhost/mashtly/landscap"> تنسيق الحدائق </a>
          </li>
          <!-- <li class="nav-item">
            <a class="nav-link" href="http://localhost/mashtly/import_service"> خدمات الاستيراد </a>
          </li> -->
          <!-- <li class="nav-item">
            <a class="nav-link" href="http://localhost/mashtly/gifts"> الهدايا </a>
          </li> -->
          <li class="nav-item">
            <a class="nav-link" href="http://localhost/mashtly/blog"> المدونة </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="http://localhost/mashtly/contact"> تواصل معنا </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</div>

<script>
  function fetchData() {
    // Retrieve the user_key cookie value
    var cookies = document.cookie.split(';');
    var userKeyCookie = cookies.find(function(cookie) {
      return cookie.trim().startsWith('user_key=');
    });

    var cookie_id;
    if (userKeyCookie) {
      cookie_id = userKeyCookie.split('=')[1];
    } else {
      // Handle the case when the user_key cookie is not set
      console.error('user_key cookie not set!');
      return;
    }
    // Make an AJAX request to the PHP script
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          // Update the count_carts variable with the updated data
          var count_carts = xhr.responseText;
          // Update the UI with the updated count_carts value
          //document.getElementById('count_carts').innerText = count_carts;
          // Update all elements with the class 'count_carts'
          var countCartsElements = document.getElementsByClassName('count_carts');
          for (var i = 0; i < countCartsElements.length; i++) {
            countCartsElements[i].innerText = count_carts;
          }
        } else {
          console.error('Error fetching data:', xhr.status);
        }
      }
    };
    xhr.open('GET', 'http://localhost/mashtly/fetch_cart_count.php?cookie_id=' + encodeURIComponent(cookie_id), true);
    xhr.send();
  }

  // Call the fetchData function initially
  fetchData();

  // Call the fetchData function every 10 seconds
  setInterval(fetchData, 10000); // 10 seconds in milliseconds
</script>