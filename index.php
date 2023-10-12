<?php
ob_start();
session_start();
$page_title = 'مشتلي - الرئيسية';
include "init.php";

?>
<div class="hero">
    <div id="carouselExampleCaptions" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <?php
            $stmt = $connect->prepare("SELECT * FROM banners ORDER BY id asc LIMIT 1");
            $stmt->execute();
            $banner1_data = $stmt->fetch();
            $banner1_data_id = $banner1_data['id'];
            $stmt = $connect->prepare("SELECT * FROM banners WHERE id !=? ");
            $stmt->execute(array($banner1_data_id));
            $allbanners = $stmt->fetchAll();
            ?>
            <div class="carousel-item carousel-item1 active">
                <div class="overlay"></div>
                <div class="carousel-caption">
                    <h5> <?php echo $banner1_data['head_name'] ?> </h5>
                    <p> <?php echo $banner1_data['description'] ?> </p>
                    <a target="_blank" href="https://t.me/mshtly" class="btn"> تواصل مع الخبير </a>
                </div>
            </div>
            <?php
            foreach ($allbanners as $banner) {
            ?>
                <div class="carousel-item carousel-item1">
                    <div class="overlay"></div>
                    <div class="carousel-caption">
                        <h5> <?php echo $banner['head_name']; ?> </h5>
                        <p> <?php echo $banner['description']; ?> </p>
                        <a target="_blank" href="https://t.me/mshtly" class="btn"> تواصل مع الخبير </a>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>
<!-- START AUTOMATIC SEARCH INDEX -->

<div class="index_automatic_search">
    <div class="container">
        <div class="data">
            <div class="row">
                <?php
                $stmt = $connect->prepare("SELECT * FROM about_home_page");
                $stmt->execute();
                $about_section = $stmt->fetch();
                $about_section_head = $about_section['head'];
                $about_section_desc = $about_section['description'];
                $about_section_image = $about_section['image'];
                ?>
                <div class="col-lg-6">
                    <div class="info info2">
                        <h2> <?php echo $about_section_head; ?> </h2>
                        <p> <?php echo $about_section_desc; ?> </p>
                        <a href="shop" class="global_button"> جرب الباحث الآلي الآن <img src="uploads/search_arrow.png" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="info">
                        <img src="admin/about_home_page/images/<?php echo $about_section_image; ?>" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END AUTOMATIC SEARCH INDEX -->
<!-- START NEWWER PRODUCTS -->
<?php
// add to favorite
if (isset($_POST['add_to_fav'])) {
    if (isset($_SESSION['user_id'])) {
        $product_id = $_POST['product_id'];
        $user_id = $_SESSION['user_id'];
        $stmt = $connect->prepare("INSERT INTO user_favourite (user_id, product_id)
        VALUES(:zuser_id, :zproduct_id)
        ");
        $stmt->execute(array(
            "zuser_id" => $user_id,
            "zproduct_id" => $product_id
        ));
        if ($stmt) {
            alertfavorite();
        }
    } else {
        header("Location:login");
    }
}
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $price = $_POST['price'];
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    } else {
        $user_id = null;
    }
    $stmt = $connect->prepare("INSERT INTO cart (user_id, cookie_id, product_id,quantity,price,total_price)
    VALUES(:zuser_id, :zcookie_id , :zproduct_id,:zquantity ,:zprice , :ztotal_price)
    ");
    $stmt->execute(array(
        "zuser_id" => $user_id,
        "zcookie_id" => $cookie_id,
        "zproduct_id" => $product_id,
        "zquantity" => 1,
        "zprice" => $price,
        "ztotal_price" => $price,
    ));
    if ($stmt) {
        alertcart();
    }
}
?>
<div class="new_producs">
    <div class="container">
        <div class="data">
            <div class="data_header">
                <div class="data_header_name">
                    <h2 class='header2'>وصلنا حديثا</h2>
                    <p>نبايات جديدة وصلتنا هذا الأسبوع</p>
                </div>
                <div>
                    <a href="shop" class='global_button btn'> تصفح المزيد </a>
                </div>
            </div>
            <div class="products" id='products'>
                <?php
                $stmt = $connect->prepare("SELECT * FROM products ORDER BY id DESC LIMIT 10");
                $stmt->execute();
                $allproduct = $stmt->fetchAll();
                foreach ($allproduct as $product) {
                ?>
                    <div class="product_info">
                        <!-- get the product image -->
                        <?php
                        $stmt = $connect->prepare("SELECT * FROM products_image WHERE product_id = ?");
                        $stmt->execute(array($product['id']));
                        //  getproductimage($connect,$product['id']);
                        $count_image = $stmt->rowCount();
                        $product_data_image = $stmt->fetch();
                        if ($count_image > 0) {
                        ?>
                            <img class="main_image" src="admin/product_images/<?php echo $product_data_image['main_image']; ?>" alt="<?php echo $product_data_image['image_alt']; ?>">
                        <?php
                        } else {
                        ?>
                            <img class="main_image" src="uploads/product.png" alt="">
                        <?php
                        }
                        ?>

                        <div class="product_details">
                            <h2> <a href="product?slug=<?php echo $product['slug']; ?>"> <?php echo $product['name']; ?> </a> </h2>
                            <?php
                            $maximumPrice = -INF; // قيمة أقصى سعر ممكنة
                            $minimumPrice = INF; // قيمة أدنى سعر ممكنة
                            // نشوف علي المنتج يحتوي علي متغيرات او لا
                            $stmt = $connect->prepare("SELECT * FROM product_details2 WHERE product_id = ? AND price != ''");
                            $stmt->execute(array($product['id']));
                            $count_pro_attr = $stmt->rowCount();
                            if ($count_pro_attr > 0) {
                                $allproduct_data = $stmt->fetchAll();
                                foreach ($allproduct_data as $product_data) {
                                    $pro_price =  $product_data['price'];
                                    $maximumPrice = max($maximumPrice, $pro_price);
                                    $minimumPrice = min($minimumPrice, $pro_price);
                                }
                            ?>
                                <h4 class='price'> <?php echo number_format($minimumPrice, 2); ?> - <?php echo number_format($maximumPrice, 2); ?> ر.س </h4>
                            <?php
                            } else {
                            ?>
                                <h4 class='price'> <?php
                                                    if ($product['sale_price'] != '' && $product['sale_price'] != 0) {
                                                        echo $product['sale_price'];
                                                    } else {
                                                        echo $product['price'];
                                                    }
                                                    ?> ر.س </h4>
                            <?php
                            }
                            ?>
                            <form action="" method="post">
                                <input type="hidden" name="price" value="<?php if ($product['sale_price'] != '' && $product['sale_price'] != 0) {
                                                                                echo $product['sale_price'];
                                                                            } else {
                                                                                echo $product['price'];
                                                                            } ?>">
                                <div class='add_cart'>
                                    <div>
                                        <?php
                                        if (checkIfProductInCart($connect, $cookie_id, $product['id'])) {
                                        ?>
                                            <a href="cart" class='btn global_button'> <img src="uploads/shopping-cart.png" alt="">
                                                مشاهدة السلة
                                            </a>
                                        <?php
                                        } else {
                                        ?>
                                            <?php
                                            if ($count_pro_attr > 0) {
                                            ?>
                                                <a href="product?slug=<?php echo $product['slug']; ?>" class='btn global_button'> <img src="uploads/shopping-cart.png" alt="">
                                                    مشاهدة الاختيارات
                                                </a>
                                            <?php
                                            } else {
                                            ?>
                                                <button name="add_to_cart" class='btn global_button'> <img src="uploads/shopping-cart.png" alt=""> أضف
                                                    الي السلة
                                                </button>
                                            <?php
                                            }
                                            ?>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="heart">
                                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                        <?php
                                        if (isset($_SESSION['user_id']) && checkIfProductIsFavourite($connect, $_SESSION['user_id'], $product['id'])) {
                                        ?>
                                            <img src="<?php echo $uploads; ?>/heart2.svg" alt="">
                                        <?php
                                        } else {
                                        ?>
                                            <button name="add_to_fav" type="submit" style="border: none; background-color:transparent">
                                                <img src="<?php echo $uploads ?>/heart.png" alt="">
                                            </button>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
<!-- END NEWWER PRODUCTS  -->
<!-- START PLANTS REQUIRES -->
<div class='planets_require_index'>
    <div class="container">
        <div class="data">
            <h2> مستلزمات العناية بنباتاتك </h2>
            <a href="categories" class="btn global_button"> تصفح جميع المستلزمات <img src="<?php echo $uploads ?>left.svg" alt=""> </a>
        </div>
    </div>
</div>
<!-- END PLANTS REQUIRES -->
<!-- START BEST PRODUCTS -->
<div class="new_producs best_products">
    <div class="container">
        <div class="data">
            <div class="data_header">
                <div class="data_header_name">
                    <h2 class='header2'> الأفضل مبيعا </h2>
                    <p> خصومات هائلة بمناسبة يوم التأسيس ويوم الحب </p>
                </div>
                <div>
                    <a href="shop" class='global_button btn'> تصفح المزيد </a>
                </div>
            </div>
            <div class="products" id='products'>
                <?php
                $stmt = $connect->prepare("SELECT * FROM products WHERE feature_product = 1 ORDER BY id DESC");
                $stmt->execute();
                $allproduct = $stmt->fetchAll();
                foreach ($allproduct as $product) {
                ?>
                    <div class="product_info">
                        <span class='badge'>الأكثر مبيعاً</span>
                        <!-- get the product image -->
                        <?php
                        $stmt = $connect->prepare("SELECT * FROM products_image WHERE product_id = ?");
                        $stmt->execute(array($product['id']));
                        //  getproductimage($connect,$product['id']);
                        $count_image = $stmt->rowCount();
                        $product_data_image = $stmt->fetch();
                        if ($count_image > 0) {
                        ?>
                            <img class="main_image" src="admin/product_images/<?php echo $product_data_image['main_image']; ?>" alt="<?php echo $product_data_image['image_alt']; ?>">
                        <?php
                        } else {
                        ?>
                            <img class="main_image" src="uploads/product.png" alt="">
                        <?php
                        }
                        ?>

                        <div class="product_details">
                            <h2> <a href="product?slug=<?php echo $product['slug']; ?>"> <?php echo $product['name']; ?> </a> </h2>
                            <?php
                            $maximumPrice = -INF; // قيمة أقصى سعر ممكنة
                            $minimumPrice = INF; // قيمة أدنى سعر ممكنة
                            // نشوف علي المنتج يحتوي علي متغيرات او لا
                            $stmt = $connect->prepare("SELECT * FROM product_details2 WHERE product_id = ? AND price != ''");
                            $stmt->execute(array($product['id']));
                            $count_pro_attr = $stmt->rowCount();
                            if ($count_pro_attr > 0) {
                                $allproduct_data = $stmt->fetchAll();
                                foreach ($allproduct_data as $product_data) {
                                    $pro_price =  $product_data['price'];
                                    $maximumPrice = max($maximumPrice, $pro_price);
                                    $minimumPrice = min($minimumPrice, $pro_price);
                                }
                            ?>
                                <h4 class='price'> <?php echo number_format($minimumPrice, 2); ?> - <?php echo number_format($maximumPrice, 2); ?> ر.س </h4>
                            <?php
                            } else {
                            ?>
                                <h4 class='price'> <?php
                                                    if ($product['sale_price'] != '' && $product['sale_price'] != 0) {
                                                        echo $product['sale_price'];
                                                    } else {
                                                        echo $product['price'];
                                                    }
                                                    ?> ر.س </h4>
                            <?php
                            }
                            ?>
                            <form action="" method="post">
                                <input type="hidden" name="price" value="<?php if ($product['sale_price'] != '' && $product['sale_price'] != 0) {
                                                                                echo $product['sale_price'];
                                                                            } else {
                                                                                echo $product['price'];
                                                                            } ?>">
                                <div class='add_cart'>
                                    <div>
                                        <?php
                                        if (checkIfProductInCart($connect, $cookie_id, $product['id'])) {
                                        ?>
                                            <a href="cart" class='btn global_button'> <img src="uploads/shopping-cart.png" alt="">
                                                مشاهدة السلة
                                            </a>
                                        <?php
                                        } else {
                                        ?>
                                            <?php
                                            if ($count_pro_attr > 0) {
                                            ?>
                                                <a href="product?slug=<?php echo $product['slug']; ?>" class='btn global_button'> <img src="uploads/shopping-cart.png" alt="">
                                                    مشاهدة الاختيارات
                                                </a>
                                            <?php
                                            } else {
                                            ?>
                                                <button name="add_to_cart" class='btn global_button'> <img src="uploads/shopping-cart.png" alt=""> أضف
                                                    الي السلة
                                                </button>
                                            <?php
                                            }
                                            ?>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="heart">
                                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                        <?php
                                        if (isset($_SESSION['user_id']) && checkIfProductIsFavourite($connect, $_SESSION['user_id'], $product['id'])) {
                                        ?>
                                            <img src="<?php echo $uploads; ?>/heart2.svg" alt="">
                                        <?php
                                        } else {
                                        ?>
                                            <button name="add_to_fav" type="submit" style="border: none; background-color:transparent">
                                                <img src="<?php echo $uploads ?>/heart.png" alt="">
                                            </button>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
<!-- END BEST  PRODUCTS  -->
<!-- START INDEX ALL CATEGORY  -->
<div class="index_all_cat index_categories" id="categories">
    <div class="container">
        <div class="data">
            <div class="data_header_name">
                <h2 class='header2'> جميع التصنيفات </h2>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <div class="all_cat">
                        <ul class="list-unstyled">
                            <?php
                            $stmt = $connect->prepare("SELECT * FROM categories");
                            $stmt->execute();
                            $allcats = $stmt->fetchAll();
                            foreach ($allcats as $cat) {
                            ?>
                                <li> <a data-section="categories" href="category_products?cat=<?php echo $cat['slug']; ?>"> <?php echo $cat['name']; ?> </a> </li>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="row">
                        <?php
                        $stmt = $connect->prepare("SELECT * FROM products order by id ASC LIMIT 9");
                        $stmt->execute();
                        $allproducts  = $stmt->fetchAll();
                        foreach ($allproducts as $product) {
                        ?>
                            <div class="col-lg-4">
                                <div class="product_info">
                                    <!-- get the product image -->
                                    <?php
                                    $stmt = $connect->prepare("SELECT * FROM products_image WHERE product_id = ?");
                                    $stmt->execute(array($product['id']));
                                    //  getproductimage($connect,$product['id']);
                                    $count_image = $stmt->rowCount();
                                    $product_data_image = $stmt->fetch();
                                    if ($count_image > 0) {
                                    ?>
                                        <img class="main_image" src="admin/product_images/<?php echo $product_data_image['main_image']; ?>" alt="<?php echo $product_data_image['image_alt']; ?>">
                                    <?php
                                    } else {
                                    ?>
                                        <img class="main_image" src="uploads/product.png" alt="">
                                    <?php
                                    }
                                    ?>
                                    <div class="product_details">
                                        <h2> <a href="product?slug=<?php echo $product['slug']; ?>"> <?php echo $product['name']; ?> </a> </h2>
                                        <?php
                                        $maximumPrice = -INF; // قيمة أقصى سعر ممكنة
                                        $minimumPrice = INF; // قيمة أدنى سعر ممكنة
                                        // نشوف علي المنتج يحتوي علي متغيرات او لا
                                        $stmt = $connect->prepare("SELECT * FROM product_details2 WHERE product_id = ? AND price != ''");
                                        $stmt->execute(array($product['id']));
                                        $count_pro_attr = $stmt->rowCount();
                                        if ($count_pro_attr > 0) {
                                            $allproduct_data = $stmt->fetchAll();
                                            foreach ($allproduct_data as $product_data) {
                                                $pro_price =  $product_data['price'];
                                                $maximumPrice = max($maximumPrice, $pro_price);
                                                $minimumPrice = min($minimumPrice, $pro_price);
                                            }
                                        ?>
                                            <h4 class='price'> <?php echo number_format($minimumPrice, 2); ?> - <?php echo number_format($maximumPrice, 2); ?> ر.س </h4>
                                        <?php
                                        } else {
                                        ?>
                                            <h4 class='price'> <?php
                                                                if ($product['sale_price'] != '' && $product['sale_price'] != 0) {
                                                                    echo $product['sale_price'];
                                                                } else {
                                                                    echo $product['price'];
                                                                }
                                                                ?> ر.س </h4>
                                        <?php
                                        }
                                        ?>
                                        <form action="" method="post">
                                            <input type="hidden" name="price" value="<?php if ($product['sale_price'] != '' && $product['sale_price'] != 0) {
                                                                                            echo $product['sale_price'];
                                                                                        } else {
                                                                                            echo $product['price'];
                                                                                        } ?>">
                                            <div class='add_cart'>
                                                <div>
                                                    <?php
                                                    if (checkIfProductInCart($connect, $cookie_id, $product['id'])) {
                                                    ?>
                                                        <a href="cart" class='btn global_button'> <img src="uploads/shopping-cart.png" alt="">
                                                            مشاهدة السلة
                                                        </a>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <?php
                                                        if ($count_pro_attr > 0) {
                                                        ?>
                                                            <a href="product?slug=<?php echo $product['slug']; ?>" class='btn global_button' style="font-size: 12px;"> <img src="uploads/shopping-cart.png" alt="">
                                                                مشاهدة الاختيارات
                                                            </a>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <button name="add_to_cart" class='btn global_button'> <img src="uploads/shopping-cart.png" alt=""> أضف
                                                                الي السلة
                                                            </button>
                                                        <?php
                                                        }
                                                        ?>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                                <div class="heart">
                                                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                                    <?php
                                                    if (isset($_SESSION['user_id']) && checkIfProductIsFavourite($connect, $_SESSION['user_id'], $product['id'])) {
                                                    ?>
                                                        <img src="<?php echo $uploads; ?>/heart2.svg" alt="">
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <button name="add_to_fav" type="submit" style="border: none; background-color:transparent">
                                                            <img src="<?php echo $uploads ?>/heart.png" alt="">
                                                        </button>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        /*
                        } else {
                            echo "No";
                        }*/
                        ?>
                    </div>
                    <a href="shop" class='global_button btn more_button'> تصفح المزيد </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END INDEX ALL CATEGORY  -->
<!-- START GARDEN SERVICES -->
<div class="garden_services">
    <div class="container">
        <div class="data">
            <div class="row">
                <div class="col-lg-6">
                    <div class="info info1">
                        <h3> خدمات الحدائق </h3>
                        <a href="landscap" class="btn global_button"> اعرف المزيد <img src="<?php echo $uploads; ?>/arrow_left.svg" alt=""> </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="info info2">
                        <h3> الطلبات الكبيرة </h3>
                        <a href="big_orders" class="btn global_button"> اعرف المزيد <img src="<?php echo $uploads; ?>/right-arrow-2.svg" alt=""> </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END GARDEN SERVICES -->
<!-- START BEST PRODUCTS -->
<div class="new_producs product_discounts best_products">
    <div class="container">
        <div class="data">
            <div class="data_header">
                <div class="data_header_name">
                    <h2 class='header2'> عروض وخصومات </h2>
                    <p> خصومات هائلة بمناسبة يوم التأسيس ويوم الحب </p>
                </div>
                <div>
                    <a href="shop" class='global_button btn'> تصفح المزيد </a>
                </div>
            </div>
            <div class="products" id='products'>
                <?php
                $stmt = $connect->prepare("SELECT * FROM products WHERE sale_price!=0 OR sale_price !=null ORDER BY id DESC LIMIT 10");
                $stmt->execute();
                $allproduct = $stmt->fetchAll();
                foreach ($allproduct as $product) {
                ?>
                    <div class="product_info">
                        <!-- get the product image -->
                        <?php
                        $stmt = $connect->prepare("SELECT * FROM products_image WHERE product_id = ?");
                        $stmt->execute(array($product['id']));
                        //  getproductimage($connect,$product['id']);
                        $count_image = $stmt->rowCount();
                        $product_data_image = $stmt->fetch();
                        if ($count_image > 0) {
                        ?>
                            <img class="main_image" src="admin/product_images/<?php echo $product_data_image['main_image']; ?>" alt="<?php echo $product_data_image['image_alt']; ?>">
                        <?php
                        } else {
                        ?>
                            <img class="main_image" src="uploads/product.png" alt="">
                        <?php
                        }
                        ?>

                        <div class="product_details">
                            <h2> <a href="product?slug=<?php echo $product['slug']; ?>"> <?php echo $product['name']; ?> </a> </h2>
                            <?php
                            $maximumPrice = -INF; // قيمة أقصى سعر ممكنة
                            $minimumPrice = INF; // قيمة أدنى سعر ممكنة
                            // نشوف علي المنتج يحتوي علي متغيرات او لا
                            $stmt = $connect->prepare("SELECT * FROM product_details2 WHERE product_id = ? AND price != ''");
                            $stmt->execute(array($product['id']));
                            $count_pro_attr = $stmt->rowCount();
                            if ($count_pro_attr > 0) {
                                $allproduct_data = $stmt->fetchAll();
                                foreach ($allproduct_data as $product_data) {
                                    $pro_price =  $product_data['price'];
                                    $maximumPrice = max($maximumPrice, $pro_price);
                                    $minimumPrice = min($minimumPrice, $pro_price);
                                }
                            ?>
                                <h4 class='price'> <?php echo number_format($minimumPrice, 2); ?> - <?php echo number_format($maximumPrice, 2); ?> ر.س </h4>
                            <?php
                            } else {
                            ?>
                                <div class='price_diffrent'>
                                    <h4 class='price'><?php echo number_format($product['sale_price'], 2) ?> ر.س </h4>
                                    <h4 class='old'> <?php echo number_format($product['price'], 2) ?> ر.س </h4>
                                </div>
                            <?php
                            }
                            ?>
                            <form action="" method="post">
                                <input type="hidden" name="price" value="<?php if ($product['sale_price'] != '' && $product['sale_price'] != 0) {
                                                                                echo $product['sale_price'];
                                                                            } else {
                                                                                echo $product['price'];
                                                                            } ?>">
                                <div class='add_cart'>
                                    <div>
                                        <?php
                                        if (checkIfProductInCart($connect, $cookie_id, $product['id'])) {
                                        ?>
                                            <a href="cart" class='btn global_button'> <img src="uploads/shopping-cart.png" alt="">
                                                مشاهدة السلة
                                            </a>
                                        <?php
                                        } else {
                                        ?>
                                            <?php
                                            if ($count_pro_attr > 0) {
                                            ?>
                                                <a href="product?slug=<?php echo $product['slug']; ?>" class='btn global_button'> <img src="uploads/shopping-cart.png" alt="">
                                                    مشاهدة الاختيارات
                                                </a>
                                            <?php
                                            } else {
                                            ?>
                                                <button name="add_to_cart" class='btn global_button'> <img src="uploads/shopping-cart.png" alt=""> أضف
                                                    الي السلة
                                                </button>
                                            <?php
                                            }
                                            ?>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="heart">
                                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                        <?php
                                        if (isset($_SESSION['user_id']) && checkIfProductIsFavourite($connect, $_SESSION['user_id'], $product['id'])) {
                                        ?>
                                            <img src="<?php echo $uploads; ?>/heart2.svg" alt="">
                                        <?php
                                        } else {
                                        ?>
                                            <button name="add_to_fav" type="submit" style="border: none; background-color:transparent">
                                                <img src="<?php echo $uploads ?>/heart.png" alt="">
                                            </button>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
<!-- END BEST  PRODUCTS  -->
<!-- START EXPERT CONNECT -->
<div class='expert_connect'>
    <div class='container'>
        <div class="data">
            <div class='row'>
                <div class="col-lg-5">
                    <div class="info">
                        <h2>تواصل مع الخبير <br> للعناية بنباتاتك المنزلية</h2>
                        <p> يرغب في تمتعك بنباتات صحية ونامية، وأن تتوفق لأفضل المنتجات المناسبة لك ,لذلك وفرنا خبراء
                            متخصصين بالهندسة الزراعية لتقديم الدعم والتوجيه، ولنساعدك في اختيار النباتات </p>
                        <a target="_blank" href="https://t.me/mshtly" class="btn global_button">تواصل مع الخبير</a>
                    </div>
                </div>
                <div class='col-lg-7'>
                    <div class='image'>
                        <img src="uploads/points.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END EXPERT CONNECT -->
<!-- START NEW DECORE  -->
<div class="new_producs best_products">
    <div class="container">
        <div class="data">
            <div class="data_header">
                <div class="data_header_name">
                    <h2 class='header2'> غيري شكل بيتك - النباتات المنزلية </h2>
                    <p> النباتات المنزلية الداخلية تفعل الكثير أما الخارجية فتصنع السحر </p>
                </div>
                <div>
                    <a href="category_products?cat=النباتات-الداخلية" class='global_button btn'> تصفح المزيد </a>
                </div>
            </div>
            <!-- قسم النباتات الداخلية  -->
            <div class="products" id='products'>
                <?php
                $stmt = $connect->prepare("SELECT * FROM products WHERE cat_id = 227 ORDER BY id DESC LIMIT 10");
                $stmt->execute();
                $allproduct = $stmt->fetchAll();
                foreach ($allproduct as $product) {
                ?>
                    <div class="product_info">
                        <!-- get the product image -->
                        <?php
                        $stmt = $connect->prepare("SELECT * FROM products_image WHERE product_id = ?");
                        $stmt->execute(array($product['id']));
                        //  getproductimage($connect,$product['id']);
                        $count_image = $stmt->rowCount();
                        $product_data_image = $stmt->fetch();
                        if ($count_image > 0) {
                        ?>
                            <img class="main_image" src="admin/product_images/<?php echo $product_data_image['main_image']; ?>" alt="<?php echo $product_data_image['image_alt']; ?>">
                        <?php
                        } else {
                        ?>
                            <img class="main_image" src="uploads/product.png" alt="">
                        <?php
                        }
                        ?>

                        <div class="product_details">
                            <h2> <a href="product?slug=<?php echo $product['slug']; ?>"> <?php echo $product['name']; ?> </a> </h2>
                            <?php
                            $maximumPrice = -INF; // قيمة أقصى سعر ممكنة
                            $minimumPrice = INF; // قيمة أدنى سعر ممكنة
                            // نشوف علي المنتج يحتوي علي متغيرات او لا
                            $stmt = $connect->prepare("SELECT * FROM product_details2 WHERE product_id = ? AND price != ''");
                            $stmt->execute(array($product['id']));
                            $count_pro_attr = $stmt->rowCount();
                            if ($count_pro_attr > 0) {
                                $allproduct_data = $stmt->fetchAll();
                                foreach ($allproduct_data as $product_data) {
                                    $pro_price =  $product_data['price'];
                                    $maximumPrice = max($maximumPrice, $pro_price);
                                    $minimumPrice = min($minimumPrice, $pro_price);
                                }
                            ?>
                                <h4 class='price'> <?php echo number_format($minimumPrice, 2); ?> - <?php echo number_format($maximumPrice, 2); ?> ر.س </h4>
                            <?php
                            } else {
                            ?>
                                <h4 class='price'> <?php
                                                    if ($product['sale_price'] != '' && $product['sale_price'] != 0) {
                                                        echo $product['sale_price'];
                                                    } else {
                                                        echo $product['price'];
                                                    }
                                                    ?> ر.س </h4>
                            <?php
                            }
                            ?>
                            <form action="" method="post">
                                <input type="hidden" name="price" value="<?php if ($product['sale_price'] != '' && $product['sale_price'] != 0) {
                                                                                echo $product['sale_price'];
                                                                            } else {
                                                                                echo $product['price'];
                                                                            } ?>">
                                <div class='add_cart'>
                                    <div>
                                        <?php
                                        if (checkIfProductInCart($connect, $cookie_id, $product['id'])) {
                                        ?>
                                            <a href="cart" class='btn global_button'> <img src="uploads/shopping-cart.png" alt="">
                                                مشاهدة السلة
                                            </a>
                                        <?php
                                        } else {
                                        ?>
                                            <?php
                                            if ($count_pro_attr > 0) {
                                            ?>
                                                <a href="product?slug=<?php echo $product['slug']; ?>" class='btn global_button'> <img src="uploads/shopping-cart.png" alt="">
                                                    مشاهدة الاختيارات
                                                </a>
                                            <?php
                                            } else {
                                            ?>
                                                <button name="add_to_cart" class='btn global_button'> <img src="uploads/shopping-cart.png" alt=""> أضف
                                                    الي السلة
                                                </button>
                                            <?php
                                            }
                                            ?>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="heart">
                                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                        <?php
                                        if (isset($_SESSION['user_id']) && checkIfProductIsFavourite($connect, $_SESSION['user_id'], $product['id'])) {
                                        ?>
                                            <img src="<?php echo $uploads; ?>/heart2.svg" alt="">
                                        <?php
                                        } else {
                                        ?>
                                            <button name="add_to_fav" type="submit" style="border: none; background-color:transparent">
                                                <img src="<?php echo $uploads ?>/heart.png" alt="">
                                            </button>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
<!-- END  NEW DECORE  -->
<!-- START WHY MASHTLY -->
<div class="why_mashtly">
    <div class='container'>
        <div class="data">
            <div class="data_header_name">
                <h2 class='header2'> لماذا مشتلي </h2>
                <p> مزايا وخدمات موقع مشتلي، تستحق الإهتمام </p>
            </div>
            <div class='row'>
                <div class='col-lg-3 col-6'>
                    <div class="info">
                        <img src="uploads/cash_on_delivery.webp" alt="">
                        <h4> الدفع عند الاستلام </h4>
                        <p> حاليا داخل الرياض فقط </p>
                    </div>
                </div>
                <div class='col-lg-3 col-6'>
                    <div class="info">
                        <img src="uploads/to_home2.svg" alt="">
                        <h4> التوصيل الى المنزل </h4>
                        <p> حاليا داخل الرياض فقط </p>
                    </div>
                </div>
                <div class='col-lg-3 col-6'>
                    <div class="info">
                        <img src="uploads/hary_delievry.svg" alt="">
                        <h4> توصيل سريع </h4>
                        <p> من 2- 6 أيام عمل </p>
                    </div>
                </div>
                <div class='col-lg-3 col-6'>
                    <div class="info">
                        <img src="uploads/phone_contact.svg" alt="">
                        <h4> تواصل معنا </h4>
                        <p> 0530047542 </p>
                    </div>
                </div>
                <div class='col-lg-3 col-6'>
                    <div class="info">
                        <img src="uploads/cus_services.svg" alt="">
                        <h4> دعم الخبراء </h4>
                        <p> مجانا قبل وبعد الشراء </p>
                    </div>
                </div>
                <div class='col-lg-3 col-6'>
                    <div class="info">
                        <img src="uploads/quality.svg" alt="">
                        <h4> ضمان غير محدود </h4>
                        <p> نضمن لك استلام نباتات سليمة وصحية </p>
                    </div>
                </div>
                <div class='col-lg-3 col-6'>
                    <div class="info">
                        <img src="uploads/down_price.svg" alt="">
                        <h4> أسعار تنافسية </h4>
                        <p> أسعارنا لا تقبل المنافسة </p>
                    </div>
                </div>
                <div class='col-lg-3 col-6'>
                    <div class="info">
                        <img src="uploads/plants_requirement.svg" alt="">
                        <h4> مستلزمات الزراعة </h4>
                        <p> جميع المستلزمات الزراعية التي قد تحتاجها </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END WHY MASHTLY -->

<!-- START POST INDEX -->
<div class='index_posts'>
    <div class="container">
        <div class="data">
            <?php
            $stmt = $connect->prepare("SELECT * FROM posts WHERE publish = 1 ORDER BY id DESC LIMIT 1");
            $stmt->execute();
            $last_post = $stmt->fetch();
            $post_id = $last_post['id'];
            $post_head = $last_post['name'];
            $post_desc = $last_post['description'];
            $post_desc = explode(' ', $post_desc);
            // استخدم array_slice للحصول على أول 10 كلمات
            $post_desc_last = implode(' ', array_slice($post_desc, 0, 80));
            $post_short_desc = $last_post['short_desc'];
            $post_date = $last_post['date'];
            $post_slug = $last_post['slug'];
            $post_image = $last_post['main_image'];
            ?>
            <div class='row'>
                <div class="col-lg-6">
                    <div class="info">
                        <img src="admin/posts/images/<?php echo $post_image; ?>" alt="">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="info">
                        <span> من المدونة </span>
                        <h3> <?php echo $post_head; ?> </h3>
                        <p> <?php echo $post_desc_last . '...' ?> </p>
                        <a href='blog_details?slug=<?php echo $post_slug; ?>' class='btn global_button'> اقرأ المزيد </a>
                    </div>
                </div>
            </div>
            <div class='from_blog'>
                <div class='row'>
                    <?php
                    $stmt = $connect->prepare("SELECT * FROM posts WHERE publish = 1 AND id !=?");
                    $stmt->execute(array($post_id));
                    $allposts = $stmt->fetchAll();
                    foreach ($allposts as $post) {
                        $post_desc = explode(' ', $post['description']);
                        $post_desc = implode(' ', array_slice($post_desc, 0, 20));
                    ?>
                        <div class="col-lg-3">
                            <a href="blog_details?slug=<?php echo $post['slug']; ?>" style="text-decoration: none;">
                                <div class="post_info">
                                    <img src="admin/posts/images/<?php echo $post['main_image'] ?>" alt="">
                                    <h4> <?php echo $post['name']; ?> </h4>
                                    <p> <?php echo $post_desc . "..."; ?> </p>
                                </div>
                            </a>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END  POST INDEX -->
<!-- START INDEX VIDEO  -->
<div class='index_video'>
    <div class='container'>
        <div class='data'>
            <div class="row">
                <div class="col-lg-8">
                    <div class="info">
                        <div class="plyr__video-embed" id="player">
                            <iframe width="400px" height="400px" data-poster="uploads/poster.webp" src="https://www.youtube.com/watch?v=MALvzJsQ2ys" allowfullscreen allowtransparency allow="autoplay"></iframe>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="info">
                        <div class='video_data'>
                            <img class="image1" src="uploads/points.png" alt="">
                            <img class="image2" src="uploads/points.png" alt="">
                            <span>
                                فيديوهات ومقاطع مميزه
                            </span>
                            <img class="arrow" src="uploads/arrow.png" alt="">
                            <h2>كيف تغرس </br> الأشجار و النباتات الجديدة </h2>
                            <a href="https://www.youtube.com/channel/UCa-0QzwA1e3hGp-nrQn0qNg" class='btn global_button'> جميع الفيديوهات <img src="uploads/arrow.png" alt=""> </a>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!--- END INDEX VIDEO  -->
<!-- START CUSTOMER TESTMON -->
<div class='testmonails'>
    <div class="container">
        <div class="data">
            <div class="data_header_name">
                <h2 class='header2'> آراء العملاء </h2>
                <p> ماذا يقول عملائنا عن منتجات مشتلي </p>
            </div>
            <div class="testmon" id='testmon'>
                <?php
                $stmt = $connect->prepare("SELECT * FROM testmonails");
                $stmt->execute();
                $alltest = $stmt->fetchAll();
                foreach ($alltest as $test) {
                ?>
                    <div class="person_info">
                        <div class='head'>
                            <div>
                                <h3> <?php echo $test['head']; ?> </h3>
                            </div>
                            <div>
                                <img src="uploads/quote.svg" alt="">
                            </div>
                        </div>
                        <p>
                            <?php echo $test['description']; ?>
                        </p>
                        <div class='foo'>
                            <div>
                                <?php
                                if ($test['image'] != '') {
                                ?>
                                    <img src="admin/testmonails/images/<?php echo $test['image']; ?>" alt="">
                                <?php
                                } else {
                                ?>
                                    <img src="uploads/person.png" alt="">
                                <?php
                                }
                                ?>
                            </div>
                            <div>
                                <h5> <?php echo $test['name']; ?> </h5>
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
<div class="instagrame_footer">
    <div class="container">
        <div class="data">
            <h2> شاركينا جمال بيتك - نباتات الحديقة </h2>
            <p> أرسلي صور حديقة منزلك ونباتات حديقتك عبر انستجرام وسوف تظهر هنا </p>
            <div class="insta_slider">
                <div class="insta_info">
                    <img src="<?php echo $uploads ?>/insta1.png" alt="">
                    <div class="overlay">
                        <img src="<?php echo $uploads ?>/insta_share_icon.svg" alt="">
                    </div>
                </div>
                <div class="insta_info">
                    <img src="<?php echo $uploads ?>/insta2.png" alt="">
                    <div class="overlay">
                        <img src="<?php echo $uploads ?>/insta_share_icon.svg" alt="">
                    </div>
                </div>
                <div class="insta_info">
                    <img src="<?php echo $uploads ?>/insta3.png" alt="">
                    <div class="overlay">
                        <img src="<?php echo $uploads ?>/insta_share_icon.svg" alt="">
                    </div>
                </div>
                <div class="insta_info">
                    <img src="<?php echo $uploads ?>/insta2.png" alt="">
                    <div class="overlay">
                        <img src="<?php echo $uploads ?>/insta_share_icon.svg" alt="">
                    </div>
                </div>
                <div class="insta_info">
                    <img src="<?php echo $uploads ?>/insta1.png" alt="">
                    <div class="overlay">
                        <img src="<?php echo $uploads ?>/insta_share_icon.svg" alt="">
                    </div>
                </div>
                <div class="insta_info">
                    <img src="<?php echo $uploads ?>/insta2.png" alt="">
                    <div class="overlay">
                        <img src="<?php echo $uploads ?>/insta_share_icon.svg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php
include $tem . 'footer.php';
ob_end_flush();
?>