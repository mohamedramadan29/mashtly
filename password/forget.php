<?php
ob_start();
session_start();
$page_title = 'نسيت كلمة المرور';
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
            <?php
            if (isset($_POST['forget_button'])) {
                $email = sanitizeInput($_POST['email']);
                $stmt = $connect->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
                $stmt->execute(array($email));
                $count = $stmt->rowCount();
                if ($count > 0) {
                    $to = $email;
                    $subject = 'تفعيل الحساب';
                    $message = 'مرحبًا،\n\nشكرًا لتسجيلك في الموقع. يرجى النقر على الرابط التالي لتفعيل حسابك:\n\n http://localhost/mashtly/password/change?email=' . urlencode($email);
                    $headers = 'From: your_email@example.com';
                    // إرسال البريد الإلكتروني
                    if (mail($to, $subject, $message, $headers)) {
            ?>
                        <div class="alert alert-success">
                            تم إرسال رابط التغير إلى عنوان البريد الإلكتروني الخاص بك. يرجى التحقق من بريدك الإلكتروني واتباع التعليمات .
                        </div>
                    <?php

                    } else {
                        echo "حدث خطأ أثناء إرسال رسالة التفعيل. يرجى المحاولة مرة أخرى.";
                    }
                } else {
                    ?>
                    <div class="alert alert-danger"> البريد الإلكتروني غير صحيح </div>
            <?php
                }
            }
            ?>
            <form action="#" method="post">
                <div class='row'>
                    <div class='box'>
                        <div class="input_box">
                            <label for="email"> البريد الإلكتروني </label>
                            <input value="<?php if (isset($_REQUEST['email'])) echo $_REQUEST['email']; ?>" id="email" type="email" name="email" class='form-control' placeholder=" Example@gmail.com">
                        </div>
                    </div>
                    <div class="box">
                        <div class="input_box">
                            <div class="submit_buttons" style="width: 100%;">
                                <button class="btn global_button forget_button" name="forget_button" type="submit" style="display: block;"> أرسل رابط التأكيد </button>
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