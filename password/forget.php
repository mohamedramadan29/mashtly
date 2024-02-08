<?php

ob_start();
session_start();
$page_title = 'نسيت كلمة المرور';
include "init.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);
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

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $email = sanitizeInput($_POST['email']);
                $formerror = [];
                if (empty($email)) {
                    $formerror[] = ' من فضلك ادخل اسم المستخدم او البريد الالكتروني  ';
                }
                if (empty($formerror)) {

                    $stmt = $connect->prepare("SELECT * FROM users WHERE email = ?");
                    $stmt->execute(array($email));
                    $data = $stmt->fetch();
                    $count = $stmt->rowCount();
                    $to_email = $data['email'];
                    $to_name = $data['user_name'];
                    if ($count > 0) {
                        $stmt = $connect->prepare("UPDATE users SET password=?,pass_code=? WHERE email=?");
                        $stmt->execute(array(sha1($randomString), $randomString, $data['email']));
                        try {
                            // الإعدادات الأساسية لإعداد البريد الإلكتروني
                            $mail->CharSet = 'UTF-8';
                            $mail->WordWrap = true;
                            $mail->isSMTP();
                            $mail->Host = 'mshtly.com';
                            $mail->SMTPAuth = true;
                            $mail->Username = 'test@mshtly.com';
                            $mail->Password = 'mohamedramadan2930';
                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

                            $mail->Port = 465;

                            // مُحتوى الرسالة

                            $mail->setFrom('test@mshtly.com', 'مشتلي');
                            $mail->addAddress($to_email, $to_name);
                            $mail->Subject = ' تعديل كلمه المرور الخاصه بك  ';
                            $mail->Body = " <p style='font-size:18px; font-family:inherit'>مرحبا " . $to_name . ",</p>
                                                <p style='font-size:18px; font-family:inherit'> كلمه المرور الجديده الخاصه بك علي مشتلي  </p>
                                                <p style='font-size:18px; font-family:inherit'> " . $randomString . " </p>
                                            ";
                            $mail->AltBody = 'This is the plain text message body for non-HTML mail clients.';
                            // إرسال البريد الإلكتروني
                            $mail->send();
                            //                                header('Location:activate');
            ?>
                            <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
                            <script>
                                new swal({
                                    title: " شكرا لك   !",
                                    text: " تم ارسال كلمه المرور الجديده الخاصه بك علي البريد الالكتروني المسجل  ",
                                    icon: "success",
                                    button: "اغلاق",
                                });
                            </script>
                            <?php header('refresh:3;url=../login'); ?>
                        <?php
                        } catch (Exception $e) {
                            echo "حدث خطأ في إرسال البريد الإلكتروني: {$mail->ErrorInfo}";
                        }
                        // END SEND MAIL //////////////////////////////////////
                        // if ($stmt) {
                        //     header('refresh:4;url=../login');
                        // }
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
            <form action="" method="post" id="send_form">
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
                                <button class="btn global_button forget_button" id="send_message" name="forget_button" type="submit" style="display: block;"> ارسال </button>
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

<script>
    // disable button untill Send 
    $(document).ready(function($) {
        // قائمة لتخزين معلومات الملفات المختارة
        let selectedFiles = [];
        $('#send_form').submit(function() {
            var submitButton = document.getElementById('send_message');
            submitButton.setAttribute('disabled', 'disabled');
        });
    });
</script>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>