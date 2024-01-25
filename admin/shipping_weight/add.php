<?php
if (isset($_POST['add_cat'])) {
    $formerror = [];
    $new_size = $_POST['new_size'];
    $new_price = $_POST['new_price'];
    if (empty($new_price)) {
        $formerror[] = ' من فضلك ادخل سعر الشحن  ';
    } elseif (empty($new_size)) {
        $formerror[] = ' من فضلك  حدد المنطقة  ';
    }
    if (empty($formerror)) {
        $stmt = $connect->prepare("INSERT INTO shipping_size (new_size ,new_price)
        VALUES (:znew_size,:znew_price)");
        $stmt->execute(array(
            "znew_size" => $new_size,
            "znew_price" => $new_price,
        ));
        if ($stmt) {
            $_SESSION['success_message'] = " تمت الأضافة بنجاح  ";
            header('Location:main?dir=shipping_weight&page=report');
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=shipping_weight&page=report');
        exit();
    }
}
