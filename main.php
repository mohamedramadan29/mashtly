<?php
ob_start();
$pagetitle = 'Home';
session_start();
include 'init.php';

if (isset($_SESSION['admin_username'])) {
    include 'include/navbar.php';
}if (isset($_SESSION['username'])) {
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

    // START products
    if ($dir == 'products' && $page == 'add') {
        include "products/add.php";
    } elseif ($dir == 'products' && $page == 'edit') {
        include "products/edit.php";
    } elseif ($dir == 'products' && $page == 'delete') {
        include 'products/delete.php';
    } elseif ($dir == 'products' && $page == 'report') {
        include "products/report.php";
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