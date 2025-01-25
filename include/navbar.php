<div class="main_navbar">
  <div class="top_header">
    <div class="container">
      <div class="data">
        <div class="speed_contact">
          <p> <a target="_blank" href="https://wa.me/9660530047542"> للاستفسارات او الشكاوى <i
                class="bi bi-whatsapp"></i> </a> </p>
        </div>
        <div class='country'> <img loading="lazy" src="<?php echo $uploads ?>/sudia_logo.png" alt="لوجو السعودية">
          السعودية </div>
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
                <img loading="lazy" src="<?php echo $uploads ?>/logo.png" alt="لوجو - مشتلي">
              </a>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="search">
              <form action="http://localhost/mashtly/search" method="get" class='form-group' id="searchForm">
                <div class="box">
                  <div class="box2">
                    <input type="text" id="searchInput" name='search' value="<?php if (isset($_REQUEST['search']))
                      echo $_REQUEST['search']; ?>" placeholder="اكتب كلمة البحث…" class="form-control">
                  </div>
                  <div class='box3'>
                    <button type='submit'> البحث المتقدم <img src="<?php echo $uploads ?>/search.webp" alt="بحث">
                    </button>
                  </div>
                </div>
              </form>
              <div id="searchResults"></div>
            </div>
            <style>
              #searchResults {
                overflow: scroll;
                max-height: 300px;
                position: absolute;
                z-index: 9999;
                background: #fff;
                border-radius: 18px;
                line-height: 2
              }

              #searchResults a {
                display: block;
                text-decoration: none;
                color: #000;
                padding: 5px;
                padding-right: 10px;
                border-bottom: 1px solid #f0f0f0;
              }
            </style>
          </div>
          <?php
          $stmt = $connect->prepare("SELECT * FROM cart WHERE cookie_id = ?");
          $stmt->execute(array($cookie_id));
          $count_carts = $stmt->rowCount();
          $allitems = $stmt->fetchAll();
          ?>
          <div class='col-lg-4'>
            <div class="info">
              <div class="cart">
                <a data-bs-toggle="offcanvas" href="#cartItems" role="button" aria-controls="cartItems">
                  <?php
                  if ($count_carts > 0) {
                    ?>
                    <span class="cart_count count_carts"> <?php echo $count_carts; ?> </span>
                    <?php
                  }
                  ?>

                  <img loading="lazy" src="<?php echo $uploads ?>/shopping-cart.webp" alt="سلة المشتريات">
                </a>
              </div>

              <div class="heart">
                <a href="http://localhost/mashtly/profile/favorite">
                  <img loading="lazy" src="<?php echo $uploads ?>/heart.webp" alt="المفضلة">
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
                      <img loading="lazy" src="<?php echo $uploads ?>/user.svg" alt="حسابي">
                    </div>
                    <div>
                      <span> مرحبا بك </span>
                      <h4> <?php echo $user_name; ?> <i class="fa fa-chevron-down"> </i></h4>
                    </div>
                    <div class="links">
                      <ul class="list-unstyled">
                        <li> <img loading="lazy" src="<?php echo $uploads ?>/purches.svg" alt="مشترياتي"> <a
                            href="http://localhost/mashtly/profile/purchase">مشترياتي</a> </li>
                        <li> <img loading="lazy" src="<?php echo $uploads ?>/address.svg" alt="العنوان"> <a
                            href="http://localhost/mashtly/profile/address">عناويني</a> </li>
                        <li> <img loading="lazy" src="<?php echo $uploads ?>/return.svg" alt="ارجاع المشتريات"> <a
                            href="http://localhost/mashtly/profile/purchase">الإرجاع</a> </li>
                        <li> <img loading="lazy" src="<?php echo $uploads ?>/profile_payment.svg" alt="وسائل الدفع"> <a
                            href="http://localhost/mashtly/profile/payment">طرق الدفع </a> </li>
                        <li> <img loading="lazy" src="<?php echo $uploads ?>/cart.svg" alt="سلة المشتريات"> <a
                            href="http://localhost/mashtly/cart">سلة الشراء </a> </li>
                        <li> <img loading="lazy" src="<?php echo $uploads ?>/heart_profile.svg" alt="المفضلة"> <a
                            href="http://localhost/mashtly/profile/favorite"> المفضلة </a> </li>
                        <li> <img loading="lazy" src="<?php echo $uploads ?>/change.svg" alt="تغير كلمة المرور"> <a
                            href="http://localhost/mashtly/profile/change_password"> تغيير كلمة المرور </a> </li>
                        <li> <img loading="lazy" src="<?php echo $uploads ?>/edit_data.svg" alt="تعديل الحساب"> <a
                            href="http://localhost/mashtly/profile/edit_data"> تعديل بياناتي </a> </li>
                        <li> <i class="fa fa-log"></i> <a style="color: red; padding-right:15px"
                            href="http://localhost/mashtly/logout"> تسجيل خروج </a> </li>
                      </ul>
                    </div>
                  </div>
                  <?php
                } else {
                  ?>
                  <a href="http://localhost/mashtly/login"> <img loading="lazy" src="<?php echo $uploads ?>/sign-in.png"
                      alt="تسجيل الدخول"> تسجيل الدخول </a>
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
                <img loading="lazy" src="<?php echo $uploads ?>/logo.png" alt="لوجو - مشتلي">
              </a>
            </div>
          </div>
          <div class='col-6'>
            <div class="info">
              <div class="cart">
                <a data-bs-toggle="offcanvas" href="#cartItems" role="button" aria-controls="cartItems">
                  <?php
                  // get all product from user cart
                  if ($count_carts > 0) {
                    ?>
                    <span class="cart_count count_carts"> <?php echo $count_carts; ?> </span>
                    <?php
                  }
                  ?>
                  <img loading="lazy" width="20px" src="<?php echo $uploads ?>/shopping-cart.webp" alt="سلة المشتريات">
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
                      <img loading="lazy" style="width:17px" src="<?php echo $uploads ?>/user.svg" alt="حسابي ">
                    </div>

                    <div class="links">
                      <ul class="list-unstyled">
                        <li> <img loading="lazy" src="<?php echo $uploads ?>/purches.svg" alt="مشترياتي"> <a
                            href="http://localhost/mashtly/profile/purchase">مشترياتي</a> </li>
                        <li> <img loading="lazy" src="<?php echo $uploads ?>/address.svg" alt="العنوان"> <a
                            href="http://localhost/mashtly/profile/address">عناويني</a> </li>
                        <li> <img loading="lazy" src="<?php echo $uploads ?>/return.svg" alt="ارجاع المشتريات"> <a
                            href="http://localhost/mashtly/profile/purchase">الإرجاع</a> </li>
                        <!-- <li> <img src="<?php echo $uploads ?>/profile_payment.svg" alt=""> <a href="http://localhost/mashtly/profile/payment">طرق الدفع </a> </li> -->
                        <li> <img loading="lazy" src="<?php echo $uploads ?>/cart.svg" alt="سلة المشتريات"> <a
                            href="http://localhost/mashtly/cart">سلة الشراء </a> </li>
                        <li> <img loading="lazy" src="<?php echo $uploads ?>/heart_profile.svg" alt="المفضلة"> <a
                            href="http://localhost/mashtly/profile/favorite"> المفضلة </a> </li>
                        <li> <img loading="lazy" src="<?php echo $uploads ?>/change.svg" alt="تغير كلمة المرور"> <a
                            href="http://localhost/mashtly/profile/change_password"> تغيير كلمة المرور </a> </li>
                        <li> <img loading="lazy" src="<?php echo $uploads ?>/edit_data.svg" alt="تعديل البيانات"> <a
                            href="http://localhost/mashtly/profile/edit_data"> تعديل بياناتي </a> </li>
                        <li> <i class="fa fa-log"></i> <a style="color: red; padding-right:15px"
                            href="http://localhost/mashtly/logout"> تسجيل خروج </a> </li>
                      </ul>
                    </div>
                  </div>
                  <?php
                } else {
                  ?>
                  <div class="user_account">
                    <div class="image">
                      <a id="login_link" href="http://localhost/mashtly/login">
                        <img loading="lazy" style="width:17px" src="<?php echo $uploads ?>/user.svg" alt="حسابي">
                      </a>
                      <style>
                        #login_link {
                          text-decoration: none;
                          background-color: transparent;
                          padding: 0;
                        }
                      </style>
                    </div>
                  </div>
                  <?php
                }
                ?>
              </div>

            </div>
          </div>
          <div class='col-2'>
            <a class="btn toggle_button" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button"
              aria-controls="offcanvasExample">
              <i class="bi bi-justify"></i>
            </a>
            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample"
              aria-labelledby="offcanvasExampleLabel">
              <div class="offcanvas-header">
                <a href="index">
                  <img loading="lazy" class="logo" src="<?php echo $uploads ?>/logo.png" alt="لوجو - مشتلي">
                </a>

                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
              </div>
              <div class="offcanvas-body">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="http://localhost/mashtly"> <i
                        class="bi bi-home"></i>
                      الرئيسية </a>
                  </li>
                  <li>
                    <div class="dropdown mobile_dropdown">
                      <button class="dropdown-toggle"> <a href='http://localhost/mashtly/categories'> التصنيفات </a>
                      </button>
                      <ul class="dropdown-menu">
                        <?php
                        $stmt = $connect->prepare("SELECT * FROM categories");
                        $stmt->execute();
                        $allcategories = $stmt->fetchAll();
                        foreach ($allcategories as $category) {
                          ?>
                          <li><a class="dropdown-item"
                              href="http://localhost/mashtly/product-category/<?php echo $category['slug']; ?>">
                              <?php echo $category['name']; ?> </a></li>
                          <?php
                        }
                        ?>
                      </ul>
                    </div>
                  </li>

                  <li class="nav-item nav_badge">

                    <a class="nav-link" href="http://localhost/mashtly/shop"> تصفح حسب احتياجاتك </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="http://localhost/mashtly/big-orders"> الطلبات الكبيرة </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="http://localhost/mashtly/landscap"> تنسيق الحدائق </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="http://localhost/mashtly/blog-category"> المدونة </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="http://localhost/mashtly/contact"> تواصل معنا </a>
                  </li>
                </ul>
              </div>
            </div>

            <script>
              // إضافة حدث عند النقر لعرض وإخفاء القائمة
              const dropdownToggle = document.querySelector('.dropdown-toggle');
              const dropdownMenu = document.querySelector('.dropdown-menu');

              dropdownToggle.addEventListener('click', function () {
                dropdownMenu.classList.toggle('show');
              });

              // إخفاء القائمة عند النقر خارجها
              window.addEventListener('click', function (e) {
                if (!dropdownToggle.contains(e.target) && !dropdownMenu.contains(e.target)) {
                  dropdownMenu.classList.remove('show');
                }
              });
            </script>
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
              <form action="http://localhost/mashtly/search" method="get" class='form-group' id="searchForm2">
                <div class="box">
                  <div class="box2">
                    <input type="text" name='search' value="<?php if (isset($_REQUEST['search']))
                      echo $_REQUEST['search']; ?>" placeholder="اكتب كلمة البحث…" class="form-control"
                      id="searchInput2">

                  </div>
                  <div class='box3'>
                    <button type='submit'> البحث المتقدم <img src="<?php echo $uploads ?>/search.webp" alt="البحث">
                    </button>
                  </div>
                </div>
              </form>
              <div id="searchResults2"></div>
              <style>
                #searchResults2 {
                  overflow: scroll;
                  max-height: 300px;
                  position: absolute;
                  z-index: 9999;
                  background: #fff;
                  border-radius: 18px;
                  line-height: 2
                }

                #searchResults2 a {
                  display: block;
                  text-decoration: none;
                  color: #000;
                  padding: 5px;
                  padding-right: 10px;
                  border-bottom: 1px solid #f0f0f0;
                }
              </style>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
  <?php
  include 'cart-items.php';
  ?>
  <div id="lg_navbar_load"></div>
  <script>
    // دالة للتحقق من حجم الشاشة وتحميل القسم إذا كان العرض أكبر من 991 بكسل
    function loadBlogSection() {
      if (window.innerWidth > 991) {
        // استدعاء قسم المقالات فقط إذا كان العرض أكبر من 991 بكسل
        document.getElementById('lg_navbar_load').innerHTML = `
          <nav class="navbar navbar-expand-lg">
    <div class="container">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="http://localhost/mashtly"> <img src="<?php echo $uploads ?>/home.svg" alt="الرئيسية"> الرئيسية </a>
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
            <a class="nav-link" href="http://localhost/mashtly/big-orders"> الطلبات الكبيرة </a>
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
          <!-- <li class="nav-item">
            <a class="nav-link" href="http://localhost/mashtly/blog"> المدونة </a>
          </li> -->
          <li class="nav-item">
            <a class="nav-link" href="http://localhost/mashtly/blog-category"> المدونة </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="http://localhost/mashtly/contact"> تواصل معنا </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
        `;
      }
    }

    // استدعاء الدالة فور تحميل الصفحة
    loadBlogSection();

    // استدعاء الدالة عند تغيير حجم الشاشة
    window.addEventListener('resize', loadBlogSection);
  </script>

