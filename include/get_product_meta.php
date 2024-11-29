<?php
include $connect_db;
$current_url = $_SERVER['REQUEST_URI'];
$keyword1 = "product";
$keyword2 = "blog";
$keyword3 = "land_details";
$keyword4 = 'product-category';
$keyword5 = 'blog-categories-details';
// تقسيم الرابط بناءً على "/" والحصول على جزء الاسم بعد "product/"
$url_parts = explode('/', $current_url);
$product_index = array_search($keyword1, $url_parts);
if ($product_index !== false && isset($url_parts[$product_index + 1])) {
    // استخراج اسم المنتج بعد "product/"
    $product_name = $url_parts[$product_index + 1];
    $slug =  urldecode($product_name);
    $stmt = $connect->prepare("SELECT * FROM products WHERE slug = ? ORDER BY id DESC LIMIT 1 ");
    $stmt->execute(array($slug));
    $product_data = $stmt->fetch();
    $count  = $stmt->rowCount();
    /* get the product meta */
    $meta_keywords = $product_data['tags'];
    $meta_short_description = strip_tags($product_data['short_desc']);
    $meta_title = $product_data['name'];
    ///// get the product image
    $stmt = $connect->prepare("SELECT * FROM products_image WHERE product_id = ?");
    $stmt->execute(array($product_data['id']));
    $product_data_image = $stmt->fetch();
    $pro_image = $product_data_image['main_image'];
}
$url_parts = explode('/', $current_url);
$blog_index = array_search($keyword2, $url_parts);
if ($blog_index !== false && isset($url_parts[$blog_index + 1])) {
    $blog_name = $url_parts[$blog_index + 1];
    $slug = urldecode($blog_name);
    $stmt = $connect->prepare("SELECT * FROM posts WHERE slug = ? ORDER BY id DESC LIMIT 1 ");
    $stmt->execute(array($slug));
    $product_data = $stmt->fetch();
    $count  = $stmt->rowCount();
    /* get the product meta */
    $meta_keywords = $product_data['tags'];
    $meta_short_description = strip_tags($product_data['short_desc']);
    $meta_title = $product_data['name'];
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

$url_parts = explode('/', $current_url);
$category_index = array_search($keyword4, $url_parts);
if ($category_index !== false && isset($url_parts[$category_index + 1])) {
    $category_index = $url_parts[$category_index + 1];
    $slug = urldecode($category_index);
    $stmt = $connect->prepare("SELECT * FROM categories WHERE slug = ? ORDER BY id DESC LIMIT 1 ");
    $stmt->execute(array($slug));
    $product_data = $stmt->fetch();
    $count  = $stmt->rowCount();
    /* get the product meta */
    $meta_keywords = $product_data['tags'];
    $meta_short_description = strip_tags($product_data['description']);
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

$blog_category_index = array_search($keyword5, $url_parts);
if ($blog_category_index !== false && isset($url_parts[$blog_category_index + 1])) {
    $blog_category_index = $url_parts[$blog_category_index + 1];
    $slug = urldecode(string: $blog_category_index);
    $stmt = $connect->prepare("SELECT * FROM category_posts WHERE slug = ? ORDER BY id DESC LIMIT 1 ");
    $stmt->execute(array($slug));
    $category_data = $stmt->fetch();
    $count  = $stmt->rowCount();
    /* get the product meta */
    $meta_keywords = '';
    $meta_short_description = strip_tags($category_data['description']);
    $description = $category_data['description'];
    $description = strip_tags($description);
    $maxLength = 160;
    if (strlen($description) > $maxLength) {
        $description = substr($description, 0, $maxLength) . '...'; // Truncate and add ellipsis
    } else {
        $description = $description; // Use the full description if it's shorter than 160 characters
    }
    $meta_title = $category_data['name'];
}
