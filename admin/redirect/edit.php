<?php
if (isset($_POST['edit_cat'])) {
    $formerror = [];
    $redirect_id = $_POST['redirect_id'];
    $old_url = $_POST['old_url'];
    $new_url = $_POST['new_url'];
    $status_code = $_POST['status_code'];
    if (empty($formerror)) {
        $stmt = $connect->prepare("UPDATE redirects SET old_url=? ,new_url=? ,status_code = ? WHERE id = ? ");
        $stmt->execute(array($old_url, $new_url, $status_code, $redirect_id));
        if ($stmt) {
            $_SESSION['success_message'] = "تم التعديل بنجاح ";
            header('Location:main?dir=redirect&page=index');
            exit();
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=redirect&page=index');
        exit();
    }
}
