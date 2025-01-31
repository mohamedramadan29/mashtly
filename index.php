<?php
ob_start();
session_start();
$page_title = 'متجر مشتلي لمختلف أنواع النباتات المنزلية والخارجية';
$description = ' مشتلي هي منصة إلكترونية مبتكرة تتيح للعملاء شراء مختلف أنواع النباتات، بما في ذلك الأشجار والزهور والنباتات المنزلية، بشكل مريح وسريع. تتميز المنصة بتوفير تجربة تسوق فريدة من نوعها، حيث يمكن للعميل اختيار النباتات التي تناسب احتياجاته دون الحاجة لزيارة المشاتل التقليدية، مما يسهل عليه الحصول على كل ما يحتاجه من راحة منزله. ';
$page_keywords = ' مشتلي ,متجر مشتلي  ';
include "init.php";
?>
<div id='hero_lg'></div>
<div id='hero_mobile'></div>
<script>
    // دالة للتحقق من حجم الشاشة وتحميل القسم المناسب
    function loadBlogSection() {
        // تفريغ المحتويات من كلا القسمين للتأكد من عدم التكرار
        document.getElementById('hero_lg').innerHTML = '';
        document.getElementById('hero_mobile').innerHTML = '';
        if (window.innerWidth > 991) {
            // تحميل الكاروسيل الخاص بالشاشات الكبيرة
            document.getElementById('hero_lg').innerHTML = `
            <div class="hero">
                <div id="carouselExampleCaptions" class="carousel slide carousel-fade" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img loading="lazy" src="uploads/mshtly1.png" class="d-block w-100" alt="عروض اليوم الوطني">
                        </div>
                        <div class="carousel-item">
                            <img src="uploads/mshtly2.png" class="d-block w-100" alt="عروض اليوم الوطني">
                        </div>
                        <div class="carousel-item">
                            <img src="uploads/mshtly3.png" class="d-block w-100" alt="عروض اليوم الوطني">
                        </div>
                    </div>
                </div>
            </div>`;
        } else {
            // تحميل الكاروسيل الخاص بالشاشات الصغيرة (الموبايل)
            document.getElementById('hero_mobile').innerHTML = `
            <div class="hero">
                <div id="carouselExampleCaptions" class="carousel slide carousel-fade" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img loading="lazy" src="uploads/mshtly_m_1.png" class="d-block w-100" alt="عروض اليوم الوطني">
                        </div>
                        <div class="carousel-item">
                            <img src="uploads/mshtly_m_2.png" class="d-block w-100" alt="عروض اليوم الوطني">
                        </div>
                        <div class="carousel-item">
                            <img src="uploads/mshtly_m_3.png" class="d-block w-100" alt="عروض اليوم الوطني">
                        </div>
                    </div>
                </div>
            </div>`;
        }
    }

    // استدعاء الدالة فور تحميل الصفحة
    loadBlogSection();

    // استدعاء الدالة عند تغيير حجم الشاشة
    window.addEventListener('resize', loadBlogSection);
</script>

<!-- START AUTOMATIC SEARCH INDEX -->

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
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    } else {
        $user_id = null;
    }
    $stmt = $connect->prepare("SELECT * FROM cart WHERE cookie_id = ? AND product_id = ?");
    $stmt->execute(array($cookie_id, $product_id));
    $cart_data = $stmt->fetch();
    $count_product = $stmt->rowCount();
    if ($count_product > 0) {
        $new_qty = $cart_data['quantity'] + 1; // زيادة الكمية بواحد
        $stmt = $connect->prepare("UPDATE cart SET quantity = ?, total_price = ? WHERE cookie_id = ? AND product_id = ?");
        $stmt->execute(array($new_qty, $cart_data['price'] * $new_qty, $cookie_id, $product_id)); // تحديث الكمية والسعر الإجمالي
    } else {
        $stmt = $connect->prepare("INSERT INTO cart (user_id, cookie_id, product_id, product_name, quantity, price, total_price)
        VALUES (:zuser_id, :zcookie_id, :zproduct_id, :zproduct_name, :zquantity, :zprice, :ztotal_price)");
        $stmt->execute(array(
            "zuser_id" => $user_id,
            "zcookie_id" => $cookie_id,
            "zproduct_id" => $product_id,
            "zproduct_name" => $product_name,
            "zquantity" => 1,
            "zprice" => $price,
            "ztotal_price" => $price,
        ));
    }
    if ($stmt) {
        alertcart();
    }
}
?>
<br>
<br>
<br>

