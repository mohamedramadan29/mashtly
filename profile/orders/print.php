<?php
ob_start();
session_start();
$page_title = ' طباعه فاتورة | مشتلي ';
include 'init.php';
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $order_number = $_GET['order_number'];
    // get user data 

    $stmt = $connect->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
    $stmt->execute(array($user_id));
    $user_data = $stmt->fetch();
    $user_name = $user_data['name'];
    $user_username = $user_data['user_name'];
    $user_email = $user_data['email'];
    $user_phone = $user_data['phone'];

    // get order data 

    $stmt = $connect->prepare("SELECT * FROM orders WHERE order_number = ? AND user_id = ? LIMIT 1");
    $stmt->execute(array($order_number, $user_id));
    $order_data = $stmt->fetch();
    $ship_price = $order_data['ship_price'];
    $order_date = $order_data['order_date'];
    $total_price = $order_data['total_price'];

    // get order details

    $stmt = $connect->prepare("SELECT * FROM order_details WHERE order_number = ?");
    $stmt->execute(array($order_number));
    $alldetails = $stmt->fetchAll();


?>

    <div class="profile_page">
        <div class='container'>
            <div class="data">
                <div class="print_order">
                    <div class="print printable-content" id="print">
                        <div class="print_head">
                            <div class="logo">
                                <img src="<?php echo $uploads ?>/logo.png" alt="">
                            </div>
                            <div class="person_data">
                                <h2> مرحبا <?php if (!empty($user_name)) {
                                                echo $user_name;
                                            } else {
                                                echo $user_username;
                                            }; ?> </h2>
                                <p> شكرا لطلبك، من مشتلي تم تأكيد طلبك وسوف يصلك في الوقت المحدد لإلغاء الطلب أو تعديله يرجي زيارة الموقع قسم <span style="color: var(--second-color);"> مشترياتي </span> </p>
                                <p> يوجد أدناه فاتورة برقم الطلب وتفاصيله </p>
                            </div>
                            <div class="d-flex ul_div">
                                <ul class="list-unstyled">
                                    <li> <span> رقم الطلب: </span> </li>
                                    <li> <span> تاريخ الطلب: </span> </li>
                                    <li> <span> الاسم: </span> </li>
                                    <li> <span> البريد الألكتروني : </span> </li>
                                    <li> <span> رقم الجوال: </span> </li>
                                </ul>
                                <ul class="list-unstyled">
                                    <li> #62403441 </li>
                                    <li> 30 مايو 2023 | 10:31 مساءً </li>
                                    <li> <?php if (!empty($user_name)) {
                                                echo $user_name;
                                            } else {
                                                echo $user_username;
                                            }; ?> </li>
                                    <li> <?php echo $user_email; ?> </li>
                                    <li> <?php echo $user_phone; ?> </li>
                                </ul>
                            </div>
                        </div>
                        <div class="order_details">
                            <h4> تفاصيل الطلب </h4>
                            <div class="order">
                                <div>
                                    <h6> المنتج </h6>
                                </div>
                                <div style="display: flex;justify-content: space-between;min-width: 40%;">
                                    <div>
                                        <h6> الكمية </h6>
                                    </div>
                                    <div>
                                        <h6> إجمالي السعر </h6>
                                    </div>
                                </div>
                            </div>
                            <?php
                            foreach ($alldetails as $details) {
                                // get product data
                                $stmt = $connect->prepare("SELECT * FROM products WHERE id = ?");
                                $stmt->execute(array($details['product_id']));
                                $product_data = $stmt->fetch();
                            ?>
                                <div class="order" style="display: flex;">
                                    <div>
                                        <div class="product_data">
                                            <div class="image">
                                                <img src="<?php echo $uploads ?>/product.png" alt="">
                                            </div>
                                            <div>
                                                <h4> <?php echo $product_data['name']; ?> </h4>
                                                <p> <?php echo number_format($product_data['price'], 2); ?> ر.س </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="display: flex;justify-content: space-between;min-width: 30%;">
                                        <div>
                                            <span> <?php echo $details['qty']; ?> </span>
                                        </div>
                                        <div>
                                            <span> <?php echo  number_format($details['qty'] * $details['total'], 2); ?> ر.س </span>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }

                            ?>
                        </div>
                        <div class="order_totals">
                            <div class="price_sections">
                                <div class="first">
                                    <div>
                                        <h3> المجموع الفرعي: </h3>
                                        <p> إجمالي سعر المنتجات في السلة </p>
                                    </div>
                                    <div>
                                        <h2 class="total"> <?php echo number_format(50, 2); ?> ر.س </h2>
                                    </div>
                                </div>
                                <div class="first">
                                    <div>
                                        <h3> تكلفة الإضافات: </h3>
                                        <p> تكلفة الزراعة + تكلفة التغليف كهدية </p>
                                    </div>
                                    <div>
                                        <h2 class="total"> <?php echo number_format(40, 2); ?> ر.س </h2>
                                    </div>
                                </div>
                                <div class="first">
                                    <div>
                                        <h3> الشحن والتسليم: </h3>
                                        <p> يحدد سعر الشحن حسب الموقع </p>
                                    </div>
                                    <div>
                                        <h2 class="total"><?php echo number_format($ship_price, 2); ?> ر.س </h2>
                                    </div>
                                </div>
                                <div class="first">
                                    <div>
                                        <h3> ضريبة القيمة المضافة VAT: </h3>
                                        <p> القيمة المضافة تساوي 15% من اجمالي الطلب </p>
                                    </div>
                                    <div>
                                        <?php
                                        $vat = $total_price * (15 / 100);

                                        ?>
                                        <h2 class="total"> <?php echo number_format($vat, 2); ?> ر.س </h2>
                                    </div>
                                </div>
                                <hr>
                                <div class="first">
                                    <div>
                                        <h3> إجمالي المبلغ: </h3>
                                        <p> المبلغ المطلوب دفعه </p>
                                    </div>
                                    <div>
                                        <h2 class="total"> <?php echo number_format($total_price, 2); ?> ر.س </h2>
                                    </div>
                                </div>
                            </div>
                            <p class="thanks"> شكرا لتسوقكم من <a href="#"> مشتلي </a> </p>
                        </div>
                    </div>
                    <button id="print_Button" onclick="window.print(); return false;" class="global_button btn print-link"> طباعة الفاتورة <i class="fa fa-print"></i> </button>
                </div>
            </div>
        </div>
    </div>


<?php
    include $tem . 'footer.php';
    ob_end_flush();
} else {
    header("Location:../index");
}
?>

<style>
    @media print {

        .footer,
        .bottom_footer,
        .main_navbar,
        .instagrame_footer {
            display: none !important;
        }

        .print_order {
            max-width: 100% !important;
            padding: 10px !important;
        }

        body {
            background-color: #fff;
        }

        #print_Button {
            display: none !important;
        }

        .print-link {
            display: none !important;
        }

        @page {
            margin: 0;
        }

        body {
            margin: 1.6cm;
        }
    }
</style>