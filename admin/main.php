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

    // START USers 
    if ($dir == 'users' && $page == 'report') {
        include "users/report.php";
    }
    // START products
    if ($dir == 'products' && $page == 'add') {
        include "products/add.php";
    } elseif ($dir == 'products' && $page == 'edit') {
        include "products/edit.php";
    } elseif ($dir == 'products' && $page == 'delete') {
        include 'products/delete.php';
    } elseif ($dir == 'products' && $page == 'report') {
        include "products/report.php";
    } elseif ($dir == 'products' && $page == 'get_variation') {
        include "products/get_variation.php";
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