<?php
if (isset($_POST['add_cat'])) {
    $name = $_POST['name'];
    $coupon_value = $_POST['coupon_value'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $available_number = $_POST['available_number'];
    $formerror = [];
    if (empty($name)) {
        $formerror[] = 'من فضلك ادخل اسم القسم';
    }
    $stmt = $connect->prepare("SELECT * FROM coupons WHERE name = ?");
    $stmt->execute(array($name));
    $count = $stmt->rowCount();
    if ($count > 0) {
        $formerror[] = ' الكوبون موجود من قبل من فضلك غير الاسم  ';
    }
    if (empty($formerror)) {
        $stmt = $connect->prepare("INSERT INTO coupons (name, coupon_value,start_date,
        end_date,available_number)
        VALUES (:zname,:zcoupon_value,:zstart_date,:zend_date,:zavailable_number)");
        $stmt->execute(array(
            "zname" => $name,
            "zcoupon_value" => $coupon_value,
            "zstart_date" => $start_date,
            "zend_date" => $end_date,
            "zavailable_number" => $available_number,
        ));
        if ($stmt) {
            $_SESSION['success_message'] = " تمت الأضافة بنجاح  ";
            header('Location:main?dir=coupons&page=report');
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=coupons&page=report');
        exit();
    }
}
