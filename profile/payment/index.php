<?php
ob_start();
session_start();
$page_title = ' طرق الدفع  ';
include 'init.php';
$user_id = $_SESSION['user_id'];
?>
<div class="profile_page adress_page">

    <div class='container'>
        <div class="data">
            <div class="breadcrump">
                <p> <a href="../index"> الرئيسية </a> \ <a href="../index"> حسابي </a> \ <span> طرق الدفع </span> </p>
            </div>
            <div class="purches_header">
                <div class="data_header_name">
                    <h2 class='header2'> طرق الدفع </h2>
                    <p> نستخدم أحدث طرق التشفير لحفط بياناتك </p>
                </div>

            </div>
            <div class="addresses">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="address active payment_method">
                            <form action="#" method="post">
                                <div class='add_head'>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="flexRadioDefault"
                                            id="flexRadioDefault1" checked>
                                        <label class="form-check-label" for="flexRadioDefault1" class='active'>
                                            تعيين كطريقة دفع افتراضية
                                        </label>
                                    </div>
                                    <div class='remove_add'>
                                        <button> <i class='fa fa-close'></i> حذف البطاقة </button>
                                    </div>
                                </div>
                                <div class='add_content'>
                                    <div class="card_image">
                                        <img src="<?php echo $uploads ?>master.png" alt="">
                                    </div>
                                    <div class="card_data">
                                        <p class="number"> 7343 **** **** **** </p>
                                        <p class="end_date"> تاريخ الانتهاء <span> 06/24 </span> </p>
                                        <p class="name"> AHMED SAMIR </p>
                                    </div>
                                </div>
                                <div class='edit'>
                                    <a href="#"> تعديل <img src="<?php echo $uploads ?>edit_button.svg" alt=""> </a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="address payment_method">
                            <form action="#" method="post">
                                <div class='add_head'>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="flexRadioDefault"
                                            id="flexRadioDefault1">
                                        <label class="form-check-label" for="flexRadioDefault1" class='active'>
                                            تعيين كطريقة دفع افتراضية
                                        </label>
                                    </div>
                                    <div class='remove_add'>
                                        <button> <i class='fa fa-close'></i> حذف البطاقة </button>
                                    </div>
                                </div>
                                <div class='add_content'>
                                    <div class="card_image">
                                        <img src="<?php echo $uploads ?>master.png" alt="">
                                    </div>
                                    <div class="card_data">
                                        <p class="number"> 7343 **** **** **** </p>
                                        <p class="end_date"> تاريخ الانتهاء <span> 06/24 </span> </p>
                                        <p class="name"> AHMED SAMIR </p>
                                    </div>
                                </div>
                                <div class='edit'>
                                    <a href="#"> تعديل <img src="<?php echo $uploads ?>edit_button.svg" alt=""> </a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="add_new_address">
                            <a href="add">
                                <i class="fa fa-plus"></i>
                                <h3> أضف بطاقة جديدة </h3>
                            </a>
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