<?php
ob_start();
session_start();
$page_title = ' حسابي  ';
include 'init.php';
?>
<div class="profile_page">

    <div class='container'>
        <div class="data">
            <div class="breadcrump">
                <p> <a href="#"> الرئيسية </a> / <span> حسابي </span> </p>
            </div>
            <div class="data_header_name">
                <h2 class='header2'> حسابي </h2>
                <p> قم بتعديل بياناتك وتتبع طلباتك والمزيد </p>
            </div>
            <div class='row'>
                <div class="col-lg-3">
                    <a href="purchase">
                        <div class="info">
                            <div>
                                <img src="<?php echo $uploads ?>/profile_payment.svg" alt="">
                            </div>
                            <div>
                                <h3> مشترياتي </h3>
                                <p> يمكنك تتبع جميع مشترياتك </p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3">
                    <a href="#">
                        <div class="info">
                            <div>
                                <img src="<?php echo $uploads ?>/profile_payment.svg" alt="">
                            </div>
                            <div>
                                <h3> عناويني </h3>
                                <p> تحكم في عناوين الشحن الخاصه بك </p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3">
                    <a href="#">
                        <div class="info">
                            <div>
                                <img src="<?php echo $uploads ?>/profile_payment.svg" alt="">
                            </div>
                            <div>
                                <h3> الإرجاع </h3>
                                <p> طلبات و سياسة إرجاع المنتجات </p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3">
                    <a href="#">
                        <div class="info">
                            <div>
                                <img src="<?php echo $uploads ?>/profile_payment.svg" alt="">
                            </div>
                            <div>
                                <h3> طرق الدفع </h3>
                                <p> تحكم في طرق الدفع الخاصة بك </p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3">
                    <a href="#">
                        <div class="info">
                            <div>
                                <img src="<?php echo $uploads ?>/profile_payment.svg" alt="">
                            </div>
                            <div>
                                <h3> سلة الشراء </h3>
                                <p> جميع المنتجات الموجودة بالسلة </p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3">
                    <a href="#">
                        <div class="info">
                            <div>
                                <img src="<?php echo $uploads ?>/profile_payment.svg" alt="">
                            </div>
                            <div>
                                <h3> المفضلة </h3>
                                <p> منتجاتك المضافة للمفضلة </p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3">
                    <a href="#">
                        <div class="info">
                            <div>
                                <img src="<?php echo $uploads ?>/profile_payment.svg" alt="">
                            </div>
                            <div>
                                <h3> تغيير كلمة المرور </h3>
                                <p> تغيير كلمة المرور الخاصة بك </p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3">
                    <a href="#">
                        <div class="info">
                            <div>
                                <img src="<?php echo $uploads ?>/profile_payment.svg" alt="">
                            </div>
                            <div>
                                <h3> تعديل بياناتي </h3>
                                <p> تعديل البيانات الشخصية </p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
<?php
include $tem . 'footer.php';
ob_end_flush();
?>