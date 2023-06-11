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
                <table class="table">
                    <thead>
                        <tr class="thead-row">
                            <th style="border-radius: 0 10px 10px 0;"> المنتج </th>
                            <th> تاريخ الشراء </th>
                            <th> تاريخ طلب الإرجاع </th>
                            <th style="border-radius: 10px 0 0 10px;"> الحالة </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="tbody-row">
                            <td>
                                <div class="product_data">
                                    <div>
                                        <img src="<?php echo $uploads ?>product.png" alt="">
                                    </div>
                                    <div>
                                        <h3>شجيرة التيكوما</h3>
                                        <span>87.00 ر.س</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="buy_date">
                                    <img src="<?php echo $uploads ?>calendar.svg" alt="">
                                    <span> 19 أبريل 2023</span>
                                </div>
                            </td>
                            <td>
                                <div class="buy_date">
                                    <img src="<?php echo $uploads ?>calendar.svg" alt="">
                                    <span> 19 أبريل 2023</span>
                                </div>
                            </td>
                            <td>
                                <p class="status">تم تنفيذ الطلب</p>
                            </td>
                        </tr>
                        <span style="display: block; margin-bottom:15px"></span>
                        <tr>
                            <td>
                                <div class="product_data">
                                    <div>
                                        <img src="<?php echo $uploads ?>product.png" alt="">
                                    </div>
                                    <div>
                                        <h3>شجيرة التيكوما</h3>
                                        <span>87.00 ر.س</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="buy_date">
                                    <img src="<?php echo $uploads ?>calendar.svg" alt="">
                                    <span> 19 أبريل 2023</span>
                                </div>
                            </td>
                            <td>
                                <div class="buy_date">
                                    <img src="<?php echo $uploads ?>calendar.svg" alt="">
                                    <span> 19 أبريل 2023</span>
                                </div>
                            </td>
                            <td>
                                <p class="status">تم تنفيذ الطلب</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<?php
include $tem . 'footer.php';
ob_end_flush();
?>