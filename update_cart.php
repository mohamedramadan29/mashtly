<?php
// تضمين ملف الاتصال بقاعدة البيانات
include 'admin/connect.php';

// التحقق من وجود بيانات مرسلة عبر POST
if (isset($_POST['quantities'])) {
    // حلقة لتحديث كل عنصر في السلة
    foreach ($_POST['quantities'] as $item) {
        // الحصول على قيم المنتجات المحدثة
        $item_id = $item['item_id'];
        $quantity = $item['quantity'];
        // التحقق من وجود خدمة زراعية محددة
        $selectedValue = isset($_POST['farmserv'][$item_id]) ? intval($_POST['farmserv'][$item_id]) : null;

        // تحديث الكمية وخدمة الزراعة للعنصر
        $stmt = $connect->prepare("UPDATE cart SET quantity = ?, farm_service = ? WHERE id = ?");
        $stmt->execute(array($quantity, $selectedValue, $item_id));

        // التحقق من نجاح التحديث
        if (!$stmt) {
            // في حالة حدوث خطأ، إظهار رسالة الخطأ والخروج من الحلقة
            echo "Error updating cart. Please try again.";
            break;
        }
    }

    // إعادة رسالة نجاح بعد تحديث السلة بنجاح
    echo " تم تحديث السلة بنجاح  ";
} else {
    // إذا لم يتم إرسال أي بيانات، إظهار رسالة الخطأ
    echo " حدث خطا اثناء تحديث السلة ";
}