<!-- START BEST PRODUCTS -->
<div class="new_producs best_products lazy-section">
    <div class="container">
        <div class="data">
            <div class="data_header">
                <div class="data_header_name">
                    <h2 class='header2'> الأفضل مبيعا </h2>
                    <p> المنتجات الافضل والاكثر مبيعا في مشتلي </p>
                </div>
                <div>
                    <a href="shop" class='global_button btn'> تصفح المزيد </a>
                </div>
            </div>
            <div class="products" id='products'>
                <?php
                $stmt = $connect->prepare("SELECT product_id, COUNT(*) as total_sales FROM order_details
                GROUP BY product_id ORDER BY total_sales DESC LIMIT 20");
                $stmt->execute();
                $top_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($top_products as $top_product) {
                    $stmt = $connect->prepare("SELECT * FROM products WHERE id = ?");
                    $stmt->execute(array(($top_product['product_id'])));
                    $product = $stmt->fetch();
                    include 'tempelate/product.php';
                }

                $stmt = $connect->prepare("SELECT * FROM products WHERE  feature_product = 1 AND  publish = 1 AND product_status_store = 1  AND name !='' AND price !='' ORDER BY id DESC");
                $stmt->execute();
                $allproduct = $stmt->fetchAll();
                foreach ($allproduct as $product) {
                    include 'tempelate/product.php';
                }
                ?>
            </div>
        </div>
    </div>
</div>
<!-- END BEST  PRODUCTS  -->


<!-- START PLANTS REQUIRES -->
<div class='planets_require_index lazy-section'>
    <div class="container">
        <div class="data">
            <h2> مستلزمات العناية بنباتاتك </h2>
            <a href="categories" class="btn global_button"> تصفح جميع المستلزمات <img loading="lazy"
                    src="<?php echo $uploads ?>left.svg" alt="جميع المستلزمات"> </a>
        </div>
    </div>
</div>
<!-- END PLANTS REQUIRES -->




<div class="new_producs lazy-section">
    <div class="container">
        <div class="data">
            <div class="data_header">
                <div class="data_header_name">
                    <h1 class='header2'> منتجات جديدة وصلتنا حديثا </h1>
                    <p>نباتات جديدة وصلتنا هذا الأسبوع</p>
                </div>
                <div>
                    <a href="shop" class='global_button btn'> تصفح المزيد </a>
                </div>
            </div>
            <div class="products" id='products'>
                <?php
                $stmt = $connect->prepare("SELECT * FROM products WHERE  publish = 1 AND product_status_store = 1 AND  (cat_id = 227 OR cat_id = 21)  AND  name !='' AND price !='' ORDER BY RAND() LIMIT 10");
                $stmt->execute();
                $allproduct = $stmt->fetchAll();
                foreach ($allproduct as $product) {
                    include 'tempelate/product.php';
                }
                ?>
            </div>
        </div>
    </div>
</div>
<!-- END NEWWER PRODUCTS  -->

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
                                <img loading="lazy" src="uploads/quote.svg" alt="اراء العملاء">
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
                                    <img loading="lazy" src="uploads/plant.svg" alt="مشتلي ">
                                    <?php
                                } else {
                                    ?>
                                    <img loading="lazy" src="uploads/plant.svg" alt="مشتلي">
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




<!-- START INDEX ALL CATEGORY  -->
<div id='index_all_cat_desktop lazy-section'>

</div>
<script>
    // دالة للتحقق من حجم الشاشة وتحميل القسم إذا كان العرض أكبر من 991 بكسل
    function loadallSection() {
        if (window.innerWidth > 991) {
            // استدعاء قسم المقالات فقط إذا كان العرض أكبر من 991 بكسل
            document.getElementById('index_all_cat_desktop').innerHTML = `<div class="index_all_cat index_categories" id="categories">
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
                                    <li><a data-section="categories" href="category_products?cat=<?php echo $cat['slug']; ?>"> <?php echo $cat['name']; ?> </a>
                                    </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="row">
                        <?php
                        $stmt = $connect->prepare("SELECT * FROM products WHERE publish = 1 AND product_status_store = 1 AND name !='' AND price !=''  order by id ASC LIMIT 9");
                        $stmt->execute();
                        $allproducts = $stmt->fetchAll();
                        foreach ($allproducts as $product) {
                            ?>
                                <div class="col-lg-4">
                                    <?php
                                    include 'tempelate/product.php';
                                    ?>
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
</div>`;
        }
    }

    // استدعاء الدالة فور تحميل الصفحة
    loadallSection();

    // استدعاء الدالة عند تغيير حجم الشاشة
    window.addEventListener('resize', loadallSection);
</script>
<!-- END INDEX ALL CATEGORY  -->
<!-- START GARDEN SERVICES -->
<div class="garden_services">
    <div class="container">
        <div class="data">
            <div class="row">
                <div class="col-lg-6">
                    <div class="info info1">
                        <h3> خدمات الحدائق </h3>
                        <a href="landscap" class="btn global_button"> اعرف المزيد <img loading="lazy"
                                src="<?php echo $uploads; ?>/arrow_left.svg" alt="المزيد"> </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="info info2">
                        <h3> الطلبات الكبيرة </h3>
                        <a href="big_orders" class="btn global_button"> اعرف المزيد <img loading="lazy"
                                src="<?php echo $uploads; ?>/right-arrow-2.svg" alt="المزيد"> </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END GARDEN SERVICES -->
<!-- START BEST PRODUCTS -->
<?php
$stmt = $connect->prepare("SELECT * FROM products WHERE publish = 1 AND product_status_store = 1 AND  name !='' AND price !='' AND sale_price!=0 OR sale_price !=null ORDER BY id DESC LIMIT 10");
$stmt->execute();
$countSaleproduct = $stmt->rowCount();
if ($countSaleproduct > 0) {
    $allproduct = $stmt->fetchAll();

    ?>
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
                                <img loading="lazy" class="main_image"
                                    src="admin/product_images/<?php echo $product_data_image['main_image']; ?>"
                                    alt="<?php echo $product_data_image['image_alt']; ?>">
                                <?php
                            } else {
                                ?>
                                <img loading="lazy" class="main_image" src="uploads/product.png" alt="الصورة الرئيسية للمنتج">
                                <?php
                            }
                            ?>

                            <div class="product_details">
                                <h2>
                                    <a href="product?slug=<?php echo $product['slug']; ?>"> <?php echo $product['name']; ?> </a>
                                </h2>
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
                                        $pro_price = $product_data['price'];
                                        $maximumPrice = max($maximumPrice, $pro_price);
                                        $minimumPrice = min($minimumPrice, $pro_price);
                                    }
                                    ?>
                                    <h4 class='price'> <?php echo number_format($minimumPrice, 2); ?>
                                        - <?php echo number_format($maximumPrice, 2); ?> ر.س </h4>
                                    <?php
                                } else {
                                    ?>
                                    <div class='price_diffrent'>
                                        <h4 class='price'><?php echo number_format($product['sale_price'], 2) ?>
                                            ر.س </h4>
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
                                                <a href="cart" class='btn global_button'> <img loading="lazy"
                                                        src="uploads/shopping-cart.png" alt="سلة المشتريات">
                                                    مشاهدة السلة
                                                </a>
                                                <?php
                                            } else {
                                                ?>
                                                <?php
                                                if ($count_pro_attr > 0) {
                                                    ?>
                                                    <a href="product?slug=<?php echo $product['slug']; ?>" class='btn global_button'>
                                                        <img loading="lazy" src="uploads/shopping-cart.png" alt="خيارات المنتج">
                                                        مشاهدة الاختيارات
                                                    </a>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <button name="add_to_cart" class='btn global_button'><img loading="lazy"
                                                            src="uploads/shopping-cart.png" alt="سلة المشتريات"> أضف
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
                                                <img loading="lazy" src="<?php echo $uploads; ?>/heart2.svg" alt="المفضلة">
                                                <?php
                                            } else {
                                                ?>
                                                <button id='add_to_fav2' name="add_to_fav" type="submit">
                                                    <img loading="lazy" src="<?php echo $uploads ?>/heart.png" alt="المفضلة">
                                                </button>
                                                <style>
                                                    #add_to_fav2 {
                                                        border: none;
                                                        background-color: transparent
                                                    }
                                                </style>
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
    <?php
}
?>

