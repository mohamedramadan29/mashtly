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
                        <form action="" method="post">
                            <div class="input_box">
                                <input required value="<?php if (isset($_REQUEST['order_number'])) echo $_REQUEST['order_number'] ?>" name="order_number" type="text" placeholder="البحث برقم الطلب…" class='form-control'>
                            </div>
                            <div class="input_box">
                                <button class="btn global_button" name="search_order" type='submit'> <img src="<?php echo $uploads; ?>order_search.svg" alt=""> بحث </button>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
                $stmt = $connect->prepare("SELECT * FROM orders WHERE user_id = ? AND  status_value !='pending'  ORDER BY id DESC");
                $stmt->execute(array($user_id));
                $orders = $stmt->fetchAll();
                $count_orders = $stmt->rowCount();
                // Make Search Form
                if (isset($_POST['search_order'])) {
                    $order_number = $_POST['order_number'];
                    $stmt = $connect->prepare("SELECT * FROM orders WHERE order_number=? AND user_id = ?");
                    $stmt->execute(array($order_number, $user_id));
                    $count = $stmt->rowCount();
                    if ($count > 0) {
                        $orders = $stmt->fetchAll();
                    } else {
                ?>
                        <div class="alert alert-danger"> لا يوجد طلب بهذا الرقم </div>
                    <?php
                    }
                }
                if ($count_orders > 0) {
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
                                            <a href="orders/print?order_number=<?php echo $order['order_number']; ?>" class="btn global_button"> طباعة الفاتورة <img src="<?php echo $uploads ?>print.svg" alt=""> </a>
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
                                        $stmt = $connect->prepare("SELECT * FROM products_image WHERE product_id = ?");
                                        $stmt->execute(array($product_data['id']));
                                        $product_data_image = $stmt->fetch();
                                        $count_image = $stmt->rowCount();
                                        if ($count_image > 0) {
                                            $product_image = $product_data_image['main_image'];
                                        } else {
                                            $product_image = "insta3.png";
                                        }
                                    ?>
                                        <div class="body_data">
                                            <div class='product_data'>
                                                <div>
                                                    <a href="http://localhost/mashtly/product/<?php echo $product_data['slug']; ?>">
                                                        <img src="../admin/product_images/<?php echo $product_image; ?>" alt="">
                                                    </a>
                                                </div>
                                                <div>
                                                    <a href="http://localhost/mashtly/product/<?php echo $product_data['slug']; ?>">
                                                        <h2> <?php echo $product_data['name']; ?> </h2>
                                                    </a>
                                                    <span> <?php echo number_format($detail['product_price'], 2); ?> ر.س</span>
                                                    <?php
                                                    // get more details data
                                                    $stmt = $connect->prepare("SELECT * FROM product_details2 WHERE id = ?");
                                                    $stmt->execute(array($detail['more_details']));
                                                    $more_details_data = $stmt->fetch();
                                                    $more_detail_name = $more_details_data['vartions_name']
                                                    ?>
                                                    <br>
                                                    <p class="badge badge-danger bg-danger"><?php echo $more_detail_name; ?></p>
                                                    <br>
                                                    <p style="display: block; width: 100%;"> امكانية الزراعه ::
                                                        <?php if ($detail['farm_service'] == 0) {
                                                            echo "لا";
                                                        } else {
                                                            echo "نعم ";
                                                        } ?> </p>
                                                </div>
                                            </div>
                                            <div class='order_status'>
                                                <?php
                                                if ($order['status_value'] == 'مكتمل') {
                                                ?>
                                                    <?php
                                                    // check if product Already in return orders or Not 
                                                    $stmt = $connect->prepare("SELECT * FROM return_products WHERE order_number = ? AND product_id = ?");
                                                    $stmt->execute(array($order['order_number'], $detail['product_id']));
                                                    $count_return = $stmt->rowCount();
                                                    if ($count_return > 0) {
                                                        $return_data = $stmt->fetch();
                                                        if ($return_data['status'] == 0) {
                                                    ?>
                                                            <a style="color: var(--second-color);">
                                                                جاري تنفيذ طلب الأرجاع .... </a>
                                                        <?php
                                                        } elseif ($return_data['status'] == 1) {
                                                        ?>
                                                            <a style="color: var(--second-color);">
                                                                تم استرجاع المنتج </a>
                                                        <?php
                                                        }
                                                        ?>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <p> تم التوصيل في: <span> <?php echo $order['order_date'] ?> </span> </p>
                                                        <!-- <a href="return/return_product?order=<?php echo $order['order_number']; ?>&product=<?php echo $product_data['id']; ?>" class='btn global_button return_product'>
                                                            إرجاع المنتج </a> -->
                                                        <a href="product_reviews/add?order=<?php echo $order['order_number']; ?>&product=<?php echo $product_data['id']; ?>" class='btn global_button return_product'>
                                                            اضافة تقيم </a>
                                                    <?php
                                                    }
                                                    ?>

                                                <?php
                                                } elseif ($order['status_value'] == 'ملغي') {
                                                ?>
                                                    <p> طلب ملغي </p>
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
                } else {
                    ?>
                    <div class="not_found_orders">
                        <div class="info" style="flex-direction: column;">
                            <img src="<?php echo $uploads ?>plant.png" alt="">
                            <br>
                            <h3> لا يوجد طلبات شراء في الوقت الحالي </h3>
                            <br>
                            <a href="../shop" class="btn global_button"> تسوق الان </a>
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