b<?php
    if (isset($_POST['add_emp'])) {
        $username = $_POST['email'];
        $email = $_POST['email'];
        $length = 8; // Set the length of the random string
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; // Set the characters to use
        $randomString = '';
        // Generate the random string
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        $randomString =  substr($randomString, 0, 8);
        $password = $randomString;
        $role_name = $_POST['role_name'];
        $formerror = [];
        if (empty($email)) {
            $formerror[] = 'من فضلك ادخل  ادخل البريد الألكتروني    ';
        }
        $stmt = $connect->prepare("SELECT * FROM employes WHERE email = ?");
        $stmt->execute(array($email));
        $count = $stmt->rowCount();
        if ($count > 0) {
            $formerror[] = ' البريد الالكتروني مسجل من قبل ادخل بريد الكتروني جديد ';
        }
        if (empty($formerror)) {
            $stmt = $connect->prepare("INSERT INTO employes (username , email , password , role_name)
        VALUES (:zusername,:zemail,:zpassword , :zrole_name)");
            $stmt->execute(array(
                "zusername" => $username,
                "zemail" => $email,
                "zpassword" => $password,
                "zrole_name" => $role_name
            ));
            if ($stmt) {
                $stmt = $connect->prepare("SELECT * FROM employes ORDER BY id DESC LIMIT 1");
                $stmt->execute();
                $emp_data = $stmt->fetch();
                $emp_mail = $emp_data['email'];
                $emp_password = $emp_data['password'];
                $to_email = $emp_mail;
                $subject = " معلومات الدخول الخاصة بك علي مشتلي  ";
                $body =   " معلومات الدخول الخاصة  بك هي  ";
                $body .= 'البريد الألكتروني ';
                $body .= " =>  " . $emp_mail;
                $body .= "</br>";
                $body .= ' كلمة المرور ';
                $body .= " =>  " . $emp_password;
                $headers = "From: info@mashtly.online";
                mail($to_email, $subject, $body, $headers);
                $_SESSION['success_message'] = " تمت الأضافة بنجاح  ";
                header('Location:main?dir=employee&page=report');
            }
        } else {
            $_SESSION['error_messages'] = $formerror;
            header('Location:main?dir=employee&page=report');
            exit();
        }
    }
