<?php
ob_start();
session_start();
$page_title = 'الرئيسية';
include "init.php";
$stmt = $connect->prepare("SELECT * FROM categories order by id desc");
$stmt->execute();
$allcat = $stmt->fetchAll();
$cat_count = count($allcat);
?>
<div class="profile_page new_address_page">
    <div class='container'>
        <div class="data">
            <div class="breadcrump">
                <p> <a href="index"> الرئيسية </a> \
                    <span> التصنيفات </span>
                </p>
            </div>
            <div class="purches_header">
                <div class="data_header_name">
                    <h2 class='header2'> التصنيفات </h2>
                    <p> أجمالي عدد التصنيفات : <span> <?php echo $cat_count; ?> </span> </p>
                </div>
            </div>
            <div class="main_categories">
                <div class="row">
                    <?php
                    foreach ($allcat as $cat) {
                        $cat_id = $cat['id'];
                        // count product in cat
                        $stmt = $connect->prepare("SELECT * FROM products WHERE cat_id = ? AND publish = 1 AND product_status_store = 1 AND name !='' AND price !='' ");
                        $stmt->execute(array($cat_id));
                        $allpro = $stmt->fetchAll();
                        $count_pro = count($allpro);
                        if ($count_pro > 0) {
                    ?>
                            <div class="col-6 col-lg-2">
                                <a href="product-category/<?php echo $cat['slug']; ?>">
                                    <div class="cat">
                                        <div class="main">
                                            <?php
                                            if ($cat['image'] != '') {
                                            ?>
                                                <img src="admin/category_images/<?php echo $cat['image']; ?>" alt="">
                                            <?php
                                            } else { ?>
                                                <img src="<?php echo $uploads ?>cat.png" alt="">
                                            <?php
                                            }
                                            ?>
                                            <h3> <?php echo $cat['name']; ?> </h3>
                                            <!-- <p> عدد العناصر: <?php echo $count_pro; ?> </p> -->
                                        </div>
                                        <a href="product-category/<?php echo $cat['slug']; ?>">
                                            <div class="overlay">

                                                <img src="<?php echo $uploads ?>cat_arrow.png" alt="">
                                                <h4> تصفح التصنيف </h4>

                                            </div>
                                        </a>
                                    </div>
                                </a>
                            </div>
                    <?php
                        }
                    }

                    ?>


                </div>
            </div>
        </div>
    </div>

</div>

<?php
include $tem . 'footer.php';
ob_end_flush();
?>