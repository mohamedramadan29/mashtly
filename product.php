<?php
ob_start();
session_start();
$page_title = 'تفاصيل المنتج ';
include 'init.php';
// الحصول على الجزء من العنوان بعد اسم الملف (مثل product)
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$parts = explode('/', $url);
// البحث عن قيمة المتغير بدون كلمة slug
$key = array_search('product', $parts);
if ($key !== false && isset($parts[$key + 1])) {
    // يمكنك استخدام $parts[$key+1] كـ slug
    $slug = $parts[$key + 1];
    $slug =  urldecode($slug);
} else {
    // لم يتم العثور على slug
    echo "العنوان غير صحيح";
}
// $slug = $_GET['slug'];
$stmt = $connect->prepare("SELECT * FROM products WHERE slug = ? AND publish = 1 ORDER BY id  LIMIT 1 ");
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
    $product_status_store = $product_data['product_status_store'];
    $description_status =   $product_data['new_description_status']; 
    $writer_id = $product_data['writer_id'];
    $reviewer_id = $product_data['reviewer_id'];
    $supervisor_id = $product_data['supervisor_id'];
    if ($public_tail == '' || $public_tail == 0 || $public_tail == null) {
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
    $main_category = $category_data['main_category'];
} else {
    header("Location:https://www.mshtly.com/404");
}
///////////////////// Add To Cart   /////////////////////
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    if (isset($_POST['product_name'])) {
        $product_name = $_POST['product_name'];
    } else {
        $product_name = $product_name;
    }
    if (isset($_POST['vartion_select']) && $_POST['vartion_select'] != '') {
        $price = $_POST['select_price'];
        $vartion_name = $_POST['vartion_select'];
    } else {
        $vartion_name = null;
        if ($product_sale_price != '') {
            $price = $product_sale_price; 
            if ($category_type == 1) {
                $price = $product_sale_price + ($product_sale_price * 0.05); // إضافة 5%
            }
        } else {
            $price = $product_price; 
            if ($category_type == 1) {
                $price += $price * 0.05;
            }
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
    if ($vartion_name != null && $vartion_name != '') {
        $stmt = $connect->prepare("SELECT * FROM cart WHERE cookie_id = ? AND product_id = ? AND vartion_name = ?");
        $stmt->execute(array($cookie_id, $product_id, $vartion_name));
        $cart_data = $stmt->fetch();
        $count_product = $stmt->rowCount();
        if ($count_product > 0) {
            $new_qty = $cart_data['quantity'] + $quantity; // زيادة الكمية بواحد
            $stmt = $connect->prepare("UPDATE cart SET quantity = ?, total_price = ? WHERE cookie_id = ? AND product_id = ? AND vartion_name = ?");
            $stmt->execute(array($new_qty, $cart_data['price'] * $new_qty, $cookie_id, $product_id, $vartion_name)); // تحديث الكمية والسعر الإجمالي
        } else {
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
        }
    } else {
        $stmt = $connect->prepare("SELECT * FROM cart WHERE cookie_id = ? AND product_id = ?");
        $stmt->execute(array($cookie_id, $product_id));
        $cart_data = $stmt->fetch();
        $count_product = $stmt->rowCount();
        if ($count_product > 0) {
            $new_qty = $cart_data['quantity'] + 1; // زيادة الكمية بواحد
            $stmt = $connect->prepare("UPDATE cart SET quantity = ?, total_price = ? WHERE cookie_id = ? AND product_id = ?");
            $stmt->execute(array($new_qty, $cart_data['price'] * $new_qty, $cookie_id, $product_id)); // تحديث الكمية والسعر الإجمالي
        } else {
            $stmt = $connect->prepare("INSERT INTO cart (user_id, cookie_id, product_id,product_name,quantity,price,farm_service,
                gift_id,total_price)
        VALUES(:zuser_id, :zcookie_id,:zproduct_id,:zproduct_name,:zquantity,:zprice,:zfarm_service,:zgift_id,:ztotal_price)
        ");
            $stmt->execute(array(
                "zuser_id" => $user_id,
                "zcookie_id" => $cookie_id,
                "zproduct_id" => $product_id,
                "zproduct_name" => $product_name,
                "zquantity" => $quantity,
                "zprice" => $price, 
                "zfarm_service" => $farm_planet,
                "zgift_id" => $gift_id,
                "ztotal_price" => $total_price,
            ));
        }
    }
    if ($stmt) {
        $total_price = 0;
        $stmt = $connect->prepare("SELECT * FROM cart WHERE cookie_id = ?");
        $stmt->execute(array($cookie_id));
        $count = $stmt->rowCount();
        $allitems = $stmt->fetchAll();
        foreach ($allitems as $item) {
            $total_price = $total_price + ($item['price'] * $item['quantity']);
        }
        // تحديث قيمة الجلسة
        $_SESSION['total'] = $total_price;
        $_SESSION['item_added_to_cart'] = true;
       header("Location: " . $_SERVER['REQUEST_URI']);
       exit; // تأكد من إنهاء التنفيذ بعد إعادة التوجيه
       // alertcart();
    }
}
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        <?php if (isset($_SESSION['item_added_to_cart']) && $_SESSION['item_added_to_cart']): ?>
            // افتح السلة باستخدام Bootstrap
            var cartOffcanvas = new bootstrap.Offcanvas(document.getElementById('cartItems'));
            cartOffcanvas.show();
            <?php unset($_SESSION['item_added_to_cart']); // إزالة الحالة بعد استخدامها ?>
        <?php endif; ?>
    });
