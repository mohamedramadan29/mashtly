<?php
if (isset($_GET['coupon_id']) && is_numeric($_GET['coupon_id'])) {
    $coupon_id = $_GET['coupon_id'];
    $stmt = $connect->prepare('SELECT * FROM coupons WHERE id= ?');
    $stmt->execute([$coupon_id]);
    $cat_data = $stmt->fetch();
    $count = $stmt->rowCount();
    if($count > 0){

        $stmt = $connect->prepare('DELETE FROM coupons WHERE id=?');
        $stmt->execute([$coupon_id]);
        if ($stmt) {
            $_SESSION['success_message'] = "تم الحذف بنجاح";
            header('Location: main?dir=coupons&page=report');
            exit(); // Terminate the script after redirecting
        }
    }else{
        header('Location: main?dir=coupons&page=report');
            exit(); // Terminate the script after redirecting
    }
}
