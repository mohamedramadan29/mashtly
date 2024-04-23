<?php
if (isset($_POST['edit_cat'])) {
    $user_id = $_POST['user_id'];
    $status = $_POST['status'];
    $active_status = $_POST['active_status'];

    if (empty($formerror)) {
        $stmt = $connect->prepare("UPDATE users SET active_status=?,status=? WHERE id = ? ");
        $stmt->execute(array($active_status, $status, $user_id));

        if ($stmt) {
            $_SESSION['success_message'] = "تم التعديل بنجاح ";
            header('Location:main?dir=users&page=report');
            exit();
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=users&page=report');
        exit();
    }
}
