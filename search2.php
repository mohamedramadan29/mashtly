<?php 
include "admin/connect.php";
// if (isset($_GET['search']) && !empty($_GET['search'])) {
//     $search = $_GET['search'];
    
//     // استخدام تعبير استعلام معدّ مسبقًا للحماية من هجمات SQL Injection
//     $stmt = $connect->prepare("SELECT * FROM products WHERE publish = 1 AND product_status_store = 1 AND name LIKE ?");
//     $stmt->execute(["%$search%"]);
    
//     // استرجاع النتائج
//     $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
//     // إرسال النتائج كـ JSON
//     echo json_encode($results);
// } else {
//     // يُمكن تعيين رسالة الخطأ أو قائمة فارغة
//     echo json_encode([]);
// }

// جلب جميع المنتجات مرة واحدة

 
// السماح بالوصول من أي مصدر (CORS)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// جلب جميع المنتجات مرة واحدة
$stmt = $connect->prepare("SELECT name, slug FROM products WHERE publish = 1");
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// إرجاع النتائج بصيغة JSON
echo json_encode($products);
?>

?>
