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
    } else {
        header("Location:404");
    }


?>
    <!-- START SELECT DATA HEADER -->
    <div class="select_plan_head">
        <div class="container">
            <div class="data">
                <div class="head">
                    <img src="<?php echo $uploads ?>plant.svg" alt="">
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
                <p> <a href="index"> الرئيسية </a> \ <span> نباتات خارجية </span> \ <span> نباتات خارجية </span> شجرة الدفلة </p>
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
                                <img src="<?php echo $uploads ?>/product.png" alt="">
                            </div>
                            <div class="product_info">
                                <h2> <img src="<?php echo $uploads ?>/left_arrow.png" alt=""> <?php echo $product_name; ?> </h2>
                                <p> يبدأ من: <span> <?php echo number_format($product_price, 2); ?> ر.س </span> </p>
                                <div class="support">
                                    <div>
                                        <img src="<?php echo $uploads ?>/support.svg" alt="">
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
                            <h3> وصف النبات </h3>
                            <p> <?php echo $product_desc ?> </p>
                            <button class="btn"> رقم النبات:#<?php echo $product_id; ?> </button>
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
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            كيفية العناية بالنبات؟
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p> نعم، يوفر مشتلي مجموعة واسعة من النباتات الطبية، ومن بينها النعناع والزعتر والألوفيرا والشمام والكركم والزنجبيل والكمون والكركديه وغيرها الكثير. </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingtwo">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            الشحن والاسترجاع
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingtwo" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <p> نعم، يوفر مشتلي مجموعة واسعة من النباتات الطبية، ومن بينها النعناع والزعتر والألوفيرا والشمام والكركم والزنجبيل والكمون والكركديه وغيرها الكثير. </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="request">
                            <h3> اطلبه الآن </h3>
                            <div class="options">
                                <h6> لون الزهرة </h6>
                                <div class="colors">
                                    <div class="color">
                                        <p> <span class="" style=" background-color: red;"> </span> احمر <i class="fa fa-check"></i> </p>
                                    </div>
                                    <div class="color">
                                        <p> <span class="" style=" background-color: #fff;"> </span> ابيض <i class="fa fa-check"></i> </p>
                                    </div>
                                </div>
                                <h6> طول النبتة </h6>
                                <div class="input_box">
                                    <select name="" id="" class="form-control select2">
                                        <option value="100"> 100 سم </option>
                                        <option value="200"> 200 سم </option>
                                        <option value="300"> 300 سم </option>
                                    </select>
                                </div>
                                <h6> الكمية </h6>
                                <div class="quantity">
                                    <button class="increase-btn"> + </button>
                                    <input type="number" class="quantity-input" value="1" min="1">
                                    <button class="decrease-btn">-</button>
                                </div>
                                <div class="present" data-bs-toggle="modal" data-bs-target="#exampleModalgift">
                                    <div class="image">
                                        <div class="pre_image">
                                            <img src="<?php echo $uploads ?>/shopping-cart.png" alt="">
                                        </div>
                                        <div>
                                            <h4> التغليف كهدية </h4>
                                            <p> لا اريد التغليف كهدية </p>
                                        </div>
                                    </div>
                                    <div style="cursor: pointer;">
                                        <img src="<?php echo $uploads ?>/small_left_model.png" alt="">
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
                                                        
                                                        
                                                        ?>
                                                        <div class="diffrent_price">
                                                            <div>
                                                                <img src="<?php echo $uploads ?>/shopping-cart.png" alt="">
                                                            </div>
                                                            <div>
                                                                <p> أشجار التي طولها من 3 م وأعلى تبدأ من <span> 30 ريال </span> </p>
                                                            </div>
                                                        </div>
                                                        <div class="diffrent_price">
                                                            <div>
                                                                <img src="<?php echo $uploads ?>/shopping-cart.png" alt="">
                                                            </div>
                                                            <div>
                                                                <p> البناتات التي اقل من 3 م تبدأ من <span> 20 ريال </span> </p>
                                                            </div>
                                                        </div>
                                                        <div class="diffrent_price">
                                                            <div>
                                                                <img src="<?php echo $uploads ?>/shopping-cart.png" alt="">
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
                                                                    <img src="<?php echo $uploads ?>/tree.svg" alt="">
                                                                </div>
                                                                <div>
                                                                    <p> أشجار التي طولها من 3 م وأعلى تبدأ من <span> 30 ريال </span> </p>
                                                                </div>
                                                            </div>
                                                            <div class="diffrent_price">
                                                                <div>
                                                                    <img src="<?php echo $uploads ?>/flower-pot.svg" alt="">
                                                                </div>
                                                                <div>
                                                                    <p> البناتات التي اقل من 3 م تبدأ من <span> 20 ريال </span> </p>
                                                                </div>
                                                            </div>
                                                            <div class="diffrent_price">
                                                                <div>
                                                                    <img src="<?php echo $uploads ?>/sakura.svg" alt="">
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
                                <div class="total_price">
                                    <div class="total">
                                        <div>
                                            <h5> المجموع الفرعي: </h5>
                                            <p> إجمالي سعر النباتات </p>
                                        </div>
                                        <div>
                                            <p class="price_num"> 87.00 ر.س </p>
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
                                <div class="add_cart">
                                    <button class="btn global_button cart" name="add_to_cart"> <img src="<?php echo $uploads ?>/shopping-cart-2.png" alt=""> أضف الي السلة </button>
                                    <button class="btn wishlist" name="add_to_wishlist"> <img src="<?php echo $uploads ?>/heart.png" alt=""> أضف الي السلة </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- START NEWWER PRODUCTS -->
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
                    <div class="link_pro">
                        <input type="checkbox" name="related_select" checked>
                        <img class="main_image" src="uploads/product.png" alt="">
                        <div class="product_details">
                            <h2>نبات ملكة النهار</h2>
                            <h4 class='price'> 87.00 ر.س </h4>
                        </div>
                    </div>
                    +
                    <div class="link_pro">
                        <input type="checkbox" name="related_select" checked>
                        <img class="main_image" src="uploads/product.png" alt="">
                        <div class="product_details">
                            <h2>نبات ملكة النهار</h2>
                            <h4 class='price'> 87.00 ر.س </h4>
                        </div>
                    </div>
                    +
                    <div class="link_pro">
                        <input type="checkbox" name="related_select" checked>
                        <img class="main_image" src="uploads/product.png" alt="">
                        <div class="product_details">
                            <h2>نبات ملكة النهار</h2>
                            <h4 class='price'> 87.00 ر.س </h4>
                        </div>
                    </div>
                    <div class="link_pro total_links">
                        <div class="total">
                            <p> إجمالي السعر: <span> 261.00 ر.س </span> </p>
                        </div>
                        <div>
                            <button class="btn global_button" name="add_to_cart"> <img src="<?php echo $uploads ?>/shopping-cart-2.png" alt=""> أضف الي السلة </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                        <p> لأنك تصفحت شجرة الدفلة </p>
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