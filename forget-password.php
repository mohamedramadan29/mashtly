<?php
ob_start();
session_start();
$page_title = 'الرئيسية';
include "init.php";
?>
<div class="profile_page adress_page">
    <div class='container'>
        <div class="data">
            <div class="breadcrump">
                <p> <a href="../index"> الرئيسية </a> \ <span> هل نسيت كلمة المرور </span> </p>
            </div>
            <div class="purches_header">
                <div class="data_header_name">
                    <h2 class='header2'> هل نسيت كلمة المرور </h2>
                    <p> أدخل البريد الإلكتروني الذي قمت بالتسجيل في الموقع من خلاله <br>، وسوف يصلك رابط التأكيد علي بريدك الإلكتروني </p>
                </div>
            </div>
        </div>
        <div class="add_new_address add_new_payment">
            <form action="#" method="post">
                <div class='row'>
                    <div class='box'>
                        <div class="input_box">
                            <label for="email"> البريد الإلكتروني </label>
                            <input id="email" type="email" name="email" class='form-control' placeholder=" Example@gmail.com">
                        </div>
                    </div>
                    <div class="box">
                        <div class="input_box">
                            <div class="submit_buttons" style="width: 100%;">
                                <button class="btn global_button forget_button" style="display: block;"> أرسل رابط التأكيد </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
include $tem . 'footer.php';
ob_end_flush();
?>