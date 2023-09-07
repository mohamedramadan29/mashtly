<?php
if (isset($_POST['edit_cat'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];
    if (empty($formerror)) {
        $stmt = $connect->prepare("UPDATE landscap_request SET status=? WHERE id = ? ");
        $stmt->execute(array($status, $order_id));
        if ($stmt) {
            $_SESSION['success_message'] = "تم التعديل بنجاح ";
            header('Location:main?dir=landscap_orders&page=report');
            exit();
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=landscap_orders&page=report');
        exit();
    }
}
