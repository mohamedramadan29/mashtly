<?php
if (isset($_POST['add_cat'])) {
    $formerror = [];
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
        $stmt = $connect->prepare("INSERT INTO company_trips (company_id ,trip_name,ship_type,ship_city,whight_from,whight_to,ship_start_from_price,ship_end_to_price,default_whight_ship_price,more_kilo_price)
        VALUES (:zcompany_id,:ztrip_name,:zship_type,:zship_city,:zwhight_from,:zwhight_to,:zship_start_from_price,:zship_end_to_price,:zdefault_whight_ship_price,:zmore_kilo_price)");
        $stmt->execute(array(
            "zcompany_id" => $company_id,
            "ztrip_name" => $trip_name,
            "zship_type" => $ship_type,
            "zship_city" => $ship_city,
            "zwhight_from" => $whight_from,
            "zwhight_to" => $whight_to,
            "zship_start_from_price" => $ship_start_from_price,
            "zship_end_to_price" => $ship_end_to_price,
            "zdefault_whight_ship_price" => $default_whight_ship_price,
            "zmore_kilo_price" => $more_kilo_price,
        ));
        if ($stmt) {
            $_SESSION['success_message'] = " تمت الأضافة بنجاح  ";
            header('Location:main?dir=shipping_company/trips&page=report&company_id='.$company_id);
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=shipping_company/trips&page=report&company_id='.$company_id);
        exit();
    }
}
