<?php
ob_start();
session_start();
$page_title = ' مشترياتي  ';
include 'init.php';
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
?>
    <div class="profile_page">
        <div class='container'>
            <div class="data">
                <div class="breadcrump">
                    <p> <a href="../index"> الرئيسية </a> \ <a href="index"> حسابي </a> \ <span> مشترياتي </span> </p>
                </div>
                <div class="purches_header">
                    <div class="data_header_name">
                        <h2 class='header2'> مشترياتي </h2>
                        <p> يمكنك تتبع جميع مشترياتك </p>
                    </div>
                    <div class='search'>
                        <form action="#" method="post">
                            <div class="input_box">
                                <input type="text" placeholder="البحث برقم الطلب…" class='form-control'>
                            </div>
                            <div class="input_box">
                                <button class="btn global_button" name="search_order" type='submit'> <img src="<?php echo $uploads; ?>order_search.svg" alt=""> بحث </button>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
                $stmt = $connect->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY id DESC");
                $stmt->execute(array($user_id));
                $orders = $stmt->fetchAll();
                foreach ($orders as $order) {
                    /* Formate Date  */
                    $dateString = $order['order_date'];
                    $dateTime = DateTime::createFromFormat('m/d/Y h:i A', $dateString);
                    $newDate = $dateTime->format('j F Y h:i A');
                    // تحويل الشهور إلى اللغة العربية
                    $arabicMonths = array(
                        "January" => "يناير",
                        "February" => "فبراير",
                        "March" => "مارس",
                        "April" => "أبريل",
                        "May" => "مايو",
                        "June" => "يونيو",
                        "July" => "يوليو",
                        "August" => "أغسطس",
                        "September" => "سبتمبر",
                        "October" => "أكتوبر",
                        "November" => "نوفمبر",
                        "December" => "ديسمبر"
                    );
                    foreach ($arabicMonths as $englishMonth => $arabicMonth) {
                        $newDate = str_replace($englishMonth, $arabicMonth, $newDate);
                    }
                ?>
                    <div class='purches_orders'>
                        <div class="card">
                            <div class='card-header'>
                                <div class='header_data'>
                                    <div class='order_num'>
                                        <h6> رقم الطلب :</h6>
                                        <p> <?php echo $order['order_number']; ?> </p>
                                    </div>
                                    <div class='order_num'>
                                        <h6> تم الطلب في : </h6>
                                        <p><?php echo $newDate; ?></p>
                                    </div>
                                    <div class='order_num'>
                                        <h6> تم الشحن الي : </h6>
                                        <p><?php echo $order['area'] . " - " . $order['city']; ?></p>
                                    </div>
                                </div>
                                <div class="print_section">
                                    <div class="total_invoice">
                                        <h6> أجمالي الفاتورة: </h6>
                                        <p> <?php echo number_format($order['total_price'], 2); ?> ر. س </p>
                                    </div>
                                    <div class="total_invoice">
                                        <a href="#" class="btn global_button"> طباعة الفاتورة <img src="<?php echo $uploads ?>print.svg" alt=""> </a>
                                    </div>
                                </div>
                            </div>
                            <div class='card-body'>
                                <?php
                                // get orders products details
                                $stmt = $connect->prepare("SELECT * FROM order_details WHERE order_id = ?");
                                $stmt->execute(array($order['id']));
                                $order_details = $stmt->fetchAll();
                                foreach ($order_details as $detail) {
                                    // get product data
                                    $stmt = $connect->prepare("SELECT * FROM products WHERE id = ?");
                                    $stmt->execute(array($detail['product_id']));
                                    $product_data = $stmt->fetch();
                                ?>
                                    <div class="body_data">
                                        <div class='product_data'>
                                            <div>
                                                <img src="<?php echo $uploads ?>product.png" alt="">
                                            </div>
                                            <div>
                                                <h2> <?php echo $product_data['name']; ?> </h2>
                                                <span> <?php echo $product_data['price']; ?> ر.س</span>
                                            </div>
                                        </div>
                                        <div class='order_status'>
                                            <?php
                                            if ($order['status_value'] == 'تم التوصيل') {
                                            ?>
                                                <p> تم التوصيل في: <span>5 أبريل 2023</span> </p>
                                                <a href="return_product" class='btn global_button return_product'>
                                                    إرجاع المنتج </a>
                                            <?php
                                            } else {
                                            ?>
                                                <a href="orders/tracking?order_number=<?php echo $order['order_number']; ?>" class='btn global_button'> تتبع الطرد </a>

                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>


                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
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