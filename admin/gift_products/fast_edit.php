<?php
if (isset($_POST['edit_cat'])) {
    $pro_id = $_POST['pro_id'];
    $name = $_POST['name'];
    $slug = createSlug($_POST['slug']);
    $price = $_POST['price'];
    $sale_price = $_POST['sale_price'];
    $product_status_store = $_POST['product_status_store'];
    $publish = $_POST['publish'];
    $feature_product = $_POST['feature_product'];
    $formerror = [];
    if (empty($name)) {
        $formerror[] = ' من فضلك ادخل اسم المنتج  ';
    }
    $stmt = $connect->prepare("SELECT * FROM products_gift WHERE name = ? AND id != ? ");
    $stmt->execute(array($name, $pro_id));
    $count = $stmt->rowCount();
    if ($count > 0) {
        $formerror[] = ' اسم المنتج  موجود من قبل من فضلك ادخل اسم اخر  ';
    }
    $stmt = $connect->prepare("SELECT * FROM products_gift WHERE slug = ? AND id != ? ");
    $stmt->execute(array($slug, $pro_id));
    $count = $stmt->rowCount();
    if ($count > 0) {
        $formerror[] = ' هذا الرابط موجود بالفعل من فضلك ادخل رابط اخر  ';
    }
    if (empty($formerror)) {
        $stmt = $connect->prepare("UPDATE products_gift SET name=?,slug=?,price=?,sale_price=?,publish=?,product_status_store=?,feature_product=? WHERE id = ? ");
        $stmt->execute(array($name, $slug, $price, $sale_price, $publish, $product_status_store, $feature_product, $pro_id));
        if ($stmt) {
            $_SESSION['success_message'] = "تم التعديل بنجاح ";
            header('Location:main?dir=gift_products&page=report');
            exit();
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=gift_products&page=report');
        exit();
    }
}
