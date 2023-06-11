<?php
ob_start();
session_start();
$page_title = ' اضافة طريقة دفع ';
include 'init.php';
?>
<div class="profile_page new_address_page">

    <div class='container'>
        <div class="data">
            <div class="breadcrump">
                <p> <a href="../index"> الرئيسية </a> \ <a href="index"> حسابي </a> \ <a href="payments"> طرق الدفع </a>
                    \
                    <span> أضف بطاقة دفع جديدة</span>
                </p>
            </div>
            <div class="purches_header">
                <div class="data_header_name">
                    <h2 class='header2'> أضف بطاقة دفع جديدة</h2>
                    <p> نستخدم أحدث طرق التشفير لحفط بياناتك </p>
                </div>
            </div>
            <div class="add_new_address add_new_payment">
                <form action="#" method="post">
                    <div class='row'>

                        <div class='box'>
                            <div class="input_box">
                                <label for="name"> أضف رقم البطاقة </label>
                                <input id="name" type="text" name="name" class='form-control'
                                    placeholder=" 0000 0000 0000 0000">
                            </div>
                            <div class="input_box">
                                <label for="phone"> اسم صاحب البطاقة </label>
                                <input id="phone" type="text" name="phone" class='form-control' placeholder="اكتب…">
                            </div>
                        </div>
                        <div class="box">

                            <div class="input_box">
                                <label for="end_date"> تاريخ الانتهاء</label>
                                <input id="end_date" type="text" name="end_date" class='form-control'
                                    placeholder="09 / 23">
                            </div>
                            <div class="input_box">
                                <label for="cvc_number"> CVC </label>
                                <input id="cvc_number" type="text" name="cvc_number" class='form-control'
                                    placeholder="102">
                            </div>
                        </div>

                        <div class="input_box">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                <label class="form-check-label" for="flexCheckChecked">
                                    تعيين كطريقة دفع افتراضية
                                </label>
                            </div>
                        </div>
                        <div class="submit_buttons">
                            <button class="btn global_button" type="reset"> إعادة تعيين </button>
                            <button class="btn global_button"> إضافة عنوان جديد </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<?php
include $tem . 'footer.php';
ob_end_flush();
?>