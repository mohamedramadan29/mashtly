<?php
ob_start();
session_start();
$page_title = ' اضافة طلب خارجي  ';
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
    <div class="profile_page adress_page add_new_address">
        <div class='container'>
            <div class="data">
                <div class="breadcrump">
                    <p><a href="index"> الرئيسية </a> \ <span> اضافة طلب خارجي </span></p>
                </div>
                <div class="purches_header">
                    <div class="data_header_name">
                        <h2 class='header2'> اضافة طلب خارجي </h2>
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
                                </div>
                                <div class="add_new_address">
                                    <div class="addresses">
                                        <div class='row'>
                                            <div class="box">
                                                <div class="input_box">
                                                    <label for="country"> البلد / الدولة </label>
                                                    <input type="text" readonly name="country" class='form-control' value="SAR">
                                                </div>
                                                <br>
                                                <div class="input_box">
                                                    <label for="country"> المدينة </label>
                                                    <select required name="city" id="city" class='select2 form-control'>
                                                        <option value=""> حدد المدينة</option>
                                                        <?php
                                                        $stmt = $connect->prepare("SELECT * FROM suadia_city");
                                                        $stmt->execute();
                                                        $allsaucountry = $stmt->fetchAll();
                                                        foreach ($allsaucountry as $city) {
                                                        ?>
                                                            <option <?php if (isset($_REQUEST['city']) && $_REQUEST['city'] == $city['name']) echo "selected"; ?> value="<?php echo $city['name']; ?>"> <?php echo $city['name']; ?> </option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class='box'>
                                                <div class="input_box">
                                                    <label for="name"> الاسم بالكامل </label>
                                                    <input required id="name" type="text" name="name" class='form-control' placeholder="اكتب…" value="<?php if (isset($_REQUEST['name'])) echo $_REQUEST['name']; ?>">
                                                </div>
                                                <div class="input_box">
                                                    <label for="phone"> رقم الجوال </label>
                                                    <input required id="phone" type="text" name="phone" class='form-control' placeholder="اكتب…" value="<?php if (isset($_REQUEST['phone'])) echo $_REQUEST['phone']; ?>">
                                                </div>
                                            </div>
                                            <div class="box">
                                                <div class="input_box">
                                                    <label for="email"> البريد الالكتروني </label>
                                                    <input required id="email" type="text" name="email" class='form-control' placeholder="اكتب…" value="<?php if (isset($_REQUEST['email'])) echo $_REQUEST['email']; ?>">
                                                </div>
                                            </div>
                                            <div class="box">
                                                <div class="input_box">
                                                    <label for="street_name"> اسم الشارع </label>
                                                    <input required id="street_name" type="text" name="street_name" class='form-control' placeholder="اكتب…" value="<?php if (isset($_REQUEST['street_name'])) echo $_REQUEST['street_name']; ?>">
                                                </div>
                                                <div class="input_box">
                                                    <label for="build_number"> رقم المبني </label>
                                                    <input required id="build_number" type="text" name="build_number" class='form-control' placeholder="اكتب…" value="<?php if (isset($_REQUEST['build_number'])) echo $_REQUEST['build_number']; ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="user_address">
                                    <textarea style="box-shadow: none; outline:none; height:100px;border-radius: 10px" name="order_details" class="form-control" placeholder="ملاحظات اضافية علي طلبك"></textarea>
                                </div>
                                <br>
                                <!-- ----------------------- اضافة منتجات غير متاحة في المتجر   --------------------------->
                                <div class="outside_products">
                                    <?php
                                    $total_outside_product = 0;
                                    ?>

                                    <button class="btn btn-primary btn-sm" id="add_new_outside_product"> اضافة المزيد من
                                        المنتجات الغير متاحة في
                                        المتجر <i class="fa fa-plus"></i></button>
                                    <div id="add_new_product">
                                        <div class="add_products">
                                            <div class="box">
                                                <div class="input_box" style="min-width: 160px">
                                                    <label for="pro_name"> اسم المنتج </label>
                                                    <input id="pro_name" type="text" name="pro_name[]" class='form-control' placeholder="اكتب…">
                                                </div>

                                                <div class="input_box">
                                                    <label for="pro_type"> نوع المنتج </label>
                                                    <select name="pro_type[]" id="pro_type" class='form-control'>
                                                        <option value=""> نوع المنتج</option>
                                                        <option value="نباتات"> نباتات</option>
                                                        <option value="مستلزمات"> مستلزمات</option>
                                                    </select>
                                                </div>
                                                <div class="input_box">
                                                    <label for="pro_qty"> الكمية </label>
                                                    <input id="pro_qty" type="number" name="pro_qty[]" class='form-control'>
                                                </div>
                                                <div class="input_box">
                                                    <label for="product_tail"> طول المنتج <span class="badge badge-danger bg-danger"> متر </span>
                                                    </label>
                                                    <select name="pro_tail[]" id="product_tail" class='form-control'>
                                                        <option value=""> حدد الطول</option>
                                                        <?php
                                                        $stmt = $connect->prepare("SELECT * FROM shipping_weight_tools");
                                                        $stmt->execute();
                                                        $alltails = $stmt->fetchAll();
                                                        foreach ($alltails as $tail) {
                                                        ?>
                                                            <option value="<?php echo $tail['tail']; ?>"> <?php echo $tail['tail']; ?> </option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="input_box">
                                                    <label for="first_price"> سعر التكلفة </label>
                                                    <input min="0" id="first_price" type="number" name="pro_first_price[]" class='form-control'>
                                                </div>
                                                <div class="input_box">
                                                    <label for="main_price"> سعر التنفيذ </label>
                                                    <input id="main_price" type="number" name="pro_main_price[]" class='form-control' min="0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!------------------------------------------- Add New Product ----------------------->
                                <script>
                                    document.getElementById('add_new_outside_product').addEventListener('click', function($e) {
                                        $e.preventDefault();
                                        // Clone the add_services section
                                        var original = document.querySelector('.add_products');
                                        var clone = original.cloneNode(true);
                                        // Clear the input values in the cloned section
                                        var inputs = clone.querySelectorAll('input');
                                        inputs.forEach(function(input) {
                                            input.value = '';
                                        });
                                        // Append the cloned section to the container
                                        document.getElementById('add_new_product').appendChild(clone);
                                    });
                                    document.getElementById('services_container').addEventListener('click', function(event) {
                                        if (event.target && event.target.classList.contains('remove_service')) {
                                            // Remove the corresponding add_services section
                                            var serviceSection = event.target.closest('.add_services');
                                            serviceSection.remove();
                                        }
                                    });
                                </script>
                                <!-- -----------------------  اضافة خدمات غير متاحة   --------------------------->

                                <div class="outside_products">
                                    <?php
                                    $total_outside_services = 0;
                                    ?>

                                    <button id="add_new_outside_serve" class="btn btn-warning btn-sm">
                                        اضافة المزيد من الخدمات <i class="fa fa-plus"></i>
                                    </button>

                                    <div id="services_container">
                                        <div class="add_services">
                                            <div class="box">
                                                <div class="input_box">
                                                    <label for="pro_name">اسم الخدمة</label>
                                                    <input required id="pro_name" type="text" name="serv_name[]" class="form-control" placeholder="اكتب…">
                                                </div>
                                                <div class="input_box">
                                                    <label for="first_price">سعر التكلفة</label>
                                                    <input required id="first_price" type="number" name="serv_first_price[]" class="form-control" min="0">
                                                </div>
                                                <div class="input_box">
                                                    <label for="main_price">سعر التنفيذ</label>
                                                    <input required id="main_price" type="number" name="serv_main_price[]" class="form-control" min="0">
                                                </div>
                                                <!--                                                <div class="input_box">-->
                                                <!--                                                    <button style="margin-top: 40px" class="remove_service btn btn-danger btn-sm"> <i class="fa fa-trash"></i> </button>-->
                                                <!--                                                </div>-->
                                            </div>
                                        </div>
                                    </div>


                                    <!----------------------- Add New Services  ----------------->
                                    <script>
                                        document.getElementById('add_new_outside_serve').addEventListener('click', function($e) {
                                            $e.preventDefault();
                                            // Clone the add_services section
                                            var original = document.querySelector('.add_services');
                                            var clone = original.cloneNode(true);
                                            // Clear the input values in the cloned section
                                            var inputs = clone.querySelectorAll('input');
                                            inputs.forEach(function(input) {
                                                input.value = '';
                                            });
                                            // Append the cloned section to the container
                                            document.getElementById('services_container').appendChild(clone);
                                        });
                                        document.getElementById('services_container').addEventListener('click', function(event) {
                                            if (event.target && event.target.classList.contains('remove_service')) {
                                                // Remove the corresponding add_services section
                                                var serviceSection = event.target.closest('.add_services');
                                                serviceSection.remove();
                                            }
                                        });
                                    </script>

                                </div>
                            </div>
                            <br>
                            <div class="col-lg-12">
                                <div class="cart_price_info">
                                    <p class="no_sheap_price">
                                        <img src="<?php echo $uploads ?>free.svg" alt="">
                                        مدة الشحن المتوقعة 2-7 ايام
                                    </p>
                                    <div class="price_sections">
                                        <div class="first">
                                            <div>
                                                <h3> اجمالي سعر المنتجات في سلة الشراء : </h3>
                                                <p> إجمالي سعر المنتجات في السلة </p>
                                            </div>
                                            <div>
                                                <h2 class="total"> <?php echo number_format($_SESSION['total'], 2); ?>
                                                    ر.س </h2>
                                            </div>
                                        </div>
                                        <!---->
                                        <!--                                        <div class="first">-->
                                        <!--                                            <div>-->
                                        <!--                                                <h3> اجمالي سعر المنتجات الخارجية : </h3>-->
                                        <!--                                                <p> اجمالي سعر المنتجات الخارجية </p>-->
                                        <!--                                            </div>-->
                                        <!--                                            <div>-->
                                        <!--                                                <h2 class="total"> --><?php //echo number_format($total_outside_product, 2); 
                                                                                                                    ?>
                                        <!--                                                    ر.س </h2>-->
                                        <!--                                            </div>-->
                                        <!--                                        </div>-->
                                        <!---->
                                        <!--                                        <div class="first">-->
                                        <!--                                            <div>-->
                                        <!--                                                <h3> اجمالي سعر الخدمات الخارجية : </h3>-->
                                        <!--                                                <p> اجمالي سعر الخدمات الخارجية </p>-->
                                        <!--                                            </div>-->
                                        <!--                                            <div>-->
                                        <!--                                                <h2 class="total"> --><?php //echo number_format($total_outside_services, 2); 
                                                                                                                    ?>
                                        <!--                                                    ر.س </h2>-->
                                        <!--                                            </div>-->
                                        <!--                                        </div>-->

                                        <div class="first">
                                            <div>
                                                <h3> تكلفة الاضافات في سلة الشراء : </h3>
                                                <!-- <p> تكلفة الزراعة + تكلفة التغليف كهدية </p> -->
                                                <p>تكلفة الاضافات في سلة الشراء </p>
                                            </div>
                                            <div>
                                                <h2 class="total"> <?php echo number_format($_SESSION['farm_services'], 2); ?>
                                                    ر.س </h2>
                                            </div>
                                        </div>
                                        <div class="first">
                                            <div>
                                                <h3> الشحن والتسليم: </h3>
                                                <p> يحدد سعر الشحن حسب الموقع </p>
                                            </div>
                                            <div>
                                                <h2 class="total"> <?php include 'tempelate/shiping_price.php'; ?> </h2>
                                                <input type="hidden" name="last_shipping_value" id="lastshippingvalue" value="<?php echo $shipping_value; ?>">
                                                <h2 class="total"> <?php // echo number_format($_SESSION['shipping_value'],2);
                                                                    ?> </h2>
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
                                                    $shipping_discount = $_SESSION['coupon'] / 100;
                                                    //$_SESSION['discount_value'] = $shipping_discount;
                                                    $grand_total = $_SESSION['total'] + $_SESSION['farm_services'] + $shipping_value;
                                                    $grand_total = $grand_total - $shipping_discount;
                                                } else {
                                                    $grand_total = $_SESSION['total'] + $_SESSION['farm_services'] + $shipping_value +
                                                        $total_outside_product + $total_outside_services;
                                                }
                                                ?>
                                                <h2 class="total" id="grand_total"></h2>
                                                <h2 class="total" id="grand_total"> <?php echo $grand_total; ?>ر.س </h2>
                                                <input type="hidden" name="grand_total" id="grand_total_value" value="<?php echo $grand_total ?>">
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
                                                    <input type="hidden" name="discountValue" value="<?php echo $shipping_discount; ?>" id="discountValue">
                                                    <h2 class="total" id="discountValue_total"> <?php echo $shipping_discount; ?> </h2>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>

                                </div>
                            </div>
                            <div class="user_address">
                                <div style="margin-top: 20px;">
                                    <h5> حدد الشحن والتسليم لاختيار طريقة الدفع المناسبة لك </h5>
                                </div>
                                <!-- <div>
                                    <a href="profile/payment/add"> <i class="fa fa-plus"></i> اضف بطاقة جديدة </a>
                                </div> -->
                            </div>
                            <!-- get payments   -->
                            <div class="addresses">
                                <div class="row">
                                    <div class="d-flex align-items-center" id="payment2">
                                        <input checked style="width: 35px;height: 28px;cursor: pointer;" required id="when_drive" type="radio" name="checkout_payment" value="الدفع عن الاستلام">
                                        <label style="width: 95%;" for="when_drive" class="checkout_address">
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
                        </div>
                        <button type="submit" name="order_compelete" class="btn global_button"> اكمال عملية الشراء
                        </button>

                    </div>
            </div>
            </form>
            <?php
            if (isset($_POST['order_compelete'])) {
                $formerror = [];
                $order_details = sanitizeInput($_POST['order_details']);
                $shipping_value = $_POST['last_shipping_value'];
                $grand_total = $_POST['grand_total'];
                $_SESSION['grand_total'] = $grand_total;
                $discountValue = $_POST['discountValue'];
                $_SESSION['discount_value'] = $discountValue;

                /////////// /
                /// OutSide Products //////////
                $pro_names = $_POST['pro_name'];
                $pro_types = $_POST['pro_type'];
                $pro_qtys = $_POST['pro_qty'];
                $pro_tails = $_POST['pro_tail'];
                $pro_first_prices = $_POST['pro_first_price'];
                $pro_main_prices = $_POST['pro_main_price'];

                ////////////// End OuTSide Products //////////
                $serv_names = $_POST['serv_name'];
                $serv_first_prices = $_POST['serv_first_price'];
                $serv_main_prices = $_POST['serv_main_price'];
                /// /////////Start OutSide Services ///////

                /// End OutSide Services //////////////
                // get the last order number  id and number
                $stmt = $connect->prepare("SELECT * FROM outside_orders ORDER BY id DESC LIMIT 1");
                $stmt->execute();
                $order_data = $stmt->fetch();
                $order_id = $order_data['id'];
                // Increment the count by 1 for the new order number
                $order_number = $order_data['order_number'] + 1;
                $user_id = $user_id;
                $country = $_POST['country'];
                $name = $_POST['name'];
                $phone = $_POST['phone'];
                $city = $_POST['city'];
                $build_number = $_POST['build_number'];
                $street_name = $_POST['street_name'];
                $stmt = $connect->prepare("SELECT * FROM suadia_city WHERE name=?");
                $stmt->execute(array($city));
                $city_data = $stmt->fetch();
                $area = $city_data['region'];
                $area_code = $city_data['reg_id'];
                $address = $build_number . '-' . $street_name . '-' . $area . '-' . $city . '-' . $country;
                $email = $_POST['email'];
                $ship_price = $shipping_value;
                $order_date = date("n/j/Y g:i A");
                $status = 0;
                $status_value = 'لم يبدا';
                $farm_service = $_SESSION['farm_services'];
                $grand_total = $_SESSION['grand_total'];

                if ($farm_service == '') {
                    $farm_service = 0;
                }
                $payment_method = $_POST['checkout_payment'];
                if (empty($shipping_value) || $shipping_value == 0) {
                    $formerror[] = ' من فضلك حدد الشحن  ';
                }
                if (empty($payment_method)) {
                    $formerror[] = ' من فضلك حدد وسيلة الدفع ';
                }
                if (empty($area) || empty($city) || empty($name) || empty($phone) || empty($address)) {
                    $formerror[] = ' من فضلك ادخل العنوان الخاص بك بشكل صحيح  ';
                }
                if (empty($formerror)) {
                    // تخزين البيانات في السيشن
                    $_SESSION['order_data'] = [
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
                        "order_details" => $order_details,
                    ];
                    if ($payment_method === 'الدفع عن الاستلام') {

                        echo "الدفع عند الاستلام";
                        // inset order into orders
                        try {
                            $stmt = $connect->prepare("INSERT INTO outside_orders (order_number, user_id, name, email,phone,
                                area, city, address, ship_price,order_details, order_date, status,status_value,farm_service_price,total_price,
                                payment_method,coupon_code,discount_value,shipping_problem)
                                VALUES (:zorder_number , :zuser_id , :zname , :zemail ,:zphone , :zarea , :zcity , :zaddress,
                                :zship_price,:zorder_details, :zorder_date, :zstatus, :zstatus_value,:zfarm_service_price,:ztotal_price,:zpayment_method,:zcoupon_code,:zdiscount_value,:zshipping_problem)");
                            $stmt->execute(array(
                                "zorder_number" => $order_number, "zuser_id" => $user_id, "zname" => $name,
                                "zemail" => $email, "zphone" => $phone, "zarea" => $area, "zcity" => $city,
                                "zaddress" => $address, "zship_price" => $ship_price, "zorder_details" => $order_details, "zorder_date" => $order_date,
                                "zstatus" => $status, "zstatus_value" => $status_value, "zfarm_service_price" => $farm_service,
                                "ztotal_price" => $grand_total, "zpayment_method" => $payment_method, "zcoupon_code" => $_SESSION['coupon_name'], "zdiscount_value" => $_SESSION['discount_value'],
                                "zshipping_problem" => $_SESSION['shipping_problem']
                            ));
                            // get the last order number  id and number
                            $stmt = $connect->prepare("SELECT * FROM outside_orders ORDER BY id DESC LIMIT 1");
                            $stmt->execute();
                            $order_data = $stmt->fetch();
                            $order_id = $order_data['id'];
                            $order_number = $order_data['order_number'];
                            $_SESSION['order_number'] = $order_number;
                            foreach ($allitems as $item) {
                                $product_id = $item['product_id'];
                                $quantity = $item['quantity'];
                                $price = $item['price'];
                                $farm_service = $item['farm_service'];
                                $as_present = $item['gift_id'];
                                $more_details = $item['vartion_name'];
                                $total_price = $item['total_price'];
                                // Insert Order Details
                                $stmt = $connect->prepare("INSERT INTO outside_order_details (order_id, order_number,product_id,
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
                            }


                            //////////////////// Start  Insert OutSide Products ////////////////
                            foreach ($pro_names as $index => $name) {
                                if (!empty($name)) {
                                    $pro_type = $pro_types[$index];
                                    $pro_qty = $pro_qtys[$index];
                                    $pro_tail = $pro_tails[$index];
                                    $pro_first_price = $pro_first_prices[$index];
                                    $pro_main_price = $pro_main_prices[$index];
                                    $stmt = $connect->prepare("INSERT INTO outside_products (order_id,order_number,product_name,product_qty,product_type,product_tail,first_price,main_price)
                                        VALUES (:zorder_id,:zorder_number,:zproduct_name,:zproduct_qty,:zproduct_type,:zproduct_tail,:zfirst_price,:zmain_price)
                                        ");

                                    $stmt->execute(array(
                                        'zorder_id' => $order_id,
                                        "zorder_number" => $order_number,
                                        'zproduct_name' => $name,
                                        'zproduct_qty' => $pro_qty,
                                        'zproduct_type' => $pro_type,
                                        'zproduct_tail' => $pro_tail,
                                        'zfirst_price' => $pro_first_price,
                                        'zmain_price' => $pro_main_price,
                                    ));
                                    //////////// End  Insert Into OutSide Products //////////////////////
                                }
                            }


                            /////////////////////// Start Insert OutSide Services  ////////////////////////
                            ///
                            foreach ($serv_names as $index => $serv_name) {
                                if (!empty($serv_name)) {
                                    $serv_first_price = $serv_first_prices[$index];
                                    $serv_main_price = $serv_main_prices[$index];

                                    $stmt = $connect->prepare("INSERT INTO outside_services (order_id,order_number,serv_name,first_price,main_price)
                                        VALUES (:zorder_id,:zorder_number,:zserv_name,:zfirst_price,:zmain_price)
                                        ");
                                    $stmt->execute(array(
                                        'zorder_id' => $order_id,
                                        "zorder_number" => $order_number,
                                        'zserv_name' => $serv_name,
                                        'zfirst_price' => $serv_first_price,
                                        'zmain_price' => $serv_main_price,
                                    ));
                                }
                            }
                            /////////////////////// End Insert OutSide Services ///////////////////////////


                            if ($stmt) {
                                //include "send_mail/index.php";
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
                                unset($_SESSION['shipping_problem']);
                                $stmt = $connect->prepare("DELETE FROM cart WHERE cookie_id = ? OR user_id = ?");
                                $stmt->execute(array($cookie_id, $user_id));
                                header("Location:profile/orders/compelete");
                            }
                        } catch (\Exception $e) {
                            echo $e;
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
                                "save_card" => false,
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
                                    "url" => "https://www.mshtly.com/checkout"
                                ],
                                "redirect" => [
                                    "url" => "https://www.mshtly.com/payment/callback"
                                ],
                                "metadata" => [
                                    "udf1" => "Metadata 1"
                                ]
                            ],
                            'headers' => [
                                'Authorization' => 'Bearer sk_live_btGUwFZROMA1vTSK4LomyIWn',
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
                } else {
                    foreach ($formerror as $error) {
            ?>

                        <div style="margin-top: 20px;" class="alert alert-danger"> <?php echo $error; ?> </div>
            <?php
                    }
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
<style>
    /* #payment1 {
        display: block !important;
    }

    #payment2 {
        display: none !important;
    } */
</style>

<?php
include $tem . 'footer.php';
ob_end_flush();
?>


<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>