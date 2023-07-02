<?php
//include 'location_currancy.php';
include 'admin/connect.php';
$tem = "include/";
$css = "themes/css/";
$js = "themes/js/";
$uploads = "uploads/";
include $tem . "header.php";
include $tem . "navbar.php";
include 'global_functions.php';
// user Cookies



// تحديد تاريخ انتهاء الصلاحية (هنا: 30 يومًا)
$expiry_date = time() + (86400 * 30);

// التحقق من وجود الكوكيز
if (isset($_COOKIE['cart_items'])) {
    // إذا كانت الكوكيز محفوظة، استرجاع قيمتها
    $cart_items_value = $_COOKIE['cart_items'];
} else {
    $cart_items_value = ""; // تعيين قيمة الكوكيز إلى سلسلة فارغة
    // إذا لم تكن الكوكيز محفوظة، تسجيلها
    setcookie("cart_items", $cart_items_value, $expiry_date, "/");
}

// استخدام قيمة الكوكيز
//$cookie_id = $cart_items_value;
$cookie_id = 1;
