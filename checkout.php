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
    if ($count > 0) {
    } else {
        header("Location:cart");
    }
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
                <form action="" method="post">
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
                                        $name = $address['name'];
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
                                <div class="coupon_form">
                                    <div>
                                        <input name="coupon_value" type="text" class="form-control" placeholder="أدخل الكوبون">
                                    </div>
                                    <div>
                                        <button name="coupon" type="submit" class="btn global_button"> تطبيق </button>
                                    </div>
                                </div>
                                <div class="user_address">
                                    <div>
                                        <h5> طريقة الدفع </h5>
                                    </div>
                                    <div>
                                        <a href="profile/payment/add"> <i class="fa fa-plus"></i> اضف بطاقة جديدة </a>
                                    </div>
                                </div>
                                <!-- get payments   -->
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
                                            <input style="display: none;" id="visa_payment" type="radio" name="checkout_payment" value="الدفع الالكتروني">
                                            <label for="visa_payment" class="checkout_address">
                                                <div class="address payment_method">
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
                                            </label>

                                        <?php
                                        }
                                        ?>
                                        <input style="display: none;" id="when_drive" type="radio" name="checkout_payment" value="الدفع عن الاستلام">
                                        <label for="when_drive" class="checkout_address">
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
                                        </label>
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
                                    <button type="submit" name="order_compelete" class="btn global_button"> اكمال عملية الشراء </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <?php
                // $get user data 
                $stmt = $connect->prepare("SELECT * FROM users WHERE id = ?");
                $stmt->execute(array($user_id));
                $user_data = $stmt->fetch();
                // get the last order number 
                $stmt = $connect->prepare("SELECT * FROM orders ORDER BY id DESC LIMIT 1");
                $stmt->execute();
                $order_data = $stmt->fetch();
                $order_id = $order_data['id'];
                $order_number = $order_id + 1;
                $user_id = $user_id;
                $name = $name;
                $phone = $phone;
                $area = $area;
                $city = $city;
                $address = $build_number . '-' . $street_name . '-' . $area . '-' . $city . '-' . $country;
                $email = $user_data['email'];
                $ship_price = $_SESSION['shipping_value'];
                $order_date = date("n/j/Y g:i A");
                $status = 0;
                $status_value = 'لم يبدا';
                $total_price = $_SESSION['last_total'];

                if (isset($_POST['order_compelete'])) {
                    $payment_method = $_POST['checkout_payment'];
                    // inset order into orders 
                    $stmt = $connect->prepare("INSERT INTO orders (order_number, user_id, name, email,phone,
                    area, city, address, ship_price, order_date, status, status_value,total_price,
                    payment_method) 
                    VALUES (:zorder_number , :zuser_id , :zname , :zemail ,:zphone , :zarea , :zcity , :zaddress,
                    :zship_price, :zorder_date, :zstatus, :zstatus_value,:ztotal_price,:zpayment_method)");
                    $stmt->execute(array(
                        "zorder_number" => $order_number, "zuser_id" => $user_id, "zname" => $name,
                        "zemail" => $email, "zphone" => $phone, "zarea" => $area, "zcity" => $city,
                        "zaddress" => $address, "zship_price" => $ship_price, "zorder_date" => $order_date,
                        "zstatus" => $status, "zstatus_value" => $status_value,
                        "ztotal_price" => $total_price, "zpayment_method" => $payment_method
                    ));
                    // get the last order number  id and number 
                    $stmt = $connect->prepare("SELECT * FROM orders ORDER BY id DESC LIMIT 1");
                    $stmt->execute();
                    $order_data = $stmt->fetch();
                    $order_id = $order_data['id'];
                    $order_number = $order_data['order_number'];
                    $_SESSION['order_number'] = $order_number;
                    foreach ($allitems as $item) {
                        $product_id = $item['product_id'];
                        $quantity  = $item['quantity'];
                        $price  = $item['price'];
                        $farm_service  = $item['farm_service'];
                        $as_present  = $item['gift_id'];
                        $option1  = $item['option1'];
                        $option2 = $item['option2'];
                        $option3 = $item['option3'];
                        $option4 = $item['option4'];
                        $total_price = $item['total_price'];
                        // Insert Order Details
                        $stmt = $connect->prepare("INSERT INTO order_details (order_id, order_number,product_id,
                        qty, product_price, total,farm_service, as_present, option1, option2,option3,option4)
                        VALUES (:zorder_id, :zorder_number,:zproduct_id,
                        :zqty, :zproduct_price, :ztotal,:zfarm_service, :zas_present, :zoption1, :zoption2,:zoption3,:zoption4)
                        ");
                        $stmt->execute(array(
                            "zorder_id" => $order_id,
                            "zorder_number" => $order_number,
                            "zproduct_id" => $product_id,
                            "zqty" => $quantity,
                            "zproduct_price" => $price,
                            "ztotal" => $total_price,
                            "zfarm_service" => $farm_service,
                            "zas_present" => $as_present,
                            "zoption1" => $option1,
                            "zoption2" => $option2,
                            "zoption3" => $option3,
                            "zoption4" => $option4,
                        ));
                    }
                    if ($stmt) {
                        // delete session 
                        unset($_SESSION['total']);
                        unset($_SESSION['shipping_value']);
                        unset($_SESSION['farm_services']);
                        unset($_SESSION['vat_value']);
                        unset($_SESSION['last_total']);
                        $stmt = $connect->prepare("DELETE FROM cart WHERE cookie_id = ? OR user_id = ?");
                        $stmt->execute(array($cookie_id, $user_id));
                        header("Location:profile/orders/compelete");
                    }
                }
                ?>
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