</div>


<script>
  document.addEventListener("DOMContentLoaded", function () {
    var form = document.getElementById('searchForm');
    var form2 = document.getElementById('searchForm2');
    var searchInput = document.getElementById('searchInput');
    var searchInput2 = document.getElementById('searchInput2');
    var searchResults = document.getElementById('searchResults');
    var searchResults2 = document.getElementById('searchResults2');
    // استخدام الحدث "input" بدلاً من "submit"
    searchInput.addEventListener('input', function () {
      var searchValue = searchInput.value.trim();
      if (!searchValue) {
        searchResults.innerHTML = '';
        return;
      }
      // إرسال طلب AJAX للبحث
      var xhr = new XMLHttpRequest();
      xhr.open('GET', 'http://localhost/mashtly/search2?search=' + encodeURIComponent(searchValue), true);
      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
          if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            // عرض النتائج في العنصر المخصص
            displayResults(response);
          } else {
            searchResults.innerHTML = 'حدث خطأ أثناء جلب البيانات';
          }
        }
      };
      xhr.send();
    });
    // In Mobile 
    searchInput2.addEventListener('input', function () {
      var searchValue2 = searchInput2.value.trim();
      if (!searchValue2) {
        searchResults2.innerHTML = '';
        return;
      }
      // إرسال طلب AJAX للبحث
      var xhr = new XMLHttpRequest();
      xhr.open('GET', 'http://localhost/mashtly/search2?search=' + encodeURIComponent(searchValue2), true);
      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
          if (xhr.status === 200) {
            var response2 = JSON.parse(xhr.responseText);
            // عرض النتائج في العنصر المخصص
            displayResults2(response2);
          } else {
            // searchResults2.innerHTML = 'حدث خطأ أثناء جلب البيانات';
          }
        }
      };
      xhr.send();
    });

    function displayResults2(results) {
      // مسح النتائج السابقة
      searchResults2.innerHTML = '';
      if (results.length === 0) {
        searchResults2.innerHTML = 'لا توجد نتائج للبحث';
        return;
      }
      // عرض النتائج في العنصر المخصص
      // عرض النتائج في العنصر المخصص
      results.forEach(function (result) {
        var resultLink2 = document.createElement('a'); // إنشاء عنصر الرابط
        resultLink2.textContent = result.name; // تحديد نص الرابط
        resultLink2.href = 'http://localhost/mashtly/product/' + result.slug; // تحديد عنوان الرابط مع الإشارة إلى صفحة تفاصيل المنتج
        searchResults2.appendChild(resultLink2); // إضافة الرابط إلى عنصر النتيجة
      });
    }
    /////////
    function displayResults(results) {
      // مسح النتائج السابقة
      searchResults.innerHTML = '';
      if (results.length === 0) {
        searchResults.innerHTML = 'لا توجد نتائج للبحث';
        return;
      }
      // عرض النتائج في العنصر المخصص
      // عرض النتائج في العنصر المخصص
      results.forEach(function (result) {
        var resultLink = document.createElement('a'); // إنشاء عنصر الرابط
        resultLink.textContent = result.name; // تحديد نص الرابط
        resultLink.href = 'http://localhost/mashtly/product/' + result.slug; // تحديد عنوان الرابط مع الإشارة إلى صفحة تفاصيل المنتج
        searchResults.appendChild(resultLink); // إضافة الرابط إلى عنصر النتيجة
      });
    }
  });
</script>