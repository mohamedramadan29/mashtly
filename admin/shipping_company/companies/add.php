<?php
if (isset($_POST['add_cat'])) {
    $formerror = [];
    $company_name = $_POST['company_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $status = $_POST['status'];
    $company_type = $_POST['company_type'];

    if (empty($company_name) || empty($email) || empty($phone) || empty($address)) {
        $formerror[] = ' من فضلك ادخل المعلومات كاملة  ';
    }
    if (empty($formerror)) {
        $stmt = $connect->prepare("INSERT INTO new_shipping_company (name ,address,email,phone,company_type,status)
        VALUES (:zcompany_name,:zaddress,:zemail,:zphone,:zcompany_type,:zstatus)");
        $stmt->execute(array(
            "zcompany_name" => $company_name,
            "zaddress" => $address,
            "zemail" => $email,
            "zphone" => $phone,
            "zcompany_type" => $company_type,
            "zstatus" => $status,
        ));
        if ($stmt) {
            $_SESSION['success_message'] = " تمت الأضافة بنجاح  ";
            header('Location:main?dir=shipping_company/companies&page=report');
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=shipping_company/companies&page=report');
        exit();
    }
}
