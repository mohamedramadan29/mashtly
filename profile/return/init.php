<?php
/*
Created by mohamed ramadan
Email:mr319242@gmail.com
Phone:01011642731

*/
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
 
    include '../../admin/connect.php';
    $connect_db  = '../../admin/connect.php';
    $tem = "../../include/";
    $css = "../../themes/css/";
    $js = "../../themes/js/";
    $uploads = "../../uploads/";
    include $tem . "header.php";
    include $tem . "navbar.php";
    include '../../global_functions.php';
 
