<?php
if (isset($_POST['edit_cat'])) {
    $formerror = [];
    $area_id = $_POST['area_id'];
    $new_area = $_POST['new_area'];
    $new_price = $_POST['new_price'];
    if($area_id == 1){
        $new_area = null;
    }
    if (empty($formerror)) {
        $stmt = $connect->prepare("UPDATE shipping_area SET new_area=?,new_price=? WHERE id = ? ");
        $stmt->execute(array($new_area, $new_price, $area_id));
        if ($stmt) {
            $_SESSION['success_message'] = "تم التعديل بنجاح ";
            header('Location:main?dir=shipping&page=report');
            exit();
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=shipping&page=report');
        exit();
    }
}
