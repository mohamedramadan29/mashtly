<?php
if (isset($_GET['redirect_id']) && is_numeric($_GET['redirect_id'])) {
    $redirect_id = $_GET['redirect_id'];
    $stmt = $connect->prepare('SELECT * FROM redirects WHERE id = ?');
    $stmt->execute([$redirect_id]);
    $gift_data = $stmt->fetch();
    $count = $stmt->rowCount();

    if ($count > 0) {
        $stmt = $connect->prepare('DELETE FROM redirects WHERE id = ?');
        $stmt->execute([$redirect_id]);

        if ($stmt) {
            $_SESSION['success_message'] = "تم الحذف بنجاح";
            header('Location: main?dir=redirect&page=index');
            exit(); // إنهاء النص بعد إعادة التوجيه
        }
    } else {
        header('Location: main?dir=redirect&page=index');
        exit(); // إنهاء النص بعد إعادة التوجيه
    }
}
