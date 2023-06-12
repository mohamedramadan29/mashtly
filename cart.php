<?php
ob_start();
session_start();
$page_title = ' سلة الشراء  ';
include 'init.php';
?>
<div class="profile_page adress_page">

    <div class='container'>
        <div class="data">
            <div class="breadcrump">
                <p> <a href="index"> الرئيسية </a> \ <span> سلة الشراء </span> </p>
            </div>
            <div class="purches_header">
                <div class="data_header_name">
                    <h2 class='header2'> سلة الشراء </h2>
                    <p> عدد عناصر السلة: <span> 3 </span></p>
                </div>
            </div>
            <div class="cart">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="card_items">
                            <span class="fa fa-close remove_item"> </span>
                            <div class="product_data">
                                <div class="product_image">
                                    <img src="<?php echo $uploads ?>product.png" alt="">
                                </div>
                                <div class="product_info">
                                    <h3> نبات ملكة النهار </h3>
                                    <p class="item_price"> سعر الوحدة :<span> 87.00 ر.س </span> </p>
                                    <p class="add_fav"> <img src="<?php echo $uploads ?>heart.png" alt=""> أضف الي المفضلة  </p>
                                </div>
                            </div>
                            <div class="product_num">
                                <form action="#" method="post">
                                    <div class="counter">
                                        <span class="plus" id="fa-plus"> <img src="<?php echo $uploads ?>plus.svg" alt=""> </span>
                                        <span class="count_number" id="count_number"> 1 </span>
                                        <span class="minus" id="fa-minus"> <img src="<?php echo $uploads ?>minus.svg" alt=""> </span>
                                    </div>
                                </form>
                                <p> إجمالي السعر: <span> 87.00 ر.س </span> </p>
                            </div>
                            <div class="services">
                                <form action="#" method="post">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <label class="form-check-label" for="flexCheckChecked">
                                            أضف خدمة الزراعة
                                        </label>
                                    </div>
                                    <p> <span> 15 ر.س </span> <a href="#"> إعرف أكثر عن التكلفة </a> </p>
                                </form>
                                <div class="gift">
                                    <div class="image">
                                        <img src="<?php echo $uploads ?>product.png" alt="">
                                    </div>
                                    <div class="gift_info">
                                        <h3> التغليف كهدية </h3>
                                        <p> يتم إضافة 20 ر.س </p>
                                    </div>
                                </div>
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