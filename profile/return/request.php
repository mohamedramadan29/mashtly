<?php
ob_start();
session_start();
$page_title = ' تم الطلب   ';
include 'init.php';
if (isset($_SESSION['user_id'])) {
    $return_number = $_GET['num'];
?>
    <div class="profile_page retrun_orders">

        <div class='container'>
            <div class="data">
                <div class="breadcrump">
                    <p> <a href="../../index"> الرئيسية </a> \ <a href="../index"> حسابي </a> \
                        <span> طلب  الارجاع </span>
                    </p>
                </div>
                <div class="purches_header">
                    <div class="data_header_name">
                        <h2 class='header2'>  طلب الارجاع  </h2>
                    </div>
                </div>
                <div class="not_found_orders ">
                    <div class="info">
                        <img src="<?php echo $uploads ?>request_return.svg" alt="">
                        <h3 style="margin-top: 20px; margin-bottom: 20px;"> تم تقديم طلب الإرجاع بنجاح </h3>
                        <p style="color: #8F918F;"> رقم الطلب : <span style="color: #000;"> <?php echo $return_number; ?> </span> </p>
                        <span style="color: #8F918F; font-size: 14px;"> سوف يتواصل معك مندوبنا في خلال ٣ إلي ٥ أيام عمل لإرجاع المنتج </span>
                        <span style="color: #8F918F; font-size: 14px;"> سوف يصلك المبلغ المستحق علي نفس طريقة الدفع التي قمت بها </span>

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