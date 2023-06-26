<?php
ob_start();
session_start();
$page_title = '';
include 'init.php';
$currentURL = $_SERVER['REQUEST_URI'];
if (strpos($currentURL, "mashtly/index") !== false) {
    $page_title = 'الرئيسية';
    include 'index.php';
} 
elseif (strpos($currentURL, "mashtly/cart") !== false) {
    include 'cart.php';
}

elseif (strpos($currentURL, "mashtly/categories") !== false) {
    include 'categories.php';
}

elseif (strpos($currentURL, "mashtly/contact") !== false) {
    include 'contact.php';
}

elseif (strpos($currentURL, "mashtly/delivery_policy") !== false) {
    include 'delivery_policy.php';
}

elseif (strpos($currentURL, "mashtly/faq") !== false) {
    include 'faq.php';
}

elseif (strpos($currentURL, "mashtly/forget_password") !== false) {
    include 'forget_password.php';
}

elseif (strpos($currentURL, "mashtly/join_us") !== false) {
    include 'join_us.php';
}

elseif (strpos($currentURL, "mashtly/login") !== false) {
    include 'login.php';
}

elseif (strpos($currentURL, "mashtly/logout") !== false) {
    include 'logout.php';
}

elseif (strpos($currentURL, "mashtly/payment_policy") !== false) {
    include 'payment_policy.php';
}
elseif (strpos($currentURL, "mashtly/select_plan") !== false) {
    include 'select_plan.php';
}
elseif (strpos($currentURL, "mashtly/terms") !== false) {
    include 'terms.php';
}
?>
<?php
include $tem . 'footer.php';
ob_end_flush();
?>