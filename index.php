<?php
ob_start();
session_start();
$page_title = 'الرئيسية';
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
            <div class="carousel-item carousel-item1 active">
                <div class="overlay"></div>
                <div class="carousel-caption">
                    <h5>العناية بالنباتات المنزلية 1 </h5>
                    <p> يرغب في تمتعك بنباتات صحية ونامية، وأن تتوفق لأفضل المنتجات المناسبة لك ,لذلك وفرنا خبراء
                        متخصصين بالهندسة الزراعية لتقديم الدعم والتوجيه، ولنساعدك في اختيار النباتات </p>
                    <a href="#" class="btn"> تواصل مع الخبير </a>
                </div>
            </div>
            <div class="carousel-item carousel-item1">
                <div class="overlay"></div>
                <div class="carousel-caption">
                    <h5> العناية بالنباتات المنزلية 2 </h5>
                    <p>يرغب في تمتعك بنباتات صحية ونامية، وأن تتوفق لأفضل المنتجات المناسبة لك ,لذلك وفرنا خبراء متخصصين
                        بالهندسة الزراعية لتقديم الدعم والتوجيه، ولنساعدك في اختيار
                    </p>
                    <a href="#" class="btn"> تواصل مع الخبير </a>
                </div>
            </div>
            <div class="carousel-item carousel-item1">
                <div class="overlay"></div>
                <div class="carousel-caption">
                    <h5> العناية بالنباتات المنزلية 3</h5>
                    <p> يرغب في تمتعك بنباتات صحية ونامية، وأن تتوفق لأفضل المنتجات المناسبة لك ,لذلك وفرنا خبراء
                        متخصصين بالهندسة الزراعية لتقديم الدعم والتوجيه، ولنساعدك في اختيار النباتات </p>
                    <a href="#" class="btn global_buttom"> تواصل مع الخبير </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- START AUTOMATIC SEARCH INDEX -->

