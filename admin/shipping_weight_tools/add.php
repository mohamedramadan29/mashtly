<?php
if (isset($_POST['add_cat'])) {
    $formerror = [];
    $tail = $_POST['tail'];
    $weight = $_POST['weight'];
    if (empty($formerror)) {
        $stmt = $connect->prepare("INSERT INTO shipping_weight_tools (tail,weight)
        VALUES (:ztail,:zweight)");
        $stmt->execute(array(
            "ztail" => $tail,
            "zweight" => $weight,
        ));
        if ($stmt) {
            $_SESSION['success_message'] = " تمت الأضافة بنجاح  ";
            header('Location:main?dir=shipping_weight_tools&page=report&company_id=' . $company_id);
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=shipping_weight_tools&page=report&company_id=' . $company_id);
        exit();
    }
}
