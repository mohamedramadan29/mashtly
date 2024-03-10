<?php

ob_start();
session_start();
$page_title = 'نسيت كلمة المرور';
include "init.php";
require_once '../send_mail/vendor/autoload.php';
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



                        $transport = (new Swift_SmtpTransport('smtp.mshtly.com', 587))
                            ->setUsername('info@mshtly.com')
                            ->setPassword('mohamedramadan2930#');
                        $mailer = new Swift_Mailer($transport);
                        $body_message = '
                            <!DOCTYPE html>
                            <html lang="ar" dir="rtl">

                            <head>
                                <meta charset="UTF-8">
                                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                <title> تاكيد الحساب </title>
                            </head>
                            <body style="text-align:right;" dir="rtl">
                                <div class="profile_page" style="background-color:#F0F5F0;">
                                    <div class="container">
                                        <div class="data">
                                            <div class="print_order" style="background-color: #fff;padding: 50px;border-radius: 30px;max-width: 75%;margin: auto;margin-top: 80px; margin-bottom:80px;">
                                                <div class="print printable-content" id="print">
                                                    <div class="print_head">
                                                        <div class="logo" style="text-align: center;
                                                        padding: 20px;">
                                                        <img src="https://www.mshtly.com/logo.png" alt="">
                                                        </div>
                                                        <div class="person_data">
                                                            <h2 style=" color: #1B1B1B; font-size: 25px; font-weight: bold; margin-bottom: 16px;">
                                                                ' . $to_name . '
                                                            </h2>
                                                            <p style="color: #585858;  font-size: 17px;  line-height: 1.8;">  كلمه المرور الجديده الخاصه بك علي مشتلي 
                                                            </p>
                                                            <p> ' . $randomString . '  </p>
                                                        </div>
                                                        </div>
                                                    </div> 
                                                    <div class="order_totals">
                                                        <p class="thanks" style="margin-top: 25px;color: #1b1b1b; font-size:18px;"> اطيب االتوفيق  <a href="https://www.mshtly.com/" style="text-decoration: none; color:#5c8e00;"> مشتلي </a> </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </body>

                            </html>
                            ';
                        $title = 'طلب شراء';

                        // Create a message
                        $message = (new Swift_Message('Forget Password'))
                            ->setFrom(['info@mshtly.com' => 'Mshtly'])
                            ->setTo($email)
                            ->setBody($body_message, 'text/html');
                        $result = $mailer->send($message);
                        if ($result) {
            ?>
                            <div class="alert alert-success"> تم ارسال كلمة المرور الجديدة بنجاح  </div>
                        <?php
                        } else {
                        ?>
                            <div class="alert alert-danger"> حدث خطا من فضلك حاول مره اخري </div>
                        <?php
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