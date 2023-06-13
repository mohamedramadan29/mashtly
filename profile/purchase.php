<?php
ob_start();
session_start();
$page_title = ' مشترياتي  ';
include 'init.php';
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
            <div class='purches_orders'>
                <div class="card">
                    <div class='card-header'>
                        <div class='header_data'>
                            <div class='order_num'>
                                <h6> رقم الطلب :</h6>
                                <p> 27550-221 </p>
                            </div>
                            <div class='order_num'>
                                <h6> تم الطلب في : </h6>
                                <p> 4 أبريل 2023 </p>
                            </div>
                            <div class='order_num'>
                                <h6> تم الشحن الي : </h6>
                                <p> مسكن الرحالة </p>
                            </div>
                        </div>
                        <div class="print_section">
                            <div class="total_invoice">
                                <h6> أجمالي الفاتورة: </h6>
                                <p> 280 ر. س </p>
                            </div>
                            <div class="total_invoice">
                                <a href="#" class="btn global_button"> طباعة الفاتورة <img src="<?php echo $uploads ?>print.svg" alt=""> </a>
                            </div>
                        </div>
                    </div>
                    <div class='card-body'>
                        <div class="body_data">
                            <div class='product_data'>
                                <div>
                                    <img src="<?php echo $uploads ?>product.png" alt="">
                                </div>
                                <div>
                                    <h2>شجيرة التيكوما</h2>
                                    <span>87.00 ر.س</span>
                                </div>
                            </div>
                            <div class='order_status'>
                                <a href="order_tracking" class='btn global_button'> تتبع الطرد </a>
                            </div>
                        </div>
                        <div class="body_data">
                            <div class='product_data'>
                                <div>
                                    <img src="<?php echo $uploads ?>product.png" alt="">
                                </div>
                                <div>
                                    <h2>شجيرة التيكوما</h2>
                                    <span>87.00 ر.س</span>
                                </div>
                            </div>
                            <div class='order_status'>
                                <a href="order_tracking" class='btn global_button'> تتبع الطرد </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class='purches_orders'>
                <div class="card">
                    <div class='card-header'>
                        <div class='header_data'>
                            <div class='order_num'>
                                <h6> رقم الطلب :</h6>
                                <p> 27550-221 </p>
                            </div>
                            <div class='order_num'>
                                <h6> تم الطلب في : </h6>
                                <p> 4 أبريل 2023 </p>
                            </div>
                            <div class='order_num'>
                                <h6> تم الشحن الي : </h6>
                                <p> مسكن الرحالة </p>
                            </div>
                        </div>
                        <div class="print_section">
                            <div class="total_invoice">
                                <h6> أجمالي الفاتورة: </h6>
                                <p> 280 ر. س </p>
                            </div>
                            <div class="total_invoice">
                                <a href="#" class="btn global_button"> طباعة الفاتورة <img src="<?php echo $uploads ?>print.svg" alt=""> </a>
                            </div>
                        </div>
                    </div>
                    <div class='card-body'>
                        <div class="body_data">
                            <div class='product_data'>
                                <div>
                                    <img src="<?php echo $uploads ?>product.png" alt="">
                                </div>
                                <div>
                                    <h2>شجيرة التيكوما</h2>
                                    <span>87.00 ر.س</span>
                                </div>
                            </div>
                            <div class='order_status'>
                                <p> تم التوصيل في: <span>5 أبريل 2023</span> </p>
                            </div>
                        </div>
                        <div class="body_data">
                            <div class='product_data'>
                                <div>
                                    <img src="<?php echo $uploads ?>product.png" alt="">
                                </div>
                                <div>
                                    <h2>شجيرة التيكوما</h2>
                                    <span>87.00 ر.س</span>
                                </div>
                            </div>
                            <div class='order_status'>
                                <p> تم التوصيل في: <span>5 أبريل 2023</span> </p>
                                <a href="#" class='btn global_button return_product'>
                                    إرجاع المنتج </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<?php
include $tem . 'footer.php';
ob_end_flush();
?>