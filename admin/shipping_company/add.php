<?php
if (isset($_POST['add_cat'])) {
    $formerror = [];
    $company_name = $_POST['company_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $status = $_POST['status'];
    $ship_type = $_POST['ship_type'];
    $ship_area = $_POST['ship_area'];
    $whight_from = $_POST['whight_from'];
    $whight_to = $_POST['whight_to'];
    $ship_start_from_price = $_POST['ship_start_from_price'];
    $ship_end_to_price = $_POST['ship_end_to_price'];
    $default_whight_ship_price = $_POST['default_whight_ship_price'];
    $more_kilo_price = $_POST['more_kilo_price'];

    if (empty($company_name) || empty($email) || empty($phone) || empty($address) || empty($ship_type)) {
        $formerror[] = ' من فضلك ادخل المعلومات كاملة  ';
    }
    if (empty($formerror)) {
        $stmt = $connect->prepare("INSERT INTO shipping_company (company_name ,address,email,phone,status,ship_type,ship_area,whight_from,whight_to,ship_start_from_price,ship_end_to_price,default_whight_ship_price,more_kilo_price)
        VALUES (:zcompany_name,:zaddress,:zemail,:zphone,:zstatus,:zship_type,:zship_area,:zwhight_from,:zwhight_to,:zship_start_from_price,:zship_end_to_price,:zdefault_whight_ship_price,:zmore_kilo_price)");
        $stmt->execute(array(
            "zcompany_name" => $company_name,
            "zaddress" => $address,
            "zemail" => $email,
            "zphone" => $phone,
            "zstatus" => $status,
            "zship_type" => $ship_type,
            "zship_area" => $ship_area,
            "zwhight_from" => $whight_from,
            "zwhight_to" => $whight_to,
            "zship_start_from_price" => $ship_start_from_price,
            "zship_end_to_price" => $ship_end_to_price,
            "zdefault_whight_ship_price" => $default_whight_ship_price,
            "zmore_kilo_price" => $more_kilo_price,
        ));
        if ($stmt) {
            $_SESSION['success_message'] = " تمت الأضافة بنجاح  ";
            header('Location:main?dir=shipping_company&page=report');
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=shipping_company&page=report');
        exit();
    }
}
