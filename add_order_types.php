<?php

include "init.php";

$orders = $connect->prepare("SELECT * FROM orders ORDER BY id DESC LIMIT 10");
$orders->execute();
$orders_data = $orders->fetchAll();

foreach ($orders_data as $order) {

    $order_details = $connect->prepare('SELECT * FROM order_details WHERE order_id = ?');
    $order_details->execute(array($order['id']));
    $allitems = $order_details->fetchAll();
    $ship_type = [];
    foreach ($allitems as $item) {
        $stmt = $connect->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute(array($item['product_id']));
        $product_data_ship = $stmt->fetch();
        $stmt = $connect->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->execute(array($product_data_ship['cat_id']));
        $category_data = $stmt->fetch();
        $category_type = $category_data['main_category'];
        if ($category_type == 1) {
            $ship_type[] = 1;
        } elseif ($category_type == 2) {
            $ship_type[] = 2;
        }
        // تحديد نوع الشحنة بناءً على فئة المنتج
if (in_array('1', $ship_type) && in_array('2', $ship_type)) {
    $ship_type_data = 'مختلطة نباتات ومستلزمات';

} elseif (in_array('1', $ship_type)) {
    $ship_type_data = 'نباتات';
} elseif (in_array('2', $ship_type)) {
    $ship_type_data = 'مستلزمات';
} else {
    $ship_type_data = '';
}
    }
    $stmt = $connect->prepare("UPDATE orders SET order_type = ? WHERE id = ?");
    $stmt->execute(array($ship_type_data, $order['id']));
}
?>