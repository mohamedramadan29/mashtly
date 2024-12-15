<?php
ob_start();
session_start();
$page_title = ' مشتلي - تصنيفات المدونة   ';
$description = ' اقسام المدونة  ';
$page_keywords = '  مشتلي , تصنيفات المدونة   ';
include "init.php";

// احصل على الرابط الكامل
$current_url = $_SERVER['REQUEST_URI'];

// التحقق من وجود الأجزاء الإضافية
if (strpos($current_url, '?cat=index.php/index') !== false) {
    // إذا كان الرابط يحتوي على "?cat=index.php/index"، قم بإعادة التوجيه إلى الرابط الصحيح
    $correct_url = "/blog-category";
    header("Location: $correct_url", true, 301);
    exit;
}

?>
<div class="profile_page adress_page">
    <div class='container'>
        <div class="data">
            <div class="breadcrump">
                <p> <a href="index"> الرئيسية </a> \ <span> تصنيفات المدونة </span> </p>
            </div>
            <div class="purches_header">
                <div class="data_header_name">
                    <h2 class='header2'> تصنيفات المدونة </h2>
                </div>
            </div>
        </div>
        <div class="landscap">
            <div class="row">
                <?php
                // get all landscap design
                $stmt = $connect->prepare("SELECT * FROM category_posts order by id DESC");
                $stmt->execute();
                $allcat = $stmt->fetchAll();
                foreach ($allcat as $cat) {
                    ?>
                    <div class="col-lg-3">
                        <div class="info">
                            <img src="admin/post_categories/images/<?php echo $cat['main_image'] ?>"
                                alt="<?php echo $cat['name'] ?>">
                            <div class="heading">
                                <h3> <?php echo $cat['name']; ?> </h3>
                                <p>
                                    <?php
                                    $words = explode(' ', $cat['description']);
                                    $first_20_words = array_slice($words, 0, 20);
                                    echo implode(' ', $first_20_words) . '...';
                                    ?>
                                </p>
                                <a href="blog-categories-details/<?php echo $cat['slug']; ?>" class="global_button">
                                    المقالات </a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>

            </div>
        </div>
    </div>

</div>
<?php
include $tem . 'footer.php';
ob_end_flush();
?>