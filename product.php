<?php
ob_start();
session_start();
$page_title = 'تفاصيل المنتج ';
include 'init.php';
if (isset($_GET['slug'])) {
    $slug = $_GET['slug'];
    $stmt = $connect->prepare("SELECT * FROM products WHERE slug = ? ORDER BY id DESC LIMIT 1 ");
    $stmt->execute(array($slug));
    $product_data = $stmt->fetch();
    $count  = $stmt->rowCount();
    if ($count > 0) {
        $product_id = $product_data['id'];
        $product_name = $product_data['name'];
        $product_desc = $product_data['description'];
        $product_price = $product_data['price'];
        $product_category = $product_data['cat_id'];
        $related_products = $product_data['related_product'];
        // get product category 
        $stmt = $connect->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->execute(array($product_category));
        $category_data = $stmt->fetch();
        $cat_name = $category_data['name'];
    } else {
        header("Location:404");
    }
    ///////////////////// Add To Cart   /////////////////////
    if (isset($_POST['add_to_cart'])) {
        $product_id = $_POST['product_id'];
        if (isset($_POST['attribute_price']) && $_POST['attribute_price'] != '') {
            $price = $_POST['attribute_price'];
        } else {
            $price = $product_price;
        }
        if (isset($_POST['quantity'])) {
            $quantity = $_POST['quantity'];
        } else {
            $quantity = 1;
        }
        if (isset($_POST['gift_id'])) {
            $gift_id = $_POST['gift_id'];
        } else {
            $gift_id = null;
        }
        if (isset($_POST['farm_planet'])) {
            $farm_planet = 1;
        } else {
            $farm_planet = null;
        }
        /// Product Options 
        if (isset($_POST['attribute_data'])) {
            $options = $_POST['attribute_data'];
        }
        if (isset($options[0])) {
            $option0 = $options[0];
        } else {
            $option0 = null;
        }
        if (isset($options[1])) {
            $option1 = $options[1];
        } else {
            $option1 = null;
        }
        if (isset($options[2])) {
            $option2 = $options[2];
        } else {
            $option2 = null;
        }
        if (isset($options[3])) {
            $option3 = $options[3];
        } else {
            $option3 = null;
        }
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
        } else {
            $user_id = null;
        }
        $total_price = null;
        $stmt = $connect->prepare("INSERT INTO cart (user_id, cookie_id, product_id,quantity,price,farm_service,
            gift_id,option1,option2,option3,option4,total_price)
    VALUES(:zuser_id, :zcookie_id , :zproduct_id,:zquantity,:zprice,:zfarm_service,
    :zgift_id,:zoption1,:zoption2,:zoption3,:zoption4,:ztotal_price)
    ");
        $stmt->execute(array(
            "zuser_id" => $user_id,
            "zcookie_id" => $cookie_id,
            "zproduct_id" => $product_id,
            "zquantity" => $quantity,
            "zprice" => $price,
            "zfarm_service" => $farm_planet,
            "zgift_id" => $gift_id,
            "zoption1" => $option0,
            "zoption2" => $option1,
            "zoption3" => $option2,
            "zoption4" => $option3,
            "ztotal_price" => $total_price,
        ));
        if ($stmt) {
            alertcart();
        }
    }
