<?php
if (isset($_POST['edit_cat'])) {
    $formerror = [];
    $area_id = $_POST['area_id'];
    $company_id = $_POST['company_id'];
    $ship_type = implode(',', $_POST['ship_type']);
    $ship_area = implode(',', $_POST['ship_area']);
    $whight_from = $_POST['whight_from'];
    $whight_to = $_POST['whight_to'];
    $ship_start_from_price = $_POST['ship_start_from_price'];
    $ship_end_to_price = $_POST['ship_end_to_price'];
    $default_whight_ship_price = $_POST['default_whight_ship_price'];
    $more_kilo_price = $_POST['more_kilo_price'];
    if (empty($formerror)) {
        $stmt = $connect->prepare("UPDATE company_areas  SET ship_type=?,ship_area=?,whight_from=?,whight_to=?,ship_start_from_price=?,ship_end_to_price=?,default_whight_ship_price=?,more_kilo_price=? WHERE id = ? ");
        $stmt->execute(array($ship_type, $ship_area, $whight_from, $whight_to, $ship_start_from_price, $ship_end_to_price, $default_whight_ship_price, $more_kilo_price, $area_id));
        if ($stmt) {
            $_SESSION['success_message'] = "تم التعديل بنجاح ";
            header('Location:main.php?dir=shipping_company/areas&page=report&company_id=' . $company_id);
            exit();
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main.php?dir=shipping_company/areas&page=report&company_id=' . $company_id);
        exit();
    }
}
