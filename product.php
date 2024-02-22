<?php
ob_start();
session_start();
$page_title = 'تفاصيل المنتج ';
include 'init.php';
if (isset($_GET['slug'])) {
    $slug = $_GET['slug'];
    $stmt = $connect->prepare("SELECT * FROM products WHERE slug = ? ORDER BY id  LIMIT 1 ");
    $stmt->execute(array($slug));
    $product_data = $stmt->fetch();
    $count  = $stmt->rowCount();
    /************ */
    if ($count > 0) {
        $product_id = $product_data['id'];
        $product_name = $product_data['name'];
        $product_desc = $product_data['description'];
        $product_price = $product_data['price'];
        $product_sale_price = $product_data['sale_price'];
        $product_category = $product_data['cat_id'];
        $related_products = $product_data['related_product'];
        $public_tail = $product_data['public_tail'];
        if($public_tail == '' || $public_tail == 0 || $public_tail == null){
            $public_tail = 5;
        }
        $more_info = $product_data['more_info'];
        // get product category 
        $stmt = $connect->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->execute(array($product_category));
        $category_data = $stmt->fetch();
        $cat_name = $category_data['name'];
        $cat_slug = $category_data['slug'];
        $category_type = $category_data['main_category'];
    } else {
        header("Location:404");
    }
    ///////////////////// Add To Cart   /////////////////////
    if (isset($_POST['add_to_cart'])) {
        $product_id = $_POST['product_id'];
        if(isset($_POST['product_name'])){
            $product_name = $_POST['product_name'];
        }else{
            $product_name = $product_name;
        }
        if (isset($_POST['vartion_select']) && $_POST['vartion_select'] != '') {
            $price = $_POST['select_price'];
            $vartion_name = $_POST['vartion_select'];
        } else {
            $vartion_name = null;
            if ($product_sale_price != '') {
                $price = $product_sale_price;
            } else {
                $price = $product_price;
            }
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
            $farm_planet = $public_tail;
        } else {
            $farm_planet = null;
        }

        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
        } else {
            $user_id = null;
        }
        $total_price = null;
        $stmt = $connect->prepare("INSERT INTO cart (user_id, cookie_id, product_id,product_name,quantity,price,vartion_name,farm_service,
            gift_id,total_price)
    VALUES(:zuser_id, :zcookie_id,:zproduct_id,:zproduct_name,:zquantity,:zprice,:zvartion_name,:zfarm_service,:zgift_id,:ztotal_price)
    ");
        $stmt->execute(array(
            "zuser_id" => $user_id,
            "zcookie_id" => $cookie_id,
            "zproduct_id" => $product_id,
            "zproduct_name" => $product_name,
            "zquantity" => $quantity,
            "zprice" => $price,
            "zvartion_name" => $vartion_name,
            "zfarm_service" => $farm_planet,
            "zgift_id" => $gift_id,
            "ztotal_price" => $total_price,
        ));
        if ($stmt) {
            alertcart();
        }
    }

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
                <p> <a href="index"> الرئيسية </a> \ <span> <a href="shop"> المتجر </a> </span> \ <span> <a href="category_products?cat=<?php echo $cat_slug; ?>"> <?php echo  $cat_name ?> </a> </span> \ <?php echo $product_name ?> </p>
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
                                    <div class="main-slider gallery-lb">
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
                                                if ($gallary['image'] != null || $gallary['image'] != '') {
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
                                        <?php
                                        } else {
                                        }
                                        ?>
                                        <?php
                                        // check if this product have images in Attributes 
                                        $stmt = $connect->prepare("SELECT * FROM product_details2 WHERE product_id = ?");
                                        $stmt->execute(array($product_id));
                                        $allattimages = $stmt->fetchAll();
                                        $count_att_g = count($allattimages);
                                        if ($count_att_g > 0) {
                                            foreach ($allattimages as $att_image) {
                                        ?>
                                                <div>
                                                    <a href="admin/product_images/<?php echo $att_image['image']; ?>">
                                                        <img loading="lazy" src="admin/product_images/<?php echo $att_image['image']; ?>" alt="Image 2">
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
                                    <?php
                                    if ($count_g > 1) {
                                    ?>
                                        <div class="thumbnail-slider products_thumnails" id="products_thumnails">
                                            <div>
                                                <img class="thumbnail-image" loading="lazy" src="admin/product_images/<?php echo $product_data_image['main_image']; ?>" alt="Thumbnail 1" data-image2="<?php echo $product_data_image['main_image']; ?>">
                                            </div>
                                            <?php
                                            if ($count_g > 0) {
                                                foreach ($allgallary as $gallary) {
                                                    if ($gallary['image'] != null || $gallary['image'] != '') {
                                            ?>
                                                        <div>
                                                            <img class="thumbnail-image" loading="lazy" src="admin/product_images/<?php echo $gallary['image']; ?>" alt="Image 2xcxcxc" data-image2="<?php echo $gallary['image']; ?>">
                                                        </div>
                                                    <?php
                                                    }
                                                    ?>
                                                <?php
                                                }
                                                ?>
                                                <?php
                                            }
                                            if ($count_att_g > 0) {
                                                foreach ($allattimages as $att_image) {
                                                    if ($att_image['image'] != '' || $att_image['image'] != null) {
                                                ?>
                                                        <div>
                                                            <img class="thumbnail-image" loading="lazy" src="admin/product_images/<?php echo $att_image['image']; ?>" alt="Image 2" data-image2="<?php echo $att_image['image']; ?>">
                                                        </div>
                                                    <?php
                                                    }
                                                    ?>
                                                <?php
                                                }
                                                ?>
                                            <?php
                                            }
                                            ?>
                                            <!-- يمكنك إضافة المزيد من الصور المصغرة هنا -->
                                        </div>
                                    <?php
                                    }
                                    ?>

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
                                $stmt = $connect->prepare("SELECT * FROM product_details2 WHERE product_id = ? AND price !='' AND price !=0");
                                $stmt->execute(array($product_id));
                                $att_count = $stmt->rowCount();
                                if ($att_count > 0) {
                                    $allproduct_data = $stmt->fetchAll();
                                    foreach ($allproduct_data as $product_data) {
                                        $pro_price =  $product_data['price'];
                                        $maximumPrice = max($maximumPrice, $pro_price);
                                        $minimumPrice = min($minimumPrice, $pro_price);
                                    }
                                ?>
                                    <p> يبدأ من: <span> <?php echo number_format($minimumPrice, 2); ?> - <?php echo number_format($maximumPrice, 2); ?> ر.س </span> </p>
                                <?php
                                } else {
                                ?>
                                    <?php
                                    if (empty($product_sale_price)) {
                                    ?>
                                        <p> السعر : <span> <?php echo number_format($product_price, 2); ?> ر.س </span> </p>
                                    <?php
                                    } else {
                                    ?>
                                        <div style="display: flex;">
                                            <p> السعر : <span style="text-decoration: line-through; margin-left: 15px;"> <?php echo number_format($product_price, 2); ?> ر.س </span> </p>
                                            <p style="font-weight: bold;"> <span> <?php echo number_format($product_sale_price, 2); ?> ر.س </span> </p>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                <?php
                                } ?>
                                <div class="more_info">
                                    <p style="color: #000 !important;"> <?php echo $more_info; ?> </p>
                                </div>
                                <div class="support">
                                    <div>
                                        <img loading="lazy" src="<?php echo $uploads ?>/support.svg" alt="">
                                    </div>
                                    <div>
                                        <a href="https://t.me/mshtly" style="text-decoration: none;">
                                            <h4> دعم الخبراء المجاني </h4>
                                            <p style="color: #3c3b3b;"> للعناية بالنباتات أو اختيار الأنسب من مهندسي مشتلي </p>
                                        </a>
                                    </div>
                                </div>
                                <div class="attention">
                                    <h3> تنويه </h3>
                                    <p> الصور المعروضة للمنتج هنا توضح مميزاتها وشكلها بعد زراعتها ورعايتها وتقديم كامل احتياجاتها كما هو موضح في وصف النبتة، وبإمكانكم الحصول على تفاصيل أكثر من خلال دعم خبرائنا المجاني . </p>
                                </div>
                            </div>
                        </div>
                        <div class="show_in_small_screen">
                            <div class="request">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="product_id" value="<?php echo $product_id ?>" id="">
                                    <input type="hidden" name="product_name" value="<?php echo $product_name ?>" id="">
                                    <h3> اطلبه الآن </h3>
                                    <?php
                                    $stmt = $connect->prepare("SELECT * FROM product_details2 WHERE product_id = ?");
                                    $stmt->execute(array($product_id));
                                    $allpro_attibutes = $stmt->fetchAll();
                                    $allpro_attibutes_count = count($allpro_attibutes); ?>
                                    <div class="options">
                                        <?php
                                        if ($allpro_attibutes_count > 0) {
                                        ?>
                                            <h6> حدد احد الاختيارات </h6>
                                        <?php
                                        }
                                        ?>
                                        <div class="colors">
                                            <?php
                                            if ($allpro_attibutes_count > 0) {
                                                echo '<select class="form-control" name="vartion_select2" required>';
                                                echo '<option value=""> "حدد احد الخيارات" </option>';
                                                foreach ($allpro_attibutes as $allpro_att) {
                                                    echo '<option value="' . $allpro_att['id'] . '" data-image="' . $allpro_att['image'] . '" data-price="' . $allpro_att['price'] . '" id="' . $allpro_att['id'] . '">' . $allpro_att['vartions_name'] . '</option>';
                                                }
                                                echo '</select>';
                                                echo '<div>';
                                                echo '<h6>السعر</h6>';
                                                if ($allpro_att['price'] != '') {
                                                    echo '<span class="text-bold" id="selected_price2">0.00 ر.س</span>';
                                                    echo '<input id="price_value2" type="hidden" name="select_price" value="' . $allpro_att['price'] . '">';
                                                } else {
                                                    echo '<span class="text-bold"> ' . $product_data['price'] . ' ر.س</span>';
                                                    echo '<input  type="hidden" name="select_price" value="' . $product_data['price'] . '">';
                                                }

                                                echo '</div>';
                                            }
                                            ?>

                                        </div>
                                        <h6> الكمية </h6>
                                        <div class="quantity">
                                            <button class="increase-btn"> + </button>
                                            <input name="quantity" type="number" class="quantity-input" value="1" min="1">
                                            <button class="decrease-btn">-</button>
                                        </div>
                                        <div class="present" data-bs-toggle="modal" data-bs-target="#exampleModalgift2">
                                            <div class="image">
                                                <div class="pre_image">
                                                    <img loading="lazy" src="<?php echo $uploads ?>/shopping-cart.png" alt="">
                                                </div>
                                                <div>
                                                    <h4> التغليف كهدية </h4>
                                                    <p> استعرض النماذج والأسعار. </p>
                                                </div>
                                            </div>
                                            <div style="cursor: pointer;">
                                                <img loading="lazy" src="<?php echo $uploads ?>/small_left_model.png" alt="">
                                            </div>
                                        </div>
                                        <div class="farm_price preset_price">
                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModalgift2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                                    <input style="display: none;" class="select_gift" value="<?php echo $gift['id'] ?>" type="radio" name="gift_id" id="<?php echo $gift['id']; ?>2">
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
                                                            <button type="button" data-bs-dismiss="modal" aria-label="Close" style="background-color:#5c8e00; border-radius: 50px; color:#fff;margin:auto;display: block;" class="btn"> حفظ </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-------------- End Gifts ---------------->




                                        <?php
                                        if ($category_type == 1) {
                                        ?>
                                            <div class="farm">
                                                <div class="check">
                                                    <input style="border-color: red;" type="checkbox" name="farm_planet">
                                                </div>
                                                <div>
                                                    <h4> يرجى زراعة النبتة بعد التوصيل </h4>
                                                    <p> هذة الخدمة داخل مدينة الرياض فقط
                                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal2">
                                                            إعرف التكلفة
                                                        </button>
                                                    </p>
                                                </div>
                                                <div class="farm_price">
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                                        <?php
                                                                        // get the tails 
                                                                        $stmt = $connect->prepare("SELECT * FROM public_tails");
                                                                        $stmt->execute();
                                                                        $available_tail = $stmt->fetchAll();
                                                                        foreach ($available_tail as $tail) { ?>
                                                                            <div class="diffrent_price">
                                                                                <div>
                                                                                    <img loading="lazy" src="<?php echo $uploads ?>/tree.svg" alt="">
                                                                                </div>
                                                                                <div>
                                                                                    <p> <?php echo $tail['name']; ?> <span> <?php echo $tail['price']; ?> ريال </span> </p>
                                                                                </div>
                                                                            </div>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>

                                        <div class="add_cart">
                                            <?php
                                            $stmt = $connect->prepare("SELECT * FROM cart WHERE product_id = ? AND cookie_id = ?");
                                            $stmt->execute(array($product_id, $cookie_id));
                                            $count_pro = $stmt->rowCount();
                                            if ($count_pro > 0) {
                                            ?>
                                                <a class="btn global_button cart" href="cart"> <img loading="lazy" src="<?php echo $uploads ?>/shopping-cart-2.png" alt=""> مشاهدة السلة </a>
                                            <?php
                                            } else {
                                            ?>
                                                <button class="btn global_button cart" name="add_to_cart"> <img loading="lazy" src="<?php echo $uploads ?>/shopping-cart-2.png" alt=""> أضف الي السلة </button>
                                            <?php
                                            }
                                            ?>
                                            <button class="btn wishlist" name="add_to_wishlist"> <img loading="lazy" src="<?php echo $uploads ?>/heart.png" alt=""> أضف الي المفضلة </button>
                                        </div>
                                    </div>
                                </form>
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
                            <!-- AddToAny BEGIN -->
                            <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                                <!-- <a class="a2a_dd" href="https://www.addtoany.com/share"></a> -->
                                <a class="a2a_button_facebook"></a>
                                <a class="a2a_button_whatsapp"></a>
                                <a class="a2a_button_linkedin"></a>
                                <a class="a2a_button_twitter"></a>
                                <a class="a2a_button_x"></a>
                                <a class="a2a_button_telegram"></a>
                            </div>
                            <script async src="https://static.addtoany.com/menu/page.js"></script>
                            <!-- AddToAny END -->

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
                    <div class="col-lg-4 show_in_large_screen">
                        <div class="request">
                            <form action="" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="product_id" value="<?php echo $product_id ?>" id="">
                                <h3> اطلبه الآن </h3>
                                <?php
                                $stmt = $connect->prepare("SELECT * FROM product_details2 WHERE product_id = ?");
                                $stmt->execute(array($product_id));
                                $allpro_attibutes = $stmt->fetchAll();
                                $allpro_attibutes_count = count($allpro_attibutes); ?>
                                <div class="options">
                                    <?php
                                    if ($allpro_attibutes_count > 0) {
                                    ?>
                                        <h6> حدد احد الاختيارات </h6>
                                    <?php
                                    }
                                    ?>
                                    <div class="colors">
                                        <?php
                                        if ($allpro_attibutes_count > 0) {
                                            echo '<select class="form-control" name="vartion_select" required>';
                                            echo '<option value=""> "حدد احد الخيارات" </option>';
                                            foreach ($allpro_attibutes as $allpro_att) {
                                                echo '<option value="' . $allpro_att['id'] . '" data-image="' . $allpro_att['image'] . '" data-price="' . $allpro_att['price'] . '" id="' . $allpro_att['id'] . '">' . $allpro_att['vartions_name'] . '</option>';
                                            }
                                            echo '</select>';
                                            echo '<div>';
                                            echo '<h6>السعر</h6>';
                                            if ($allpro_att['price'] != '') {
                                                echo '<span class="text-bold" id="selected_price">0.00 ر.س</span>';
                                                echo '<input id="price_value" type="hidden" name="select_price" value="' . $allpro_att['price'] . '">';
                                            }else{
                                                echo '<span class="text-bold">'.$product_data['price'].' ر.س</span>';
                                                echo '<input type="hidden" name="select_price" value="' . $product_data['price'] . '">';
                                            }
 
                                            echo '</div>';
                                        }
                                        ?>

                                    </div>
                                    <h6> الكمية </h6>
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
                                                <p> استعرض النماذج والأسعار. </p>
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
                                                        <button type="button" data-bs-dismiss="modal" aria-label="Close" style="background-color:#5c8e00; border-radius: 50px; color:#fff;margin:auto;display: block;" class="btn"> حفظ </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-------------- End Gifts ---------------->
                                    <?php
                                    if ($category_type == 1) {
                                    ?>

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
                                                                    <?php
                                                                    // get the tails 
                                                                    $stmt = $connect->prepare("SELECT * FROM public_tails");
                                                                    $stmt->execute();
                                                                    $available_tail = $stmt->fetchAll();
                                                                    foreach ($available_tail as $tail) { ?>
                                                                        <div class="diffrent_price">
                                                                            <div>
                                                                                <img loading="lazy" src="<?php echo $uploads ?>/tree.svg" alt="">
                                                                            </div>
                                                                            <div>
                                                                                <p> <?php echo $tail['name']; ?> <span> <?php echo $tail['price']; ?> ريال </span> </p>
                                                                            </div>
                                                                        </div>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    <div class="add_cart">
                                        <?php
                                        $stmt = $connect->prepare("SELECT * FROM cart WHERE product_id = ? AND cookie_id = ?");
                                        $stmt->execute(array($product_id, $cookie_id));
                                        $count_pro = $stmt->rowCount();
                                        if ($count_pro > 0) {
                                        ?>
                                            <a class="btn global_button cart" href="cart"> <img loading="lazy" src="<?php echo $uploads ?>/shopping-cart-2.png" alt=""> مشاهدة السلة </a>
                                        <?php
                                        } else {
                                        ?>
                                            <button class="btn global_button cart" name="add_to_cart"> <img loading="lazy" src="<?php echo $uploads ?>/shopping-cart-2.png" alt=""> أضف الي السلة </button>
                                        <?php
                                        }
                                        ?>
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
                            $stmt = $connect->prepare("SELECT * FROM product_details2 WHERE product_id = ?");
                            $stmt->execute(array($relate_pro));
                            $product_related = $stmt->fetch();
                            $product_related_count = $stmt->rowCount();
                            if ($product_related_count > 0) {
                            } else {
                                $stmt = $connect->prepare("SELECT * FROM products WHERE id = ?");
                                $stmt->execute(array($relate_pro));
                                $product_data_related = $stmt->fetch();
                        ?>
                                <div class="link_pro">
                                    <!-- <input type="checkbox" name="related_select" checked> -->
                                    <!-- get the product image  -->
                                    <?php
                                    $stmt = $connect->prepare("SELECT * FROM products_image WHERE product_id = ?");
                                    $stmt->execute(array($product_data_related['id']));
                                    $product_image_data = $stmt->fetch();
                                    $product_image_data_count = $stmt->rowCount();
                                    if ($product_image_data_count > 0) {
                                        $product_image_related = $product_image_data['main_image'];
                                    ?>
                                        <img loading="lazy" class="main_image" src="admin/product_images/<?php echo $product_image_related; ?>" alt="">
                                    <?php
                                    } else {
                                    ?>
                                        <img loading="lazy" class="main_image" src="uploads/product.png" alt="">
                                    <?php
                                    }
                                    ?>
                                    <div class="product_details">
                                        <h2> <a href="product?slug=<?php echo $product_data_related['slug']; ?>"> <?php echo $product_data_related['name']; ?> </a> </h2>
                                        <?php
                                        if ($product_data_related['sale_price'] != '') {
                                            $related_price = $product_data_related['sale_price'];
                                        ?>
                                            <h4 class='price' style="text-decoration: line-through;"> <?php echo number_format($product_data_related['price'], 2); ?> ر.س </h4>
                                            <h4 class='price'> <?php echo number_format($product_data_related['sale_price'], 2); ?> ر.س </h4>
                                        <?php
                                        } else {
                                            $related_price = $product_data_related['price'];
                                        ?>
                                            <h4 class='price'> <?php echo number_format($product_data_related['price'], 2); ?> ر.س </h4>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <span class="plus_related"> + </span>
                            <?php
                                $related_total_price = $related_total_price + $related_price;
                            }
                            ?>
                        <?php
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
                                        $stmt = $connect->prepare("SELECT * FROM product_details2 WHERE product_id = ?");
                                        $stmt->execute(array($related_pro));
                                        $product_related = $stmt->fetch();
                                        $product_related_count = $stmt->rowCount();
                                        if ($product_related_count > 0) {
                                        } else {
                                            $stmt = $connect->prepare("SELECT * FROM products WHERE id = ?");
                                            $stmt->execute(array($related_pro));
                                            $product_data_related = $stmt->fetch();
                                            if ($product_data_related['sale_price'] != '') {
                                                $price =  $product_data_related['sale_price'];
                                            } else {
                                                $price =  $product_data_related['price'];
                                            }

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
                    <?php
                    $stmt = $connect->prepare("SELECT * FROM products WHERE cat_id = 935 ORDER BY id LIMIT 8");
                    $stmt->execute();
                    $allproducts = $stmt->fetchAll();
                    foreach ($allproducts as $product) {
                    ?>
                        <div class="col-lg-3 col-6">
                            <?php
                            include 'tempelate/product.php';
                            ?>
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
    <!-- <div class="new_producs index_all_cat" style="padding-top: 0;">
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
    </div> -->
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
                    $stmt = $connect->prepare("SELECT * FROM products WHERE cat_id = ? AND name !='' AND price !='' AND id !=? ORDER BY id DESC LIMIT 8");
                    $stmt->execute(array($product_category, $product_id));
                    $allproduct = $stmt->fetchAll();
                    foreach ($allproduct as $product) {
                    ?>
                        <div class="col-lg-3 col-6">
                            <?php
                            include 'tempelate/product.php';
                            ?>
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
    <!-- <div class="index_all_cat product_testmonails" style="padding-top: 0;">
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
    </div> -->
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

<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>