<!-- END BEST  PRODUCTS  -->
<!-- START EXPERT CONNECT -->
<div class='expert_connect'>
    <div class='container'>
        <div class="data">
            <div class='row'>
                <div class="col-lg-5">
                    <div class="info">
                        <h2>تواصل مع الخبير <br> للعناية بنباتاتك المنزلية</h2>
                        <p> يرغب متجر مشتلي في أن تتمتع بنباتات نامية وصحية، وأن تتوفق لاختيار أفضل المنتجات, لذلك وفرنا
                            خبراء متخصصين بالهندسة الزراعية لتقديم الدعم والتوجيه والمساعدة. </p>
                        <a target="_blank" href="https://t.me/mshtly" class="btn global_button">تواصل مع الخبير</a>
                    </div>
                </div>
                <div class='col-lg-7'>
                    <div class='image lazy-background' data-bg="uploads/expert_contact.webp">
                        <img loading="lazy" src="uploads/points.png" alt="العناية بالنباتات">
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
                    <a href="product-category/النباتات-الداخلية" class='global_button btn'> تصفح المزيد </a>
                </div>
            </div>
            <!-- قسم النباتات الداخلية  -->
            <div class="products" id='products'>
                <?php
                $stmt = $connect->prepare("SELECT * FROM products WHERE cat_id = 227 AND publish = 1 AND product_status_store = 1 AND name !='' AND price !='' ORDER BY id DESC LIMIT 10");
                $stmt->execute();
                $allproduct = $stmt->fetchAll();
                foreach ($allproduct as $product) {
                    include 'tempelate/product.php';
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
                        <img loading="lazy" src="uploads/cash_on_delivery.webp" alt="الدفع عند الاستلام">
                        <h4> الدفع عند الاستلام </h4>
                        <p> حاليا داخل الرياض فقط </p>
                    </div>
                </div>
                <div class='col-lg-3 col-6'>
                    <div class="info">
                        <img loading="lazy" src="uploads/to_home2.svg" alt="التوصيل الي المنزل">
                        <h4> التوصيل الى المنزل </h4>
                        <p> حاليا داخل الرياض فقط </p>
                    </div>
                </div>
                <div class='col-lg-3 col-6'>
                    <div class="info">
                        <img loading="lazy" src="uploads/hary_delievry.svg" alt="توصيل سريع">
                        <h4> توصيل سريع </h4>
                        <p> من 2- 6 أيام عمل </p>
                    </div>
                </div>
                <div class='col-lg-3 col-6'>
                    <div class="info">
                        <img loading="lazy" src="uploads/phone_contact.svg" alt="تواصل معنا">
                        <h4> تواصل معنا </h4>
                        <p> 0530047542 </p>
                    </div>
                </div>
                <div class='col-lg-3 col-6'>
                    <div class="info">
                        <img loading="lazy" src="uploads/cus_services.svg" alt="دعم الخبراء">
                        <h4> دعم الخبراء </h4>
                        <p> مجانا قبل وبعد الشراء </p>
                    </div>
                </div>
                <div class='col-lg-3 col-6'>
                    <div class="info">
                        <img loading="lazy" src="uploads/quality.svg" alt="ضمان غير محدود">
                        <h4> ضمان غير محدود </h4>
                        <p> نضمن لك استلام نباتات سليمة وصحية </p>
                    </div>
                </div>
                <div class='col-lg-3 col-6'>
                    <div class="info">
                        <img loading="lazy" src="uploads/down_price.svg" alt="اسعار تنافسية">
                        <h4> أسعار تنافسية </h4>
                        <p> أسعارنا لا تقبل المنافسة </p>
                    </div>
                </div>
                <div class='col-lg-3 col-6'>
                    <div class="info">
                        <img loading="lazy" src="uploads/plants_requirement.svg" alt="مستلزمات زراعية">
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
            $stmt = $connect->prepare("SELECT * FROM posts WHERE publish = 1  ORDER BY id DESC LIMIT 1");
            $stmt->execute();
            $last_post = $stmt->fetch();
            $post_id = $last_post['id'];
            $post_head = $last_post['name'];
            $post_desc = $last_post['description'];
            $post_desc = explode(' ', $post_desc);
            // استخدم array_slice للحصول على أول 10 كلمات
            $post_desc_last = implode(' ', array_slice($post_desc, 0, 70));
            $post_short_desc = $last_post['short_desc'];
            $post_date = $last_post['date'];
            $post_slug = $last_post['slug'];
            $post_image = $last_post['main_image'];
            ?>
            <div class='row'>
                <div class="col-lg-6">
                    <div class="info">
                        <img loading="lazy" src="admin/posts/images/<?php echo $post_image; ?>"
                            alt="<?php echo $post_head ?>">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="info">
                        <span> من المدونة </span>
                        <h3> <?php echo $post_head; ?> </h3>
                        <p> <?php echo $post_desc_last . '...' ?> </p>
                        <a href='blog/<?php echo $post_slug; ?>' class='btn global_button'> اقرأ
                            المزيد </a>
                    </div>
                </div>
            </div>
            <div id="from_blog_container"></div>
            <script>
                // دالة للتحقق من حجم الشاشة وتحميل القسم إذا كان العرض أكبر من 991 بكسل
                function loadBlogSection() {
                    if (window.innerWidth > 991) {
                        // استدعاء قسم المقالات فقط إذا كان العرض أكبر من 991 بكسل
                        document.getElementById('from_blog_container').innerHTML = `<div class='from_blog'>
                <div class='row'>
                    <?php
                    $stmt = $connect->prepare("SELECT * FROM posts WHERE publish = 1 AND id !=? ORDER BY id DESC LIMIT 4");
                    $stmt->execute(array($post_id));
                    $allposts = $stmt->fetchAll();
                    foreach ($allposts as $post) {
                        $cleaned_desc = strip_tags($post['description']);
                        $post_desc = explode(' ', $cleaned_desc);
                        $post_desc = implode(' ', array_slice($post_desc, 0, 20));
                        ?>
                            <div class="col-lg-3">
                                <a href="blog/<?php echo $post['slug']; ?>" style="text-decoration: none;">
                                    <div class="post_info">
                                        <img loading="lazy" src="admin/posts/images/<?php echo $post['main_image'] ?>" alt="<?php echo $post['name'] ?>">
                                        <h4> <?php echo $post['name']; ?> </h4>
                                        <p> <?php echo $post_desc . "..."; ?> </p>
                                    </div>
                                </a>
                            </div>
                        <?php
                    }
                    ?>
                </div>
            </div>`;
                    }
                }
                // استدعاء الدالة فور تحميل الصفحة
                loadBlogSection();

                // استدعاء الدالة عند تغيير حجم الشاشة
                window.addEventListener('resize', loadBlogSection);
            </script>

        </div>
    </div>
</div>
<!-- END  POST INDEX -->
<!-- START INDEX VIDEO  -->

<div id="index_video_container"></div>

<script>
    // دالة للتحقق من حجم الشاشة وتحميل القسم إذا كان العرض أكبر من 991 بكسل
    function loadvideoSection() {
        if (window.innerWidth > 991) {
            // استدعاء قسم المقالات فقط إذا كان العرض أكبر من 991 بكسل
            document.getElementById('index_video_container').innerHTML = `<div class='index_video'>
    <div class='container'>
        <div class='data'>
            <div class="row">
                <div class="col-lg-8">
                    <div class="info">
                        <div class="plyr__video-embed" id="player">
                            <lite-youtube videoid="TFAF1e7eHUU" posterquality="maxresdefault" class="custom-poster"></lite-youtube>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="info">
                        <div class='video_data'>
                            <img loading="lazy" class="image1" src="uploads/points.png" alt="videos">
                            <img loading="lazy" class="image2" src="uploads/points.png" alt="videos">
                            <span>
                                فيديوهات ومقاطع مميزه
                            </span>
                            <img loading="lazy" class="arrow" src="uploads/arrow.png" alt="المزيد من الفيديوهات">
                            <h2>كيف تغرس </br> الأشجار و النباتات الجديدة </h2>
                            <a href="https://www.youtube.com/channel/UCa-0QzwA1e3hGp-nrQn0qNg" class='btn global_button'> جميع الفيديوهات <img src="uploads/arrow.png" alt="المزيد من الفيديوهات"> </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>`;
        }
    }

    // استدعاء الدالة فور تحميل الصفحة
    loadvideoSection();

    // استدعاء الدالة عند تغيير حجم الشاشة
    window.addEventListener('resize', loadvideoSection);
</script>
<!--- END INDEX VIDEO  -->

<div class="instagrame_footer">
    <div class="container">
        <div class="data">
            <h2> شاركينا جمال بيتك - نباتات الحديقة </h2>
            <p> أرسلي صور حديقة منزلك ونباتات حديقتك عبر انستجرام وسوف تظهر هنا </p>
            <div class="insta_slider">
                <div class="insta_info">
                    <a href="https://www.instagram.com/mshtly1/">
                        <img loading="lazy" src="<?php echo $uploads ?>/insta1.png" alt="نباتات الحديقة">
                        <div class="overlay">
                            <img loading="lazy" src="<?php echo $uploads ?>/insta_share_icon.svg" alt="نباتات الحديقة">
                        </div>
                    </a>
                </div>
                <div class="insta_info">
                    <a href="https://www.instagram.com/mshtly1/">
                        <img loading="lazy" src="<?php echo $uploads ?>/insta2.png" alt="نباتات الحديقة">
                        <div class="overlay">
                            <img loading="lazy" src="<?php echo $uploads ?>/insta_share_icon.svg" alt="نباتات الحديقة">
                        </div>
                    </a>
                </div>
                <div class="insta_info">
                    <a href="https://www.instagram.com/mshtly1/">
                        <img loading="lazy" src="<?php echo $uploads ?>/insta3.png" alt="نباتات الحديقة">
                        <div class="overlay">
                            <img loading="lazy" src="<?php echo $uploads ?>/insta_share_icon.svg" alt="نباتات الحديقة">
                        </div>
                    </a>
                </div>
                <div class="insta_info">
                    <a href="https://www.instagram.com/mshtly1/">
                        <img loading="lazy" src="<?php echo $uploads ?>/insta2.png" alt="نباتات الحديقة">
                        <div class="overlay">
                            <img loading="lazy" src="<?php echo $uploads ?>/insta_share_icon.svg" alt="نباتات الحديقة">
                        </div>
                    </a>
                </div>
                <div class="insta_info">
                    <a href="https://www.instagram.com/mshtly1/">
                        <img loading="lazy" src="<?php echo $uploads ?>/insta1.png" alt="نباتات الحديقة">
                        <div class="overlay">
                            <img loading="lazy" src="<?php echo $uploads ?>/insta_share_icon.svg" alt="نباتات الحديقة">
                        </div>
                    </a>
                </div>
                <div class="insta_info">
                    <a href="https://www.instagram.com/mshtly1/">
                        <img loading="lazy" src="<?php echo $uploads ?>/insta2.png" alt="نباتات الحديقة">
                        <div class="overlay">
                            <img loading="lazy" src="<?php echo $uploads ?>/insta_share_icon.svg" alt="نباتات الحديقة">
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include $tem . 'footer.php';
ob_end_flush();

?>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js" integrity="sha512-ykZ1QQr0Jy/4ZkvKuqWn4iF3lqPZyij9iRv6sGqLRdTPkY69YX6+7wvVGmsdBbiIfN/8OdsI7HABjvEok6ZopQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
<script src='<?php echo $js; ?>/jquery.min.js'></script>
<script src='<?php echo $js; ?>/bootstrap.min.js'></script>
<!-- Sweet Alert  -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/lite-youtube-embed/src/lite-yt-embed.js"></script>
<script src='<?php echo $js; ?>/slick.min.js'></script>
<script src='<?php echo $js; ?>/slick-custom.js'></script>

<script src='<?php echo $js; ?>/main.js'></script>
</body>

</html>

<!-- for insta footer -->
<script>
    $(document).ready(function () {
        $('.insta_slider').slick({
            rtl: true,
            slidesToShow: 5,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
            infinite: true,
            prevArrow: false,
            nextArrow: false,
            centerMode: true,
            variableWidth: true,
            responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,

                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            }
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
            ]

        });
    });