<div class="index_automatic_search">
    <div class="container">
        <div class="data">
            <div class="row">
                <div class="col-lg-6">
                    <div class="info info2">
                        <h2> استخدم باحث مشتلي الآلي </h2>
                        <p> إن تحديد المواصفات المرغوبة بشكل مسبق في النباتات التي تبحث عنها سيسهل عليك الوصول إليها
                            ويساعدك في اختيار الأنسب، سواء كنت تبحث عن نبات يمتاز بشكل جمالي معين أو بسهولة العناية أو
                            لاستخدامه في مكان محدد أو يتحمل ضروف بيئية معينة …. أو غير ذالك. </p>
                        <a href="shop" class="global_button"> جرب الباحث الآلي الآن <img src="uploads/search_arrow.png" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="info">
                        <img src="uploads/index_d_search.png" alt="">
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
                $stmt = $connect->prepare("SELECT * FROM products ORDER BY id DESC LIMIT 5");
                $stmt->execute();
                $allproduct = $stmt->fetchAll();
                foreach ($allproduct as $product) {
                ?>
                    <div class="product_info">
                        <img class="main_image" src="uploads/product.png" alt="">
                        <div class="product_details">
                            <h2> <a href="product?slug=<?php echo $product['slug']; ?>"> <?php echo $product['name']; ?> </a> </h2>
                            <?php
                            $maximumPrice = -INF; // قيمة أقصى سعر ممكنة
                            $minimumPrice = INF; // قيمة أدنى سعر ممكنة
                            // نشوف علي المنتج يحتوي علي متغيرات او لا 
                            $stmt = $connect->prepare("SELECT * FROM product_details WHERE pro_id = ? AND pro_price != ''");
                            $stmt->execute(array($product['id']));
                            $count_pro_attr = $stmt->rowCount();
                            if ($count_pro_attr > 0) {
                                $allproduct_data = $stmt->fetchAll();
                                foreach ($allproduct_data as $product_data) {
                                    $pro_price =  $product_data['pro_price'];
                                    $maximumPrice = max($maximumPrice, $pro_price);
                                    $minimumPrice = min($minimumPrice, $pro_price);
                                }
                            ?>
                                <h4 class='price'> <?php echo number_format($minimumPrice, 2); ?> - <?php echo number_format($maximumPrice, 2); ?> ر.س </h4>
                            <?php
                            } else {
                            ?>
                                <h4 class='price'> <?php echo $product['price'] ?> ر.س </h4>
                            <?php
                            }
                            ?>
                            <form action="" method="post">
                                <input type="hidden" name="price" value="<?php echo $product['price']; ?>">
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
            <a href="" class="btn global_button"> تصفح جميع المستلزمات <img src="<?php echo $uploads ?>left.svg" alt=""> </a>
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
                <div class="product_info">
                    <span class='badge'>الأكثر مبيعاً</span>
                    <img class="main_image" src="uploads/product.png" alt="">
                    <div class="product_details">
                        <h2>نبات ملكة النهار</h2>
                        <h4 class='price'> 87.00 ر.س </h4>
                        <div class='add_cart'>
                            <div>
                                <a href="#" class='btn global_button'> <img src="uploads/shopping-cart.png" alt=""> أضف
                                    الي السلة </a>
                            </div>
                            <div class="heart">
                                <img src="uploads/heart.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="product_info">
                    <img class="main_image" src="uploads/product.png" alt="">
                    <div class="product_details">
                        <h2>نبات ملكة النهار</h2>
                        <h4 class='price'> 87.00 ر.س </h4>
                        <div class='add_cart'>
                            <div>
                                <a href="#" class='btn global_button'> <img src="uploads/shopping-cart.png" alt=""> أضف
                                    الي السلة </a>
                            </div>
                            <div class="heart">
                                <img src="uploads/heart.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product_info">
                    <span class='badge'>الأكثر مبيعاً</span>
                    <img class="main_image" src="uploads/product.png" alt="">
                    <div class="product_details">
                        <h2>نبات ملكة النهار</h2>
                        <h4 class='price'> 87.00 ر.س </h4>
                        <div class='add_cart'>
                            <div>
                                <a href="#" class='btn global_button'> <img src="uploads/shopping-cart.png" alt=""> أضف
                                    الي السلة </a>
                            </div>
                            <div class="heart">
                                <img src="uploads/heart.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product_info">
                    <img class="main_image" src="uploads/product.png" alt="">
                    <div class="product_details">
                        <h2>نبات ملكة النهار</h2>
                        <h4 class='price'> 87.00 ر.س </h4>
                        <div class='add_cart'>
                            <div>
                                <a href="#" class='btn global_button'> <img src="uploads/shopping-cart.png" alt=""> أضف
                                    الي السلة </a>
                            </div>
                            <div class="heart">
                                <img src="uploads/heart.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product_info">
                    <span class='badge'>الأكثر مبيعاً</span>
                    <img class="main_image" src="uploads/product.png" alt="">
                    <div class="product_details">
                        <h2>نبات ملكة النهار</h2>
                        <h4 class='price'> 87.00 ر.س </h4>
                        <div class='add_cart'>
                            <div>
                                <a href="#" class='btn global_button'> <img src="uploads/shopping-cart.png" alt=""> أضف
                                    الي السلة </a>
                            </div>
                            <div class="heart">
                                <img src="uploads/heart.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product_info">
                    <img class="main_image" src="uploads/product.png" alt="">
                    <div class="product_details">
                        <h2>نبات ملكة النهار</h2>
                        <h4 class='price'> 87.00 ر.س </h4>
                        <div class='add_cart'>
                            <div>
                                <a href="#" class='btn global_button'> <img src="uploads/shopping-cart.png" alt=""> أضف
                                    الي السلة </a>
                            </div>
                            <div class="heart">
                                <img src="uploads/heart.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product_info">
                    <img class="main_image" src="uploads/product.png" alt="">
                    <div class="product_details">
                        <h2>نبات ملكة النهار</h2>
                        <h4 class='price'> 87.00 ر.س </h4>
                        <div class='add_cart'>
                            <div>
                                <a href="#" class='btn global_button'> <img src="uploads/shopping-cart.png" alt=""> أضف
                                    الي السلة </a>
                            </div>
                            <div class="heart">
                                <img src="uploads/heart.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END BEST  PRODUCTS  -->
<!-- START INDEX ALL CATEGORY  -->
<div class="index_all_cat" id="categories">
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
                                <li> <a data-section="categories" href="index?slug=<?php echo $cat['slug']; ?>"> <?php echo $cat['name']; ?> </a> </li>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="row">
                        <?php
                        if (isset($_GET['slug'])) {
                            $cat_slug = $_GET['slug'];
                            $stmt = $connect->prepare("SELECT * FROM categories WHERE slug = ?");
                            $stmt->execute(array($cat_slug));
                            $cat_data = $stmt->fetch();
                            $cat_id = $cat_data['id'];
                            $stmt = $connect->prepare("SELECT * FROM products WHERE cat_id = ? LIMIT 9");
                            $stmt->execute(array($cat_id));
                            $allproducts  = $stmt->fetchAll();
                            foreach ($allproducts as $pro) {
                        ?>
                                <div class="col-lg-4">
                                    <div class="product_info">
                                        <img class="main_image" src="uploads/product.png" alt="">
                                        <div class="product_details">
                                            <h2> <?php echo $pro['name']; ?> </h2>
                                            <h4 class='price'> 87.00 ر.س </h4>
                                            <div class='add_cart'>
                                                <div>
                                                    <a href="#" class='btn global_button'> <img src="uploads/shopping-cart.png" alt=""> أضف
                                                        الي السلة </a>
                                                </div>
                                                <div class="heart">
                                                    <img src="uploads/heart.png" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        } else {
                            echo "No";
                        }
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
        <a href="#">
            <img src="uploads/garden_serv.png" alt="">
        </a>
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
                <div class="product_info">
                    <span class='badge'>الأكثر مبيعاً</span>
                    <img class="main_image" src="uploads/product.png" alt="">
                    <div class="product_details">
                        <h2>نبات ملكة النهار</h2>
                        <div class='price_diffrent'>
                            <h4 class='price'> 87.00 ر.س </h4>
                            <h4 class='old'> 87.00 ر.س </h4>
                        </div>

                        <div class='add_cart'>
                            <div>
                                <a href="#" class='btn global_button'> <img src="uploads/shopping-cart.png" alt=""> أضف
                                    الي السلة </a>
                            </div>
                            <div class="heart">
                                <img src="uploads/heart.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="product_info">
                    <img class="main_image" src="uploads/product.png" alt="">
                    <div class="product_details">
                        <h2>نبات ملكة النهار</h2>
                        <div class='price_diffrent'>
                            <h4 class='price'> 87.00 ر.س </h4>
                            <h4 class='old'> 87.00 ر.س </h4>
                        </div>
                        <div class='add_cart'>
                            <div>
                                <a href="#" class='btn global_button'> <img src="uploads/shopping-cart.png" alt=""> أضف
                                    الي السلة </a>
                            </div>
                            <div class="heart">
                                <img src="uploads/heart.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product_info">
                    <span class='badge'>الأكثر مبيعاً</span>
                    <img class="main_image" src="uploads/product.png" alt="">
                    <div class="product_details">
                        <h2>نبات ملكة النهار</h2>
                        <div class='price_diffrent'>
                            <h4 class='price'> 87.00 ر.س </h4>
                            <h4 class='old'> 87.00 ر.س </h4>
                        </div>
                        <div class='add_cart'>
                            <div>
                                <a href="#" class='btn global_button'> <img src="uploads/shopping-cart.png" alt=""> أضف
                                    الي السلة </a>
                            </div>
                            <div class="heart">
                                <img src="uploads/heart.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product_info">
                    <img class="main_image" src="uploads/product.png" alt="">
                    <div class="product_details">
                        <h2>نبات ملكة النهار</h2>
                        <div class='price_diffrent'>
                            <h4 class='price'> 87.00 ر.س </h4>
                            <h4 class='old'> 87.00 ر.س </h4>
                        </div>
                        <div class='add_cart'>
                            <div>
                                <a href="#" class='btn global_button'> <img src="uploads/shopping-cart.png" alt=""> أضف
                                    الي السلة </a>
                            </div>
                            <div class="heart">
                                <img src="uploads/heart.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product_info">
                    <span class='badge'>الأكثر مبيعاً</span>
                    <img class="main_image" src="uploads/product.png" alt="">
                    <div class="product_details">
                        <h2>نبات ملكة النهار</h2>
                        <div class='price_diffrent'>
                            <h4 class='price'> 87.00 ر.س </h4>
                            <h4 class='old'> 87.00 ر.س </h4>
                        </div>
                        <div class='add_cart'>
                            <div>
                                <a href="#" class='btn global_button'> <img src="uploads/shopping-cart.png" alt=""> أضف
                                    الي السلة </a>
                            </div>
                            <div class="heart">
                                <img src="uploads/heart.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product_info">
                    <img class="main_image" src="uploads/product.png" alt="">
                    <div class="product_details">
                        <h2>نبات ملكة النهار</h2>
                        <div class='price_diffrent'>
                            <h4 class='price'> 87.00 ر.س </h4>
                            <h4 class='old'> 87.00 ر.س </h4>
                        </div>
                        <div class='add_cart'>
                            <div>
                                <a href="#" class='btn global_button'> <img src="uploads/shopping-cart.png" alt=""> أضف
                                    الي السلة </a>
                            </div>
                            <div class="heart">
                                <img src="uploads/heart.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product_info">
                    <img class="main_image" src="uploads/product.png" alt="">
                    <div class="product_details">
                        <h2>نبات ملكة النهار</h2>
                        <div class='price_diffrent'>
                            <h4 class='price'> 87.00 ر.س </h4>
                            <h4 class='old'> 87.00 ر.س </h4>
                        </div>
                        <div class='add_cart'>
                            <div>
                                <a href="#" class='btn global_button'> <img src="uploads/shopping-cart.png" alt=""> أضف
                                    الي السلة </a>
                            </div>
                            <div class="heart">
                                <img src="uploads/heart.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
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
                        <a href="#" class="btn global_button">تواصل مع الخبير</a>
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
                    <a href="shop" class='global_button btn'> تصفح المزيد </a>
                </div>
            </div>
            <div class="products" id='products'>
                <div class="product_info">
                    <img class="main_image" src="uploads/product.png" alt="">
                    <div class="product_details">
                        <h2>نبات ملكة النهار</h2>
                        <h4 class='price'> 87.00 ر.س </h4>
                        <div class='add_cart'>
                            <div>
                                <a href="#" class='btn global_button'> <img src="uploads/shopping-cart.png" alt=""> أضف
                                    الي السلة </a>
                            </div>
                            <div class="heart">
                                <img src="uploads/heart.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="product_info">
                    <img class="main_image" src="uploads/product.png" alt="">
                    <div class="product_details">
                        <h2>نبات ملكة النهار</h2>
                        <h4 class='price'> 87.00 ر.س </h4>
                        <div class='add_cart'>
                            <div>
                                <a href="#" class='btn global_button'> <img src="uploads/shopping-cart.png" alt=""> أضف
                                    الي السلة </a>
                            </div>
                            <div class="heart">
                                <img src="uploads/heart.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product_info">
                    <img class="main_image" src="uploads/product.png" alt="">
                    <div class="product_details">
                        <h2>نبات ملكة النهار</h2>
                        <h4 class='price'> 87.00 ر.س </h4>
                        <div class='add_cart'>
                            <div>
                                <a href="#" class='btn global_button'> <img src="uploads/shopping-cart.png" alt=""> أضف
                                    الي السلة </a>
                            </div>
                            <div class="heart">
                                <img src="uploads/heart.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product_info">
                    <img class="main_image" src="uploads/product.png" alt="">
                    <div class="product_details">
                        <h2>نبات ملكة النهار</h2>
                        <h4 class='price'> 87.00 ر.س </h4>
                        <div class='add_cart'>
                            <div>
                                <a href="#" class='btn global_button'> <img src="uploads/shopping-cart.png" alt=""> أضف
                                    الي السلة </a>
                            </div>
                            <div class="heart">
                                <img src="uploads/heart.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product_info">
                    <img class="main_image" src="uploads/product.png" alt="">
                    <div class="product_details">
                        <h2>نبات ملكة النهار</h2>
                        <h4 class='price'> 87.00 ر.س </h4>
                        <div class='add_cart'>
                            <div>
                                <a href="#" class='btn global_button'> <img src="uploads/shopping-cart.png" alt=""> أضف
                                    الي السلة </a>
                            </div>
                            <div class="heart">
                                <img src="uploads/heart.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product_info">
                    <img class="main_image" src="uploads/product.png" alt="">
                    <div class="product_details">
                        <h2>نبات ملكة النهار</h2>
                        <h4 class='price'> 87.00 ر.س </h4>
                        <div class='add_cart'>
                            <div>
                                <a href="#" class='btn global_button'> <img src="uploads/shopping-cart.png" alt=""> أضف
                                    الي السلة </a>
                            </div>
                            <div class="heart">
                                <img src="uploads/heart.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product_info">
                    <img class="main_image" src="uploads/product.png" alt="">
                    <div class="product_details">
                        <h2>نبات ملكة النهار</h2>
                        <h4 class='price'> 87.00 ر.س </h4>
                        <div class='add_cart'>
                            <div>
                                <a href="#" class='btn global_button'> <img src="uploads/shopping-cart.png" alt=""> أضف
                                    الي السلة </a>
                            </div>
                            <div class="heart">
                                <img src="uploads/heart.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
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
                <div class='col-lg-3'>
                    <div class="info">
                        <img src="uploads/cash_on_delivery.png" alt="">
                        <h4> الدفع عند الاستلام </h4>
                        <p> حاليا داخل الرياض فقط </p>
                    </div>
                </div>
                <div class='col-lg-3'>
                    <div class="info">
                        <img src="uploads/to_home2.svg" alt="">
                        <h4> التوصيل الى المنزل </h4>
                        <p> حاليا داخل الرياض فقط </p>
                    </div>
                </div>
                <div class='col-lg-3'>
                    <div class="info">
                        <img src="uploads/hary_delievry.svg" alt="">
                        <h4> توصيل سريع </h4>
                        <p> من 2- 6 أيام عمل </p>
                    </div>
                </div>
                <div class='col-lg-3'>
                    <div class="info">
                        <img src="uploads/phone_contact.svg" alt="">
                        <h4> تواصل معنا </h4>
                        <p> 0530047542 </p>
                    </div>
                </div>
                <div class='col-lg-3'>
                    <div class="info">
                        <img src="uploads/cus_services.svg" alt="">
                        <h4> دعم الخبراء </h4>
                        <p> مجانا قبل وبعد الشراء </p>
                    </div>
                </div>
                <div class='col-lg-3'>
                    <div class="info">
                        <img src="uploads/quality.svg" alt="">
                        <h4> ضمان غير محدود </h4>
                        <p> نضمن لك استلام نباتات سليمة وصحية </p>
                    </div>
                </div>
                <div class='col-lg-3'>
                    <div class="info">
                        <img src="uploads/down_price.svg" alt="">
                        <h4> أسعار تنافسية </h4>
                        <p> أسعارنا لا تقبل المنافسة </p>
                    </div>
                </div>
                <div class='col-lg-3'>
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
            <div class='row'>
                <div class="col-lg-6">
                    <div class="info">
                        <img src="uploads/main_post.png" alt="">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="info">
                        <span> من المدونة </span>
                        <h3> كيف تغرس الأشجار الجديدة؟ </h3>
                        <p> هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على
                            الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها. ولذلك يتم استخدام طريقة لوريم
                            إيبسوم لأنها تعطي توزيعاَ طبيعياَ -إلى حد ما- للأحرف عوضاً عن استخدام “هنا يوجد محتوى نصي،
                            هنا يوجد محتوى نصي” فتجعلها تبدو (أي الأحرف) وكأنها نص مقروء. العديد من برامح النشر المكتبي
                            وبرامح تحرير صفحات الويب تستخدم لوريم إيبسوم بشكل إفتراضي كنموذج عن النص، وإذا قمت بإدخال
                            في أي محرك بحث ستظهر العديد من المواقع الحديثة العهد في نتائج البحث. </p>
                        <a href='#' class='btn global_button'> اقرأ المزيد </a>
                    </div>
                </div>
            </div>
            <div class='from_blog'>
                <div class='row'>
                    <div class="col-lg-3">
                        <div class="post_info">
                            <img src="uploads/post1.png" alt="">
                            <h4> زراعة النباتات الطبية والعطرية </h4>
                            <p>هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي ا لى
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="post_info">
                            <img src="uploads/post2.png" alt="">
                            <h4> زراعة النباتات الطبية والعطرية </h4>
                            <p>هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي ا لى
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="post_info">
                            <img src="uploads/post1.png" alt="">
                            <h4> زراعة النباتات الطبية والعطرية </h4>
                            <p>هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي ا لى
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="post_info">
                            <img src="uploads/post1.png" alt="">
                            <h4> زراعة النباتات الطبية والعطرية </h4>
                            <p>هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي ا لى
                            </p>
                        </div>
                    </div>
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
                            <iframe width="400px" height="400px" data-poster="uploads/poster.png" src="https://www.youtube.com/watch?v=Y4z2mZPKhm4" allowfullscreen allowtransparency allow="autoplay"></iframe>
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
                            <a class='btn global_button'> جميع الفيديوهات <img src="uploads/arrow.png" alt=""> </a>
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
                <div class="person_info">
                    <div class='head'>
                        <div>
                            <h3> رائع وأحلي من الوصف </h3>
                        </div>
                        <div>
                            <img src="uploads/quote.svg" alt="">
                        </div>
                    </div>
                    <p>
                        لقد كنت سعيدًا جدًا بخدمة العملاء الرائعة والنباتات الجميلة التي تلقيتها من هذا المتجر. كانت
                        تجربة تسوق رائعة بالنسبة لي، وأنا أوصي بشدة هذا المتجر لجميع محبي النباتات
                    </p>
                    <div class='foo'>
                        <div> <img src="uploads/person.png" alt=""> </div>
                        <div>
                            <h5> لجين محمد </h5>
                            <span> ربة منزل </span>
                        </div>
                    </div>
                </div>
                <div class="person_info">
                    <div class='head'>
                        <div>
                            <h3> رائع وأحلي من الوصف </h3>
                        </div>
                        <div>
                            <img src="uploads/quote.svg" alt="">
                        </div>
                    </div>
                    <p>
                        لقد كنت سعيدًا جدًا بخدمة العملاء الرائعة والنباتات الجميلة التي تلقيتها من هذا المتجر. كانت
                        تجربة تسوق رائعة بالنسبة لي، وأنا أوصي بشدة هذا المتجر لجميع محبي النباتات
                    </p>
                    <div class='foo'>
                        <div> <img src="uploads/person.png" alt=""> </div>
                        <div>
                            <h5> لجين محمد </h5>
                            <span> ربة منزل </span>
                        </div>
                    </div>
                </div>
                <div class="person_info">
                    <div class='head'>
                        <div>
                            <h3> رائع وأحلي من الوصف </h3>
                        </div>
                        <div>
                            <img src="uploads/quote.svg" alt="">
                        </div>
                    </div>
                    <p>
                        لقد كنت سعيدًا جدًا بخدمة العملاء الرائعة والنباتات الجميلة التي تلقيتها من هذا المتجر. كانت
                        تجربة تسوق رائعة بالنسبة لي، وأنا أوصي بشدة هذا المتجر لجميع محبي النباتات
                    </p>
                    <div class='foo'>
                        <div> <img src="uploads/person.png" alt=""> </div>
                        <div>
                            <h5> لجين محمد </h5>
                            <span> ربة منزل </span>
                        </div>
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