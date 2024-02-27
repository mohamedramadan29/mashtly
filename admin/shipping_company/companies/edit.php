<?php
if (isset($_POST['edit_cat'])) {
    $formerror = [];
    $company_id = $_POST['company_id'];
    $company_name = $_POST['company_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $status = $_POST['status'];
    $company_type = $_POST['company_type'];
    if (empty($formerror)) {
        $stmt = $connect->prepare("UPDATE new_shipping_company SET name=?,address=?,email=?,phone=?,company_type=?,status=? WHERE id = ? ");
        $stmt->execute(array($company_name, $address, $email, $phone, $company_type, $status, $company_id));
        if ($stmt) {
            $_SESSION['success_message'] = "تم التعديل بنجاح ";
            header('Location:main?dir=shipping_company/companies&page=report');
            exit();
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=shipping_company/companies&page=report');
        exit();
    }
}
