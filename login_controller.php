<?php
ob_start();
session_start();
include 'init.php';

if (isset($_POST['new_account'])) {
    $formerror = [];
    $username = sanitizeInput($_POST['user_name']);
    $password = $_POST['password'];
    $sha_password = sha1($_POST['password']);
    $email = sanitizeInput($_POST['email']);
    if (strlen($password) < 8) {
        $formerror[] = 'كلمة المرور يجب ان تكون اكثر من 8 احرف ';
    }
    // استخدام الوظيفة للتحقق من وجود البريد الإلكتروني
    checkIfExists($connect, 'users', 'email', $email, $formerror, 'البريد الإلكتروني مستخدم بالفعل');
    // استخدام الوظيفة للتحقق من وجود اسم المستخدم
    checkIfExists($connect, 'users', 'user_name', $username, $formerror, 'اسم المستخدم مستخدم بالفعل');

    if (empty($formerror)) {
        $table = 'users';
        $data = array(
            "user_name" => $username,
            "email" => $email,
            "password" => $sha_password,
        );
        $stmt =  insertData($connect, $table, $data);
        if ($stmt) {
            $_SESSION['success'] = ' تم تسجيل حسابك بنجاح من فضلك سجل دخولك الأن ';

            header('location:login');
        }
    } else {
        $_SESSION['error'] = $formerror;
        header('Location:login');
    }
}
/////////////////////////////////////////// login to account /////////////////////////////////
if (isset($_POST['login'])) {
    $formerror = [];
    $username = sanitizeInput($_POST['user_name']);
    $password = sha1($_POST['password']);
    $stmt = $connect->prepare("SELECT * FROM users WHERE (user_name=? OR email = ?) AND password=?");
    $stmt->execute(array($username, $username, $password));
    $user_data = $stmt->fetch();
    $count = $stmt->rowCount();
    if ($count > 0) {
        $_SESSION['user_name'] = $user_data['user_name'];
        $_SESSION['user_id']  = $user_data['id'];
        header("Location:profile");
    } else {
        $formerror[] = 'لا يوجد سجل بهذة البيانات';
        $_SESSION['error'] = $formerror;
        header('Location:login');
    }
}
