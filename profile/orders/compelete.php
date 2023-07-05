<?php
ob_start();
session_start();
$page_title = ' تم الطلب   ';
include 'init.php';
if (isset($_SESSION['user_id'])) {
?>
    <div class="profile_page retrun_orders">

        <div class='container'>
            <div class="data">
                <div class="breadcrump">
                    <p> <a href="../../index"> الرئيسية </a> \ <a href="../index"> حسابي </a> \
                        <span> تم الطلب </span>
                    </p>
                </div>
                <div class="purches_header">
                    <div class="data_header_name">
                        <h2 class='header2'> تم الطلب </h2>
                    </div>
                </div>
                <div class="not_found_orders ">
                    <div class="info">
                        <img src="<?php echo $uploads ?>shopping-cart-check.svg" alt="">
                        <h3 style="margin-top: 20px; margin-bottom: 20px;"> تم إكمال الشراء بنجاح </h3>
                        <p style="color: #8F918F;"> رقم الطلب : <span style="color: #000;"> <?php echo $_SESSION['order_number']; ?> </span> </p>
                        <span style="color: #8F918F; font-size: 14px;"> يمكنك تتع طلبك من هنا </span>
                        <div style="margin-top: 20px;">
                            <a href="tracking?order_number=<?php echo $_SESSION['order_number']; ?>" class="btn global_button"> تتبع الطلب </a>
                            <a style="background-color: transparent; color: var(--second-color); border-color:var(--second-color)" href="http://localhost/mashtly/contact" class="btn global_button contact"> تواصل معنا </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
<?php
} else {
    header("location:../../login");
}
include $tem . 'footer.php';
ob_end_flush();
?>