<?php
ob_start();
session_start();
$page_title = ' اتمام عملية الشراء  ';
include "init.php";
// get all product from user cart
$stmt = $connect->prepare("SELECT * FROM cart WHERE cookie_id = ?");
$stmt->execute(array($cookie_id));
$count = $stmt->rowCount();
$allitems = $stmt->fetchAll();

?>
<div class="profile_page adress_page">

    <div class='container'>
        <div class="data">
            <div class="breadcrump">
                <p> <a href="index"> الرئيسية </a> \ <span> اتمام عملية الشراء </span> </p>
            </div>
            <div class="purches_header">
                <div class="data_header_name">
                    <h2 class='header2'> اتمام عملية الشراء </h2>
                    <p> عدد العناصر : <span> <?php echo $count ?> </span></p>
                </div>
            </div>
            <div class="cart">
                <div class="row">
                    <div class="col-lg-8">
                        <?php
                        $total_price = 0;
                        $farm_services = 0;
                        foreach ($allitems as $item) {
                            $stmt = $connect->prepare("SELECT * FROM products WHERE id = ?");
                            $stmt->execute(array($item['product_id']));
                            $product_data = $stmt->fetch();
                            $pro_name = $product_data['name'];
                            if ($item['farm_service'] == 1) {
                                $farm_services = 30;
                            }

                            $total_price = $total_price + ($item['price'] * $item['quantity']) + $farm_services;
                        ?>
                            <div class="card_items">
                                <span class="fa fa-close remove_item"> </span>
                                <div class="product_data">
                                    <div class="product_image">
                                        <img src="<?php echo $uploads ?>product.png" alt="">
                                    </div>
                                    <div class="product_info">
                                        <h3> <?php echo $pro_name; ?> </h3>
                                        <p class="item_price"> سعر الوحدة :<span> <?php echo $item['price']; ?> ر.س </span> </p>
                                        <form action="" method="post">
                                            <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>">
                                            <p class="add_fav"> <button style="background-color: transparent; border: none; color: var(--second-color);" type="submit" name="add_to_fav"> <img src="<?php echo $uploads ?>heart.png" alt=""> أضف الي المفضلة </button>
                                            </p>
                                        </form>
                                    </div>
                                </div>
                                <div class="product_num">
                                    <div class="quantity counter">
                                        <button class="increase-btn"> + </button>
                                        <input id="count_number" type="number" class="quantity-input count_number" value="<?php echo  $item['quantity'] ?>" min="1">
                                        <button class="decrease-btn">-</button>
                                    </div>
                                    <!-- <p> إجمالي السعر: <span id="price_span"> 120 </span> </p> -->
                                </div>
                                <div class="services">
                                    <form action="#" method="post">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked<?php echo $item['id']; ?>" <?php if ($item['farm_service'] == 1) echo "checked"; ?>>
                                            <label class="form-check-label" for="flexCheckChecked<?php echo $item['id']; ?>">
                                                أضف خدمة الزراعة
                                            </label>
                                        </div>
                                        <p> <span> 30 ر.س </span> <button style="outline: none; box-shadow: none; font-size:13px; background-color: transparent; border:none; color:var(--second-color);text-decoration: underline;" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                إعرف أكثر عن التكلفة
                                            </button></p>
                                    </form>
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
                                    <div class="gift">
                                        <div class="image">
                                            <img src="<?php echo $uploads ?>product.png" alt="">
                                        </div>
                                        <div class="gift_info">
                                            <h3> التغليف كهدية </h3>
                                            <p> يتم إضافة 20 ر.س </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                        <form action="#" method="post">
                            <button class="btn global_button" type="submit" name="update_cart">تحديث السلة <i class="fa fa-pen"></i> </button>
                        </form>
                    </div>

                    <div class="col-lg-4">
                        <div class="cart_price_info">
                            <p class="no_sheap_price">
                                <img src="<?php echo $uploads ?>free.svg" alt="">
                                أضف 13 ريال واحصل علي شحن مجاني

                            </p>
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
                                        <p> تكلفة الزراعة + تكلفة التغليف كهدية </p>
                                    </div>
                                    <div>
                                        <h2 class="total"> 87.00 ر.س </h2>
                                    </div>

                                </div>
                                <div class="first">
                                    <div>
                                        <h3> الشحن والتسليم: </h3>
                                        <p> يحدد سعر الشحن حسب الموقع </p>
                                    </div>
                                    <div>
                                        <h2 class="total"> 87.00 ر.س </h2>
                                    </div>

                                </div>
                                <div class="first">
                                    <div>
                                        <h3> ضريبة القيمة المضافة VAT: </h3>
                                        <p> القيمة المضافة تساوي 15% من اجمالي الطلب </p>
                                    </div>
                                    <div>
                                        <h2 class="total"> 87.00 ر.س </h2>
                                    </div>

                                </div>
                                <hr>
                                <div class="first">
                                    <div>
                                        <h3> إجمالي المبلغ: </h3>
                                        <p> المبلغ المطلوب دفعه </p>
                                    </div>
                                    <div>
                                        <h2 class="total"> 87.00 ر.س </h2>
                                    </div>

                                </div>
                            </div>
                            <a href="#" class="btn global_button"> تابع عملية الشراء </a>

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