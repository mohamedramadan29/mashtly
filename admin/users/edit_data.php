<?php
if (isset($_POST['edit_user'])) {
    echo "Goood";
    $formerror = [];
    $user_id = $_POST['user_id'];
    $password = sanitizeInput($_POST['password']);
    $password =  sha1($_POST['password']);
    if (empty($formerror)) {
        $stmt = $connect->prepare("UPDATE users SET password=? WHERE id = ? ");
        $stmt->execute(array($password, $user_id));
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
