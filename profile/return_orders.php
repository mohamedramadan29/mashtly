<?php
ob_start();
session_start();
$page_title = ' الأرجاع ';
include 'init.php';
?>
<div class="profile_page retrun_orders">

    <div class='container'>
        <div class="data">
            <div class="breadcrump">
                <p> <a href="../index"> الرئيسية </a> \ <a href="index"> حسابي </a> \
                    <span> الأرجاع </span>
                </p>
            </div>
            <div class="purches_header">
                <div class="data_header_name">
                    <h2 class='header2'> الأرجاع </h2>
                </div>
            </div>
            <div class="orders">
                <div class="row">
                    <div>
                        <div class="orders_head">
                            <p> المنتج </p>
                            <p> تاريخ الشراء </p>
                            <p> تاريخ طلب الإرجاع </p>
                            <p> الحالة </p>
                        </div>
                        <div class="order_data">
                            <div class="product_data">
                                <div>
                                    <img src="<?php echo $uploads ?>product.png" alt="">
                                </div>
                                <div>
                                    <h3>شجيرة التيكوما</h3>
                                    <span>87.00 ر.س</span>
                                </div>
                            </div>
                            <div class="buy_date">
                                <img src="<?php echo $uploads ?>calendar.svg" alt="">
                                <span> 19 أبريل 2023</span>
                            </div>
                            <div class="buy_date">
                                <img src="<?php echo $uploads ?>calendar.svg" alt="">
                                <span> 19 أبريل 2023</span>
                            </div>
                            <div>
                                <p class="status">تم تنفيذ الطلب</p>
                            </div>
                        </div>
                        <div class="order_data">
                            <div class="product_data">
                                <div>
                                    <img src="<?php echo $uploads ?>product.png" alt="">
                                </div>
                                <div>
                                    <h3>شجيرة التيكوما</h3>
                                    <span>87.00 ر.س</span>
                                </div>
                            </div>
                            <div class="buy_date">
                                <img src="<?php echo $uploads ?>calendar.svg" alt="">
                                <span> 19 أبريل 2023</span>
                            </div>
                            <div class="buy_date">
                                <img src="<?php echo $uploads ?>calendar.svg" alt="">
                                <span> 19 أبريل 2023</span>
                            </div>
                            <div>
                                <p class="status"> جاري تنفيذ الطلب ... </p>
                            </div>
                        </div>
                        <div class="order_data">
                            <div class="product_data">
                                <div>
                                    <img src="<?php echo $uploads ?>product.png" alt="">
                                </div>
                                <div>
                                    <h3>شجيرة التيكوما</h3>
                                    <span>87.00 ر.س</span>
                                </div>
                            </div>
                            <div class="buy_date">
                                <img src="<?php echo $uploads ?>calendar.svg" alt="">
                                <span> 19 أبريل 2023</span>
                            </div>
                            <div class="buy_date">
                                <img src="<?php echo $uploads ?>calendar.svg" alt="">
                                <span> 19 أبريل 2023</span>
                            </div>
                            <div>
                                <p class="status">تم تنفيذ الطلب</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="not_found_orders">
                <div class="info">
                    <img src="<?php echo $uploads ?>plant.png" alt="">
                    <h3>لا يوجد طلبات إرجاع</h3>
                </div>
            </div>
        </div>
    </div>

</div>
<?php
include $tem . 'footer.php';
ob_end_flush();
?>