</script>
<!-- for products -->
<script>
    $(document).ready(function () {
        $('.products').slick({
            rtl: true,
            slidesToShow: 4,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
            infinite: true,
            prevArrow: '<button type="button" class="slick-prev" aria-label="Previous slide"><i class="bi bi-chevron-right"></i></button>',
            nextArrow: '<button type="button" class="slick-next" aria-label="Next slide"><i class="bi bi-chevron-left"></i></button>',
            centerMode: false,
            variableWidth: false,
            responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 3,
                }
            },
            {
                breakpoint: 900,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    variableWidth: true,
                }
            }
            ]

        });
    });
</script>
<script>
    $(document).ready(function () {
        $('.products_thumnails').slick({
            rtl: true,
            slidesToShow: 3,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
            infinite: true,
            prevArrow: '<button type="button" class="slick-prev" aria-label="Previous slide"><i class="bi bi-chevron-right"></i></button>',
            nextArrow: '<button type="button" class="slick-next" aria-label="Next slide"><i class="bi bi-chevron-left"></i></button>',
            centerMode: false,
            variableWidth: false,
            responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,

                }
            },
            {
                breakpoint: 900,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                }
            }
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
            ]

        });
    });
</script>
<!-- for testmonails -->
<script>
    $(document).ready(function () {
        $('.testmon').slick({
            rtl: true,
            slidesToShow: 2,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
            infinite: true,
            prevArrow: '<img class="right_arrow" alt="right arrow" src="<?php echo $uploads ?>/right_arrow.png">',
            nextArrow: '<img class="left_arrow" alt="left arrow" src="<?php echo $uploads ?>/left_arrow.png">',
            centerMode: false,
            variableWidth: true,
            responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,

                }
            },
            {
                breakpoint: 900,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                }
            }
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
            ]
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const lazyBackgrounds = document.querySelectorAll('.lazy-background');

        function lazyLoad() {
            lazyBackgrounds.forEach(bg => {
                if (bg.getBoundingClientRect().top < window.innerHeight && !bg.classList.contains('loaded')) {
                    bg.style.backgroundImage = `url(${bg.dataset.bg})`;
                    bg.classList.add('loaded');
                    bg.classList.remove('lazy-background');
                }
            });
        }

        lazyLoad();
        window.addEventListener('scroll', lazyLoad);
    });
</script>

<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>

<script>
    let lazySections = document.querySelectorAll('.lazy-section');

    let observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                let section = entry.target;
                section.classList.add('visible');
                observer.unobserve(section); // إلغاء المراقبة بعد التحميل
            }
        });
    });

    lazySections.forEach(section => {
        observer.observe(section);
    });

</script>