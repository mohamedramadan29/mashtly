<?php
if (isset($_POST['edit_cat'])) {
    $formerror = [];
    $trip_id = $_POST['trip_id'];
    $company_id = $_POST['company_id'];
    $trip_name = $_POST['trip_name'];
    $ship_type = implode(',', $_POST['ship_type']);
    $ship_city = implode(',', $_POST['ship_city']);
    $whight_from = $_POST['whight_from'];
    $whight_to = $_POST['whight_to'];
    $ship_start_from_price = $_POST['ship_start_from_price'];
    $ship_end_to_price = $_POST['ship_end_to_price'];
    $default_whight_ship_price = $_POST['default_whight_ship_price'];
    $more_kilo_price = $_POST['more_kilo_price'];
    if (empty($formerror)) {
        $stmt = $connect->prepare("UPDATE company_trips SET company_id=?,trip_name=?,ship_type=?,ship_city=?,whight_from=?,whight_to=?,ship_start_from_price=?,ship_end_to_price=?,default_whight_ship_price=?,more_kilo_price=? WHERE id = ? ");
        $stmt->execute(array($company_id, $trip_name, $ship_type, $ship_city, $whight_from, $whight_to, $ship_start_from_price, $ship_end_to_price, $default_whight_ship_price, $more_kilo_price, $trip_id));
        if ($stmt) {
            $_SESSION['success_message'] = "تم التعديل بنجاح ";
            header('Location:main?dir=shipping_company/trips&page=report&company_id=' . $company_id);
            exit();
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=shipping_company/trips&page=report&company_id=' . $company_id);
        exit();
    }
}
