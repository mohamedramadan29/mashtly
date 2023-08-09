<?php
if (isset($_POST['edit_cat'])) {
    $pro_id = $_POST['pro_id'];

    $name = $_POST['name'];
    $slug = createSlug($name);
    $price = $_POST['price'];
    $sale_price = $_POST['sale_price'];
    $cat_id = $_POST['cat_id'];
    $product_status_store = $_POST['product_status_store'];
    $publish = $_POST['publish'];
    $formerror = [];
    if (empty($name)) {
        $formerror[] = ' من فضلك ادخل اسم المنتج  ';
    }
    $stmt = $connect->prepare("SELECT * FROM products WHERE name = ? AND id != ? ");
    $stmt->execute(array($name, $pro_id));
    $count = $stmt->rowCount();
    if ($count > 0) {
        $formerror[] = ' اسم القسم موجود من قبل من فضلك ادخل اسم اخر  ';
    }
    if (empty($formerror)) {
        $stmt = $connect->prepare("UPDATE products SET cat_id=?,name=?,slug=?,price=?,sale_price=?,publish=?,product_status_store=? WHERE id = ? ");
        $stmt->execute(array($cat_id, $name, $slug, $price, $sale_price, $publish, $product_status_store, $pro_id));
        if ($stmt) {
            $_SESSION['success_message'] = "تم التعديل بنجاح ";
            header('Location:main?dir=products&page=report');
            exit();
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=products&page=report');
        exit();
    }
}
