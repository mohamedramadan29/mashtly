<?php
if (isset($_POST['add_cat'])) {
    $formerror = [];
    $new_area = $_POST['new_area'];
    $new_price = $_POST['new_price'];

    if (empty($new_price)) {
        $formerror[] = ' من فضلك ادخل سعر الشحن  ';
    } elseif (empty($new_area)) {
        $formerror[] = ' من فضلك  حدد المنطقة  ';
    }
    if (empty($formerror)) {
        $stmt = $connect->prepare("INSERT INTO shipping_area (new_area ,new_price)
        VALUES (:znew_area,:znew_price)");
        $stmt->execute(array(
            "znew_area" => $new_area,
            "znew_price" => $new_price,
        ));
        if ($stmt) {
            $_SESSION['success_message'] = " تمت الأضافة بنجاح  ";
            header('Location:main?dir=shipping&page=report');
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=shipping&page=report');
        exit();
    }
}
