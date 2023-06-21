<?php
ob_start();
session_start();
$page_title = 'مشتلي - الرئيسية';
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
<!-- end breadcrump  -->
<style>
    .slider1,
    .slider2 {
        width: 300px;
        margin: 0 auto;
    }

    .slider2 {
        margin-top: 20px;
    }
</style>
<!-- START PRODUCT  -->
<div class="product_details">
    <div class="container">
        <div class="data">
            <div class="row">
                <div class="col-lg-8">
                    <div class="product_info_details">
                        <div class="product_images">

                        </div>
                        <div class="product_info">
                            product_info
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="slider1">
    <div><img src="uploads/product.png" alt="Image 1"></div>
    <div><img src="uploads/product.png" alt="Image 2"></div>
    <div><img src="uploads/product.png" alt="Image 3"></div>
</div>
<div class="slider2">
    <div><img src="uploads/product.png" alt="Image 1"></div>
    <div><img src="uploads/product.png" alt="Image 2"></div>
    <div><img src="uploads/product.png" alt="Image 3"></div>
</div>
<!-- END  PRODUCT  -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="themes/js/slick.min.js"></script>

<script>
    $(document).ready(function() {
        $('.slider1').slick({
            arrows: false,
            asNavFor: '.slider2'
        });

        $('.slider2').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            asNavFor: '.slider1',
            centerMode: true,
            focusOnSelect: true
        });
    });
</script>
<?php
include $tem . 'footer.php';
ob_end_flush();
?>