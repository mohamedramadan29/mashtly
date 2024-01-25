<?php
if (isset($_POST['edit_emp'])) {
    $emp_id = $_POST['emp_id'];
    /*
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    */
    $role_name = $_POST['role_name'];
    $formerror = [];
    /*
    $stmt = $connect->prepare("SELECT * FROM employes WHERE username = ? AND id !=?");
    $stmt->execute(array($username, $emp_id));
    $count = $stmt->rowCount();
    if ($count > 0) {
        $formerror[] = ' اسم المستخدم موجود من قبل من فضلك ادخل اسم اخر  ';
    }
    
    $stmt = $connect->prepare("SELECT * FROM employes WHERE email = ? AND id !=?");
    $stmt->execute(array($email, $emp_id));
    $count = $stmt->rowCount();
    if ($count > 0) {
        $formerror[] = ' البريد الالكتروني مسجل من قبل ادخل بريد الكتروني جديد ';
    }
    */

    if (empty($formerror)) {
        $stmt = $connect->prepare("UPDATE  employes SET /*username=? , email=?, phone=? , address=? , password=? ,*/ role_name=? WHERE id = ?");
        $stmt->execute(array(
            /*$username, $email, $phone, $address, $password,  */
            $role_name, $emp_id
        ));

        if ($stmt) {
            $stmt = $connect->prepare("SELECT * FROM employes WHERE id =?");
            $stmt->execute(array($emp_id));
            $emp_data = $stmt->fetch();
            $to_email = $emp_data['email'];
            
            $subject = " تعديل صلاحيات علي مشتلي  ";
            $body =   " تم تعديل الصلاحيات الخاصة بك علي مشتلي الي  ";
            $body .= " :: " . $emp_data['role_name'];
            $headers = "From: info@mashtly.online";
            mail($to_email, $subject, $body, $headers);
            $_SESSION['success_message'] = " تمت التعديل  بنجاح  ";
            header('Location:main?dir=employee&page=report');
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=employee&page=report');
        exit();
    }
}
