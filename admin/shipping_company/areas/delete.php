<?php
if (isset($_GET['area_id']) && is_numeric($_GET['area_id'])) {
    $area_id = $_GET['area_id'];
    $stmt = $connect->prepare('SELECT * FROM company_areas WHERE id = ?');
    $stmt->execute([$area_id]);
    $gift_data = $stmt->fetch();
    $company_id = $gift_data['company_id'];
    $count = $stmt->rowCount();
    if ($count > 0) {
        $stmt = $connect->prepare('DELETE FROM company_areas WHERE id = ?');
        $stmt->execute([$area_id]);
        if ($stmt) {
            $_SESSION['success_message'] = "تم الحذف بنجاح";
            header('Location:main.php?dir=shipping_company/areas&page=report&company_id=' . $company_id);
            exit(); // إنهاء النص بعد إعادة التوجيه
        }
    } else {
        header('Location:main.php?dir=shipping_company/areas&page=report&company_id=' . $company_id);
        exit(); // إنهاء النص بعد إعادة التوجيه
    }
}
