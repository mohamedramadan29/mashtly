<?php
if (isset($_GET['area_id']) && is_numeric($_GET['area_id'])) {
    $area_id = $_GET['area_id'];
    $stmt = $connect->prepare('SELECT * FROM new_shipping_company WHERE id = ?');
    $stmt->execute([$area_id]);
    $gift_data = $stmt->fetch();
    $count = $stmt->rowCount();
    if ($count > 0) {
        $stmt = $connect->prepare('DELETE FROM new_shipping_company WHERE id = ?');
        $stmt->execute([$area_id]);
        if ($stmt) {
            $_SESSION['success_message'] = "تم الحذف بنجاح";
            header('Location: main?dir=shipping_company/companies&page=report');
            exit(); // إنهاء النص بعد إعادة التوجيه
        }
    } else {
        header('Location: main?dir=shipping_company/companies&page=report');
        exit(); // إنهاء النص بعد إعادة التوجيه
    }
}
