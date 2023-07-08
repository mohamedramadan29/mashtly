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
    $agree_policy = isset($_POST['agree_policy']);
    $emails_subscribe = isset($_POST['emails_subscribe']);
    if($emails_subscribe){
        $emails_subscribe = 1;
    }else{
        $emails_subscribe = 0;
    }
    if (strlen($password) < 8) {
        $formerror[] = 'كلمة المرور يجب ان تكون اكثر من 8 احرف ';
    }
    if (!$agree_policy) {
        $formerror[] = 'يجب الموافقة علي الشروط والأحكام';
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
            "emails_subscribe" => $emails_subscribe,
        );
        $stmt =  insertData($connect, $table, $data);
        if ($stmt) {
            $_SESSION['success'] = ' تم تسجيل حسابك بنجاح من فضلك سجل دخولك الأن ';
            if (isset($_SESSION['new_user_name'])) {
                unset($_SESSION['new_user_name']);
            } elseif (isset($_SESSION['new_email'])) {
                unset($_SESSION['new_email']);
            }
            header('location:login');
        }
    } else {
        $_SESSION['error'] = $formerror;
        header('Location:login');
        $_SESSION['new_user_name'] = $_POST['user_name'];
        $_SESSION['new_email'] = $_POST['email'];
    }
}
/////////////////////////////////////////// login to account /////////////////////////////////
if (isset($_POST['login'])) {
    $formerror = [];
    $username = sanitizeInput($_POST['user_name']);
    $password = sha1($_POST['password']);
    $rememberMe = isset($_POST['remember_me']);
    $stmt = $connect->prepare("SELECT * FROM users WHERE (user_name=? OR email = ?) AND password=?");
    $stmt->execute(array($username, $username, $password));
    $user_data = $stmt->fetch();
    $count = $stmt->rowCount();
    if ($count > 0) {
        $_SESSION['user_name'] = $user_data['user_name'];
        $_SESSION['user_id']  = $user_data['id'];
        // if click rember me 
        if ($rememberMe) {
            // إنشاء معرّف رمز تذكر كلمة المرور وتخزينه في ملف تعريف الارتباط
            $rememberToken = generateRememberToken();
            $expire_date = time() + (30 * 24 * 60 * 60); // انتهاء المدة بعد 30 يومًا
            setcookie('remember_token', $rememberToken, time() + $expire_date, '/');
            // قم بتخزين معرف المستخدم ورمز تذكر كلمة المرور في قاعدة البيانات أو أي مكان آخر يناسب تطبيقك
            saveRememberTokenToDatabase($connect, $user_data['id'], $rememberToken);
        } else {
            // حذف ملف تعريف الارتباط المرتبط بتذكر كلمة المرور (إن وجد)
            if (isset($_COOKIE['remember_token'])) {
                setcookie('remember_token', '', time() - 3600, '/');
            }
            // قم بحذف معرف رمز تذكر كلمة المرور من قاعدة البيانات أو أي مكان آخر يناسب تطبيقك
            deleteRememberTokenFromDatabase($connect, $user_data['id']);
        }
        header("Location:profile");
    } else {
        $formerror[] = 'لا يوجد سجل بهذة البيانات';
        $_SESSION['error'] = $formerror;
        header('Location:login');
    }
}
