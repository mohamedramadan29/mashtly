<?php
if (isset($_POST['edit_cat'])) {
    $coupon_id = $_POST['coupon_id'];
    $name = $_POST['name'];
    $coupon_value = $_POST['coupon_value'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $available_number = $_POST['available_number'];
    $formerror = [];
    if (empty($name)) {
        $formerror[] = 'من فضلك ادخل اسم القسم';
    }
    $stmt = $connect->prepare("SELECT * FROM coupons WHERE name = ? AND id != ?");
    $stmt->execute(array($name,$coupon_id));
    $count = $stmt->rowCount();
    if ($count > 0) {
        $formerror[] = ' الكوبون موجود من قبل من فضلك غير الاسم  ';
    }
    if (empty($formerror)) {
        $stmt = $connect->prepare("UPDATE coupons SET name=?, coupon_value=?,start_date=?,
        end_date=?,available_number=? WHERE id = ? ");
        $stmt->execute(array($name, $coupon_value,$start_date,$end_date,$available_number,$coupon_id));
        if ($stmt) {
            $_SESSION['success_message'] = "تم التعديل بنجاح ";
            header('Location:main?dir=coupons&page=report');
            exit();
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=coupons&page=report');
        exit();
    }
}
