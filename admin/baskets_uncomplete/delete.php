<?php
if (isset($_GET['cart_id']) && is_numeric($_GET['cart_id'])) {
    $cart_id = $_GET['cart_id'];
    $stmt = $connect->prepare('SELECT * FROM cart WHERE id= ?');
    $stmt->execute([$cart_id]);
    $cat_data = $stmt->fetch();
    $stmt = $connect->prepare('DELETE FROM cart WHERE id=?');
    $stmt->execute([$cart_id]);
    if ($stmt) {
        $_SESSION['success_message'] = "تم الحذف بنجاح";
        header('Location: main?dir=baskets_uncomplete&page=report');
        exit(); // Terminate the script after redirecting
    }
}
