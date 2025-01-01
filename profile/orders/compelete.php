<?php
ob_start();
session_start();
$page_title = ' تم الطلب   ';
include 'init.php';
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $order_data = $_SESSION['order_data'];
    try {
        if (isset($_SESSION['order_data'])) {
            if (isset($_SESSION['online_payment'])) {
                $name = $order_data['name'];
                $email = $order_data['email'];
                $phone = $order_data['phone'];
                $phone = $order_data['phone'];
                $order_number = $order_data['order_number'];
                $order_date = $order_data['order_date'];
                $farm_service = $order_data['farm_service_price'];
                $ship_price = $order_data['ship_price'];
                $grand_total = $order_data['total_price'];
                $stmt = $connect->prepare("SELECT * FROM cart WHERE cookie_id = ?");
                $stmt->execute(array($_SESSION['cookie_id']));
                $allitems = $stmt->fetchAll();
                foreach ($allitems as $item) {
                    // echo $item['product_name'];
                }
                include "../../send_mail/index.php";
                unset($_SESSION['order_data']);
                unset($_SESSION['online_payment']);
                unset($_SESSION['farm_services']);
                unset($_SESSION['grand_total']);
                $stmt = $connect->prepare("DELETE FROM cart WHERE cookie_id = ?");
                $stmt->execute(array($_SESSION['cookie_id']));
            }
        }
    } catch (\Exception $e) {
        echo $e;
    }

    ?>
    <div class="profile_page retrun_orders">
        <div class='container'>
            <div class="data">
                <div class="breadcrump">
                    <p> <a href="../../index"> الرئيسية </a> \ <a href="../index"> حسابي </a> \
                        <span> تم الطلب </span>
                    </p>
                </div>
                <div class="purches_header">
                    <div class="data_header_name">
                        <h2 class='header2'> تم الطلب </h2>
                    </div>
                </div>
                <?php
                ################################################################################
                $stmt = $connect->prepare("SELECT * FROM orders WHERE order_number = ?");
                $stmt->execute(array($_SESSION['order_number']));
                $price_data = $stmt->fetch();
                $order_city = $price_data['city'];
                $order_products_price = $price_data['total_price'] - $price_data['ship_price'];
                ##################################################################################
                ?>
                <div class="not_found_orders ">
                    <div class="info">
                        <img src="<?php echo $uploads ?>shopping-cart-check.svg" alt="">
                        <h3 style="margin-top: 20px; margin-bottom: 20px;"> تم إكمال الشراء بنجاح </h3>
                        <!-- ################## Edit Here  ############# -->
                        <?php
                        if ($order_products_price > 199) {
                            ?>
                            <p class="no_sheap_price"
                                style="text-align: center; line-height:2;font-size:20px;color:green; font-weight:bold">
                                <i class="bi bi-check-circle-fill"></i>
                                سوف تحصل علي الهدية الخاصة بك من متجر مشتلي عند التوصيل
                            </p>
                            <?php
                        } elseif ($order_products_price > 99 && $order_city != ['مدينة الرياض']) {
                            ?>
                            <p class="no_sheap_price"
                                style="text-align: center; line-height:2;font-size:20px;color:green; font-weight:bold">
                                <i class="bi bi-check-circle-fill"></i>
                                سوف تحصل علي الهدية الخاصة بك من متجر مشتلي عند التوصيل
                            </p>
                            <?php
                        }
                        ?>
                        <!-- ########################################### End Edit Here ######################### -->
                        <p style="color: #8F918F;"> رقم الطلب : <span style="color: #000;">
                                <?php echo $_SESSION['order_number']; ?> </span> </p>
                        <p style="color: #8F918F;"> السعر الكلي : <span style="color: #000;"> <span id="purches_price"
                                    class="strong"> <?php echo $price_data['total_price']; ?> </span> ريال </span> </p>
                        <span style="color: #8F918F; font-size: 14px;"> يمكنك تتع طلبك من هنا </span>
                        <div style="margin-top: 20px;">
                            <a href="tracking?order_number=<?php echo $_SESSION['order_number']; ?>"
                                class="btn global_button"> تتبع الطلب </a>
                            <a style="background-color: transparent; color: var(--second-color); border-color:var(--second-color)"
                                href="http://localhost/mashtly/contact" class="btn global_button contact"> تواصل معنا </a>
                            <a style="background-color: transparent; color: var(--second-color); border-color:var(--second-color)"
                                href="http://localhost/mashtly/review" class="btn global_button contact"> تقيم مشتلي </a>
                        </div>
                    </div>
                </div>
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