<?php
ob_start();
session_start();
$page_title = ' تتبع طلبك  ';
include 'init.php';
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    if (isset($_GET['order_number'])) {
        $order_number = $_GET['order_number'];
        // check if this order to this user or n't
        $stmt = $connect->prepare("SELECT * FROM orders WHERE order_number = ? AND user_id = ?");
        $stmt->execute(array($order_number, $user_id));
        $count = $stmt->rowCount();
        if ($count > 0) {
            $order_data = $stmt->fetch();
?>
            <div class="profile_page new_address_page">

                <div class='container'>
                    <div class="data">
                        <div class="breadcrump">
                            <p> <a href="../../index"> الرئيسية </a> \ <a href="../index"> حسابي </a> \ <a href="../purchase"> مشترياتي </a> \
                                <span> تتبع طلبك </span>
                            </p>
                        </div>
                        <div class="purches_header">
                            <div class="data_header_name">
                                <h2 class='header2'> تتبع طلبك </h2>
                                <p> تتبع جميع طلباتك </p>
                            </div>
                        </div>
                        <div class="order_tracking">
                            <div class="data">
                                <div>
                                    <p> رقم الطلب: </p>
                                    <h4 class="date"> <?php echo $order_data['order_number']; ?> </h4>
                                </div>
                                <div>
                                    <p> الشحن إلي: </p>
                                    <h4 class="date"> <?php echo $order_data['address']; ?> </h4>
                                </div>
                            </div>
                            <div class="order_steps">
                                <div class="step step1 active">
                                    <span></span>
                                    <div>
                                        <h3> تم الطلب </h3>
                                        <p> <?php echo $order_data['order_date']; ?> </p>
                                    </div>
                                </div>
                                <div class="step step2">
                                    <span></span>
                                    <div>
                                        <h3> تم تأكيد طلبك </h3>
                                        <p> 4 أبريل 2023 </p>
                                    </div>
                                </div>
                                <div class="step step3">
                                    <span></span>
                                    <div>
                                        <h3> تم الشحن </h3>
                                        <p> 4 أبريل 2023 </p>
                                    </div>
                                </div>
                                <div class="step step4">
                                    <span></span>
                                    <div>
                                        <h3> تم التوصيل </h3>
                                        <p> 4 أبريل 2023 </p>
                                    </div>
                                </div>
                            </div>
                            <div class="order_buttons">
                                <div>
                                    <form action="" method="post">
                                        <button name="cancel_order" class="btn global_button cancel_button"> إلغاء الطلب </button>
                                        <a href="print?order_number=<?php echo $order_number; ?>" class="btn global_button"> تفاصيل الطلب </a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <?php
            if (isset($_POST['cancel_order'])) {
                $stmt = $connect->prepare("UPDATE orders SET status = -1, status_value = 'ملغي' WHERE order_number = ?");
                $stmt->execute(array($order_number));
                if ($stmt) {
            ?>
                    <div class="alert alert-success"> تم الغاء الطلب </div>
    <?php
                    // header("refresh:2;URL=../index");
                    header('Location:../purchase');
                    exit;
                }
            }
        } else {
            header("location:../../index");
        }
    }

    ?>

<?php
} else {
    header('Location:../../login');
}
include $tem . 'footer.php';
ob_end_flush();
?>