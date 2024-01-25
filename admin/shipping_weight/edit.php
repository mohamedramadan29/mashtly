<?php
if (isset($_POST['edit_cat'])) {
    $formerror = [];
    $weight_id = $_POST['weight_id'];
    $new_size = $_POST['new_size'];
    $new_price = $_POST['new_price'];
    if (empty($formerror)) {
        $stmt = $connect->prepare("UPDATE shipping_size SET new_size=?,new_price=? WHERE id = ? ");
        $stmt->execute(array($new_size, $new_price, $weight_id));
        if ($stmt) {
            $_SESSION['success_message'] = "تم التعديل بنجاح ";
            header('Location:main?dir=shipping_weight&page=report');
            exit();
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=shipping_weight&page=report');
        exit();
    }
}
