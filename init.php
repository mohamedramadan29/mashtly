<?php
if (isset($_SESSION['main_user_login'])) {
    //include 'location_currancy.php';
    $connect_db = 'admin/connect.php';
    $tem = "include/";
    $css = "themes/css/";
    $js = "themes/js/";
    $uploads = "uploads/";
    include $tem . "header.php";
    include 'admin/connect.php';
    include 'global_functions.php';
    date_default_timezone_set('Asia/Riyadh');
    // user Cookies
    // تحديد تاريخ انتهاء الصلاحية (هنا: 30 يومًا)
    $expiry_date = time() + (86400 * 30);

    // التحقق من وجود الكوكيز
    if (isset($_COOKIE['user_key'])) {
        // إذا كانت الكوكيز محفوظة، استرجاع قيمتها
        $user_key  = $_COOKIE['user_key'];
    } else {
        $user_key = uniqid() . time();
        setcookie("user_key", $user_key, $expiry_date, "/");
    }

    // استخدام قيمة الكوكيز
    $cookie_id = $user_key;
    include $tem . "navbar.php";
} else {
    header("location:new_login");
}
