<?php
ob_start();
$pagetitle = 'Home';
session_start();
include 'init.php';

if (isset($_SESSION['admin_username'])) {
    include 'include/navbar.php';
}
if (isset($_SESSION['username'])) {
    include 'include/emp_navbar.php';
}
if (!isset($_SESSION['admin_username']) || !isset($_SESSION['admin_username'])) {
    header("Location:index");
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <?php
    $page = '';
    if (isset($_GET['page']) && isset($_GET['dir'])) {
        $page = $_GET['page'];
        $dir = $_GET['dir'];
    } else {
        $page = 'manage';
    }
    // start Website Routes 
    // STRAT DASHBAORD
    if ($dir == 'dashboard' && $page == 'dashboard') {
        include 'dashboard.php';
    } elseif ($dir == 'dashboard' && $page == 'emp_dashboard') {
        include 'emp_dashboard.php';
    }
    // END DASHBAORD
    // START Category
    if ($dir == 'categories' && $page == 'add') {
        include "categories/add.php";
    } elseif ($dir == 'categories' && $page == 'edit') {
        include "categories/edit.php";
    } elseif ($dir == 'categories' && $page == 'delete') {
        include 'categories/delete.php';
    } elseif ($dir == 'categories' && $page == 'report') {
        include "categories/report.php";
    }

    // START Coupons
    if ($dir == 'coupons' && $page == 'add') {
        include "coupons/add.php";
    } elseif ($dir == 'coupons' && $page == 'edit') {
        include "coupons/edit.php";
    } elseif ($dir == 'coupons' && $page == 'delete') {
        include 'coupons/delete.php';
    } elseif ($dir == 'coupons' && $page == 'report') {
        include "coupons/report.php";
    }

    // START Gifts 
    if ($dir == 'gifts' && $page == 'add') {
        include "gifts/add.php";
    } elseif ($dir == 'gifts' && $page == 'edit') {
        include "gifts/edit.php";
    } elseif ($dir == 'gifts' && $page == 'delete') {
        include 'gifts/delete.php';
    } elseif ($dir == 'gifts' && $page == 'report') {
        include "gifts/report.php";
    }


    // START Shipping Methods 
    if ($dir == 'shipping' && $page == 'add') {
        include "shipping/add.php";
    } elseif ($dir == 'shipping' && $page == 'edit') {
        include "shipping/edit.php";
    } elseif ($dir == 'shipping' && $page == 'delete') {
        include 'shipping/delete.php';
    } elseif ($dir == 'shipping' && $page == 'report') {
        include "shipping/report.php";
    }

    // START Shipping Methods Weight
    if ($dir == 'shipping_weight' && $page == 'add') {
        include "shipping_weight/add.php";
    } elseif ($dir == 'shipping_weight' && $page == 'edit') {
        include "shipping_weight/edit.php";
    } elseif ($dir == 'shipping_weight' && $page == 'delete') {
        include 'shipping_weight/delete.php';
    } elseif ($dir == 'shipping_weight' && $page == 'report') {
        include "shipping_weight/report.php";
    }

    // START Uncompeleted Baskets
    if ($dir == 'baskets_uncomplete' && $page == 'add') {
        include "baskets_uncomplete/add.php";
    } elseif ($dir == 'baskets_uncomplete' && $page == 'edit') {
        include "baskets_uncomplete/edit.php";
    } elseif ($dir == 'baskets_uncomplete' && $page == 'delete') {
        include 'baskets_uncomplete/delete.php';
    } elseif ($dir == 'baskets_uncomplete' && $page == 'report') {
        include "baskets_uncomplete/report.php";
    }


    // START Return Orders 
    if ($dir == 'returns_order' && $page == 'add') {
        include "returns_order/add.php";
    } elseif ($dir == 'returns_order' && $page == 'edit') {
        include "returns_order/edit.php";
    } elseif ($dir == 'returns_order' && $page == 'delete') {
        include 'returns_order/delete.php';
    } elseif ($dir == 'returns_order' && $page == 'report') {
        include "returns_order/report.php";
    }
    // START Product branches  
    if ($dir == 'product_branches' && $page == 'add') {
        include "product_branches/add.php";
    } elseif ($dir == 'product_branches' && $page == 'edit') {
        include "product_branches/edit.php";
    } elseif ($dir == 'product_branches' && $page == 'delete') {
        include 'product_branches/delete.php';
    } elseif ($dir == 'product_branches' && $page == 'report') {
        include "product_branches/report.php";
    }
    // START USers 
    if ($dir == 'users' && $page == 'report') {
        include "users/report.php";
    } elseif ($dir == 'users' && $page == 'edit') {
        include "users/edit.php";
    }
    // START products
    if ($dir == 'products' && $page == 'add') {
        include "products/add.php";
    } elseif ($dir == 'products' && $page == 'edit') {
        include "products/edit.php";
    } elseif ($dir == 'products' && $page == 'fast_edit') {
        include "products/fast_edit.php";
    } elseif ($dir == 'products' && $page == 'delete') {
        include 'products/delete.php';
    } elseif ($dir == 'products' && $page == 'report') {
        include "products/report.php";
    } elseif ($dir == 'products' && $page == 'get_variation') {
        include "products/get_variation.php";
    }
    /* 
    elseif ($dir == 'products' && $page == 'add_vartions') {
        include "products/add_vartions.php";
    }*/ elseif ($dir == 'products' && $page == 'delete_image') {
        include "products/delete_image.php";

        // product faqs 
    } elseif ($dir == 'products/faqs' && $page == 'add') {
        include "products/faqs/add.php";
    } elseif ($dir == 'products/faqs' && $page == 'edit') {
        include "products/faqs/edit.php";
    } elseif ($dir == 'products/faqs' && $page == 'report') {
        include "products/faqs/report.php";
    } elseif ($dir == 'products/faqs' && $page == 'delete') {
        include "products/faqs/delete.php";
    }
    // START orders
    if ($dir == 'orders' && $page == 'add') {
        include "orders/add.php";
    } elseif ($dir == 'orders' && $page == 'add_order') {
        include "orders/add_order.php";
    } elseif ($dir == 'orders' && $page == 'edit') {
        include "orders/edit.php";
    } elseif ($dir == 'orders' && $page == 'delete') {
        include 'orders/delete.php';
    } elseif ($dir == 'orders' && $page == 'report') {
        include "orders/report.php";
    } elseif ($dir == 'orders' && $page == 'order_details') {
        include "orders/order_details.php";
    } elseif ($dir == 'orders' && $page == 'add_step') {
        include "orders/add_step.php";
    } elseif ($dir == 'orders' && $page == 'edit_step') {
        include "orders/edit_step.php";
    } elseif ($dir == 'orders' && $page == 'edit_step') {
        include "orders/edit_step.php";
    } elseif ($dir == 'orders' && $page == 'prepare_order') {
        include "orders/prepare_order.php";
    } elseif ($dir == 'orders' && $page == 'quality_order') {
        include "orders/quality_order.php";
    } elseif ($dir == 'orders' && $page == 'order_delivery') {
        include "orders/order_delivery.php";
    } elseif ($dir == 'orders' && $page == 'accounting') {
        include "orders/accounting.php";
    } elseif ($dir == 'orders' && $page == 'order_products_rev') {
        include "orders/order_products_rev.php";
    } elseif ($dir == 'orders' && $page == 'order_invoice') {
        include "orders/order_invoice.php";
    } elseif ($dir == 'orders' && $page == 'order_done') {
        include "orders/order_done.php";
    } elseif ($dir == 'orders' && $page == 'archieve') {
        include "orders/archieve.php";
    }
    // START employee
    if ($dir == 'employee' && $page == 'add') {
        include "employee/add.php";
    } elseif ($dir == 'employee' && $page == 'edit') {
        include "employee/edit.php";
    } elseif ($dir == 'employee' && $page == 'delete') {
        include 'employee/delete.php';
    } elseif ($dir == 'employee' && $page == 'report') {
        include "employee/report.php";
    } elseif ($dir == 'employee' && $page == 'edit_profile') {
        include "employee/edit_profile.php";
    }
    // START Woocommerce
    if ($dir == 'woocommerce' && $page == 'add') {
        include "woocommerce/add.php";
    } elseif ($dir == 'woocommerce' && $page == 'product') {
        include "woocommerce/product.php";
    } elseif ($dir == 'woocommerce' && $page == 'report') {
        include "woocommerce/report.php";
    }

    // START USER PROFILE
    if ($dir == 'profile' && $page == 'report') {
        include "profile/report.php";
    } elseif ($dir == 'profile' && $page == 'edit') {
        include "profile/edit.php";
    }
    // START Category Posts 
    if ($dir == 'post_categories' && $page == 'add') {
        include "post_categories/add.php";
    } elseif ($dir == 'post_categories' && $page == 'edit') {
        include "post_categories/edit.php";
    } elseif ($dir == 'post_categories' && $page == 'delete') {
        include 'post_categories/delete.php';
    } elseif ($dir == 'post_categories' && $page == 'report') {
        include "post_categories/report.php";
    }
    // START  Posts 
    if ($dir == 'posts' && $page == 'add') {
        include "posts/add.php";
    } elseif ($dir == 'posts' && $page == 'edit') {
        include "posts/edit.php";
    } elseif ($dir == 'posts' && $page == 'delete') {
        include 'posts/delete.php';
    } elseif ($dir == 'posts' && $page == 'report') {
        include "posts/report.php";
    }
    // START  BANNERS
    if ($dir == 'banners' && $page == 'add') {
        include "banners/add.php";
    } elseif ($dir == 'banners' && $page == 'edit') {
        include "banners/edit.php";
    } elseif ($dir == 'banners' && $page == 'delete') {
        include 'banners/delete.php';
    } elseif ($dir == 'banners' && $page == 'report') {
        include "banners/report.php";
    }
    // START Section About Home Page
    if ($dir == 'about_home_page' && $page == 'add') {
        include "about_home_page/add.php";
    } elseif ($dir == 'about_home_page' && $page == 'edit') {
        include "about_home_page/edit.php";
    } elseif ($dir == 'about_home_page' && $page == 'delete') {
        include 'about_home_page/delete.php';
    } elseif ($dir == 'about_home_page' && $page == 'report') {
        include "about_home_page/report.php";
    }
    // START Testmonails
    if ($dir == 'testmonails' && $page == 'add') {
        include "testmonails/add.php";
    } elseif ($dir == 'testmonails' && $page == 'edit') {
        include "testmonails/edit.php";
    } elseif ($dir == 'testmonails' && $page == 'delete') {
        include 'testmonails/delete.php';
    } elseif ($dir == 'testmonails' && $page == 'report') {
        include "testmonails/report.php";
    }
    // START  Import Services
    if ($dir == 'import_services' && $page == 'report') {
        include "import_services/report.php";
    } elseif ($dir == 'import_services' && $page == 'edit') {
        include "import_services/edit.php";
    } elseif ($dir == 'import_services' && $page == 'delete') {
        include 'import_services/delete.php';
    }
    // START  Big Orders 
    if ($dir == 'big_orders' && $page == 'add') {
        include "big_orders/add.php";
    } elseif ($dir == 'big_orders' && $page == 'edit') {
        include "big_orders/edit.php";
    } elseif ($dir == 'big_orders' && $page == 'delete') {
        include 'big_orders/delete.php';
    } elseif ($dir == 'big_orders' && $page == 'report') {
        include "big_orders/report.php";
    }
    // START Landscap 
    if ($dir == 'landscap' && $page == 'add') {
        include "landscap/add.php";
    } elseif ($dir == 'landscap' && $page == 'edit') {
        include "landscap/edit.php";
    } elseif ($dir == 'landscap' && $page == 'delete') {
        include 'landscap/delete.php';
    } elseif ($dir == 'landscap' && $page == 'report') {
        include "landscap/report.php";
    }
    // START Landscap  Orders 
    if ($dir == 'landscap_orders' && $page == 'add') {
        include "landscap_orders/add.php";
    } elseif ($dir == 'landscap_orders' && $page == 'edit') {
        include "landscap_orders/edit.php";
    } elseif ($dir == 'landscap_orders' && $page == 'delete') {
        include 'landscap_orders/delete.php';
    } elseif ($dir == 'landscap_orders' && $page == 'report') {
        include "landscap_orders/report.php";
    }
    // START Gift Products 
    if ($dir == 'gift_products' && $page == 'add') {
        include "gift_products/add.php";
    } elseif ($dir == 'gift_products' && $page == 'edit') {
        include "gift_products/edit.php";
    } elseif ($dir == 'gift_products' && $page == 'delete') {
        include 'gift_products/delete.php';
    } elseif ($dir == 'gift_products' && $page == 'report') {
        include "gift_products/report.php";
    } elseif ($dir == 'gift_products' && $page == 'fast_edit') {
        include "gift_products/fast_edit.php";
    } elseif ($dir == 'gift_products' && $page == 'delete_image') {
        include "gift_products/delete_image.php";
    }
    // BACKUP FILES
    // START BAckup
    if ($dir == 'backup' && $page == 'backup') {
        include "backup/backup.php";
    }
    // START SiteMap
    if ($dir == 'sitemap' && $page == 'sitemap') {
        include "sitemap/sitemap.php";
    }

    ?>

</div>

</div>
</div>
</div>
</div>
</div>
</div>
</div>



<?php
include $tem . "footer.php";
?>