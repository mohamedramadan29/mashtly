<?php
ob_start();
session_start();
$page_title = ' تسجيل دخول - حساب جديد  ';
include 'init.php';
?>
<div class="profile_page new_address_page">

    <div class='container'>
        <div class="data">
            <div class="breadcrump">
                <p> <a href="../index"> الرئيسية </a> \ <span> تسجيل الدخول </span>
                </p>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="add_new_address login_register">
                        <div class="login">
                            <div class="data_header_name">
                                <h2 class='header2'> تسجيل الدخول </h2>
                                <p> سجل دخولك واحصل على أفضل النباتات المنزلية والحدائق الجميلة </p>
                            </div>
                        </div>
                        <form action="#" method="post">
                            <div class='row'>
                                <div class='box'>
                                    <div class="input_box">
                                        <label for="name"> البريد الألكتروني او اسم المستخدم </label>
                                        <input id="name" type="text" name="name" class='form-control' placeholder="اكتب…">
                                    </div>
                                </div>
                                <div class='box'>
                                    <div class="input_box">
                                        <label for="password"> كلمة المرور </label>
                                        <input id="password" type="password" name="logi_password" class='form-control' placeholder="اكتب…">
                                    </div>
                                </div>
                                <div class="box">
                                    <div class="input_box">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                            <label class="form-check-label" for="flexCheckChecked">
                                                تذكر كلمة المرور؟
                                            </label>
                                        </div>
                                    </div>
                                    <div class="input_box">
                                        <div class="form-check">
                                            <label class="form-check-label" for="flexCheckChecked">
                                                <a href="#" class="forget_password"> هل نسيت كلمة المرور؟ </a>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="submit_buttons">
                                    <button class="btn global_button"> تسجيل الدخول </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6">

                    <span class="line" style="border-right: 2px solid #ccc;
    position: absolute;
    height: 80%;
    top: 50%;"></span>
                    <div class="add_new_address login_register">
                        <div class="login">
                            <div class="data_header_name">
                                <h2 class='header2'> إنشاء حساب جديد </h2>
                                <p> إنشئ حسابك مجانا واحصل علي أفصل النباتات </p>
                            </div>
                        </div>
                        <form action="#" method="post">
                            <div class='row'>
                                <div class='box'>
                                    <div class="input_box">
                                        <label for="name"> اسم المستخدم </label>
                                        <input id="name" type="text" name="name" class='form-control' placeholder="اكتب…">
                                    </div>
                                </div>
                                <div class='box'>
                                    <div class="input_box">
                                        <label for="email"> البريد الألكتروني </label>
                                        <input id="email" type="text" name="text" class='form-control' placeholder="اكتب…">
                                    </div>
                                </div>
                                <div class='box'>
                                    <div class="input_box">
                                        <label for="password"> كلمة المرور </label>
                                        <input id="password" type="password" name="logi_password" class='form-control' placeholder="اكتب…">
                                        <span class="fa fa-eye show_eye"></span>
                                    </div>
                                </div>
                                <div class="box">
                                    <div class="input_box">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                            <label class="form-check-label" for="flexCheckChecked">
                                                أوفق علي <a href="#" target="_blank" style="color: var(--second-color);"> الشروط والأحكام </a>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="box">
                                    <div class="input_box">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                            <label class="form-check-label" for="flexCheckChecked">
                                                اشترك في القائمة البريدية لتصلك آخر العروض والخصومات
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="submit_buttons">
                                    <button class="btn global_button"> إنشاء حساب </button>
                                </div>
                            </div>
                        </form>
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