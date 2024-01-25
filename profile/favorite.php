<?php
ob_start();
session_start();
$page_title = ' المفضلة  ';
include 'init.php';
?>
<div class="profile_page adress_page">

    <div class='container'>
        <div class="data">
            <div class="breadcrump">
                <p> <a href="../index"> الرئيسية </a> \ <a href="index"> حسابي </a> \ <span> المفضلة </span> </p>
            </div>
            <div class="purches_header">
                <div class="data_header_name">
                    <h2 class='header2'>  المفضلة  </h2>
                    <p> عدد عناصر المفضلة: 2</p>
                </div>
            </div>
        </div>
        <div class="favorite">
            <div class="fav_data">
                <div class="product_data">
                    <div class="image">
                        <img src="<?php echo $uploads ?>product.png" alt="">
                    </div>
                    <div>
                        <h3> شجيرة التيكوما </h3>
                        <span> 87.00 ر.س </span>
                    </div>
                </div>
                <div class="remove">
                <button class="btn global_button">  أضف الي السلة </button>
                <p> <span class="fa fa-close"></span>  إزالة من المفضلة </p> 
                </div>
            </div>
            <div class="fav_data">
                <div class="product_data">
                    <div class="image">
                        <img src="<?php echo $uploads ?>product.png" alt="">
                    </div>
                    <div>
                        <h3> شجيرة التيكوما </h3>
                        <span> 87.00 ر.س </span>
                    </div>
                </div>
                <div class="remove">
                <button class="btn global_button">  أضف الي السلة </button>
                <p> <span class="fa fa-close"></span>  إزالة من المفضلة </p> 
                </div>
            </div>
            <div class="fav_data">
                <div class="product_data">
                    <div class="image">
                        <img src="<?php echo $uploads ?>product.png" alt="">
                    </div>
                    <div>
                        <h3> شجيرة التيكوما </h3>
                        <span> 87.00 ر.س </span>
                    </div>
                </div>
                <div class="remove">
                <button class="btn global_button">  أضف الي السلة </button>
                <p> <span class="fa fa-close"></span>  إزالة من المفضلة </p> 
                </div>
            </div>
            
        </div>
    </div>

</div>
<?php
include $tem . 'footer.php';
ob_end_flush();
?>