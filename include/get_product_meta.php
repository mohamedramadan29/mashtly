<?php
include "admin/connect.php";
if (isset($_GET['slug'])) {
    $slug = $_GET['slug'];
    $stmt = $connect->prepare("SELECT * FROM products WHERE slug = ? ORDER BY id DESC LIMIT 1 ");
    $stmt->execute(array($slug));
    $product_data = $stmt->fetch();
    $count  = $stmt->rowCount();
    /* get the product meta */
    $meta_keywords = $product_data['tags'];
    $meta_short_description = $product_data['short_desc'];
}
