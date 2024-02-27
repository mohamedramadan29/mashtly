<?php
if (isset($_POST['add_cat'])) {
    $formerror = [];
    $company_id = $_POST['company_id'];
    $company_name = $_POST['company_name'];
    $ship_type = implode(',', $_POST['ship_type']);
    $ship_area = implode(',', $_POST['ship_area']);
    $whight_from = $_POST['whight_from'];
    $whight_to = $_POST['whight_to'];
    $ship_start_from_price = $_POST['ship_start_from_price'];
    $ship_end_to_price = $_POST['ship_end_to_price'];
    $default_whight_ship_price = $_POST['default_whight_ship_price'];
    $more_kilo_price = $_POST['more_kilo_price'];
    if (empty($formerror)) {
        $stmt = $connect->prepare("INSERT INTO company_areas (company_id ,ship_type,ship_area,whight_from,whight_to,ship_start_from_price,ship_end_to_price,default_whight_ship_price,more_kilo_price)
        VALUES (:zcompany_id,:zship_type,:zship_area,:zwhight_from,:zwhight_to,:zship_start_from_price,:zship_end_to_price,:zdefault_whight_ship_price,:zmore_kilo_price)");
        $stmt->execute(array(
            "zcompany_id" => $company_id, 
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
            header('Location:main.php?dir=shipping_company/areas&page=report&company_id='.$company_id);
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main.php?dir=shipping_company/areas&page=report&company_id='.$company_id);
        exit();
    }
}
