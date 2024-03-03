<?php
include $connect_db;
$current_url = $_SERVER['REQUEST_URI'];
$keyword1 = "product";
$keyword2 = "blod_details";
$keyword3 = "land_details";
$keyword4 = 'category_products';
if (isset($_GET['slug']) && strpos($current_url, $keyword1) !== false) {
    $slug = $_GET['slug'];
    $stmt = $connect->prepare("SELECT * FROM products WHERE slug = ? ORDER BY id DESC LIMIT 1 ");
    $stmt->execute(array($slug));
    $product_data = $stmt->fetch();
    $count  = $stmt->rowCount();
    /* get the product meta */
    $meta_keywords = $product_data['tags'];
    $meta_short_description = $product_data['short_desc'];
    $meta_title = $product_data['name'];
}
if (isset($_GET['slug']) && strpos($current_url, $keyword2) !== false) {
    $slug = $_GET['slug'];
    $stmt = $connect->prepare("SELECT * FROM posts WHERE slug = ? ORDER BY id DESC LIMIT 1 ");
    $stmt->execute(array($slug));
    $product_data = $stmt->fetch();
    $count  = $stmt->rowCount();
    /* get the product meta */
    $meta_keywords = $product_data['tags'];
    $meta_short_description = $product_data['short_desc'];
}
if (isset($_GET['slug']) && strpos($current_url, $keyword3) !== false) {
    $slug = $_GET['slug'];
    $stmt = $connect->prepare("SELECT * FROM landscap WHERE slug = ? ORDER BY id DESC LIMIT 1 ");
    $stmt->execute(array($slug));
    $product_data = $stmt->fetch();
    $count  = $stmt->rowCount();
    /* get the product meta */
    $meta_keywords = $product_data['tags'];
    $meta_short_description = $product_data['short_desc'];
    $meta_title = $product_data['name'];
}
if (isset($_GET['cat']) && strpos($current_url, $keyword4) !== false) {
    $slug = $_GET['cat'];
    $stmt = $connect->prepare("SELECT * FROM categories WHERE slug = ? ORDER BY id DESC LIMIT 1 ");
    $stmt->execute(array($slug));
    $product_data = $stmt->fetch();
    $count  = $stmt->rowCount();
    /* get the product meta */
    $meta_keywords = $product_data['tags'];
    $meta_short_description =  $product_data['description'];
    $description = $product_data['description'];
    $description = strip_tags($description);
    $maxLength = 160;

    if (strlen($description) > $maxLength) {
        $description = substr($description, 0, $maxLength) . '...'; // Truncate and add ellipsis
    } else {
        $description = $description; // Use the full description if it's shorter than 160 characters
    }
    $meta_title = $product_data['name'];
}
