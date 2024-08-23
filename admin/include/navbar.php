<!-- Navbar -->
<nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
        </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav mr-auto">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fa fa-envelope"></i>
                <span class="badge badge-warning navbar-badge">15</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left">
                <span class="dropdown-item dropdown-header">15 اشعار</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <?php
                    include 'notification.php';
                    ?>
                    <span class="float-left text-muted text-sm"> </span>
                </a>

                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">عرض جميع الإخطارات</a>
            </div>
        </li>
    </ul>
</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../index" class="brand-link">
        <span class="brand-text font-weight-light"> مشتلي </span>
        <img src="uploads/logo.png" alt="AdminLTE Logo" class="brand-image elevation-3" style="box-shadow: none;">

    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="uploads/logo.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"> <?php echo $_SESSION['admin_username']; ?> </a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                   with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="main.php?dir=dashboard&page=dashboard" class="nav-link">
                        <p>
                            الرئيسية
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="main.php?dir=backup&page=backup" class="nav-link">
                        <p class="btn btn-primary">
                            عمل نسخة احتياطية
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="main.php?dir=sitemap&page=sitemap" class="nav-link">
                        <p class="btn btn-primary">
                            توليد السيتماب للموقع
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <p>
                            الأقسام
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="main.php?dir=categories&page=report" class="nav-link">
                                <p> جميع الأقسام </p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <p>
                            المنتجات
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="main.php?dir=products&page=report" class="nav-link">
                                <p> جميع المنتجات </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="main.php?dir=products&page=add" class="nav-link">
                                <p> اضافة منتج </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="main.php?dir=products&page=mstlzamat_products" class="nav-link">
                                <p> المستلزمات الزراعية  </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="main.php?dir=products&page=products_report" class="nav-link">
                                <p> تقارير عن المنتجات </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="main.php?dir=products&page=google_product" class="nav-link">
                                <p> منتجات جوجل </p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <p>
                            الطلبات
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="main.php?dir=orders&page=add" class="nav-link">
                                <p> اضافة طلب </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="main.php?dir=orders&page=report" class="nav-link">
                                <p> جميع الطلبات </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="main.php?dir=orders&page=compeleted_orders" class="nav-link">
                                <p> الطلبات المكتملة </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="main.php?dir=orders&page=archieve" class="nav-link">
                                <p> ارشيف الطلبات </p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <p>
                            الطلبات الخارجية
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="main.php?dir=outside_orders&page=report" class="nav-link">
                                <p> جميع الطلبات </p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <p>
                            عروض الاسعار 
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="main.php?dir=offer_orders&page=report" class="nav-link">
                                <p> جميع عروض الاسعار  </p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <p>
                            تقيمات المتجر 
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="main.php?dir=mshtly_reviews&page=report" class="nav-link">
                                <p> تقيمات المتجر  </p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <p>
                            السمات والمتغيرات
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="main.php?dir=attribute_vartions&page=report" class="nav-link">
                                <p> جميع السمات والمتغيرات </p>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <p>
                            تصنيف خصائص النبات
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="main.php?dir=product_branches&page=report" class="nav-link">
                                <p> جميع الخصائص </p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <p>
                            كوبونات الخصم
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="main.php?dir=coupons&page=report" class="nav-link">
                                <p> جميع الكوبونات </p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <p>
                            الهدايا
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="main.php?dir=gifts&page=report" class="nav-link">
                                <p> جميع الهدايا </p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <p>
                            الاطوال لتحديد سعر الزراعه
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="main.php?dir=product_tail&page=report" class="nav-link">
                                <p> جميع الاختيارات </p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <p>
                            الشحن
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="main.php?dir=area_city&page=report" class="nav-link">
                                <p> المناطق والمدن </p>
                            </a>
                        </li>
                        <!-- <li class="nav-item">
                          <a href="main.php?dir=shipping&page=report" class="nav-link">
                            <p> المناطق </p>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a href="main.php?dir=shipping_weight&page=report" class="nav-link">
                            <p> الاحجام </p>
                          </a>
                        </li> -->
                        <li class="nav-item">
                            <a href="main.php?dir=shipping_company/companies&page=report" class="nav-link">
                                <p> شركات الشحن </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="main.php?dir=shipping_weight_tools&page=report" class="nav-link">
                                <p> الأوزان والاطوال </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <p>
                            طلبات الأرجاع
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="main.php?dir=returns_order&page=report" class="nav-link">
                                <p> جميع الطلبات </p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <p>
                            طلبات الاستيراد
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="main.php?dir=import_services&page=report" class="nav-link">
                                <p> جميع الطلبات </p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <p>
                            الطلبات الكبيرة
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="main.php?dir=big_orders&page=report" class="nav-link">
                                <p> جميع الطلبات </p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <p>
                            تنسيق الحدائق
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="main.php?dir=landscap&page=report" class="nav-link">
                                <p> كل التنسيقات </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="main.php?dir=landscap_orders&page=report" class="nav-link">
                                <p> طلبات التنسيق </p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <p>
                            السلات
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="main.php?dir=baskets_uncomplete&page=report" class="nav-link">
                                <p> السلات المتروكة </p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <p>
                            المدونة
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="main.php?dir=post_categories&page=report" class="nav-link">
                                <p> الأقسام </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="main.php?dir=posts&page=report" class="nav-link">
                                <p> التدوينات </p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <p>
                            الموظفين
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="main.php?dir=employee&page=report" class="nav-link">
                                <p> جميع الموظفين </p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <p>
                            الصفحةالرئيسية
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="main.php?dir=banners&page=report" class="nav-link">
                                <p> مشاهدة البانر </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="main.php?dir=about_home_page&page=report" class="nav-link">
                                <p> قسم من نحن </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="main.php?dir=testmonails&page=report" class="nav-link">
                                <p> اراء العملاء </p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="main.php?dir=users&page=report" class="nav-link">
                        <p>
                             العملاء 
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="logout" class="nav-link" style="color: #e74c3c;">
                        <p>
                            تسجيل خروج
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>