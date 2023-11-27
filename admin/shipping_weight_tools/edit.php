<?php
if (isset($_POST['edit_cat'])) {
    $formerror = []; 
    $ship_tail_id = $_POST['ship_tail_id'];
    $tail = $_POST['tail'];
    $weight = $_POST['weight']; 
    if (empty($formerror)) {
        $stmt = $connect->prepare("UPDATE shipping_weight_tools SET tail=?,weight=? WHERE id = ? ");
        $stmt->execute(array($tail, $weight, $ship_tail_id));
        if ($stmt) {
            $_SESSION['success_message'] = "تم التعديل بنجاح ";
            header('Location:main?dir=shipping_weight_tools&page=report&company_id=' . $company_id);
            exit();
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=shipping_weight_tools&page=report&company_id=' . $company_id);
        exit();
    }
}
