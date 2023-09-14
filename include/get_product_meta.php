<?php
include $connect_db;
$current_url = $_SERVER['REQUEST_URI'];
$keyword1 = "product";
$keyword2 = "blod_details";
$keyword3 = "land_details";
if (isset($_GET['slug']) && strpos($current_url, $keyword1) !== false) {
    $slug = $_GET['slug'];
    $stmt = $connect->prepare("SELECT * FROM products WHERE slug = ? ORDER BY id DESC LIMIT 1 ");
    $stmt->execute(array($slug));
    $product_data = $stmt->fetch();
    $count  = $stmt->rowCount();
    /* get the product meta */
    $meta_keywords = $product_data['tags'];
    $meta_short_description = $product_data['short_desc'];
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
    $meta_short_description = $product_data['description'];
}
