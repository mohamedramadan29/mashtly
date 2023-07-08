<?php
ob_start();
session_start();
$page_title = 'الرئيسية';
include "init.php";
if (isset($_SESSION['user_id'])) {
    header("location:profile");
}
?>
<div class="profile_page new_address_page">
    <div class='container'>
        <div class="data">
            <div class="breadcrump">
                <p> <a href="../index"> الرئيسية </a> \ <span> تسجيل الدخول </span>
                </p>
            </div>
            <?php
            include "success_error_msg.php";
            ?>
            <div class="row">
                <div class="col-lg-6">
                    <div class="add_new_address login_register">
                        <div class="login">
                            <div class="data_header_name">
                                <h2 class='header2'> تسجيل الدخول </h2>
                                <p> سجل دخولك واحصل على أفضل النباتات المنزلية والحدائق الجميلة </p>
                            </div>
                        </div>
                        <form action="login_controller" method="post">
                            <div class='row'>
                                <div class='box'>
                                    <div class="input_box">
                                        <label for="name"> البريد الألكتروني او اسم المستخدم </label>
                                        <input id="name" type="text" name="user_name" class='form-control' placeholder="اكتب…">
                                    </div>
                                </div>
                                <div class='box'>
                                    <div class="input_box">
                                        <label for="password"> كلمة المرور </label>
                                        <input id="password2" type="password" name="password" class='password form-control' placeholder="اكتب…">
                                        <span onclick="togglePasswordVisibility('password2', '.password_show_icon')" class="fa fa-eye show_eye password_show_icon"></span>
                                    </div>
                                </div>
                                <div class="box">
                                    <div class="input_box">
                                        <div class="form-check">
                                            <input name="remember_me" class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                            <label class="form-check-label" for="flexCheckChecked">
                                                تذكر كلمة المرور؟
                                            </label>
                                        </div>
                                    </div>
                                    <div class="input_box">
                                        <div class="form-check">
                                            <label class="form-check-label" for="flexCheckChecked">
                                                <a href="password/forget" class="forget_password"> هل نسيت كلمة المرور؟ </a>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="submit_buttons">
                                    <button class="btn global_button" type="submit" name="login"> تسجيل الدخول </button>
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
                        <form action="login_controller" method="post">
                            <div class='row'>
                                <div class='box'>
                                    <div class="input_box">
                                        <label for="user_name"> اسم المستخدم </label>
                                        <input id="user_name" type="text" name="user_name" class='form-control' placeholder="اكتب…">
                                    </div>
                                </div>
                                <div class='box'>
                                    <div class="input_box">
                                        <label for="email"> البريد الألكتروني </label>
                                        <input id="email" type="email" name="email" class='form-control' placeholder="اكتب…">
                                    </div>
                                </div>
                                <div class='box'>
                                    <div class="input_box">
                                        <label for="password"> كلمة المرور </label>
                                        <input id="password" type="password" name="password" class='password form-control' placeholder="اكتب…">
                                        <span onclick="togglePasswordVisibility('password', '.password_show_icon')" class="fa fa-eye show_eye password_show_icon"></span>
                                    </div>
                                </div>
                                <div class="box">
                                    <div class="input_box">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="agree_terms" checked>
                                            <label class="form-check-label" for="agree_terms">
                                                أوفق علي <a href="terms" target="_blank" style="color: var(--second-color);"> الشروط والأحكام </a>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="box">
                                    <div class="input_box">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="subscribe_mail" checked>
                                            <label class="form-check-label" for="subscribe_mail">
                                                اشترك في القائمة البريدية لتصلك آخر العروض والخصومات
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="submit_buttons">
                                    <button class="btn global_button" type="submit" name="new_account"> إنشاء حساب </button>
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
<script>
    function togglePasswordVisibility(inputId, iconClass) {
        var passwordInput = document.getElementById(inputId);
        var passwordIcon = document.querySelector(iconClass);
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            passwordIcon.classList.add("password_show_icon_active");
        } else {
            passwordInput.type = "password";
            passwordIcon.classList.remove("password_show_icon_active");
        }
    }
</script>