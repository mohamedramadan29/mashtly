<?php
ob_start();
session_start();
$page_title = 'تفاصيل المنتج ';
include 'init.php';
?>
<!-- START SELECT DATA HEADER -->
<div class="select_plan_head">
    <div class="container">
        <div class="data">
            <div class="head">
                <img src="<?php echo $uploads ?>plant.svg" alt="">
                <h2> خصم ١٥٪ بمناسبة بداية فصل الربيع </h2>
                <p>
                    استخدم هذا الكود عند اتمام عملية الشراء#SP15%
                </p>
            </div>
        </div>
    </div>
</div>
<!-- END SELECT DATA HEADER -->
<!-- START breadcrump  -->
<div class="container">
    <div class="data">
        <div class="breadcrump">
            <p> <a href="index"> الرئيسية </a> \ <span> نباتات خارجية </span> \ <span> نباتات خارجية </span> شجرة الدفلة </p>
        </div>
    </div>
</div>
<div class="product_details">
    <div class="container">
        <div class="data">
            <div class="row">
                <div class="col-lg-10">
                    <div class="product">
                        <div class="product_images">
                            <img src="<?php echo $uploads ?>/product.png" alt="">
                        </div>
                        <div class="product_info">
                            <h2> <img src="<?php echo $uploads ?>/left_arrow.png" alt=""> شجرة الدفلة </h2>
                            <p> يبدأ من: <span> 87.00 ر.س </span> </p>
                            <div class="support">
                                <div>
                                    <img src="<?php echo $uploads ?>/support.svg" alt="">
                                </div>
                                <div>
                                    <h4> دعم الخبراء </h4>
                                    <p> مجانا قبل وبعد الشراء </p>
                                </div>
                            </div>
                            <div class="attention">
                                <h3> تنويه </h3>
                                <p> الصور المعروضة للنبتة هنا توضح مميزاتها وشكلها بعد زراعتها ورعايتها وتقديم كامل احتياجاتها كما هو موضح في وصف النبتة، وبإمكانكم الحصول على تفاصيل أكثر من خلال دعم خبرائنا المجاني . </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    test2
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include $tem . 'footer.php';
ob_end_flush();
?>