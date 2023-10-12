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

            $length = 8; // Set the length of the random string
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; // Set the characters to use
            $randomString = '';

            // Generate the random string
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, strlen($characters) - 1)];
            }
            $randomString =  substr($randomString, 0, 8);

            if (isset($_POST['forget_button'])) {
                $email = sanitizeInput($_POST['email']);
                $stmt = $connect->prepare("SELECT * FROM users WHERE email = ? OR user_name = ? LIMIT 1");
                $stmt->execute(array($email, $email));
                $formerror = [];
                if (empty($email)) {
                    $formerror[] = ' من فضلك ادخل اسم المستخدم او البريد الالكتروني  ';
                }
                if (empty($formerror)) {
                    $stmt = $connect->prepare('SELECT * FROM users WHERE user_name=? OR email=?');
                    $stmt->execute(array($email, $email));
                    $data = $stmt->fetch();
                    $count = $stmt->rowCount();
                    if ($count > 0) {
                        $stmt = $connect->prepare("UPDATE users SET password=?,pass_code=? WHERE user_name=?");
                        $stmt->execute(array($randomString, $randomString, $data['user_name']));
                        $to_email = $data['email'];
                        $subject = "   طلب استعادة كلمة المرور من  مشتلي    ";
                        $body =   " كلمة المورو الجديدة الخاصة بك هي   ";
                        $body .= " =>  " . $randomString;
                        $headers = "From: info@mshtly.com/";
                        mail($to_email, $subject, $body, $headers);
                        if ($stmt) {
            ?>
                            <li class="alert alert-success"> تم ارسال كلمة المرور الجديدة علي الايميل الخاص بك ( <?php echo $data['email']; ?> ) </li>

                        <?php
                            header('refresh:4;url=../login');
                        }
                    } else { ?>
                        <li class="alert alert-danger"> لا يوجد سجل بهذة البيانات </li>
                    <?php
                    }
                } else { ?>
                    <ul>
                        <?php
                        foreach ($formerror as $error) {
                        ?>
                            <li class="alert alert-danger"> <?php echo $error; ?> </li>
                        <?php
                        }
                        ?>
                    </ul>
            <?php
                }
            }
            ?>
            <form action="#" method="post">
                <div class='row'>
                    <div class='box'>
                        <div class="input_box">
                            <label for="email"> البريد الإلكتروني او اسم المستخدم </label>
                            <input value="<?php if (isset($_REQUEST['email'])) echo $_REQUEST['email']; ?>" id="email" type="text" name="email" class='form-control' placeholder=" Example@gmail.com">
                        </div>
                    </div>
                    <div class="box">
                        <div class="input_box">
                            <div class="submit_buttons" style="width: 100%;">
                                <button class="btn global_button forget_button" name="forget_button" type="submit" style="display: block;"> ارسال </button>
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