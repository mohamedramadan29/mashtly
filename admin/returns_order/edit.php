<?php
if (isset($_POST['edit_cat'])) {
    $return_id = $_POST['return_id'];
    $status = $_POST['status'];
    $description = $_POST['description'];
    $formerror = [];
    if (empty($formerror)) {
        $stmt = $connect->prepare("UPDATE return_products SET status=? WHERE id = ? ");
        $stmt->execute(array($status, $return_id));
        if ($stmt) {
            $_SESSION['success_message'] = "تم التعديل بنجاح ";
            header('Location:main?dir=returns_order&page=report');
            exit();
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=returns_order&page=report');
        exit();
    }
}
