<?php
if (isset($_POST['edit_user'])) {
    $formerror = [];
    $user_id = $_POST['user_id'];
    $email = sanitizeInput($_POST['email']);
    $password = sanitizeInput($_POST['password']);
    $password =  sha1($_POST['password']);

    $stmt = $connect->prepare("SELECT * FROM users WHERE email = ? AND id !=?");
    $stmt->execute(array($email,$user_id));
    $countmails = $stmt->rowCount();
    if($countmails > 0){
        $formerror[] = ' البريد الالكتروني متواجد بالفعل ';
    }
    if (empty($formerror)) {
        $stmt = $connect->prepare("UPDATE users SET email=? WHERE id = ? ");
        $stmt->execute(array($email, $user_id));
        if (!empty($password)) {
            $stmt = $connect->prepare("UPDATE users SET password=? WHERE id = ? ");
            $stmt->execute(array($password, $user_id));
        }

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