?>
    <!-- START SELECT DATA HEADER -->
    <div class="select_plan_head">
        <div class="container">
            <div class="data">
                <div class="head">
                    <img loading="lazy" src="<?php echo $uploads ?>plant.svg" alt="">
                    <h2> خصم ١٥٪ بمناسبة بداية فصل الربيع </h2>
                    <p>
                        استخدم هذا الكود عند اتمام عملية الشراء#SP15%
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- END SELECT DATA HEADER -->
    <!-- START breadcrump  -->
    <div class="container">
        <div class="data">
            <div class="breadcrump">
                <p> <a href="index"> الرئيسية </a> \ <span> <a href="shop"> المتجر </a> </span> \ <span>  <?php echo  $cat_name ?>  </span> \ <?php echo $product_name ?> </p>
            </div>
        </div>
    </div>
    <div class="product_details">
        <div class="container">
            <div class="data">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="product">
                            <div class="product_images">
                                <!-- HTML -->
                                <?php
                                $stmt = $connect->prepare("SELECT * FROM products_image WHERE product_id = ?");
                                $stmt->execute(array($product_id));
                                $count_image = $stmt->rowCount();
                                if ($count_image > 0) {
                                    $product_data_image = $stmt->fetch();
                                ?>
                                    <div class="main-slider  gallery-lb">
                                        <div>
                                            <a href="admin/product_images/<?php echo $product_data_image['main_image']; ?>">
                                                <img loading="lazy" src="admin/product_images/<?php echo $product_data_image['main_image']; ?>" alt="Image 1">
                                            </a>
                                        </div>
                                        <?php
                                        // check if this product have images in gallary
                                        $stmt = $connect->prepare("SELECT * FROM products_gallary WHERE product_id = ?");
                                        $stmt->execute(array($product_id));
                                        $allgallary = $stmt->fetchAll();
                                        $count_g = count($allgallary);
                                        if ($count_g > 0) {
                                            foreach ($allgallary as $gallary) {
                                        ?>
                                                <div>
                                                    <a href="admin/product_images/<?php echo $gallary['image']; ?>">
                                                        <img loading="lazy" src="admin/product_images/<?php echo $gallary['image']; ?>" alt="Image 2">
                                                    </a>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        <?php
                                        }
                                        ?>
                                        <!-- يمكنك إضافة المزيد من الصور هنا -->
                                    </div>
                                    <div class="thumbnail-slider">
                                        <div>
                                            <img loading="lazy" src="admin/product_images/<?php echo $product_data_image['main_image']; ?>" alt="Thumbnail 1">
                                        </div>
                                        <?php
                                        if ($count_g > 0) {
                                            foreach ($allgallary as $gallary) {
                                        ?>
                                                <div>
                                                    <img loading="lazy" src="admin/product_images/<?php echo $gallary['image']; ?>" alt="Image 2">
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        <?php
                                        }
                                        ?>
                                        <!-- يمكنك إضافة المزيد من الصور المصغرة هنا -->
                                    </div>
                                <?php
                                } else {
                                ?>
                                    <img loading="lazy" class="main_image" src="uploads/product.png" alt="">
                                <?php
                                }
                                ?>
                            </div>
                            <div class="product_info">
                                <h2> <img loading="lazy" src="<?php echo $uploads ?>/left_arrow.png" alt=""> <?php echo $product_name; ?> </h2>
                                <!-- check if products have more price in attribute or not -->
                                <?php
                                $maximumPrice = -INF; // قيمة أقصى سعر ممكنة
                                $minimumPrice = INF; // قيمة أدنى سعر ممكنة
                                $stmt = $connect->prepare("SELECT * FROM product_details WHERE pro_id = ? AND pro_price !='' AND pro_price !=0");
                                $stmt->execute(array($product_id));
                                $att_count = $stmt->rowCount();
                                if ($att_count > 0) {
                                    $allproduct_data = $stmt->fetchAll();
                                    foreach ($allproduct_data as $product_data) {
                                        $pro_price =  $product_data['pro_price'];
                                        $maximumPrice = max($maximumPrice, $pro_price);
                                        $minimumPrice = min($minimumPrice, $pro_price);
                                    }
                                ?>
                                    <p> يبدأ من: <span> <?php echo number_format($minimumPrice, 2); ?> - <?php echo number_format($maximumPrice, 2); ?> ر.س </span> </p>
                                <?php
                                } else {
                                ?>
                                    <p> السعر : <span> <?php echo number_format($product_price, 2); ?> ر.س </span> </p>
                                <?php
                                } ?>
                                <div class="support">
                                    <div>
                                        <img loading="lazy" src="<?php echo $uploads ?>/support.svg" alt="">
                                    </div>
                                    <div>
                                        <h4> دعم الخبراء </h4>
                                        <p> مجانا قبل وبعد الشراء </p>
                                    </div>
                                </div>
                                <div class="attention">
                                    <h3> تنويه </h3>
                                    <p> الصور المعروضة للنبتة هنا توضح مميزاتها وشكلها بعد زراعتها ورعايتها وتقديم كامل احتياجاتها كما هو موضح في وصف النبتة، وبإمكانكم الحصول على تفاصيل أكثر من خلال دعم خبرائنا المجاني . </p>
                                </div>
                            </div>
                        </div>
                        <div class="product_description">
                            <h3> وصف المنتج </h3>
                            <p> <?php echo $product_desc ?> </p>
                            <button class="btn"> رقم المنتج:#<?php echo $product_id; ?> </button>
                        </div>
                        <div class="social_share">
                            <div>
                                <p> شارك عبر </p>
                            </div>
                            <div>
                                <ul class="list-unstyled">
                                    <li> <a href="#"> <i class="fa fa-facebook"></i> </a> </li>
                                    <li> <a href="#"> <i class="fa fa-twitter"></i> </a> </li>
                                    <li> <a href="#"> <i class="fa fa-whatsapp"></i> </a> </li>
                                    <li> <a href="#"> <i class="fa fa-instagram"></i> </a> </li>
                                </ul>
                            </div>
                        </div>
                        <div class="faq">
                            <?php
                            // get product faqs 
                            $stmt = $connect->prepare("SELECT * FROM product_faqs WHERE product_id = ?");
                            $stmt->execute(array($product_id));
                            $allfaqs = $stmt->fetchAll();

                            ?>
                            <div class="accordion" id="accordionExample">
                                <?php
                                foreach ($allfaqs as $faq) {
                                ?>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                <?php echo $faq['faq_head'] ?>
                                            </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <p> <?php echo $faq['faq_descriptiion'] ?> </p>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="request">
                            <form action="" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="product_id" value="<?php echo $product_id ?>" id="">
                                <h3> اطلبه الآن </h3>
                                <div class="options">
                                    <!-- 
                                <h6> لون الزهرة </h6>
                                <div class="colors">
                                    <div class="color">
                                        <p> <span class="" style=" background-color: red;"> </span> احمر <i class="fa fa-check"></i> </p>
                                    </div>
                                    <div class="color">
                                        <p> <span class="" style=" background-color: #fff;"> </span> ابيض <i class="fa fa-check"></i> </p>
                                    </div>
                                </div>
-->
                                    <?php
                                    $stmt = $connect->prepare("SELECT pro_attribute FROM product_details WHERE pro_id = ? GROUP BY pro_attribute");
                                    $stmt->execute(array($product_id));
                                    $allproductattribute = $stmt->fetchAll();
                                    foreach ($allproductattribute as $index => $pro_attribute) {
                                        // get attribute name 
                                        $stmt = $connect->prepare("SELECT * FROM product_attribute WHERE id = ?");
                                        $stmt->execute(array($pro_attribute['pro_attribute']));
                                        $attribute_data = $stmt->fetch();
                                    ?>
                                        <h6> <?php echo $attribute_data['name']; ?></h6>
                                        <div class="input_box">
                                            <select name="attribute_data[]" id="attribute-select-<?php echo $index; ?>" class="form-control">
                                                <option> -- اختر <?php echo $attribute_data['name']; ?> -- </option>
                                                <?php
                                                echo "</br>";
                                                $stmt = $connect->prepare("SELECT * FROM product_details WHERE pro_id = ? AND pro_attribute = ?");
                                                $stmt->execute(array($product_id, $pro_attribute['pro_attribute']));
                                                $allproductvartions = $stmt->fetchAll();
                                                foreach ($allproductvartions as $pro_vartion) {
                                                    // get Vartions name 
                                                    $stmt = $connect->prepare("SELECT * FROM product_variations WHERE id = ?");
                                                    $stmt->execute(array($pro_vartion['pro_variation']));
                                                    $vartion_data = $stmt->fetch();
                                                ?>
                                                    <option data-price="<?php echo $pro_vartion['pro_price'] ?>" value="<?php echo $pro_vartion['id']; ?>"> <span><?php echo $vartion_data['name']; ?></span> <?php if (!empty($pro_vartion['pro_price'])) { ?> (<strong> السعر </strong> <span class="price"><?php echo $pro_vartion['pro_price']; ?> ر.س </span> )<?php } ?> </option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            <input type="hidden" name="attribute_price" id="attribute-price-<?php echo $index; ?>" value="0">
                                            <script>
                                                var selectElement<?php echo $index; ?> = document.getElementById("attribute-select-<?php echo $index; ?>");
                                                var priceElement<?php echo $index; ?> = document.getElementById("attribute-price-<?php echo $index; ?>");
                                                selectElement<?php echo $index; ?>.addEventListener("change", function() {
                                                    var selectedOption = selectElement<?php echo $index; ?>.options[selectElement<?php echo $index; ?>.selectedIndex];
                                                    var selectedPrice = selectedOption.dataset.price;
                                                    priceElement<?php echo $index; ?>.value = selectedPrice;
                                                });
                                            </script>
                                        </div>
                                    <?php
                                    }
                                    ?>

                                    <h6> الكمية </h6>
                                    <!-- 
                                    <div class="product_num">
                                        <div class="quantity counter">
                                            <button class="increase-btn"> + </button>
                                            <input id="count_number" type="text" name="" class="quantity-input count_number" value="1" min="1">
                                            <button class="decrease-btn">-</button>
                                        </div>
                                       
                                    </div>
                                -->
                                    <div class="quantity">

                                        <button class="increase-btn"> + </button>
                                        <input name="quantity" type="number" class="quantity-input" value="1" min="1">
                                        <button class="decrease-btn">-</button>
                                    </div>
                                    <div class="present" data-bs-toggle="modal" data-bs-target="#exampleModalgift">
                                        <div class="image">
                                            <div class="pre_image">
                                                <img loading="lazy" src="<?php echo $uploads ?>/shopping-cart.png" alt="">
                                            </div>
                                            <div>
                                                <h4> التغليف كهدية </h4>
                                                <p> لا اريد التغليف كهدية </p>
                                            </div>
                                        </div>
                                        <div style="cursor: pointer;">
                                            <img loading="lazy" src="<?php echo $uploads ?>/small_left_model.png" alt="">
                                        </div>
                                    </div>
                                    <div class="farm_price preset_price">
                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModalgift" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="modal_price">
                                                            <div class="header">
                                                                <h3> اختر تغليف الهدية المناسبة لك </h3>
                                                                <p> تكلفة تغليف الهدية تحسب علي كل نبته </p>
                                                            </div>
                                                            <p class="public"> يختلف كل تغليف من حيث التكلفة النهائية </p>
                                                            <?php
                                                            // Get Gifts 
                                                            $stmt = $connect->prepare("SELECT * FROM gifts");
                                                            $stmt->execute();
                                                            $allgifts  = $stmt->fetchAll();
                                                            foreach ($allgifts as $gift) {
                                                            ?>
                                                                <input style="display: none;" class="select_gift" value="<?php echo $gift['id'] ?>" type="radio" name="gift_id" id="<?php echo $gift['id']; ?>">
                                                                <label class="diffrent_price gifts" for="<?php echo $gift['id']; ?>">
                                                                    <div>
                                                                        <img loading="lazy" src="admin/gifts/images/<?php echo $gift['image']; ?>" alt="">
                                                                    </div>
                                                                    <div>
                                                                        <p> يكتب هنا اسم ووصف التغليف <br><span> <?php echo $gift['price'] ?> ريال </span> </p>
                                                                    </div>
                                                                </label>
                                                            <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-------------- End Gifts ---------------->
                                    <div class="farm">
                                        <div class="check">
                                            <input style="border-color: red;" type="checkbox" name="farm_planet">
                                        </div>
                                        <div>
                                            <h4> يرجى زراعة النبتة بعد التوصيل </h4>
                                            <p> هذة الخدمة داخل مدينة الرياض فقط
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                    إعرف التكلفة
                                                </button>
                                            </p>
                                        </div>
                                        <div class="farm_price">
                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="modal_price">
                                                                <div class="header">
                                                                    <h3> زراعة النباتات </h3>
                                                                    <p> تكلفة زراعة النباتات المختلفة </p>
                                                                </div>
                                                                <p class="public"> تختلف تكلفة زراعة النباتات طبقا لعامل طول ونوع النباتات من حيث كونها زهور موسمية أو أشجار مستديمة الخضرة طبقا للجدول التالي </p>
                                                                <div class="farm_services">
                                                                    <p> خدمة الزرعة تشمل: </p>
                                                                    <h4> الحفر - التسميد - الزراعة - نظافة الموقع. </h4>
                                                                </div>
                                                                <div class="diffrent_price">
                                                                    <div>
                                                                        <img loading="lazy" src="<?php echo $uploads ?>/tree.svg" alt="">
                                                                    </div>
                                                                    <div>
                                                                        <p> أشجار التي طولها من 3 م وأعلى تبدأ من <span> 30 ريال </span> </p>
                                                                    </div>
                                                                </div>
                                                                <div class="diffrent_price">
                                                                    <div>
                                                                        <img loading="lazy" src="<?php echo $uploads ?>/flower-pot.svg" alt="">
                                                                    </div>
                                                                    <div>
                                                                        <p> البناتات التي اقل من 3 م تبدأ من <span> 20 ريال </span> </p>
                                                                    </div>
                                                                </div>
                                                                <div class="diffrent_price">
                                                                    <div>
                                                                        <img loading="lazy" src="<?php echo $uploads ?>/sakura.svg" alt="">
                                                                    </div>
                                                                    <div>
                                                                        <p> الزهور الموسمية<span> 2 ريال </span> </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--
                                <div class="total_price">
                                    <div class="total">
                                        <div>
                                            <h5> المجموع الفرعي: </h5>
                                            <p> إجمالي سعر النباتات </p>
                                        </div>
                                        <div>
                                            <p class="price_num"> <?php echo number_format($product_price, 2); ?> ر.س </p>
                                        </div>
                                    </div>
                                    <div class="total">
                                        <div>
                                            <h5> تكلفة الإضافات: </h5>
                                            <p> تكلفة الزراعة + تكلفة التغليف كهدية </p>
                                        </div>
                                        <div>
                                            <p class="price_num"> 87.00 ر.س </p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="total">
                                        <div>
                                            <h5> إجمالي التكلفة </h5>
                                            <p> المبلغ المطلوب دفعه </p>
                                        </div>
                                        <div>
                                            <p class="price_num"> 87.00 ر.س </p>
                                        </div>
                                    </div>
                                </div>
                                                    -->
                                    <div class="add_cart">
                                        <button class="btn global_button cart" name="add_to_cart"> <img loading="lazy" src="<?php echo $uploads ?>/shopping-cart-2.png" alt=""> أضف الي السلة </button>
                                        <button class="btn wishlist" name="add_to_wishlist"> <img loading="lazy" src="<?php echo $uploads ?>/heart.png" alt=""> أضف الي المفضلة </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- START NEWWER PRODUCTS -->
    <?php
    if ($related_products != null) { ?>
        <div class="new_producs related_product">
            <div class="container">
                <div class="data">
                    <div class="data_header">
                        <div class="data_header_name">
                            <br>
                            <br>
                            <h2 class='header2' style="margin-bottom: 25px;">كثيرًا ما يتم شراؤها معًا </h2>
                        </div>
                    </div>
                    <div class="linked_products">
                        <?php
                        $related_products = explode(',', $related_products);
                        $related_total_price = 0;
                        foreach ($related_products as $relate_pro) {
                            $stmt = $connect->prepare("SELECT * FROM products WHERE id = ?");
                            $stmt->execute(array($relate_pro));
                            $product_data_related = $stmt->fetch();
                        ?>
                            <div class="link_pro">
                                <!-- <input type="checkbox" name="related_select" checked> -->
                                <img loading="lazy" class="main_image" src="uploads/product.png" alt="">
                                <div class="product_details">
                                    <h2> <a href="product?slug=<?php echo $product_data_related['slug']; ?>"> <?php echo $product_data_related['name']; ?> </a> </h2>
                                    <h4 class='price'> <?php echo number_format($product_data_related['price'], 2); ?> ر.س </h4>
                                </div>
                            </div>
                            <span class="plus_related"> + </span>
                        <?php
                            $related_total_price = $related_total_price + $product_data_related['price'];
                        }
                        ?>
                        <div class="link_pro total_links">
                            <div class="total">
                                <p> إجمالي السعر: <span> <?php echo $related_total_price; ?> ر.س </span> </p>
                            </div>
                            <div>
                                <form action="" method="post">
                                    <button class="btn global_button" name="add_to_cart_related"> <img loading="lazy" src="<?php echo $uploads ?>/shopping-cart-2.png" alt=""> أضف الي السلة </button>
                                </form>
                                <?php
                                if (isset($_POST['add_to_cart_related'])) {
                                    foreach ($related_products as $related_pro) {
                                        $stmt = $connect->prepare("SELECT * FROM products WHERE id = ?");
                                        $stmt->execute(array($related_pro));
                                        $product_data_related = $stmt->fetch();
                                        $price =  $product_data_related['price'];
                                        $product_id = $product_data_related['id'];
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
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php  } ?>
    <!-- END NEWWER PRODUCTS  -->
    <!-- START NEWWER PRODUCTS -->
    <div class="new_producs index_all_cat">
        <div class="container">
            <div class="data" style="box-shadow: none;">
                <div class="data_header">
                    <div class="data_header_name">
                        <h2 class='header2' style="margin-right:0"> مراكن يمكنك اضافتها </h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="product_info">
                            <img loading="lazy" class="main_image" src="uploads/product.png" alt="">
                            <div class="product_details">
                                <h2>نبات ملكة النهار</h2>
                                <h4 class='price'> 87.00 ر.س </h4>
                                <div class='add_cart'>
                                    <div>
                                        <a href="#" class='btn global_button'> <img loading="lazy" src="uploads/shopping-cart.png" alt=""> أضف
                                            الي السلة </a>
                                    </div>
                                    <div class="heart">
                                        <img loading="lazy" src="uploads/heart.png" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
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
                    <div class="col-lg-3">
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
                    <div class="col-lg-3">
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
    </div>
    <!-- END NEWWER PRODUCTS  -->

    <!-- START NEWWER PRODUCTS -->
    <div class="new_producs index_all_cat" style="padding-top: 0;">
        <div class="container">
            <div class="data" style="box-shadow: none;">
                <div class="data_header">
                    <div class="data_header_name">
                        <h2 class='header2' style="margin-right:0"> تربات زراعية </h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
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
                    <div class="col-lg-3">
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
                    <div class="col-lg-3">
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
                    <div class="col-lg-3">
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
    </div>
    <!-- END NEWWER PRODUCTS  -->


    <!-- START NEWWER PRODUCTS -->
    <div class="new_producs index_all_cat" style="padding-top: 0;">
        <div class="container">
            <div class="data" style="box-shadow: none;">
                <div class="data_header">
                    <div class="data_header_name">
                        <h2 class='header2' style="margin-right:0"> ربما يعجبك أيضا </h2>
                        <p> لأنك تصفحت <?php echo $product_name; ?> </p>
                    </div>
                </div>
                <div class="row">
                    <?php
                    // get product from the same category 
                    $stmt = $connect->prepare("SELECT * FROM products WHERE cat_id = ? AND id !=? ORDER BY id DESC LIMIT 4");
                    $stmt->execute(array($product_category, $product_id));
                    $allproduct = $stmt->fetchAll();
                    foreach ($allproduct as $product) {
                    ?>
                        <div class="col-lg-3">
                            <div class="product_info">
                                <img loading="lazy" class="main_image" src="uploads/product.png" alt="">
                                <div class="product_details">
                                    <h2> <a href="product?slug=<?php echo $product['slug']; ?>"> <?php echo $product['name']; ?> </a> </h2>
                                    <?php
                                    $maximumPrice = -INF; // قيمة أقصى سعر ممكنة
                                    $minimumPrice = INF; // قيمة أدنى سعر ممكنة
                                    // نشوف علي المنتج يحتوي علي متغيرات او لا 
                                    $stmt = $connect->prepare("SELECT * FROM product_details WHERE pro_id = ? AND pro_price != '' AND pro_price != null AND pro_price != 0 ");
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
                                                    <a href="cart" class='btn global_button'> <img loading="lazy" src="uploads/shopping-cart.png" alt="">
                                                        مشاهدة السلة
                                                    </a>
                                                <?php
                                                } else {
                                                ?>
                                                    <?php
                                                    if ($count_pro_attr > 0) {
                                                    ?>
                                                        <a href="product?slug=<?php echo $product['slug']; ?>" class='btn global_button'> <img loading="lazy" src="uploads/shopping-cart.png" alt="">
                                                            مشاهدة الاختيارات
                                                        </a>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <button name="add_to_cart" class='btn global_button'> <img loading="lazy" src="uploads/shopping-cart.png" alt=""> أضف
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
                                                    <img loading="lazy" src="<?php echo $uploads; ?>/heart2.svg" alt="">
                                                <?php
                                                } else {
                                                ?>
                                                    <button name="add_to_fav" type="submit" style="border: none; background-color:transparent">
                                                        <img loading="lazy" src="<?php echo $uploads ?>/heart.png" alt="">
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
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- END NEWWER PRODUCTS  -->


    <!-- START NEWWER PRODUCTS -->
    <div class="index_all_cat product_testmonails" style="padding-top: 0;">
        <div class="container">
            <div class="data" style="box-shadow: none;">
                <div class="data_header">
                    <div class="data_header_name">
                        <h2 class='header2' style="margin-right:0"> التقييمات </h2>
                        <p> ماذا قال العملاء عن النبتة والمتجر </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="testmonails">
                            <p> لقد كانت النباتات التي استلمتها بحالة جيدة وصحية،
                                وقد تم تغليفها بشكل جيد
                                وبعناية لضمان وصولها بشكل آمن وسليم. كما أن النباتات تتمتع بأوراق خضراء جميلة وصحية،
                                وقد كانت مطابقة للصور المعروضة على الموقع.
                            </p>
                            <h4> مازن محمد </h4>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="testmonails">
                            <p> لقد كانت النباتات التي استلمتها بحالة جيدة وصحية،
                                وقد تم تغليفها بشكل جيد
                                وبعناية لضمان وصولها بشكل آمن وسليم. كما أن النباتات تتمتع بأوراق خضراء جميلة وصحية،
                                وقد كانت مطابقة للصور المعروضة على الموقع.
                            </p>
                            <h4> مازن محمد </h4>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="testmonails">
                            <p> لقد كانت النباتات التي استلمتها بحالة جيدة وصحية،
                                وقد تم تغليفها بشكل جيد
                                وبعناية لضمان وصولها بشكل آمن وسليم. كما أن النباتات تتمتع بأوراق خضراء جميلة وصحية،
                                وقد كانت مطابقة للصور المعروضة على الموقع.
                            </p>
                            <h4> مازن محمد </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END NEWWER PRODUCTS  -->


<?php

} else {
    header("Location:shop");
}
include $tem . 'footer.php';
ob_end_flush();
?>

<script>
    const decreaseButtons = document.querySelectorAll('.decrease-btn');
    const increaseButtons = document.querySelectorAll('.increase-btn');

    decreaseButtons.forEach((button) => {
        button.addEventListener('click', (event) => {
            event.preventDefault(); // Prevent default behavior
            // Add your custom code here for decreasing quantity
        });
    });

    increaseButtons.forEach((button) => {
        button.addEventListener('click', (event) => {
            event.preventDefault(); // Prevent default behavior
            // Add your custom code here for increasing quantity
        });
    });
</script>