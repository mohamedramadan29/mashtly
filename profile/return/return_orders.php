<?php
ob_start();
session_start();
$page_title = ' الأرجاع ';
include 'init.php';
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    // get all user return orders 
    $stmt = $connect->prepare("SELECT * FROM return_products WHERE user_id = ?");
    $stmt->execute(array($user_id));
    $count = $stmt->rowCount();

?>
    <div class="profile_page retrun_orders">
        <div class='container'>
            <div class="data">
                <div class="breadcrump">
                    <p> <a href="../index"> الرئيسية </a> \ <a href="../index"> حسابي </a> \
                        <span> الأرجاع </span>
                    </p>
                </div>
                <div class="purches_header">
                    <div class="data_header_name">
                        <h2 class='header2'> الأرجاع </h2>
                    </div>
                </div>
                <?php
                if ($count > 0) {
                ?>
                    <div class="orders">
                        <div class="row">
                            <div>
                                <div class="orders_head">
                                    <p> المنتج </p>
                                    <p> تاريخ الشراء </p>
                                    <p> تاريخ طلب الإرجاع </p>
                                    <p> الحالة </p>
                                </div>
                                <?php
                                $allreturns = $stmt->fetchAll();
                                foreach ($allreturns as $return) {
                                    $product_id = $return['product_id'];
                                    $stmt = $connect->prepare("SELECT * FROM products WHERE id = ?");
                                    $stmt->execute(array($product_id));
                                    $product_data = $stmt->fetch();
                                ?>
                                    <div class="order_data">
                                        <div class="product_data">
                                            <div>
                                                <img src="<?php echo $uploads ?>product.png" alt="">
                                            </div>
                                            <div>
                                                <h3> <?php echo $product_data['name']; ?> </h3>
                                                <span> <?php echo number_format($product_data['price'], 2); ?> ر.س</span>
                                            </div>
                                        </div>
                                        <div class="buy_date">
                                            <!-- get the order date -->
                                            <?php
                                            $stmt = $connect->prepare("SELECT * FROM orders WHERE order_number = ?");
                                            $stmt->execute(array($return['order_number']));
                                            $order_data = $stmt->fetch();
                                            $order_date = $order_data['order_date'];
                                            ?>
                                            <img src="<?php echo $uploads ?>calendar.svg" alt="">
                                            <span> <?php
                                                    $date = $order_date;
                                                    $new_date = date('Y-m-d', strtotime($date));
                                                    echo $new_date; ?> </span>
                                        </div>
                                        <div class="buy_date">
                                            <img src="<?php echo $uploads ?>calendar.svg" alt="">
                                            <span> <?php
                                                    $date = $return['return_date'];
                                                    $newDate = date("Y-m-d", strtotime($date));
                                                    echo $newDate ?> </span>
                                        </div>
                                        <div>
                                            <?php
                                            if ($return['status'] == 0) { ?>
                                                <p class="status"> جاري تنفيذ الطلب ... </p>
                                            <?php
                                            } elseif ($return['status'] == 1) {
                                            ?>
                                                <p class="status">تم تنفيذ الطلب</p>
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
                } else {
                ?>
                    <div class="not_found_orders">
                        <div class="info">
                            <img src="<?php echo $uploads ?>plant.png" alt="">
                            <h3>لا يوجد طلبات إرجاع</h3>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
<?php
} else {
    header("location:../../login");
}
include $tem . 'footer.php';
ob_end_flush();
?>