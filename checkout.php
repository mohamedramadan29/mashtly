<?php
ob_start();
session_start();
$page_title = ' اتمام عملية الشراء  ';
include "init.php";
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
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
                            <div class="user_address">
                                <div>
                                    <h5> عنوان الشحن </h5>
                                </div>
                                <div>
                                    <a href="profile/address/add"> <i class="fa fa-plus"></i> اضف عنوان جديد </a>
                                </div>
                            </div>
                            <div class="addresses">
                                <?php
                                $stmt = $connect->prepare("SELECT * FROM user_address WHERE user_id=? AND default_address = 1");
                                $stmt->execute(array($user_id));
                                $alladdress = $stmt->fetchAll();
                                foreach ($alladdress as $address) {
                                    $id = $address['id'];
                                    $city = $address['city'];
                                    $build_number = $address['build_number'];
                                    $street_name = $address['street_name'];
                                    $area = $address['area'];
                                    $country = $address['country'];
                                    $phone = $address['phone'];
                                    $default_address = $address['default_address'];
                                    if ($country == 'EG') {
                                        $country = 'مصر';
                                    } elseif ($country == 'SAR') {
                                        $country = 'المملكة العربية السعودية';
                                    }
                                ?>
                                    <div class="checkout_address">
                                        <div class="address <?php if ($default_address == 1) echo "active"; ?> ">
                                            <div class='add_content'>
                                                <h2> <?php echo $city; ?> </h2>
                                                <p class="add_title">
                                                    <?php echo $build_number . '-' . $street_name . '-' . $area . '-' . $city . '-' . $country ?>
                                                </p>
                                                <p class='add_phone'>
                                                    <span> رقم الهاتف </span> <?php echo $phone; ?>
                                                </p>
                                            </div>
                                            <div>
                                                <a href="profile/address" class="btn global_button"> اختر عنوان اخر </a>
                                            </div>
                                        </div>

                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                            <div class="user_address">
                                <div>
                                    <h5> أدخل بطاقة هدايا أو كوبون الخصم </h5>
                                </div>
                            </div>
                            <form action="" method="post">
                                <div class="coupon_form">
                                    <div>
                                        <input type="text" class="form-control" placeholder="أدخل الكوبون">
                                    </div>
                                    <div>
                                        <button type="submit" class="btn global_button"> تطبيق </button>
                                    </div>
                                </div>
                            </form>
                            <div class="user_address">
                                <div>
                                    <h5> طريقة الدفع </h5>
                                </div>
                                <div>
                                    <a href="profile/payment/add"> <i class="fa fa-plus"></i> اضف بطاقة جديدة </a>
                                </div>
                            </div>

                            <div class="addresses">
                                <div class="row">
                                    <?php
                                    $encryptionKey = "!#@_MOHAMED_!#@_MASHTLY";
                                    $stmt = $connect->prepare("SELECT * FROM user_payments WHERE user_id = ? AND default_payment = 1");
                                    $stmt->execute(array($user_id));
                                    $allpayments = $stmt->fetchAll();
                                    foreach ($allpayments as $payment) {
                                        $id = $payment['id'];
                                        $card_name = $payment['card_name'];
                                        $card_number = $payment['card_number'];
                                        $card_number = openssl_decrypt($card_number, "AES-128-ECB", $encryptionKey);
                                        $first_number = substr($card_number, 0, 1);
                                        $lastFourDigits = substr($card_number, -4);
                                        $end_date = $payment['end_date'];
                                        $cvc = $payment['cvc'];
                                        $default = $payment['default_payment'];
                                    ?>
                                        <div class="checkout_address">
                                            <div class="address payment_method <?php if ($default == 1) echo "active" ?>">
                                                <div class='add_content'>
                                                    <div class="card_image">
                                                        <?php
                                                        $visa_public_name = 'فيزا';
                                                        if ($first_number == 5 || $first_number == 2) {
                                                            $visa_public_name = 'ماستر كارد ';
                                                        ?>
                                                            <img src="<?php echo $uploads ?>master.png" alt="">
                                                        <?php
                                                        } elseif ($first_number == 4) {
                                                            $visa_public_name = 'فيزا';
                                                        ?>
                                                            <img src="<?php echo $uploads ?>visa.svg" alt="">
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <img src="<?php echo $uploads ?>visa.svg" alt="">

                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="card_data">
                                                        <p class="number"> <?php echo $visa_public_name; ?> تنتهي ب <?php echo $lastFourDigits; ?> </p>
                                                        <p class="end_date"> الأسم علي البطاقة : <span style="font-weight: bold; color:#000"> <?php echo $card_name; ?></span> </p>
                                                        <p class="end_date"> تنتهي صلاحية البطاقة : <span style="font-weight: bold; color:#000"> <?php echo $end_date; ?></span> </p>

                                                    </div>
                                                </div>
                                                <div class="security_number">
                                                    <label for=""> رقم التحقق CVC </label>
                                                    <input maxlength="3" type="text" name="security_number" placeholder="123">
                                                </div>
                                            </div>
                                        </div>

                                    <?php
                                    }
                                    ?>

                                    <div class="checkout_address">
                                        <div class="address payment_method">
                                            <div class='add_content'>
                                                <div class="card_image">
                                                    <img src="<?php echo $uploads ?>cash_on.svg" alt="">
                                                </div>
                                                <div class="card_data">
                                                    <p class="number"> الدفع عند الاستلام </p>
                                                    <p class="end_date"> يتم اضافة 5 ريال رسوم تحصيل </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="cart_price_info">
                                <!-- <p class="no_sheap_price">
                                <img src="<?php echo $uploads ?>free.svg" alt="">
                                أضف 13 ريال واحصل علي شحن مجاني
                            </p>
                    -->
                                <div class="price_sections">
                                    <div class="first">
                                        <div>
                                            <h3> المجموع الفرعي: </h3>
                                            <p> إجمالي سعر المنتجات في السلة </p>
                                        </div>
                                        <div>
                                            <h2 class="total"> <?php echo number_format($_SESSION['total'], 2); ?> ر.س </h2>
                                        </div>

                                    </div>
                                    <div class="first">
                                        <div>
                                            <h3> تكلفة الإضافات: </h3>
                                            <p> تكلفة الزراعة + تكلفة التغليف كهدية </p>
                                        </div>
                                        <div>
                                            <h2 class="total"> <?php echo number_format($_SESSION['farm_services'], 2); ?> ر.س </h2>
                                        </div>

                                    </div>
                                    <div class="first">
                                        <div>
                                            <h3> الشحن والتسليم: </h3>
                                            <p> يحدد سعر الشحن حسب الموقع </p>
                                        </div>
                                        <div>
                                            <h2 class="total"> <?php echo number_format($_SESSION['shipping_value'], 2); ?> ر.س </h2>
                                        </div>

                                    </div>
                                    <div class="first">
                                        <div>
                                            <h3> ضريبة القيمة المضافة VAT: </h3>
                                            <p> القيمة المضافة تساوي 15% من اجمالي الطلب </p>
                                        </div>
                                        <div>
                                            <h2 class="total"> <?php echo number_format($_SESSION['vat_value'], 2); ?> ر.س </h2>
                                        </div>

                                    </div>
                                    <hr>
                                    <div class="first">
                                        <div>
                                            <h3> إجمالي المبلغ: </h3>
                                            <p> المبلغ المطلوب دفعه </p>
                                        </div>
                                        <div>
                                            <h2 class="total"> <?php echo number_format($_SESSION['last_total'], 2); ?>ر.س </h2>
                                        </div>

                                    </div>
                                </div>
                                <a href="#" class="btn global_button"> اكمال عملية الشراء </a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

<?php

} else {
    header("Location:login");
    exit();
}
include $tem . 'footer.php';
ob_end_flush();
?>