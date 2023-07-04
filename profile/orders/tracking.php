<?php
ob_start();
session_start();
$page_title = ' تتبع طلبك  ';
include 'init.php';
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
                        <h4 class="date"> 278200-14 </h4>
                    </div>
                    <div>
                        <p> الشحن إلي: </p>
                        <h4 class="date"> مسكن الرحالة </h4>
                    </div>
                </div>
                <div class="order_steps">
                    <div class="step step1 active">
                        <span></span>
                        <div>
                            <h3> تم الطلب </h3>
                            <p> 4 أبريل 2023 </p>
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
                        <a href="#" class="btn global_button cancel_button"> إلغاء الطلب </a>
                        <a href="#" class="btn global_button"> تفاصيل الطلب </a>
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