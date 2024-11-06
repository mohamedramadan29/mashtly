<?php
require 'admin/connect.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$cat_id = isset($_POST['cat_id']) ? (int)$_POST['cat_id'] : 0;
$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
$pageSize = 20;
$offset = ($page - 1) * $pageSize;

// تحديد ترتيب الفرز
$order_by = "";
if (isset($_POST['sort']) && !empty($_POST['sort'])) {
    $sort = $_POST['sort'];
    switch ($sort) {
        case 'heigh_to_low':
            $order_by = " ORDER BY price DESC";
            break;
        case 'low_to_heigh':
            $order_by = " ORDER BY price ASC";
            break;
        case 'newest':
            $order_by = " ORDER BY id DESC";
            break;
        case 'oldest':
            $order_by = " ORDER BY id ASC";
            break;
    }
}

// استعلام جلب المنتجات حسب الفئة والفرز

$query = "SELECT * FROM products WHERE publish = 1 AND product_status_store = 1 AND name != '' AND price != '' AND (cat_id = :cat_id OR FIND_IN_SET(:cat_id, more_cat) > 0) $order_by LIMIT :pageSize OFFSET :offset";
$stmt = $connect->prepare($query);
$stmt->bindParam(':cat_id', $cat_id, PDO::PARAM_INT);
$stmt->bindParam(':pageSize', $pageSize, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$allproducts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// إذا كانت هناك منتجات، أضف HTML مباشرة
$html = "";
foreach ($allproducts as $product) {
    ob_start();
?>
    <div class="col-lg-3 col-6">
        <?php
        include 'tempelate/product.php'; // هذه هي الصفحة التي تحتوي على هيكل المنتج
        ?>
    </div>
<?php
    $html .= ob_get_clean();
}

echo $html; // إرجاع HTML مباشرة
