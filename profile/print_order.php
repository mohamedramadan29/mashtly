<?php
ob_start();
session_start();
$page_title = ' مشترياتي  ';
include 'init.php';
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $order_number = $_GET['order_number'];
?>
    <div class="profile_page">
        <div class='container'>
            <div class="data">
                <div class="print_order">
                    <div>
                        <img src="<?php echo $uploads ?>/logo.png" alt="">
                    </div>
                    <div class="person_data">
                        <h2> مرحبا أحمد سمير </h2>
                        <p> شكرا لطلبك، من مشتلي تم تأكيد طلبك وسوف يصلك في الوقت المحدد لإلغاء الطلب أو تعديله يرجي زيارة الموقع قسم <span style="color: var(--second-color);"> مشترياتي </span> </p>
                        <p> يوجد أدناه فاتورة برقم الطلب وتفاصيله </p>
                    </div>
                    <ul class="list-unstyled">
                        <li> <span> رقم الطلب: </span> <span> #62403441 </span> </li>
                        <li> <span> تاريخ الطلب: </span> <span> 30 مايو 2023 | 10:31 مساءً </span> </li>
                        <li> <span> الاسم: </span> <span> أحمد سمير </span> </li>
                        <li> <span> رقم الجوال: </span> <span> +201092508803 </span> </li>
                    </ul>
                </div>
                <div class="order_details">
                    <h4> تفاصيل الطلب </h4>
                    <div class="order">
                        <div>
                            <h6> المنتج </h6>
                            <div class="product_data">
                                <div class="image">
                                    <img src="<?php echo $uploads ?>/product.png" alt="">
                                </div>
                                <div>
                                    <h4>شجيرة التيكوما</h4>
                                    <p> 87.00 ر.س </p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h6> الكمية </h6>
                            <span> 1 </span>
                        </div>
                        <div>
                            <h6> إجمالي السعر </h6>
                            <span> 87.00 ر.س </span>
                        </div>
                    </div>
                    <div class="order">
                        <div>
                            <h6> المنتج </h6>
                            <div class="product_data">
                                <div class="image">
                                    <img src="<?php echo $uploads ?>/product.png" alt="">
                                </div>
                                <div>
                                    <h4>شجيرة التيكوما</h4>
                                    <p> 87.00 ر.س </p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h6> الكمية </h6>
                            <span> 1 </span>
                        </div>
                        <div>
                            <h6> إجمالي السعر </h6>
                            <span> 87.00 ر.س </span>
                        </div>
                    </div>
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