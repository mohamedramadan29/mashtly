<div class="main_navbar">
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
              <a href="index">
                <img src="<?php echo $uploads ?>/logo.png" alt="">
              </a>
            </div>
          </div>
          <div class="col-lg-7">
            <div class="search">
              <form action="search" method="get" class='form-group'>
                <div class="box">
                  <div class="box2">
                    <input type="text" name='search' value="<?php if (isset($_REQUEST['search'])) echo $_REQUEST['search']; ?>" placeholder="اكتب كلمة البحث…" class="form-control">
                    <img src="<?php echo $uploads ?>/search.png" alt="">
                  </div>
                  <div class='box3'>
                    <button type='submit'> البحث المتقدم </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class='col-lg-3'>
            <div class="info">
              <div class="cart">
                <a href="cart">
                  <?php
                  // get all product from user cart
                  $stmt = $connect->prepare("SELECT * FROM cart WHERE cookie_id = ?");
                  /*
                  $stmt->execute(array($cookie_id));
                  $count_carts = $stmt->rowCount();
                  $allitems = $stmt->fetchAll();
                  */
                  ?>
                  <img src="<?php echo $uploads ?>/shopping-cart.png" alt="">
                </a>
              </div>
              <div class="heart">
                <a href="profile/favorite">
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
                        <li> <img src="<?php echo $uploads ?>/purches.svg" alt=""> <a href="profile/purchase">مشترياتي</a> </li>
                        <li> <img src="<?php echo $uploads ?>/address.svg" alt=""> <a href="profile/address">عناويني</a> </li>
                        <li> <img src="<?php echo $uploads ?>/return.svg" alt=""> <a href="profile/purchase">الإرجاع</a> </li>
                        <li> <img src="<?php echo $uploads ?>/profile_payment.svg" alt=""> <a href="profile/payment">طرق الدفع </a> </li>
                        <li> <img src="<?php echo $uploads ?>/cart.svg" alt=""> <a href="cart">سلة الشراء </a> </li>
                        <li> <img src="<?php echo $uploads ?>/heart_profile.svg" alt=""> <a href="profile/favorite"> المفضلة </a> </li>
                        <li> <img src="<?php echo $uploads ?>/change.svg" alt=""> <a href="profile/change_password"> تغيير كلمة المرور </a> </li>
                        <li> <img src="<?php echo $uploads ?>/edit_data.svg" alt=""> <a href="profile/edit_data"> تعديل بياناتي </a> </li>
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
          <div class='col-4'>
            <div class="info">
              <div class="cart">
                <a href="cart">
                  <img src="<?php echo $uploads ?>/shopping-cart.png" alt="">
                </a>
              </div>
              <div class="heart">
                <a href="profile/favorite">
                  <img src="<?php echo $uploads ?>/heart.png" alt="">
                </a>
              </div>
              <!--
              <div class="sign_in">
                <a href="#"> <img src="<?php echo $uploads ?>/sign-in.png" alt=""> تسجيل الدخول </a>
              </div>
-->
            </div>
          </div>
          <div class='col-4'>
            <nav class="navbar">
              <div class="container">
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
                      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        التصنيفات
                      </a>
                      <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">التصنيف الاول </a></li>
                        <li><a class="dropdown-item" href="#"> التصنيف الثاني </a></li>
                      </ul>
                    </li>
                    <li class="nav-item nav_badge">
                      <span class="badge badge-danger"> جديد </span>
                      <a class="nav-link" href="http://localhost/mashtly/shop"> تصفح حسب احتياجاتك </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="big_orders"> الطلبات الكبيرة </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="landscap"> تنسيق الحدائق </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="import_service"> خدمات الاستيراد </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="gifts"> الهدايا </a>
                    </li>
                    <!--
                    <li class="nav-item">
                      <a class="nav-link" href="#"> زراعة الاسطح </a>
                    </li>
              -->
                  </ul>
                </div>
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
              <form action="#" method="get" class='form-group'>
                <div class="box">
                  <div class="box2">
                    <input type="text" name='search' placeholder="اكتب كلمة البحث…" class="form-control">
                    <img src="<?php echo $uploads ?>/search.png" alt="">
                  </div>
                  <div class='box3'>
                    <button type='submit'> البحث المتقدم </button>
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
            <a class="nav-link" aria-current="page" href=""> <i class="fa fa-chevron-down"></i> التصنيفات </a>
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
                      <li> <a href="category_products?cat=<?php echo $category['slug']; ?>"> <?php echo $category['name'] ?> </a> </li>
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
            <a class="nav-link" href="big_orders"> الطلبات الكبيرة </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="landscap"> تنسيق الحدائق </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="import_service"> خدمات الاستيراد </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="gifts"> الهدايا </a>
          </li>
          <!-- 
          <li class="nav-item">
            <a class="nav-link" href="#"> زراعة الاسطح </a>
          </li>
                -->
        </ul>
      </div>
    </div>
  </nav>
</div>