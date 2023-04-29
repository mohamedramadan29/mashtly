<?php
if (isset($_POST['add_emp'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $role_name = $_POST['role_name']; 
    $formerror = [];
    if (empty($username) || empty($email) || empty($phone)) {
        $formerror[] = 'من فضلك ادخل  جميع المعلومات   ';
    }
    $stmt = $connect->prepare("SELECT * FROM employes WHERE username = ?");
    $stmt->execute(array($username));
    $count = $stmt->rowCount();
    if ($count > 0) {
        $formerror[] = ' اسم المستخدم موجود من قبل من فضلك ادخل اسم اخر  ';
    }
    $stmt = $connect->prepare("SELECT * FROM employes WHERE email = ?");
    $stmt->execute(array($email));
    $count = $stmt->rowCount();
    if ($count > 0) {
        $formerror[] = ' البريد الالكتروني مسجل من قبل ادخل بريد الكتروني جديد ';
    }
    if (empty($formerror)) {
        $stmt = $connect->prepare("INSERT INTO employes (username , email, phone , address , password , role_name)
        VALUES (:zusername,:zemail,:zphone , :zaddress,:zpassword , :zrole_name)");
        $stmt->execute(array(
            "zusername" => $username,
            "zemail" => $email,
            "zphone" => $phone,
            "zaddress" => $address,
            "zpassword" => $password,
            "zrole_name" => $role_name
        ));
        if ($stmt) {
            $_SESSION['success_message'] = " تمت الأضافة بنجاح  ";
            header('Location:main?dir=employee&page=report');
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=employee&page=report');
        exit();
    }
}
