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
                                        <a href="profile/address"> <i class="fa fa-plus"></i> اضف عنوان جديد </a>
                                    </div>
                                </div>
                                <div class="addresses">
                                    <?php
                                    $stmt = $connect->prepare("SELECT * FROM user_address WHERE user_id=? AND default_address = 1");
                                    $stmt->execute(array($user_id));
                                    $alladdress = $stmt->fetchAll();
                                    $count_address = count($alladdress);
                                    if ($count_address > 0) {
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
                                                        <a href="profile/address" class="btn global_button"> تعديل العنوان </a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <div class="alert alert-info"> من فضلك ادخل عنوان الشحن الخاص بك </div>
                                    <?php
                                    }

                                    ?>
                                </div>

                                <div class="user_address">
                                    <div>
                                        <h5> طريقة الدفع </h5>
                                    </div>
                                    <!-- <div>
                                        <a href="profile/payment/add"> <i class="fa fa-plus"></i> اضف بطاقة جديدة </a>
                                    </div> -->
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
                                            <input required style="display: none;" id="visa_payment" type="radio" name="checkout_payment" value="الدفع الالكتروني">
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

                                        <input required style="display: none;" id="visa_payment" type="radio" name="checkout_payment" value="الدفع الالكتروني">
                                        <label for="visa_payment" class="checkout_address">
                                            <div class="address payment_method">
                                                <div class='add_content'>
                                                    <div class="card_image">
                                                        <img src="<?php echo $uploads ?>visa.svg" alt="">
                                                    </div>
                                                    <div class="card_data">
                                                        <p class="number"> الدفع الالكتروني </p>

                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                        <input required style="display: none;" id="when_drive" type="radio" name="checkout_payment" value="الدفع عن الاستلام">
                                        <label for="when_drive" class="checkout_address">
                                            <div class="address payment_method">
                                                <div class='add_content'>
                                                    <div class="card_image">
                                                        <img src="<?php echo $uploads ?>cash_on.svg" alt="">
                                                    </div>
                                                    <div class="card_data">
                                                        <p class="number"> الدفع عند الاستلام </p>
                                                        <!-- <p class="end_date"> يتم اضافة 5 ريال رسوم تحصيل </p> -->
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
                                                <!-- <p> تكلفة الزراعة + تكلفة التغليف كهدية </p> -->
                                                <p> تكلفة الزراعة </p>
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
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="shipping_price" id="flexRadioDefault1" value="35" onchange="updateTotal(this)">
                                                    <label class="form-check-label" for="flexRadioDefault1">
                                                        داخل الرياض :: 35 ريال
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="shipping_price" id="flexRadioDefault2" value="65" onchange="updateTotal(this)">
                                                    <label class="form-check-label" for="flexRadioDefault2">
                                                        خارج الرياض :: 65 ريال
                                                    </label>
                                                </div>
                                                <input type="hidden" name="last_shipping_value" id="lastshippingvalue" value="">
                                                <?php
                                                /////////  Shipping Price /////
                                                //  include 'tempelate/shiping_price.php';
                                                ?>

                                            </div>

                                        </div>
                                        <hr>
                                        <div class="first">
                                            <div>
                                                <h3> إجمالي المبلغ: </h3>
                                                <p> المبلغ المطلوب دفعه </p>
                                            </div>
                                            <div>
                                                <?php
                                                if (isset($_SESSION['coupon'])) {
                                                    // تطبيق خصم 10% على قيمة الشحنة
                                                    $shipping_discount =  $_SESSION['coupon'] / 100;
                                                    //$_SESSION['discount_value'] = $shipping_discount;
                                                }
                                                ?>
                                                <h2 class="total" id="grand_total">  </h2>
                                                <input type="hidden" name="grand_total" id="grand_total_value" value="">
                                            </div>
                                        </div>
                                        <?php
                                        if (isset($_SESSION['coupon'])) {
                                        ?>
                                            <input type="hidden" name="" id="discountCoupon" value="<?php echo $shipping_discount; ?>">
                                            <?php
                                            ?>
                                            <div class="first">
                                                <div>
                                                    <h3> قيمه الخصم : </h3>
                                                    <p> قيمه الخصم من تكلفه الشحنه </p>
                                                </div>
                                                <div>
                                                    <input type="hidden" name="discountValue" value="" id="discountValue">
                                                    <h2 class="total" id="discountValue_total"> </h2>
                                                </div>
                                            </div>
                                        <?php
                                        }

                                        ?>

                                    </div>
                                    <button type="submit" name="order_compelete" class="btn global_button"> اكمال عملية الشراء </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <?php
                if (isset($_POST['order_compelete'])) {
                    $shipping_value = $_POST['last_shipping_value'];
                    $grand_total = $_POST['grand_total'];
                    $_SESSION['grand_total'] = $grand_total;
                    $discountValue = $_POST['discountValue'];
                    $_SESSION['discount_value'] =  $discountValue;
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
                    $ship_price = $shipping_value;
                    $order_date = date("n/j/Y g:i A");
                    $status = 0;
                    $status_value = 'لم يبدا';
                    $farm_service = $_SESSION['farm_services'];
                    $grand_total = $_SESSION['grand_total'];
                    // تخزين البيانات في السيشن
                    $_SESSION['order_data'] = [
                        'order_id' => $order_id,
                        'order_number' => $order_number,
                        'user_id' => $user_id,
                        'name' => $name,
                        'phone' => $phone,
                        'area' => $area,
                        'city' => $city,
                        'address' => $address,
                        'email' => $email,
                        'ship_price' => $shipping_value,
                        'order_date' => $order_date,
                        'status' => $status,
                        'status_value' => $status_value,
                        'farm_service_price' => $_SESSION['farm_services'],
                        'total_price' => $grand_total,
                        'cookie_id' => $cookie_id,
                        'coupon_code' => $_SESSION['coupon'],
                        'discount_value' => $_SESSION['discount_value'],
                    ];
                    if ($farm_service == '') {
                        $farm_service = 0;
                    }


                    $payment_method = $_POST['checkout_payment'];
                    if ($payment_method === 'الدفع عن الاستلام') {
                        echo "الدفع عند الاستلام";
                        // inset order into orders 
                        $stmt = $connect->prepare("INSERT INTO orders (order_number, user_id, name, email,phone,
                            area, city, address, ship_price, order_date, status,status_value,farm_service_price,total_price,
                            payment_method,coupon_code,discount_value) 
                            VALUES (:zorder_number , :zuser_id , :zname , :zemail ,:zphone , :zarea , :zcity , :zaddress,
                            :zship_price, :zorder_date, :zstatus, :zstatus_value,:zfarm_service_price,:ztotal_price,:zpayment_method,:zcoupon_code,:zdiscount_value)");
                        $stmt->execute(array(
                            "zorder_number" => $order_number, "zuser_id" => $user_id, "zname" => $name,
                            "zemail" => $email, "zphone" => $phone, "zarea" => $area, "zcity" => $city,
                            "zaddress" => $address, "zship_price" => $ship_price, "zorder_date" => $order_date,
                            "zstatus" => $status, "zstatus_value" => $status_value, "zfarm_service_price" => $farm_service,
                            "ztotal_price" => $grand_total, "zpayment_method" => $payment_method, "zcoupon_code" => $_SESSION['coupon_name'], "zdiscount_value" => $_SESSION['discount_value']
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
                            $more_details = $item['vartion_name'];
                            $total_price = $item['total_price'];
                            // Insert Order Details
                            $stmt = $connect->prepare("INSERT INTO order_details (order_id, order_number,product_id,
                            qty, product_price, total,farm_service, as_present,more_details)
                            VALUES (:zorder_id, :zorder_number,:zproduct_id,
                            :zqty, :zproduct_price, :ztotal,:zfarm_service, :zas_present,:zmore_details)
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
                                "zmore_details" => $more_details,
                            ));
                            // insert order steps 
                            // get the  date
                            date_default_timezone_set('Asia/Riyadh'); // تحديد المنطقة الزمنية
                            $date = date('d/m/Y h:i a'); // تنسيق التاريخ والوقت
                            // Add Order Steps 
                            $stmt = $connect->prepare("SELECT * FROM employes WHERE role_name='التواصل'");
                            $stmt->execute();
                            $emp_data = $stmt->fetch();
                            $stmt = $connect->prepare("INSERT INTO order_steps (order_id,order_number,username,date,step_name,description,step_status)
                                VALUES(:zorder_id,:zorder_number,:zusername,:zdate,:zstep_name,:zdescription,:zstep_status)
                                ");
                            $stmt->execute(array(
                                "zorder_id" => $order_id,
                                "zorder_number" => $order_number,
                                "zusername" => $emp_data['id'],
                                "zdate" => $date,
                                "zstep_name" => 'التواصل',
                                "zdescription" => ' التواصل مع العميل لبدء الطلب  ',
                                "zstep_status" => 'لم يبدا'
                            ));
                            if ($stmt) {
                                include "send_mail/index.php";
                                ////////// End Send Mail 
                                // delete session 
                                unset($_SESSION['total']);
                                unset($_SESSION['farm_services']);
                                // unset($_SESSION['vat_value']);
                                unset($_SESSION['last_total']);
                                unset($_SESSION['coupon']);
                                unset($_SESSION['discount_value']);
                                unset($_SESSION['coupon_name']);
                                unset($_SESSION['grand_total']);
                                $stmt = $connect->prepare("DELETE FROM cart WHERE cookie_id = ? OR user_id = ?");
                                $stmt->execute(array($cookie_id, $user_id));
                                header("Location:profile/orders/compelete");
                            }
                        }
                    } elseif ($payment_method === 'الدفع الالكتروني') {
                        // Get the user's details (you can fetch these from your database)
                        $name = $name;
                        $email = $email;
                        $phone = $phone;
                        $order_number = $order_number;
                        // Define the products to be purchased
                        $products = [];
                        foreach ($allitems as $item) {
                            $product_name = $item['product_id'];
                            $quantity = $item['quantity'];
                            $price = $item['price'];
                            $product = [
                                "name" => $product_name,
                                "unit_price" => $price,
                                "quantity" => intval($quantity),
                            ];
                            $products[] = $product;
                        }
                        require_once('payment/vendor/autoload.php');
                        $client = new \GuzzleHttp\Client();
                        $response = $client->request('POST', 'https://api.tap.company/v2/charges', [
                            'json' => [
                                "amount" => $_SESSION['grand_total'], // Total amount to charge (in SAR)
                                "currency" => "SAR",
                                "threeDSecure" => true,
                                "save_card" => true,
                                "description" => "Purchase of Products", // Description of the purchase
                                "receipt" => [
                                    "email" => true,
                                    "sms" => true
                                ],
                                "products" => $products, // Include the product information here
                                "customer" => [
                                    "first_name" => $name,
                                    "email" => $email,
                                    "phone" => [
                                        "number" => $phone
                                    ]
                                ],
                                "source" => [
                                    "id" => "src_all"
                                ],
                                "post" => [
                                    "url" => "http://localhost/mashtly/checkout"
                                ],
                                "redirect" => [
                                    "url" => "http://localhost/mashtly/payment/callback"
                                ],
                                "metadata" => [
                                    "udf1" => "Metadata 1"
                                ]
                            ],
                            'headers' => [
                                'Authorization' => 'Bearer sk_test_XKokBfNWv6FIYuTMg5sLPjhJ',
                                'accept' => 'application/json',
                                'content-type' => 'application/json',
                            ],
                        ]);
                        $output = $response->getBody();
                        $output = json_decode($output);
                        // var_dump($output);
                        header("location:" . $output->transaction->url);
                        // insert order in db and check if it payment correctly or not from callback page

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
?>
<div class="instagrame_footer">
    <div class="container">
        <div class="data">
            <h2> شاركينا جمال بيتك - نباتات الحديقة </h2>
            <p> أرسلي صور حديقة منزلك ونباتات حديقتك عبر انستجرام وسوف تظهر هنا </p>
            <div class="insta_slider">
                <div class="insta_info">
                    <img src="<?php echo $uploads ?>/insta1.png" alt="">
                    <div class="overlay">
                        <img src="<?php echo $uploads ?>/insta_share_icon.svg" alt="">
                    </div>
                </div>
                <div class="insta_info">
                    <img src="<?php echo $uploads ?>/insta2.png" alt="">
                    <div class="overlay">
                        <img src="<?php echo $uploads ?>/insta_share_icon.svg" alt="">
                    </div>
                </div>
                <div class="insta_info">
                    <img src="<?php echo $uploads ?>/insta3.png" alt="">
                    <div class="overlay">
                        <img src="<?php echo $uploads ?>/insta_share_icon.svg" alt="">
                    </div>
                </div>
                <div class="insta_info">
                    <img src="<?php echo $uploads ?>/insta2.png" alt="">
                    <div class="overlay">
                        <img src="<?php echo $uploads ?>/insta_share_icon.svg" alt="">
                    </div>
                </div>
                <div class="insta_info">
                    <img src="<?php echo $uploads ?>/insta1.png" alt="">
                    <div class="overlay">
                        <img src="<?php echo $uploads ?>/insta_share_icon.svg" alt="">
                    </div>
                </div>
                <div class="insta_info">
                    <img src="<?php echo $uploads ?>/insta2.png" alt="">
                    <div class="overlay">
                        <img src="<?php echo $uploads ?>/insta_share_icon.svg" alt="">
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


<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>

<script>
    function updateTotal(selectedRadio) {
        var shippingValue = parseFloat(selectedRadio.value); // القيمة المحددة للشحن
        document.getElementById('lastshippingvalue').value = shippingValue;
        var subTotal = <?php echo $_SESSION['total'] + $_SESSION['farm_services']; ?>; // المجموع الفرعي
        var grandTotal = subTotal + shippingValue; // الإجمالي الجديد
        
        var discount = 0; // الخصم، افترض صفرًا

        // إذا كان هناك خصم موجود
        <?php if (isset($_SESSION['coupon'])) { ?>
            discount = grandTotal *  document.getElementById("discountCoupon").value;
            grandTotal -= discount; // تطبيق الخصم
            document.getElementById("discountValue").value = discount;
            document.getElementById('discountValue_total').innerHTML = discount.toFixed(2) + " ر.س";
        <?php } ?>
        // عرض الإجمالي الجديد بعد تطبيق الخصم
        document.getElementById('grand_total').innerHTML = grandTotal.toFixed(2) + " ر.س";
        document.getElementById('grand_total_value').value = grandTotal;
        // يمكنك تخزين القيمة الإجمالية في الجلسة للاحتفاظ بها بين الصفحات إذا لزم الأمر
        <?php $_SESSION['grand_total'] = "grandTotal"; ?>
    }
</script>