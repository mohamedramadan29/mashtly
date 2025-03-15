<?php
if (isset($_POST['edit_emp'])) {
    $emp_id = $_POST['emp_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role_name = $_POST['role_name'];
    $writer_info = $_POST['writer_info'];
    $formerror = [];
    if (!empty($_FILES['main_image']['name'])) {
        $main_image_name = basename($_FILES['main_image']['name']); // تأمين اسم الملف
        $main_image_name = str_replace(' ', '-', $main_image_name);
        $main_image_temp = $_FILES['main_image']['tmp_name'];
        $main_image_size = $_FILES['main_image']['size'];
        $image_extension = strtolower(pathinfo($main_image_name, PATHINFO_EXTENSION));
        // التحقق من الامتداد
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];
        if (!in_array($image_extension, $allowed_extensions)) {
            die("امتداد الملف غير مسموح به!");
        }
        // إنشاء اسم فريد للملف
        $main_image_uploaded = time() . '-' . uniqid() . '.' . $image_extension;
        $upload_path = '../../uploads/emp/' . $main_image_uploaded;
    }
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
        try {
            $stmt = $connect->prepare("UPDATE employes SET username=? , email=?, role_name=? , writer_info=? WHERE id = ?");
            $stmt->execute(array(
                $username,
                $email,
                $role_name,
                $writer_info,
                $emp_id
            ));
            if (!empty($_FILES['main_image']['name'])) {
                $stmt = $connect->prepare("UPDATE employes SET image=? WHERE id = ?");
                $stmt->execute(array($main_image_uploaded, $emp_id));
            }
            if (!empty($password)) {
                $stmt = $connect->prepare("UPDATE employes SET password=? WHERE id = ?");
                $stmt->execute(array($password, $emp_id));
            }


            if ($stmt) {
                header('Location:main?dir=employee&page=report');
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=employee&page=report');
        exit();
    }
}
