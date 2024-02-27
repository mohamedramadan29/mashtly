<?php
if (isset($_GET['trip_id']) && is_numeric($_GET['trip_id'])) {
    $trip_id = $_GET['trip_id'];
    $stmt = $connect->prepare('SELECT * FROM company_trips WHERE id = ?');
    $stmt->execute([$trip_id]);
    $gift_data = $stmt->fetch();
    $company_id = $gift_data['company_id'];
    $count = $stmt->rowCount();
    if ($count > 0) {
        $stmt = $connect->prepare('DELETE FROM company_trips WHERE id = ?');
        $stmt->execute([$trip_id]);
        if ($stmt) {
            $_SESSION['success_message'] = "تم الحذف بنجاح";
            header('Location:main?dir=shipping_company/trips&page=report&company_id=' . $company_id);
            exit(); // إنهاء النص بعد إعادة التوجيه
        }
    } else {
        header('Location:main?dir=shipping_company/trips&page=report&company_id=' . $company_id);
        exit(); // إنهاء النص بعد إعادة التوجيه
    }
}