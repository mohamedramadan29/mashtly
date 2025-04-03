<?php
ob_start();
session_start();
$page_title = ' نفاصيل القسم  ';

include "init.php";

// الحصول على الجزء من العنوان بعد اسم الملف (مثل product)
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$parts = explode('/', $url);
// البحث عن قيمة المتغير بدون كلمة slug
$key = array_search('gallary', $parts);
$keyPage = array_search('page', $parts);
if ($key !== false && isset($parts[$key + 1])) {
    // يمكنك استخدام $parts[$key+1] كـ slug
    $cat_slug = $parts[$key + 1];
    $cat_slug = urldecode($cat_slug);
} else {
    // لم يتم العثور على slug
    echo "العنوان غير صحيح";
}
if ($keyPage !== false && isset($parts[$keyPage + 1])) {
    $keyPage = $parts[$keyPage + 1];
    // $keyPage = $currentpage;
    $currentpage = $keyPage;
} else {
    $currentpage = 1;
}
// echo $cat_slug;
/////////// Get The Category Data 

$stmt = $connect->prepare("SELECT * FROM categories_gallary WHERE slug =?");
$stmt->execute(array($cat_slug));
$cat_data = $stmt->fetch();
$check_cat = $stmt->rowCount();

if ($check_cat > 0) {
    $cat_id = $cat_data['id'];
}
$stmt = $connect->prepare("SELECT * FROM product_categories_gallary WHERE category_id = ? AND status = 1");
$stmt->execute(array($cat_id));
$count_images = count(($stmt->fetchAll()));
?>
<div class="profile_page adress_page">
    <div class='container'>
        <div class="data">
            <div class="breadcrump">
                <p> <a href="index"> الرئيسية </a> \ <span> <?php echo $cat_data['name'] ?> </span> </p>
            </div>
        </div>
    </div>
</div>
<!-- START POST INDEX -->
<div class='index_posts blogs gallary'>
    <div class="container">
        <div class="landscap">
            <div class="row">
                <?php
                if ($check_cat > 0) {
                    $stmt = $connect->prepare("SELECT * FROM product_categories_gallary WHERE category_id = ? AND status = 1");
                    $stmt->execute(array($cat_id));
                    $images = $stmt->fetchAll();
                    if (count($images) > 0) {
                        foreach ($images as $gallary) {
                            ?>
                            <div class="col-lg-3">
                                <a href="<?php echo $gallary['product_url'] ?>" style="text-decoration: none;">
                                    <div class="info">
                                        <img src="https://www.localhost/mashtly/uploads/gallary/<?php echo $gallary['image']; ?>"
                                            alt="<?php echo $gallary['image_alt'] ?>">
                                        <div class="heading" style="padding: 8px;">
                                            <h3 style="margin-bottom: 10px;"><?php echo $gallary['name']; ?> </h3>
                                            <p style="color: #3c3b3b;"> <?php echo $gallary['product_desc']; ?> </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <?php
                        }

                    } else {
                        ?>
                        <div class="alert alert-info"> لا يوجد صور بعد في هذا القسم </div>
                        <?php
                    }
                } else {
                    echo '<p> هناك خطا ما في هذا القسم  </p>';
                }
                ?>
            </div>
        </div>
    </div>
</div>
<!-- END  POST INDEX -->

<?php
include $tem . 'footer.php';
ob_end_flush();
?>