<?php
if (isset($_POST['edit_cat'])) {
    $formerror = [];
    $company_id = $_POST['company_id'];
    $company_name = $_POST['company_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $status = $_POST['status'];
    $ship_type = implode(',', $_POST['ship_type']);
    $ship_area = implode(',', $_POST['ship_area']);
    $whight_from = $_POST['whight_from'];
    $whight_to = $_POST['whight_to'];
    $ship_start_from_price = $_POST['ship_start_from_price'];
    $ship_end_to_price = $_POST['ship_end_to_price'];
    $default_whight_ship_price = $_POST['default_whight_ship_price'];
    $more_kilo_price = $_POST['more_kilo_price'];
    if (empty($formerror)) {
        $stmt = $connect->prepare("UPDATE shipping_company SET company_name=?,address=?,email=?,phone=?,status=?,ship_type=?,ship_area=?,whight_from=?,whight_to=?,ship_start_from_price=?,ship_end_to_price=?,default_whight_ship_price=?,more_kilo_price=? WHERE id = ? ");
        $stmt->execute(array($company_name, $address, $email, $phone, $status, $ship_type, $ship_area, $whight_from, $whight_to, $ship_start_from_price, $ship_end_to_price, $default_whight_ship_price, $more_kilo_price, $company_id));
        if ($stmt) {
            $_SESSION['success_message'] = "تم التعديل بنجاح ";
            header('Location:main?dir=shipping_company&page=report');
            exit();
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=shipping_company&page=report');
        exit();
    }
}