</script>
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
?>
<!-- START SELECT DATA HEADER -->
<!-- <div class="select_plan_head">
    <div class="container">
        <div class="data">
            <div class="head">
                <img loading="lazy" src="<?php echo $uploads ?>plant.svg" alt="plant">
                <h2> خصم 10٪ بمناسبة عروض يوم التأسيس </h2>
                <p>
                    استخدم هذا الكود عند اتمام عملية الشراء msh10
                </p>
            </div>
        </div>
    </div>
</div> -->
<!-- END SELECT DATA HEADER -->
<!-- START SELECT DATA HEADER -->
<div class="select_plan_head">
    <div class="container">
        <div class="data">
            <div class="head">
                <img src="<?php echo $uploads ?>plant.svg" alt="plant">
                <h2> اختر النباتات الملائمة لاحتياجاتك </h2>
                <p>
                    ان اختيار النباتات الملائمة أمرًا مهمًا للحصول على حديقة نباتية جميلة وصحية. لذلك، يجب النظر في المساحة المتاحة ومدى تعرض النباتات للضوء والرطوبة ودرجة الحرارة والتربة في المنطقة التي تعيش فيها بالاضافة الي العديد من العوامل الاخري.
                </p>
            </div>
        </div>
    </div>
</div>
<!-- END SELECT DATA HEADER -->
<!-- START breadcrump  -->
<div class="container product_page">
    <div class="data">
        <div class="breadcrump">
            <p> <a href="https://www.mshtly.com"> الرئيسية </a> \ <span> <a href="https://www.mshtly.com/shop"> المتجر </a> </span> \ <span> <a href="https://www.mshtly.com/product-category/<?php echo $cat_slug; ?>"> <?php echo  $cat_name ?> </a> </span> \ <?php echo $product_name ?> </p>
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
                                        <a href="https://www.mshtly.com/uploads/products/<?php echo $product_data_image['main_image']; ?>">
                                            <img loading="lazy" src="https://www.mshtly.com/uploads/products/<?php echo $product_data_image['main_image']; ?>" alt="<?php echo $product_data_image['image_alt'] ?>">
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
                                                    <a href="https://www.mshtly.com/uploads/products/<?php echo $gallary['image']; ?>">
                                                        <img loading="lazy" src="https://www.mshtly.com/uploads/products/<?php echo $gallary['image']; ?>" alt="<?php echo $gallary['image_alt'] ?>">
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
                                            if ($att_image['image'] != '' && $att_image['image'] != null){
                                                ?>
                                                  <div>
                                                <a href="https://www.mshtly.com/uploads/products/<?php echo $att_image['image']; ?>">
                                                    <img loading="lazy" src="https://www.mshtly.com/uploads/products/<?php echo $att_image['image']; ?>" alt="<?php echo $att_image['image_alt'] ?>">
                                                </a>
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
                                    <!-- يمكنك إضافة المزيد من الصور هنا -->
                                </div>
                                <?php
                                if ($count_g > 1) {
                                ?>
                                    <div class="thumbnail-slider products_thumnails" id="products_thumnails">
                                        <div>
                                            <img class="thumbnail-image" loading="lazy" src="https://www.mshtly.com/uploads/products/<?php echo $product_data_image['main_image']; ?>" alt="<?php echo $product_data_image['image_alt'] ?>" data-image2="<?php echo $product_data_image['main_image']; ?>">
                                        </div>
                                        <?php
                                        if ($count_g > 0) {
                                            foreach ($allgallary as $gallary) {
                                                if ($gallary['image'] != null || $gallary['image'] != '') {
                                        ?>
                                                    <div>
                                                        <img class="thumbnail-image" loading="lazy" src="https://www.mshtly.com/uploads/products/<?php echo $gallary['image']; ?>" alt="<?php echo $gallary['image_alt'] ?>" data-image2="<?php echo $gallary['image']; ?>">
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
                                                        <img class="thumbnail-image" loading="lazy" src="https://www.mshtly.com/uploads/products/<?php echo $att_image['image']; ?>" alt="<?php echo $att_image['image_alt'] ?>" data-image2="<?php echo $att_image['image']; ?>">
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
                                <img loading="lazy" class="main_image" src="uploads/product.png" alt="صورة المنتج">
                            <?php
                            }
                            ?>
                        </div>
                        <div class="product_info">
                            <h1 class='product_header'>  <?php echo $product_name; ?> </h2>
                            <!-- check if products have more price in attribute or not -->
                            <?php
                            $maximumPrice = -INF; // قيمة أقصى سعر ممكنة
                            $minimumPrice = INF; // قيمة أدنى سعر ممكنة
                            $oldmaximumPrice = -INF; // قيمة أقصى سعر ممكنة
                            $oldminimumPrice = INF; // قيمة أدنى سعر ممكنة
                            $stmt = $connect->prepare("SELECT * FROM product_details2 WHERE product_id = ? AND price !='' AND price !=0");
                            $stmt->execute(array($product_id));
                            $att_count = $stmt->rowCount();
                            if ($att_count > 0) {
                                $allproduct_data = $stmt->fetchAll();
                                foreach ($allproduct_data as $product_data) {
                                 //   $pro_price =  $product_data['price'] + ($product_data['price'] * 0.10);
                                    #######
                                    $pro_price = $product_data['price'];
                                   
                                    if ($category_type == 1) {
                                        // إضافة 5% على السعر
                                    $pro_price += $pro_price * 0.05;
                                    }

                                    $maximumPrice = max($maximumPrice, $pro_price);
                                    $minimumPrice = min($minimumPrice, $pro_price);
                                }
                            ?>
                                <!-- <p> يبدأ من: <span> <?php // echo number_format($minimumPrice, 2); ?> - <?php //echo number_format($maximumPrice, 2); ?> ر.س </span> </p> -->
                                   <!-- عرض النتائج -->
                                <p> 
                                      السعر : 
                                    <span><?php echo number_format($minimumPrice, 2); ?> - <?php echo number_format($maximumPrice, 2); ?> ر.س</span>
                                </p>
                               
                            <?php
                            } else {
                            ?>
                                <?php
                                if (empty($product_sale_price)) { 
                                    // إذا كان المنتج نبات، يتم خصم 10%
                                    if ($category_type == 1) {
                                        $product_price += $product_price * 0.05;
                                    }                                                                                                                                           
                                ?>
                                    <p> السعر : <span> <?php echo  number_format($product_price, 2) ?>  ر.س </span> </p>
                                <?php
                                } else {
                                     // إضافة 5% على السعر
                         
                                    if ($category_type == 1) {
                                        $product_sale_price += $product_sale_price * 0.05;

                                    }  
                                ?>
                                    <div style="display: flex;">
                                        
                                        <p  style="font-weight: bold;">  السعر :   <span> <?php echo number_format($product_sale_price , 2); ?> ر.س </span> </p>
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
                                    <img loading="lazy" src="<?php echo $uploads ?>/support.svg" alt="دعم الخبراء">
                                </div>
                                <div>
                                    <a href="https://t.me/mshtly" style="text-decoration: none;">
                                        <h4> دعم الخبراء المجاني </h4>
                                        <p style="color: #3c3b3b;"> للعناية بالنباتات أو اختيار الأنسب من مهندسي مشتلي </p>
                                    </a>
                                </div>
                            </div> 
                        </div>
                    </div>
                    <div class="product_description_large_screen">
                        <div class="product_description">
                            <h3> وصف المنتج </h3>
                            <?php 
                           // $product_desc = $product_data['description'];
                            if($description_status == 1){
                            $parts = preg_split('/<h2.*?>/', $product_desc, 2, PREG_SPLIT_NO_EMPTY);
                            $intro = isset($parts[0]) ? trim($parts[0]) : ''; // المقدمة

                            // استخراج العناوين <h2> والمحتوى الذي يليها
                            preg_match_all('/<h2.*?>(.*?)<\/h2>(.*?)(?=<h2|$)/s', $product_desc, $matches, PREG_SET_ORDER);

                            $tabData = [];

                            foreach ($matches as $match) {
                                $title = trim(strip_tags($match[1])); // إزالة الأكواد HTML من العنوان
                                $content = trim($match[2]); // المحتوى التابع للعنوان
                                $tabData[] = ['title' => $title, 'content' => $content];
                            }
                            ?>

                            <!-- عرض مقدمة المنتج إن وجدت -->
                            <?php if (!empty($intro)) : ?>
                                <div class="product-intro">
                                    <?= $intro; ?>
                                </div>
                            <?php endif; ?>

                            <!-- كود عرض التبويبات بأسلوب التبديل (Toggle) -->
                            <div class="container mt-4 new_product_description">
                                <?php foreach ($tabData as $index => $tab) : ?>
                                    <div class="tab-item">
                                        <button class="tab-button" onclick="toggleTab(<?= $index; ?>)">
                                            <?= htmlspecialchars($tab['title']); ?>
                                            <span class="icon"> <i class="bi bi-chevron-down"></i> </span>
                                        </button>
                                        <div class="tab-content" id="tab<?= $index; ?>">
                                            <?= $tab['content']; ?> <!-- عرض المحتوى كما هو دون تعديل -->
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <?php 
                            }else{
                                echo $product_desc;
                            }
                            ?>
                        </div>

                        <div class="writer_info">

                            <?php 
                            if($writer_id != ''){
                            $stmt = $connect->prepare("SELECT * FROM employes WHERE id = ?");
                            $stmt->execute(array($writer_id));
                            $writer = $stmt->fetch();
                            ?>

                        <a href="https://www.localhost/mashtly/writer-info?username=<?php echo $writer['username']; ?>">
                        <div class="writer_info_item">
                            <p> <i class="bi bi-pencil-square"></i> الكاتب  </p>
                            <p> <?php echo $writer['username']; ?> </p>
                        </div>
                        </a>
                        <?php 
                        }
                        ?>
                        <?php 
                        if($reviewer_id != ''){
                        $stmt = $connect->prepare("SELECT * FROM employes WHERE id = ?");
                        $stmt->execute(array($reviewer_id));
                        $reviewer = $stmt->fetch();
                        ?>
                        <a href="https://www.localhost/mashtly/writer-info?username=<?php echo $reviewer['username']; ?>"> 
                        <div class="writer_info_item">
                            <p> <i class="bi bi-pencil-square"></i> المراجع  </p>
                            <p> <?php echo $reviewer['username']; ?> </p>
                        </div>
                        </a>
                        <?php 
                        }
                        ?>
                        <?php 
                        if($supervisor_id != ''){
                        $stmt = $connect->prepare("SELECT * FROM employes WHERE id = ?");
                        $stmt->execute(array($supervisor_id));
                        $supervisor = $stmt->fetch();
                        ?>
                        <a href="https://www.localhost/mashtly/writer-info?username=<?php echo $supervisor['username']; ?>"> 
                        <div class="writer_info_item">
                            <p> <i class="bi bi-pencil-square"></i> المشرف  </p>
                            <p> <?php echo $supervisor['username']; ?> </p>
                        </div>
                        </a>
                        <?php 
                        }
                        ?>
                      </div>
                
                        <div class="social_share">
                            <div>
                                <p> شارك عبر </p>
                            </div>
                            <!-- AddToAny BEGIN -->
                            <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                                <!-- <a class="a2a_dd" href="https://www.addtoany.com/share"></a> -->
                                <a rel="nofollow" class="a2a_button_facebook"></a>
                                <a rel="nofollow" class="a2a_button_whatsapp"></a>
                                <a rel="nofollow" class="a2a_button_linkedin"></a>
                                <a rel="nofollow" class="a2a_button_twitter"></a>
                                <a rel="nofollow" class="a2a_button_x"></a>
                                <a rel="nofollow" class="a2a_button_telegram"></a>
                            </div>
                            <script async src="https://static.addtoany.com/menu/page.js"></script>
                            <!-- AddToAny END -->
                        </div>
                        <?php 
                            if($main_category == 1){
                                ?>
                                 <div class="attention">
                                <h3> تنويه </h3>
                                <p> الصور المعروضة للمنتج هنا توضح مميزاتها وشكلها بعد زراعتها ورعايتها وتقديم كامل احتياجاتها كما هو موضح في وصف النبتة، وبإمكانكم الحصول على تفاصيل أكثر من خلال دعم خبرائنا المجاني . </p>
                            </div>
                                <?php
                            }
                            ?>
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
                </div>
                <!-- <div class="col-lg-4 show_in_large_screen"> -->
                <div class="col-lg-4">
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
                                            if($main_category == 1){
                                                echo '<option value="' . $allpro_att['id'] . '" 
                                                    data-image="' . $allpro_att['image'] . '" 
                                                    data-price="' . ($allpro_att['price'] + ($allpro_att['price'] * 0.05)) . '" 
                                                    id="' . $allpro_att['id'] . '">' 
                                                    . $allpro_att['vartions_name'] . 
                                                '</option>';
                                            }else{
                                                echo '<option value="' . $allpro_att['id'] . '" 
                                                    data-image="' . $allpro_att['image'] . '" 
                                                    data-price="' . $allpro_att['price'] . '" 
                                                    id="' . $allpro_att['id'] . '">' 
                                                    . $allpro_att['vartions_name'] . 
                                                '</option>';
                                            }
                                            
                                        }
                                        echo '</select>';
                                        echo '<div>';
                                        echo '<h6>السعر</h6>';
                                        if ($allpro_att['price'] != '') {
                                            echo '<span class="text-bold" id="selected_price">0.00 ر.س</span>';
                                            echo '<input id="price_value" type="hidden" name="select_price" value="' . $allpro_att['price'] . '">';
                                        } else {
                                            if($main_category == 1){
                                                $product_data_price = $product_data['price'];
                                                $product_data_price += $product_data_price * 0.05;
                                            }
                                            echo '<span class="text-bold">' . $product_data_price . ' ر.س</span>';
                                            echo '<input type="hidden" name="select_price" value="' . $product_data_price . '">';
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
                                <!-- <div class="present" data-bs-toggle="modal" data-bs-target="#exampleModalgift">
                                        <div class="image">
                                            <div class="pre_image">
                                                <img loading="lazy" src="<?php echo $uploads ?>/shopping-cart.png" alt="سلة الشراء">
                                            </div>
                                            <div>
                                                <h4> التغليف كهدية </h4>
                                                <p> استعرض النماذج والأسعار. </p>
                                            </div>
                                        </div>
                                        <div style="cursor: pointer;">
                                            <img loading="lazy" src="<?php echo $uploads ?>/small_left_model.png" alt="التغليف كهدية">
                                        </div>
                                    </div> -->
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
                                                                    <img loading="lazy" src="https://www.mshtly.com/admin/gifts/images/<?php echo $gift['image']; ?>" alt="التغليف كهدية">
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
                                                                            <img loading="lazy" src="<?php echo $uploads ?>/tree.svg" alt="زراعة النباتات">
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
                                    // if ($count_pro > 0) {
                                    ?>
                                    <!-- <a class="btn global_button cart" href="https://www.mshtly.com/cart"> <img loading="lazy" src="<?php echo $uploads ?>/shopping-cart-2.png" alt="سلة الشراء"> مشاهدة السلة </a> -->
                                    <?php
                                    // } else {
                                    ?>
                                     <?php 
                                        if($product_status_store !=1){
                                            ?>
                                           <p class='btn global_button'> المنتج غير متوفر  </p>
                                            <?php 
                                        }else{
                                            ?>
                                             <button class="btn global_button cart" name="add_to_cart"> <img loading="lazy" src="<?php echo $uploads ?>/shopping-cart-2.png" alt="سلة الشراء"> أضف الي السلة </button>
                                            <?php 
                                        }
                                        ?>
                                        
                                    <!-- <button class="btn wishlist" name="add_to_wishlist"> <img loading="lazy" src="<?php echo $uploads ?>/heart.png" alt="المفضلة"> أضف الي المفضلة </button> -->
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="product_description_small_screen">
                    <div class="product_description">
                        <h3> وصف المنتج </h3>

                        <?php 
                          //  $product_desc = $product_data['description'];
                            if($description_status == 1){
                                $parts = preg_split('/<h2.*?>/', $product_desc, 2, PREG_SPLIT_NO_EMPTY);
                            $intro = isset($parts[0]) ? trim($parts[0]) : ''; // المقدمة

                            // استخراج العناوين <h2> والمحتوى الذي يليها
                            preg_match_all('/<h2.*?>(.*?)<\/h2>(.*?)(?=<h2|$)/s', $product_desc, $matches, PREG_SET_ORDER);

                            $tabData = [];

                            foreach ($matches as $match) {
                                $title = trim(strip_tags($match[1])); // إزالة الأكواد HTML من العنوان
                                $content = trim($match[2]); // المحتوى التابع للعنوان
                                $tabData[] = ['title' => $title, 'content' => $content];
                            }
                            ?>

                            <!-- عرض مقدمة المنتج إن وجدت -->
                            <?php if (!empty($intro)) : ?>
                                <div class="product-intro">
                                    <?= $intro; ?>
                                </div>
                            <?php endif; ?>

                            <!-- كود عرض التبويبات بأسلوب التبديل (Toggle) -->
                            <div class="container mt-4 new_product_description">
                                <?php foreach ($tabData as $index => $tab) : ?>
                                    <div class="tab-item">
                                        <button class="tab-button" onclick="toggleTab(<?= $index; ?>)">
                                            <?= htmlspecialchars($tab['title']); ?>
                                            <span class="icon"> <i class="bi bi-chevron-down"></i> </span>
                                        </button>
                                        <div class="tab-content" id="tab_mobile<?= $index; ?>">
                                            <?= $tab['content']; ?> <!-- عرض المحتوى كما هو دون تعديل -->
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <?php 
                            }else{
                                ?>
                                <p id="product_desc">
                            <?php 
                            $description_words = explode(' ', $product_desc);
                            $first_30_words = implode(' ', array_slice($description_words, 0, 60)); 
                            $remaining_words = implode(' ', array_slice($description_words, 60)); 
                            ?>
                            <div class="short-desc"><?php echo $first_30_words; ?>...</div>
                            <div class="full-desc" style="display: none;"><?php echo $remaining_words; ?></div>
                            <a href="javascript:void(0);" id="toggleDescription" class="toggle-btn"> قراءة المزيد </a>
                        </p>
                                <?php 
                            }
                            ?>
 
                        
                    </div>
                    <div class="writer_info">

                            <?php 
                            if($writer_id != ''){
                            $stmt = $connect->prepare("SELECT * FROM employes WHERE id = ?");
                            $stmt->execute(array($writer_id));
                            $writer = $stmt->fetch();
                            ?>

                        <a href="https://www.localhost/mashtly/writer-info?username=<?php echo $writer['username']; ?>">
                        <div class="writer_info_item">
                            <p> <i class="bi bi-pencil-square"></i> الكاتب  </p>
                            <p> <?php echo $writer['username']; ?> </p>
                        </div>
                        </a>
                        <?php 
                        }
                        ?>
                        <?php 
                        if($reviewer_id != ''){
                        $stmt = $connect->prepare("SELECT * FROM employes WHERE id = ?");
                        $stmt->execute(array($reviewer_id));
                        $reviewer = $stmt->fetch();
                        ?>
                        <a href="https://www.localhost/mashtly/writer-info?username=<?php echo $reviewer['username']; ?>"> 
                        <div class="writer_info_item">
                            <p> <i class="bi bi-pencil-square"></i> المراجع  </p>
                            <p> <?php echo $reviewer['username']; ?> </p>
                        </div>
                        </a>
                        <?php 
                        }
                        ?>
                        <?php 
                        if($supervisor_id != ''){
                        $stmt = $connect->prepare("SELECT * FROM employes WHERE id = ?");
                        $stmt->execute(array($supervisor_id));
                        $supervisor = $stmt->fetch();
                        ?>
                        <a href="https://www.localhost/mashtly/writer-info?username=<?php echo $supervisor['username']; ?>"> 
                        <div class="writer_info_item">
                            <p> <i class="bi bi-pencil-square"></i> المشرف  </p>
                            <p> <?php echo $supervisor['username']; ?> </p>
                        </div>
                        </a>
                        <?php 
                        }
                        ?>
                      </div>
                    <div class="social_share">
                        <div>
                            <p> شارك عبر </p>
                        </div>
                        <!-- AddToAny BEGIN -->
                        <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                            <!-- <a class="a2a_dd" href="https://www.addtoany.com/share"></a> -->
                            <a rel="nofollow" class="a2a_button_facebook"></a>
                            <a rel="nofollow" class="a2a_button_whatsapp"></a>
                            <a rel="nofollow" class="a2a_button_linkedin"></a>
                            <a rel="nofollow" class="a2a_button_twitter"></a>
                            <a rel="nofollow" class="a2a_button_x"></a>
                            <a rel="nofollow" class="a2a_button_telegram"></a>
                        </div>
                        <script async src="https://static.addtoany.com/menu/page.js"></script>
                        <!-- AddToAny END -->
                    </div>
                    <?php 
                            if($main_category == 1){
                                ?> 
                                <div class="product">
                                <div class="product_info">
                                 <div class="attention">
                                <h3> تنويه </h3>
                                <p> الصور المعروضة للمنتج هنا توضح مميزاتها وشكلها بعد زراعتها ورعايتها وتقديم كامل احتياجاتها كما هو موضح في وصف النبتة، وبإمكانكم الحصول على تفاصيل أكثر من خلال دعم خبرائنا المجاني . </p>
                                </div>
                                </div>
                                </div>
                            
                                <?php
                            }
                            ?>
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
            </div>
        </div>
    </div>
</div>
<!-- START NEWWER PRODUCTS -->
 
 
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
                $stmt = $connect->prepare("SELECT * FROM products WHERE publish = 1 AND price !='' AND cat_id = 935 ORDER BY id LIMIT 6");
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
<style>
    .product_description_small_screen {
        display: none;
    }

    @media(max-width:991px) {
        .product_description_small_screen {
            display: block;
        }

        .product_description_large_screen {
            display: none;
        }
    }
</style>
 
<!-- END NEWWER PRODUCTS  -->
<?php

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



<!-- Product Details  -->

<script>
    $(document).ready(function() {
        // تهيئة الصور الرئيسية
        $('.slider-for').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true, // تعيين القيمة إلى true لعرض الأسهم
            fade: true,
            asNavFor: '.slider-nav'
        });

        // تهيئة الصور المصغرة
        $('.slider-nav').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            asNavFor: '.slider-for',
            dots: true,
            centerMode: true,
            focusOnSelect: true
        });
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const link = document.querySelector('a[data-section]');
        if (link) {
            link.addEventListener('click', scrollToSection);
        }
    });

    function scrollToSection(event) {
        event.preventDefault();
        const slug = this.getAttribute('data-section');
        const element = document.getElementById(slug);
        if (element) {
            element.scrollIntoView({
                behavior: 'smooth'
            });
        }
    }
</script>

<!-- slider in product images -->

<script>
    $(document).ready(function() {
        // تحديد العناصر
        const mainSlider = document.querySelector('.main-slider');
        const thumbnailSlider = document.querySelector('.thumbnail-slider');
        const mainSlides = mainSlider.querySelectorAll('div');
        const thumbnailSelect = document.querySelector('select[name="vartion_select"]');
        const thumbnailImages = document.querySelectorAll('.thumbnail-image');
        const mainImage = mainSlider.querySelector('img');
        // تنفيذ الشريط الرئيسي
        mainSlides.forEach((slide) => {
            slide.style.display = 'none';
        });
        let mainIndex = 0;
        mainSlides[mainIndex].style.display = 'block';

        // تنفيذ الشريط المصغر
         if (thumbnailSelect) {
        thumbnailSelect.addEventListener('change', function() {
            let selectedIndex = thumbnailSelect.selectedIndex;
            mainSlides[mainIndex].style.display = 'none';
            mainIndex = selectedIndex;
            mainSlides[mainIndex].style.display = 'block';

            // تحديث الصورة الخلفية
            const selectedImage = thumbnailSelect.options[selectedIndex].getAttribute('data-image');
            if (selectedImage) {
                mainSlides[mainIndex].style.backgroundImage = 'url(https://mshtly.com/uploads/products/' + selectedImage + ')';
                const mainImageSlide = mainSlides[mainIndex].querySelector('img');
                mainImageSlide.src = 'https://mshtly.com/uploads/products/' + selectedImage;
            }
        });
         }
        //////////////
        thumbnailImages.forEach(thumbnailImage => {
            thumbnailImage.addEventListener('click', function() {
                // تحديث الصورة الرئيسية بناءً على الصورة المصغرة المنقر عليها
                const selectedImage = thumbnailImage.getAttribute('data-image2');
                //console.log(selectedImage);
                if (selectedImage) {
                    mainSlides[mainIndex].style.backgroundImage = 'url(https://mshtly.com/uploads/products/' + selectedImage + ')';
                    const mainImageSlide = mainSlides[mainIndex].querySelector('img');
                    mainImageSlide.src = 'https://mshtly.com/uploads/products/' + selectedImage;
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        const vartionSelect = document.querySelector('select[name="vartion_select"]');
        const selectedPriceElement = document.getElementById('selected_price');
        const priceValueInput = document.getElementById('price_value');

        vartionSelect.addEventListener('change', function() {
            const selectedOption = vartionSelect.options[vartionSelect.selectedIndex];
            const selectedPrice = selectedOption.getAttribute('data-price');
            if (selectedPrice !== undefined) {
                selectedPriceElement.textContent = selectedPrice  + 'ر.س';
                priceValueInput.value = selectedPrice;
            } else {
                selectedPriceElement.textContent = '0.00 ر.س';
                priceValueInput.value = '0.00';
            }
        });
    });
</script>

 
<!-- To Make Slider To Product Images  -->
<script>
    $('.gallery-lb').each(function() { // the containers for all your galleries
        $(this).magnificPopup({
            delegate: 'a', // the selector for gallery item
            type: 'image',
            gallery: {
                enabled: true
            },
            mainClass: 'mfp-fade',

        });
    });
</script>

<script>
    document.getElementById('toggleDescription').addEventListener('click', function () {
        const shortDesc = document.querySelector('.short-desc');
        const fullDesc = document.querySelector('.full-desc');
        if (shortDesc.style.display === 'none') {
            shortDesc.style.display = 'inline';
            fullDesc.style.display = 'none';
            this.textContent = ' قراءة المزيد ...';
        } else {
            shortDesc.style.display = 'none';
            fullDesc.style.display = 'inline';
            this.textContent = 'عرض أقل';
        }
    });
</script>


<!-- إضافة JavaScript لتفعيل التبديل -->
<script>
    function toggleTab(index) {
        let button = document.querySelectorAll(".tab-button")[index];
        let content = document.getElementById("tab" + index);
        let content_mobile = document.getElementById("tab_mobile" + index);
        
        if (content.style.display === "block" || content_mobile.style.display === "block") {
            content.style.display = "none";
            content_mobile.style.display = "none";
            button.classList.remove("active");
        } else {
            document.querySelectorAll(".tab-content").forEach(tab => tab.style.display = "none");

            document.querySelectorAll(".tab-button").forEach(btn => btn.classList.remove("active"));

            content.style.display = "block";
            content_mobile.style.display = "block";
            button.classList.add("active");
        }
    }
</script>