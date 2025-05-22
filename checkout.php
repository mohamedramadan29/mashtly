<?php
ob_start();
session_start();
include "init.php";
require 'admin/vendor/autoload.php';
use Google\Client;
use Google\Service\Sheets;
function addOrderToGoogleSheet($orderData)
{
    // تحميل بيانات الاعتماد من ملف JSON
    $client = new Client();
    $client->setAuthConfig('refreshing-glow-438708-b2-a68943cf6319.json');
    $client->addScope(Sheets::SPREADSHEETS);
    $service = new Sheets($client);
    // إعدادات الـ Google Sheet
    $spreadsheetId = '1Maxt487hN-r0SpUReaRZQ7CONfpaVsEPFdq2PyqplwQ'; // ضع هنا الـ ID من رابط Google Sheet
    $range = 'orders_old!A1'; // الورقة والنطاق
    $values = [$orderData]; // بيانات الطلبات
    $body = new Sheets\ValueRange(['values' => $values]);

    // كتابة البيانات في Google Sheet
    $params = ['valueInputOption' => 'RAW'];
    $result = $service->spreadsheets_values->append($spreadsheetId, $range, $body, $params);

    return $result;
}
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

    $stmt = $connect->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute(array($user_id));
    $user_data = $stmt->fetch();

    ?>

    <div class="profile_page adress_page add_new_address">
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
                <form action="" method="post" autocomplete="off">
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
                                                    <input type="text" readonly name="country" class='form-control'
                                                        value="SAR">
                                                </div>
                                                <br>
                                                <div class="input_box">
                                                    <label for="country"> المدينة <span style="color:red;font-size: 16px;"> * </span> </label>
                                                    <select required name="city" id="city" class='form-control'>
                                                        <option value=""> حدد المدينة </option>
                                                        <?php
                                                        $stmt = $connect->prepare("SELECT * FROM suadia_city");
                                                        $stmt->execute();
                                                        $allsaucountry = $stmt->fetchAll();
                                                        $selectedCity = isset($_REQUEST['city']) ? $_REQUEST['city'] : ''; // استرجاع المدينة المحددة
                                                        
                                                        foreach ($allsaucountry as $city) { ?>
                                                            <option data-region='<?php echo $city['region']; ?>' 
                                                                value="<?php echo $city['name']; ?>" 
                                                                <?php echo ($selectedCity == $city['name']) ? "selected" : ""; ?>>
                                                                <?php echo $city['name']; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                                                    <script src="themes/js/tome_select.min.js"></script>

                                                    <script>
                                                        $(document).ready(function () {
                                                            var sessionTotal = <?php echo isset($_SESSION['total']) ? $_SESSION['total'] : 0; ?>;
                                                            var selectedCity = "<?php echo $selectedCity; ?>"; // استعادة المدينة المحددة

                                                            // تهيئة TomSelect بعد تحميل الصفحة
                                                            var citySelect = new TomSelect('#city', {});

                                                            // إعادة تعيين القيمة المخزنة بعد تحميل الصفحة
                                                            if (selectedCity) {
                                                                setTimeout(function() {
                                                                    citySelect.setValue(selectedCity);
                                                                }, 500); // تأخير طفيف لحل أي مشاكل في تحميل TomSelect
                                                            }

                                                            // حدث عند تغيير المدينة
                                                            $(document).on('change', '#city', function () {
                                                                var city = $(this).val();
                                                                var region = $('#city option:selected').data('region');

                                                                // إظهار أو إخفاء طرق الدفع حسب المنطقة
                                                                if (region === 'منطقة الرياض') {
                                                                    $('#payment2').show(); // الدفع عند الاستلام
                                                                    $('#payment1').show(); // الدفع الإلكتروني
                                                                } else {
                                                                    $('#payment2').hide(); // إخفاء الدفع عند الاستلام
                                                                    $('#payment1').show(); // إظهار الدفع الإلكتروني فقط
                                                                }
                                                                    $.ajax({
                                                                        url: 'tempelate/shiping_price2.php',
                                                                        type: 'POST',
                                                                        data: { city: city },
                                                                        success: function (response) {
                                                                            var shippingCost = parseFloat(response);
                                                                            if (isNaN(shippingCost)) {
                                                                                alert(' نعتذر لك عميلنا العزيز، حالياً لا تتوفر خدمة التوصيل للمنطقة التي اخترتها، وسنوافيكم بمجرد توفرها لاحقاً بإذن الله.');
                                                                                // **تحديث الشحن إلى 0 عند عدم توفر التوصيل**
                                                                                updateShippingCost(0);
                                                                                return;
                                                                            }
                                                                            updateShippingCost(shippingCost);
                                                                        }
                                                                    });
                                                                    return;
                                                                updateShippingCost(shippingCost);
                                                            });

                                                            // تحديث تكلفة الشحن والمجموع الكلي
                                                            function updateShippingCost(shippingCost) {
                                                                $('#shipping-cost').html(shippingCost + ' ر.س');
                                                                $('#lastshippingvalue').val(shippingCost);

                                                                var grandTotal = sessionTotal + shippingCost;
                                                                $('#grand_total').html(grandTotal + ' ر.س');
                                                                $('#grand_total_value').val(grandTotal);
                                                            }
                                                        });
                                                    </script>
                                            </div>
                                            <div class='box'>
                                                <div class="input_box">
                                                    <label for="name"> الاسم بالكامل <span
                                                            style="color:red;font-size: 16px;"> * </span></label>
                                                    <input required id="name" type="text" name="name" class='form-control'
                                                        placeholder="اكتب…" value="<?php if (isset($_REQUEST['name']))
                                                            echo $_REQUEST['name'];
                                                        else
                                                            echo $user_data['user_name']; ?>">
                                                </div>
                                                <div class="input_box">
                                                    <label for="phone"> رقم الجوال <span style="color:red;font-size: 16px;">
                                                            * </span></label>
                                                    <input required id="phone" type="text" name="phone" class='form-control'
                                                        placeholder="اكتب…" value="<?php if (isset($_REQUEST['phone']))
                                                            echo $_REQUEST['phone'];
                                                        else
                                                            echo $user_data['phone'] ?>">
                                                    </div>
                                                </div>
                                                <div class="box">
                                                    <div class="input_box">
                                                        <label for="email"> البريد الالكتروني <span
                                                                style="color:red;font-size: 16px;"> * </span></label>
                                                        <input required id="email" type="text" name="email" class='form-control'
                                                            placeholder="اكتب…" value="<?php if (isset($_REQUEST['email']))
                                                            echo $_REQUEST['email'];
                                                        else
                                                            echo $user_data['email']; ?>">
                                                </div>
                                            </div>
                                            <div class="box">
                                                <div class="input_box">
                                                    <label for="street_name"> اسم الشارع <span
                                                            style="color:red;font-size: 16px;"> * </span></label>
                                                    <input required id="street_name" type="text" name="street_name"
                                                        class='form-control' placeholder="اكتب…" value="<?php if (isset($_REQUEST['street_name']))
                                                            echo $_REQUEST['street_name']; ?>">
                                                </div>
                                                <div class="input_box">
                                                    <label for="build_number"> رقم المبني <span
                                                            style="color:red;font-size: 16px;"> * </span> </label>
                                                    <input required id="build_number" type="text" name="build_number"
                                                        class='form-control' placeholder="اكتب…" value="<?php if (isset($_REQUEST['build_number']))
                                                            echo $_REQUEST['build_number']; ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="user_address">
                                    <textarea style="box-shadow: none; outline:none; height:100px;border-radius: 10px"
                                        name="order_details" class="form-control"
                                        placeholder="ملاحظات اضافية علي طلبك"></textarea>
                                </div>
                                <div class="product_details">
                                    <div class="data">
                                        <div class="request">
                                            <div class="options">
                                                <div class="present" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModalgift">
                                                    <div class="image">
                                                        <div class="pre_image">
                                                            <i class="bi bi-award"></i>
                                                        </div>
                                                        <div>
                                                            <h4> اختر الهدية المجانية الخاصة بك </h4>
                                                            <p> </p>
                                                        </div>
                                                    </div>
                                                    <div style="cursor: pointer;">
                                                        <img loading="lazy"
                                                            src="<?php echo $uploads ?>/small_left_model.png"
                                                            alt="التغليف كهدية">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="farm_price preset_price">
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModalgift" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
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
                                                        $allgifts = $stmt->fetchAll();
                                                        foreach ($allgifts as $gift) {
                                                            ?>
                                                            <input style="display: none;" class="select_gift"
                                                                value="<?php echo $gift['name'] ?>" type="radio" name="gift_id"
                                                                id="<?php echo $gift['id']; ?>">
                                                            <label class="diffrent_price gifts"
                                                                for="<?php echo $gift['id']; ?>">
                                                                <div>
                                                                    <img loading="lazy"
                                                                        src="https://www.mshtly.com/uploads/gifts/<?php echo $gift['image']; ?>"
                                                                        alt="التغليف كهدية">
                                                                </div>
                                                                <div>
                                                                    <p> <?php echo $gift['name'] ?> <br>
                                                                        <!-- <span>
                                                                            <?php echo $gift['price'] ?> ريال </span> -->
                                                                    </p>
                                                                </div>
                                                            </label>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                    <button type="button" data-bs-dismiss="modal" aria-label="Close"
                                                        style="background-color:#5c8e00; border-radius: 50px; color:#fff;margin:auto;display: block;"
                                                        class="btn"> حفظ </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-------------- End Gifts ---------------->
                                <br>
                                <div class="col-lg-12">
                                    <div class="cart_price_info">
                                        <p class="no_sheap_price">
                                            <img src="<?php echo $uploads ?>free.svg" alt="">
                                            مدة الشحن المتوقعة 2-7 ايام
                                        </p>
                                        <p class="no_sheap_price">
                                            <img src="<?php echo $uploads ?>free.svg" alt="">
                                            داخل الرياض :
                                            ( قيمة التوصيل لاتشمل الطلبيات الكبيرة جدآ )
                                        </p>
                                        <div class="price_sections">
                                            <div class="first">
                                                <div>
                                                    <h3> المجموع الفرعي: </h3>
                                                    <p> إجمالي سعر المنتجات في السلة </p>
                                                </div>
                                                <div>
                                                    <h2 class="total"> <?php echo number_format($_SESSION['total'], 2); ?>
                                                        ر.س </h2>
                                                </div>
                                            </div>
                                            <div class="first">
                                                <div>
                                                    <h3> تكلفة الإضافات: </h3>
                                                    <!-- <p> تكلفة الزراعة + تكلفة التغليف كهدية </p> -->
                                                    <p> تكلفة الزراعة </p>
                                                </div>
                                                <div>
                                                    <h2 class="total">
                                                        <?php echo number_format($_SESSION['farm_services'], 2); ?> ر.س
                                                    </h2>
                                                </div>
                                            </div>
                                            <div class="first">
                                                <div>
                                                    <h3> الشحن والتسليم: </h3>
                                                    <p> يحدد سعر الشحن حسب الموقع </p>
                                                </div>
                                                <div>
                                                    <h2 id="shipping-cost"></h2>
                                                    <input type="hidden" name="last_shipping_value" id="lastshippingvalue"
                                                        value="<?php echo $shipping_value; ?>">
                                                    <h2 class="total"> </h2>
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
                                                        $grand_total = $_SESSION['total'] + $_SESSION['farm_services'] + $shipping_value;
                                                    }
                                                    ?>
                                                    <!-- <h2 class="total" id="grand_total"> </h2> -->
                                                    <h2 class="total" id="grand_total"> <?php echo $grand_total; ?> ر.س
                                                    </h2>
                                                    <input type="hidden" name="grand_total" id="grand_total_value"
                                                        value="<?php echo $grand_total ?>">
                                                </div>
                                            </div>
                                            <?php
                                            if (isset($_SESSION['coupon'])) {
                                                ?>
                                                <input type="hidden" name="" id="discountCoupon"
                                                    value="<?php echo $shipping_discount; ?>">
                                                <?php
                                                ?>
                                                <div class="first">
                                                    <div>
                                                        <h3> قيمه الخصم : </h3>
                                                        <p> قيمه الخصم من تكلفه الشحنه </p>
                                                    </div>
                                                    <div>
                                                        <input type="hidden" name="discountValue"
                                                            value="<?php echo $shipping_discount; ?>" id="discountValue">
                                                        <h2 class="total" id="discountValue_total">
                                                            <?php echo $shipping_discount; ?>
                                                        </h2>
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
                                </div>
                                <!-- get payments   -->
                                <div class="addresses">
                                    <div class="row">
                                        <div class="align-items-center" id="payment2" style="display: none;">
                                            <input style="width: 35px;height: 28px;cursor: pointer;" required
                                                id="when_drive" type="radio" name="checkout_payment"
                                                value="الدفع عن الاستلام">
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
                                        <style>
                                            #payment2 {
                                                display: flex;
                                            }
                                        </style>
                                        <div class="d-flex align-items-center" id="payment1">
                                            <input checked style="width: 35px;height: 28px;cursor: pointer;" required
                                                id="visa_payment" type="radio" name="checkout_payment"
                                                value="الدفع الالكتروني">
                                            <label style="width: 95%;" for="visa_payment" class="checkout_address">
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
                    // $get user data 
                    $stmt = $connect->prepare("SELECT * FROM users WHERE id = ?");
                    $stmt->execute(array($user_id));
                    $user_data = $stmt->fetch();

                    // get the last order number  id and number 
                    $stmt = $connect->prepare("SELECT * FROM orders ORDER BY id DESC LIMIT 1");
                    $stmt->execute();
                    $order_data = $stmt->fetch();
                    $order_id = $order_data['id'];
                    //$order_number = $order_data['order_number'];
                    // $stmt = $connect->prepare("SELECT COUNT(*) AS order_count FROM orders");
                    // $stmt->execute();
                    // $order_count = $stmt->fetchColumn();
                    // Increment the count by 1 for the new order number
                    $order_number = $order_data['order_number'] + 1;
                    // $order_number = $order_count + 1;
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
                    $address = $build_number . '-' . $street_name . '-' . $area . '-' . $city . '-' . $country;
                    $email = $_POST['email'];
                    $ship_price = $shipping_value;
                    $order_date = date("n/j/Y g:i A");
                    $status = 0;
                    $status_value = 'لم يبدا';
                    $farm_service = $_SESSION['farm_services'];
                    $grand_total = $_SESSION['grand_total'];
                    $gift_id = $_POST['gift_id'];

                    if ($farm_service == '') {
                        $farm_service = 0;
                    }

                    ############################ Edit Here ##################################
                    // if ($city != 'مدينة الرياض') {
                    if (empty($shipping_value) || $shipping_value == 0) {
                        $formerror[] = ' من فضلك حدد الشحن  ';
                    }
                    // }
                    ############################## End Edit Here ##################################
            
                    $payment_method = $_POST['checkout_payment'];

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
                            'gift_id' => $gift_id,
                        ];
                        if ($payment_method === 'الدفع عن الاستلام') {
                           // echo "الدفع عند الاستلام";
                            // inset order into orders 
                            try {
                                $stmt = $connect->prepare("INSERT INTO orders (order_number, user_id, name, email,phone,
                                area, city, address, ship_price,order_details, order_date, status,status_value,farm_service_price,total_price,
                                payment_method,coupon_code,discount_value,shipping_problem,present_id) 
                                VALUES (:zorder_number , :zuser_id , :zname , :zemail ,:zphone , :zarea , :zcity , :zaddress,
                                :zship_price,:zorder_details, :zorder_date, :zstatus, :zstatus_value,:zfarm_service_price,:ztotal_price,:zpayment_method,:zcoupon_code,:zdiscount_value,:zshipping_problem,:zpresent_id)");
                                $stmt->execute(array(
                                    "zorder_number" => $order_number,
                                    "zuser_id" => $user_id,
                                    "zname" => $name,
                                    "zemail" => $email,
                                    "zphone" => $phone,
                                    "zarea" => $area,
                                    "zcity" => $city,
                                    "zaddress" => $address,
                                    "zship_price" => $ship_price,
                                    "zorder_details" => $order_details,
                                    "zorder_date" => $order_date,
                                    "zstatus" => $status,
                                    "zstatus_value" => $status_value,
                                    "zfarm_service_price" => $farm_service,
                                    "ztotal_price" => $grand_total,
                                    "zpayment_method" => $payment_method,
                                    "zcoupon_code" => $_SESSION['coupon_name'],
                                    "zdiscount_value" => $_SESSION['discount_value'],
                                    "zshipping_problem" => $_SESSION['shipping_problem'],
                                    'zpresent_id' => $gift_id

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
                                    $quantity = $item['quantity'];
                                    $price = $item['price'];
                                    $farm_service = $item['farm_service'];
                                    $as_present = $item['gift_id'];
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
                                }
                                if ($stmt) {

                                    #### Add Data to GoogleSheet 
                                    $OrderData = array_map(function ($value) {
                                        return $value ?? '';
                                    }, [
                                        $order_id,
                                        $order_number,
                                        $_SESSION['user_id'] ?? '',
                                        $name,
                                        $email,
                                        $area,
                                        $city,
                                        $ship_price,
                                        $order_date,
                                        'لم يبدا',
                                        $farm_service ?? 0,
                                        $grand_total,
                                        'دفع عند الاستلام',
                                        '1',
                                        $_SESSION['discount_value'] ?? 'NULL',
                                        ''
                                    ]);
                                    addOrderToGoogleSheet($OrderData);
                                   // include "send_mail/index.php";
                                    //// End Send Mail 
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
                                    $stmt = $connect->prepare("DELETE FROM cart WHERE cookie_id = ?");
                                    $stmt->execute(array($cookie_id));
                                    header("Location:profile/orders/compelete");
                                }
                            } catch (\Exception $e) {
                                echo $e;
                            }
                        } elseif ($payment_method === 'الدفع الالكتروني') {
                            // Get the user's details (you can fetch these from your database)
            
                            try {
                                $payment_method = 'الدفع الالكتروني';
                                $status_value = 'pending';
                                $stmt = $connect->prepare("INSERT INTO orders (order_number, user_id, name, email,phone,
                                    area, city, address, ship_price,order_details, order_date, status,status_value,farm_service_price,total_price,
                                    payment_method,coupon_code,discount_value,shipping_problem,present_id) 
                                    VALUES (:zorder_number , :zuser_id , :zname , :zemail ,:zphone , :zarea , :zcity , :zaddress,
                                    :zship_price,:zorder_details, :zorder_date, :zstatus, :zstatus_value,:zfarm_service_price,:ztotal_price,:zpayment_method,:zcoupon_code,:zdiscount_value,:zshipping_problem,:zpresent_id)");
                                $stmt->execute(array(
                                    "zorder_number" => $order_number,
                                    "zuser_id" => $user_id,
                                    "zname" => $name,
                                    "zemail" => $email,
                                    "zphone" => $phone,
                                    "zarea" => $area,
                                    "zcity" => $city,
                                    "zaddress" => $address,
                                    "zship_price" => $ship_price,
                                    "zorder_details" => $order_details,
                                    "zorder_date" => $order_date,
                                    "zstatus" => $status,
                                    "zstatus_value" => $status_value,
                                    "zfarm_service_price" => $farm_service,
                                    "ztotal_price" => $grand_total,
                                    "zpayment_method" => $payment_method,
                                    "zcoupon_code" => $_SESSION['coupon_name'],
                                    "zdiscount_value" => $_SESSION['discount_value'],
                                    "zshipping_problem" => $_SESSION['shipping_problem'],
                                    'zpresent_id' => $gift_id
                                ));
                                // get the last order number  id and number 
                                $stmt = $connect->prepare("SELECT * FROM orders ORDER BY id DESC LIMIT 1");
                                $stmt->execute();
                                $order_data = $stmt->fetch();
                                $order_id = $order_data['id'];
                                $order_number = $order_data['order_number'];
                                $_SESSION['order_number'] = $order_number;
                                $_SESSION['order_id'] = $order_id;
                                foreach ($allitems as $item) {
                                    $product_id = $item['product_id'];
                                    $quantity = $item['quantity'];
                                    $price = $item['price'];
                                    $farm_service = $item['farm_service'];
                                    $as_present = $item['gift_id'];
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
                                }

                            #### Add Data to GoogleSheet 
                            $OrderData = array_map(function ($value) {
                                return $value ?? '';
                            }, [
                                $order_id,
                                $order_number,
                                $_SESSION['user_id'] ?? '',
                                $name,
                                $email,
                                $area,
                                $city,
                                $ship_price,
                                $order_date,
                                'لم يبدا',
                                $farm_service ?? 0,
                                $grand_total,
                                'الدفع الالكتروني',
                                '1',
                                $_SESSION['discount_value'] ?? 'NULL',
                                ''
                            ]);
                            addOrderToGoogleSheet($OrderData);
                            } catch (\Exception $e) {
                                echo $e;
                            }


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
                                    'Authorization' => 'Bearer sk_test',
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
    // function updateTotal(selectedRadio) {
    //     var shippingValue = parseFloat(selectedRadio.value); // القيمة المحددة للشحن
    //     document.getElementById('lastshippingvalue').value = shippingValue;
    //     var subTotal = <?php echo $_SESSION['total'] + $_SESSION['farm_services']; ?>; // المجموع الفرعي
    //     var grandTotal = subTotal + shippingValue; // الإجمالي الجديد
    //     var discount = 0; // الخصم، افترض صفرًا
    //     // إذا كان هناك خصم موجود
    //     <?php if (isset($_SESSION['coupon'])) { ?>
        //         discount = grandTotal * document.getElementById("discountCoupon").value;
        //         grandTotal -= discount; // تطبيق الخصم
        //         document.getElementById("discountValue").value = discount;
        //         document.getElementById('discountValue_total').innerHTML = discount.toFixed(2) + " ر.س";
        //     <?php } ?>
    //     // عرض الإجمالي الجديد بعد تطبيق الخصم
    //     document.getElementById('grand_total').innerHTML = grandTotal.toFixed(2) + " ر.س";
    //     document.getElementById('grand_total_value').value = grandTotal;
    //     // يمكنك تخزين القيمة الإجمالية في الجلسة للاحتفاظ بها بين الصفحات إذا لزم الأمر
    //     <?php $_SESSION['grand_total'] = "grandTotal"; ?>
    //     ///////////////// select payment method ///////////
    // }
</script>





<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>