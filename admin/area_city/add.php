<?php
if (isset($_POST['add_cat'])) {
    $formerror = [];
    $area = $_POST['area'];
    $cities = $_POST['cities'];
    $cities = explode(',', $cities);


    if (empty($area)) {
        $formerror[] = ' من فضلك ادخل اسم المنطقة   ';
    }
    if (empty($formerror)) {
        $stmt = $connect->prepare("SELECT * FROM suadia_city ORDER BY reg_id DESC LIMIT 1");
        $stmt->execute();
        $last_reg = $stmt->fetch();
        $last_reg_id = $last_reg['reg_id'];
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
            $_SESSION['success_message'] = " تمت الأضافة بنجاح  ";
            header('Location:main?dir=area_city&page=report');
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=area_city&page=report');
        exit();
    }
}
