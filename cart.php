<?php
ob_start();
session_start();
$page_title = 'سلة الشراء ';
include "init.php";
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


// get all product from user cart

$stmt = $connect->prepare("SELECT * FROM cart WHERE cookie_id = ?");
$stmt->execute(array($cookie_id));
$count = $stmt->rowCount();
$allitems = $stmt->fetchAll();
// update cart items 
if (isset($_POST['update_cart'])) {
    $quantities = $_POST['quantity'];
    foreach ($quantities as $product_id => $quantity) {
        // Get the selected value from the dropdown
        $selectedValue = isset($_POST['farmserv'][$product_id]) ? intval($_POST['farmserv'][$product_id]) : null;
        $stmt = $connect->prepare("UPDATE cart SET quantity = ?, farm_service = ? WHERE id = ?");
        $stmt->execute(array($quantity, $selectedValue, $product_id));

        if ($stmt) {
            alertdefaultedit();
            header('refresh:1;url=cart');
        }
    }
}

// delete Items From the cart
if (isset($_POST['remove_item'])) {
    $item_id = $_POST['item_id'];
    $stmt = $connect->prepare("DELETE FROM cart WHERE id = ? AND cookie_id=?");
    $stmt->execute(array($item_id, $cookie_id));
    if ($stmt) {
        header("Location:cart");
    }
}
?>
<div class="profile_page adress_page">

    <div class='container'>
        <div class="data">
            <div class="breadcrump">
                <p> <a href="index"> الرئيسية </a> \ <span> سلة الشراء </span> </p>
            </div>
            <?php
            if ($count > 0) {
            ?>

                <div class="purches_header">
                    <div class="data_header_name">
                        <h2 class='header2'> سلة الشراء </h2>
                        <p> عدد عناصر السلة: <span> <?php echo $count ?> </span></p>
                    </div>
                </div>
                <div class="cart">
                    <div class="row">
                        <div class="col-lg-8">
                            <?php
                            $total_price = 0;
                            $farm_services_total = 0;
                            $gift_price = 0;
                            foreach ($allitems as $item) {
                                // check if item have gift or not
                                if ($item['gift_id'] != null && $item['gift_id'] != 0) {
                                    $gift_id = $item['gift_id'];
                                    $stmt = $connect->prepare("SELECT * FROM gifts WHERE id = ?");
                                    $stmt->execute(array($gift_id));
                                    $gift_data = $stmt->fetch();
                                    $gift_price =   $gift_data['price'] * $item['quantity'];
                                }
                                $item_id = $item['id'];
                                $stmt = $connect->prepare("SELECT * FROM products WHERE id = ?");
                                $stmt->execute(array($item['product_id']));
                                $product_data = $stmt->fetch();
                                $pro_name = $product_data['name'];
                                $pro_slug = $product_data['slug'];
                                $pro_farm = $product_data['public_tail'];
                                $farm_services = 0;
                                if ($item['farm_service'] != null) {
                                    $stmt = $connect->prepare("SELECT * FROM public_tails WHERE id = ?");
                                    $stmt->execute(array($item['farm_service']));
                                    $tail_data = $stmt->fetch();
                                    $tail_price = $tail_data['price'];
                                    $farm_services = $tail_price;
                                    $farm_services_total += $farm_services * $item['quantity'];
                                }
                                $total_price = $total_price + ($item['price'] * $item['quantity']);
                                $grand_farm_services = $farm_services_total + $gift_price;

                            ?>
                                <form action="" method="post">
                                    <input type="hidden" name="item_id" value="<?php echo $item['id'] ?>">
                                    <div class="card_items">
                                        <button onclick="return confirm('هل أنت متأكد من رغبتك في حذف المنتج ؟ ');" name="remove_item" class="remove_item" style="border: none;">
                                            <span class="fa fa-close"> </span>
                                        </button>
                                        <div class="product_data">
                                            <div class="product_image">
                                                <a href="product/<?php echo $pro_slug ?>">
                                                    <?php
                                                    $stmt = $connect->prepare("SELECT * FROM products_image WHERE product_id = ?");
                                                    $stmt->execute(array($item['product_id']));
                                                    $count_image = $stmt->rowCount();
                                                    if ($count_image > 0) {
                                                        $product_data_image = $stmt->fetch();
                                                    ?>
                                                        <img class="main_image" src="admin/product_images/<?php echo $product_data_image['main_image']; ?>" alt="<?php echo $product_data_image['image_alt']; ?>">
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <img class="main_image" src="uploads/product.png" alt="">
                                                    <?php
                                                    }
                                                    ?>
                                                </a>
                                            </div>
                                            <div class="product_info">
                                                <h3> <a href="product/<?php echo $pro_slug ?>"> <?php echo $pro_name; ?> </a> </h3>
                                                <p class="item_price"> سعر الوحدة :<span> <?php echo $item['price']; ?> ر.س </span> </p>
                                                <?php
                                                if ($item['vartion_name'] != null && $item['vartion_name'] != '') {
                                                    $stmt = $connect->prepare("SELECT * FROM product_details2 WHERE id = ?");
                                                    $stmt->execute(array($item['vartion_name']));
                                                    $var_data = $stmt->fetch();
                                                    $var_name = $var_data['vartions_name'];
                                                ?>
                                                    <span style="color: var(--second-color); margin-bottom: 10px;"> <?php echo $var_name; ?> </span>
                                                    <br>
                                                <?php
                                                }
                                                ?>
                                                <!--  <form action="" method="post"> -->
                                                <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>">
                                                <?php
                                                if (isset($_SESSION['user_id']) && checkIfProductIsFavourite($connect, $_SESSION['user_id'], $item['product_id'])) {
                                                ?>
                                                    <p class="add_fav">
                                                        <a href="profile/favorite/" style="background-color: transparent; border: none; color: var(--second-color);">
                                                            <img src="<?php echo $uploads ?>heart.png" alt=""> مشاهدة المفضلة </a>
                                                    </p>
                                                <?php
                                                } else {
                                                ?>
                                                    <p class="add_fav">
                                                        <button style="background-color: transparent; border: none; color: var(--second-color);" type="submit" name="add_to_fav">
                                                            <img src="<?php echo $uploads ?>heart.png" alt=""> أضف الي المفضلة </button>
                                                    </p>
                                                <?php
                                                }
                                                ?>
                                                <!--  </form> -->
                                            </div>
                                        </div>
                                        <div class="product_num">
                                            <div class="quantity counter">
                                                <button class="increase-btn"> + </button>
                                                <input id="count_number" type="text" name="quantity[<?php echo $item_id ?>]" class="quantity-input count_number" value="<?php echo  $item['quantity'] ?>" min="1">
                                                <button class="decrease-btn">-</button>
                                            </div>
                                            <!-- <p> إجمالي السعر: <span id="price_span"> 120 </span> </p> -->
                                        </div>
                                        <div class="services">
                                            <!--  <form action="#" method="post"> -->
                                            <?php
                                            if ($pro_farm != null) {
                                            ?>
                                                <div class="form-check">
                                                    <input class="form-check-input" name="farmserv[<?php echo $item['id']; ?>]" type="checkbox" value="<?php echo $pro_farm; ?>" id="flexCheckChecked<?php echo $item['id']; ?>" <?php if ($item['farm_service'] != null) echo "checked"; ?>>
                                                    <label class="form-check-label" for="flexCheckChecked<?php echo $item['id']; ?>">
                                                        أضف خدمة الزراعة
                                                    </label>
                                                </div>
                                                <?php
                                                if ($item['farm_service'] != null) {
                                                    // get the farm services price
                                                    $stmt = $connect->prepare("SELECT * FROM public_tails WHERE id = ?");
                                                    $stmt->execute(array($item['farm_service']));
                                                    $farm_services_data = $stmt->fetch();
                                                    $farm_services_price = $farm_services_data['price'];
                                                ?>
                                                    <p> <span> <?php echo $farm_services_price; ?> ر.س </span> <button style="outline: none; box-shadow: none; font-size:13px; background-color: transparent; border:none; color:var(--second-color);text-decoration: underline;" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                            إعرف أكثر عن التكلفة
                                                        </button></p>
                                                <?php
                                                } else {
                                                ?>
                                                    <p> <span> </span> <button style="outline: none; box-shadow: none; font-size:13px; background-color: transparent; border:none; color:var(--second-color);text-decoration: underline;" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                            إعرف أكثر عن التكلفة
                                                        </button></p>
                                                <?php
                                                }
                                                ?>
                                            <?php
                                            }
                                            ?>

                                            <!--  </form> -->
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
                                            <div class="gift">
                                                <?php
                                                if ($item['gift_id'] != null && $item['gift_id'] != 0) {
                                                    $gift_id = $item['gift_id'];
                                                    $stmt = $connect->prepare("SELECT * FROM gifts WHERE id = ?");
                                                    $stmt->execute(array($gift_id));
                                                    $gift_data = $stmt->fetch();
                                                ?>
                                                    <div class="image">
                                                        <img src="admin/gifts/images/<?php echo $gift_data['image']; ?>" alt="">
                                                    </div>
                                                    <div class="gift_info">
                                                        <h3> التغليف كهدية </h3>
                                                        <p style="color: #ACC288;font-size: 13px; margin-bottom: 9px;"> السعر :
                                                            <span style="font-weight: bold; color:var(--main-color);"> <?php echo $gift_data['price']; ?> ر.س </span>
                                                        </p>
                                                    </div>
                                                <?php
                                                } else { ?>
                                                    <!-- <div class="image">
                                                        <img src="<?php echo $uploads ?>product.png" alt="">
                                                    </div>
                                                    <div class="gift_info">
                                                        <h3> التغليف كهدية </h3>
                                                        <p> لا اريد التغليف كهدية</p>
                                                    </div> -->
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                            }
                                ?>
                                <button class="btn global_button cart_button" type="submit" name="update_cart">تحديث السلة <i class="fa fa-pen"></i> </button>
                                </form>
                                <br>
                                <?php
                                //////////////////// Coupon Code  /////////////////////
                                if (isset($_POST['coupon'])) {
                                    $coupon = sanitizeInput($_POST['coupon_value']);
                                    // get the coupons data
                                    $stmt = $connect->prepare("SELECT * FROM coupons WHERE name = ?");
                                    $stmt->execute(array($coupon));
                                    $coupon_data = $stmt->fetch();
                                    $count = $stmt->rowCount();
                                    if ($count > 0) {
                                        $start_date = $coupon_data['start_date'];
                                        $end_date = $coupon_data['end_date'];
                                        $today_date = date("Y-m-d");
                                        if ($today_date >= $start_date && $today_date <= $end_date) {

                                            $_SESSION['coupon'] = $coupon_data['coupon_value'];
                                            $_SESSION['coupon_name'] = $coupon_data['name'];
                                ?>
                                            <div class="alert alert-success"> تم تطبيق الكوبون بنجاح وسيتم خصم نسبه [ % <?php echo $coupon_data['coupon_value'] ?> ] من قيمه الشحنه </div>
                                        <?php
                                        } else {
                                        ?>
                                            <div class="alert alert-danger"> كود الخصم غير فعال في الوقت الحالي </div>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <div class="alert alert-danger"> الكود غير صحيح </div>
                                <?php
                                    }
                                }
                                //////////////////////// End Coupon Code ///////////////////
                                ?>

                                <div class="user_address">
                                    <div>

                                        <h5> أدخل بطاقة هدايا أو كوبون الخصم </h5>
                                    </div>
                                </div>
                                <form method="post" action="">
                                    <div class="coupon_form">
                                        <div>
                                            <input name="coupon_value" type="text" class="form-control" placeholder="أدخل الكوبون">
                                        </div>
                                        <div>
                                            <button name="coupon" type="submit" class="btn global_button"> تطبيق </button>
                                        </div>
                                    </div>
                                </form>

                        </div>
                        <div class="col-lg-4">
                            <div class="cart_price_info">
                                <!-- <p class="no_sheap_price">
                                    <img src="<?php echo $uploads ?>free.svg" alt="">
                                    أضف 13 ريال واحصل علي شحن مجاني
                                </p> -->
                                <div class="price_sections">
                                    <div class="first">
                                        <div>
                                            <h3> المجموع الفرعي: </h3>
                                            <p> إجمالي سعر المنتجات في السلة </p>
                                        </div>
                                        <div>
                                            <h2 class="total"> <?php echo number_format($total_price, 2); ?> ر.س </h2>
                                        </div>
                                    </div>
                                    <div class="first">
                                        <div>
                                            <h3> تكلفة الإضافات: </h3>
                                            <!-- <p> تكلفة الزراعة + تكلفة التغليف كهدية </p> -->
                                            <p> تكلفة الزراعة   </p>
                                        </div>
                                        <div>
                                            <h2 class="total"> <?php echo number_format($grand_farm_services, 2); ?> ر.س </h2>
                                        </div>
                                    </div>

                                    <div class="first">
                                        <?php
                                        // $vat_value = ($total_price + $shipping_value + $farm_services_total) * (15 / 100);
                                        ?>
                                        <!-- <div>
                                            <h3> ضريبة القيمة المضافة VAT: </h3>
                                            <p> القيمة المضافة تساوي 15% من اجمالي الطلب </p>
                                        </div>
                                        <div>
                                            <h2 class="total"> <?php //echo number_format($vat_value, 2); 
                                                                ?> ر.س </h2>
                                        </div> -->
                                    </div>
                                    <hr>
                                    <div class="first">
                                        <?php
                                        $last_total = $total_price + $grand_farm_services;
                                        ?>
                                        <div>
                                            <h3> السعر الكلي قبل الشحن : </h3>
                                            <p> المبلغ المطلوب دفعه </p>
                                        </div>
                                        <div>
                                            <h2 class="total"> <?php echo number_format($last_total, 2); ?> ر.س </h2>
                                        </div>
                                    </div>
                                    <?php
                                    if (isset($_SESSION['coupon'])) {
                                    ?>
                                        <div class="first">
                                            <div>
                                                <h3> قيمه كوبون الخصم : </h3>
                                                <p> سيتم الخصم من قيمه الشحنه بالكامل</p>
                                            </div>
                                            <div>
                                                <h2 class="total"> <?php echo number_format($_SESSION['coupon'], 2); ?> % </h2>
                                            </div>
                                        </div>
                                    <?php
                                    }

                                    ?>

                                </div>
                                <?php
                                $_SESSION['total'] = $total_price;
                                // $_SESSION['shipping_value'] = $shipping_value;
                                $_SESSION['farm_services'] = $grand_farm_services;
                                // $_SESSION['vat_value'] = $vat_value;
                                $_SESSION['last_total'] = $last_total;
                                ?>
                                <a href="checkout" class="btn global_button"> تابع عملية الشراء </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            } else {
                unset($_SESSION['total']);
                unset($_SESSION['farm_services']);
                unset($_SESSION['last_total']);
            ?>
                <div class="not_found_orders">
                    <div class="info" style="flex-direction: column;">
                        <img src="<?php echo $uploads ?>plant.png" alt="">
                        <br>
                        <h3> لا يوجد منتجات في السلة في الوقت الحالي </h3>
                        <br>
                        <a href="shop" class="btn global_button"> تسوق الان </a>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
    <br>
</div>

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