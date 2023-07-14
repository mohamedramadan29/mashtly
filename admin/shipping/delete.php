<?php
if (isset($_GET['gift_id']) && is_numeric($_GET['gift_id'])) {
    $gift_id = $_GET['gift_id'];
    $stmt = $connect->prepare('SELECT * FROM gifts WHERE id = ?');
    $stmt->execute([$gift_id]);
    $gift_data = $stmt->fetch();
    $count = $stmt->rowCount();

    if ($count > 0) {
        $image_path = 'gifts/images/' . $gift_data['image']; // تعديل المسار إلى مسار حقيقي

        // حذف الصورة من مجلد الصور إذا كانت موجودة
        if (file_exists($image_path)) {
            unlink($image_path);
        }

        $stmt = $connect->prepare('DELETE FROM gifts WHERE id = ?');
        $stmt->execute([$gift_id]);

        if ($stmt) {
            $_SESSION['success_message'] = "تم الحذف بنجاح";
            header('Location: main?dir=coupons&page=report');
            exit(); // إنهاء النص بعد إعادة التوجيه
        }
    } else {
        header('Location: main?dir=coupons&page=report');
        exit(); // إنهاء النص بعد إعادة التوجيه
    }
}
