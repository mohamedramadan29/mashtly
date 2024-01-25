<?php
if (isset($_POST['edit_cat'])) {
    $formerror = [];
    $area_id = $_POST['area_id'];
    $area = $_POST['area'];
    $cities = $_POST['cities'];
    $cities = explode(',', $cities);
    array_pop($cities);
    $cities_id = $_POST['cities_id'];
    $cities_id = explode(',', $cities_id);
    if (empty($formerror)) {
        $stmt = $connect->prepare("SELECT * FROM suadia_city ORDER BY reg_id DESC LIMIT 1");
        $stmt->execute();
        $last_reg = $stmt->fetch();
        $last_reg_id = $last_reg['reg_id'];
        // first delete all city in this area
        foreach ($cities_id as $city_id) {
            $stmt = $connect->prepare("DELETE FROM suadia_city WHERE id=?");
            $stmt->execute(array($city_id));
        }
        foreach ($cities as $city) {
            $stmt = $connect->prepare("INSERT INTO suadia_city (name ,region,reg_id)
            VALUES (:zname,:zregion,:zreg_id)");
            $stmt->execute(array(
                "zname" => $city,
                "zregion" => $area,
                "zreg_id" => $last_reg_id + 1,
            ));
        }

        if ($stmt) {
            $_SESSION['success_message'] = "تم التعديل بنجاح ";
            header('Location:main?dir=area_city&page=report');
            exit();
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=area_city&page=report');
        exit();
    }
}
