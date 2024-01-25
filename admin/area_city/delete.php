<?php
if (isset($_GET['area_id']) && is_numeric($_GET['area_id'])) {
    $area_id = $_GET['area_id'];
    $stmt = $connect->prepare('SELECT * FROM suadia_city WHERE id = ?');
    $stmt->execute([$area_id]);
    $gift_data = $stmt->fetch();
    $area_name = $gift_data['region'];
    $count = $stmt->rowCount();
    if ($count > 0) {
        $stmt = $connect->prepare('DELETE FROM suadia_city WHERE region = ?');
        $stmt->execute([$area_name]);
        if ($stmt) {
            $_SESSION['success_message'] = "تم الحذف بنجاح";
            header('Location: main?dir=area_city&page=report');
            exit(); // إنهاء النص بعد إعادة التوجيه
        }
    } else {
        header('Location: main?dir=area_city&page=report');
        exit(); // إنهاء النص بعد إعادة التوجيه
    }
}
