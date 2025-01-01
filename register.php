<?php
ob_start();
session_start();
$page_title = 'تسجيل الدخول';
$description = 'سجل الدخول للوصول إلى أفضل النباتات المنزلية وتصاميم الحدائق المميزة. استمتع بخدمات زراعية فريدة وحلول لتجميل المساحات الخارجية والداخلية بأسهل الطرق الممكنة.';
include "init.php";
require 'admin/vendor/autoload.php';
use Google\Client;
use Google\Service\Sheets;

function addClientToGoogleSheet($clientData)
{
    // تحميل بيانات الاعتماد من ملف JSON
    $client = new Client();
    $client->setAuthConfig('refreshing-glow-438708-b2-b759bbeb40eb.json');
    $client->addScope(Sheets::SPREADSHEETS);
    $service = new Sheets($client);
    // إعدادات الـ Google Sheet
    $spreadsheetId = '1Z8M4FIcK4RbY_9ctBu-DxlX2-0x2qJpnoaLFADgwjPw'; // ضع هنا الـ ID من رابط Google Sheet
    $range = 'Sheet1!A1'; // الورقة والنطاق
    $values = [$clientData]; // بيانات الطلبات
    $body = new Sheets\ValueRange(['values' => $values]);
    // كتابة البيانات في Google Sheet
    $params = ['valueInputOption' => 'RAW'];
    $result = $service->spreadsheets_values->append($spreadsheetId, $range, $body, $params);
    return $result;
}


$client->setClientId('97629819536-q1o4om4q3onf2iskp0iglo65o6ici4bv.apps.googleusercontent.com'); // استبدل بـ Client ID
$client->setClientSecret('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'); // استبدل بـ Client Secret
$client->setRedirectUri('http://www.mshtly.com/googlecallback.php'); // استبدل بـ Redirect URI
$client->addScope('email');
$client->addScope('profile');

// إنشاء رابط تسجيل الدخول
$loginUrl = $client->createAuthUrl();

if (isset($_SESSION['user_id'])) {
    header("location:profile");
}
 
?>
<div class="profile_page new_address_page">
    <div class='container'>
        <div class="data">

            <div class="breadcrump">
                <p><a href="../index"> الرئيسية </a> \ <span> تسجيل الدخول </span>
                </p>
            </div>
            <div class="row">

                <div class="col-12">

                    <div class="add_new_address login_register">
                        <div class="login">
                            <div class="data_header_name">
                                <h2 class='header2 text-center'> إنشاء حساب جديد </h2>
                                <p class="text-center"> أنشئ حسابك مجاناً واحصل علي أفضل النباتات </p>
                                <?php
                                if (isset($_POST['new_account'])) {
                                    // Generate a unique activation code 
                                    $active_status_code = rand(1, 55555);
                                    $formerror = [];
                                    $username = sanitizeInput($_POST['user_name']);
                                    $password = sanitizeInput($_POST['password']);
                                    $sha_password = sha1($_POST['password']);
                                    $email = sanitizeInput($_POST['email']);
                                    $phone = sanitizeInput($_POST['phone']);
                                    $agree_policy = isset($_POST['agree_policy']);
                                    $emails_subscribe = isset($_POST['emails_subscribe']);
                                    if ($emails_subscribe) {
                                        $emails_subscribe = 1;
                                    } else {
                                        $emails_subscribe = 0;
                                    }
                                    if (strlen($password) < 8 || !preg_match('/^[a-zA-Z0-9!@#$%^&*()-=_+]+$/', $password) || !preg_match('/\d/', $password)) {
                                        $formerror[] = "كلمة المرور يجب أن تكون اكبر من 8 احرف و تحتوي على الأحرف الإنجليزية والأرقام والرموز الخاصة.";
                                    }
                                    if (!$agree_policy) {
                                        $formerror[] = 'يجب الموافقة علي الشروط والأحكام';
                                    }
                                    if (empty($email)) {
                                        $formerror[] = " يجب اضافة البريد الالكتروني  ";
                                    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                        $formerror[] = " يجب إدخال عنوان بريد إلكتروني صالح ";
                                    } elseif (strlen($email) > 100) {
                                        $formerror[] = "طول البريد الإلكتروني يجب أن لا يتجاوز 100 حرفًا";
                                    } elseif (!preg_match('/^[a-zA-Z0-9.@ـ\-\_\+\,\']+$/u', $email)) {
                                        $formerror[] = "البريد الإلكتروني يجب أن يحتوي على أحرف وأرقام ورموز صحيحة فقط";
                                    } elseif (strpos($email, '..') !== false) {
                                        $formerror[] = "البريد الإلكتروني يحتوي على أحرف غير صالحة";
                                    }
                                    if (empty($username)) {
                                        $formerror[] = "  من فضلك ادخل الاسم الخاص بك ";
                                    }
                                    if (strlen($username) > 50) {
                                        $formerror[] = 'اسم المستخدم يجب ان يكون اقل من 50 حرف';
                                    }
                                    if (empty($phone)) {
                                        $formerror[] = ' من فضلك ادخل رقم الهاتف ';
                                    }
                                    // استخدام الوظيفة للتحقق من وجود البريد الإلكتروني
                                    checkIfExists($connect, 'users', 'email', $email, $formerror, 'البريد الإلكتروني مستخدم بالفعل');
                                    checkIfExists($connect, 'users', 'phone', $phone, $formerror, ' رقم الهاتف مستخدم بالفعل ');
                                    // استخدام الوظيفة للتحقق من وجود اسم المستخدم
                                    checkIfExists($connect, 'users', 'user_name', $username, $formerror, 'اسم المستخدم مستخدم بالفعل');
                                    if (empty($formerror)) {
                                        try {
                                            $stmt = $connect->prepare("INSERT INTO users(user_name,email,phone,password,active_status,active_status_code,emails_subscribe,created_at) VALUES 
                                            (:zuser_name,:zemail,:zphone,:zpassword,:zactive_status,:zactive_status_code,:zemail_sub,:zcreated_at)");
                                            $stmt->execute(array(
                                                "zuser_name" => $username,
                                                "zemail" => $email,
                                                "zphone" => $phone,
                                                "zpassword" => $sha_password,
                                                'zactive_status' => 1,
                                                "zactive_status_code" => $active_status_code,
                                                "zemail_sub" => $emails_subscribe,
                                                'zcreated_at' => date("n/j/Y g:i A"),
                                            ));
                                        } catch (\Exception $e) {
                                            echo $e;
                                        }
                                        // $stmt = insertData($connect, $table, $data);
                                        if ($stmt) {
                                            $stmt = $connect->prepare("SELECT * FROM users ORDER BY id DESC LIMIT 1");
                                            $stmt->execute();
                                            $last_user = $stmt->fetch();
                                            $user_id = $last_user['id'];
                                            addClientToGoogleSheet([
                                                $user_id,
                                                $username,
                                                $email,
                                                1,
                                                $emails_subscribe,
                                                1,
                                                date("n/j/Y g:i A"),
                                            ]);
                                            //////////////////// Send Email Activation ////////////////////////////
                                            header("Location:login");
                                        }
                                    } else {

                                        foreach ($formerror as $error) {
                                            ?>
                                            <div style="max-width: 500px; text-align:center;margin:auto;margin-top:15px;"
                                                class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <?php echo $error; ?>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                            <?php
                                        }
                                    }
                                } ?>
                            </div>
                        </div>
                        <div class="social_media_login">
                            <div class="google_login">
                                <a href="<?= $loginUrl ?>"> <i class="bi bi-google"></i> </a>
                                <br>
                                <span> او </span>
                            </div>
                        </div>
                        <form action="" method="post">
                            <div class='row'>
                                <div class='box'>
                                    <div class="input_box">
                                        <label for="user_name"> اسم المستخدم </label>
                                        <input required id="user_name" type="text" name="user_name" class='form-control'
                                            placeholder="اكتب…" value="<?php if (isset($_REQUEST['user_name']))
                                                echo $_REQUEST['user_name']; ?>">
                                    </div>
                                </div>
                                <div class='box'>
                                    <div class="input_box">
                                        <label for="email"> البريد الألكتروني </label>
                                        <input value="<?php if (isset($_REQUEST['email']))
                                            echo $_REQUEST['email']; ?>" required id="email" type="email" name="email"
                                            class='form-control' placeholder="اكتب…">
                                    </div>
                                </div>

                                <div class='box'>
                                    <div class="input_box">
                                        <label for="email"> رقم الهاتف </label>
                                        <input value="<?php if (isset($_REQUEST['phone']))
                                            echo $_REQUEST['phone']; ?>" required id="phone" type="text" name="phone"
                                            class='form-control' placeholder="اكتب…">
                                    </div>
                                </div>

                                <div class='box'>
                                    <div class="input_box">
                                        <label for="password"> كلمة المرور </label>
                                        <input required id="password" type="password" name="password"
                                            class='password form-control' placeholder="اكتب…">
                                        <span onclick="togglePasswordVisibility('password', this)"
                                            class="fa fa-eye-slash show_eye password_show_icon"></span>

                                    </div>
                                </div>
                                <div class="box">
                                    <div class="input_box">
                                        <div class="form-check">
                                            <input required class="form-check-input" type="checkbox" value=""
                                                name="agree_policy" id="agree_terms" checked>
                                            <label class="form-check-label" for="agree_terms">
                                                أوافق علي <a href="terms" target="_blank"
                                                    style="color: var(--second-color);"> الشروط والأحكام </a>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="box">
                                    <div class="input_box">
                                        <div class="form-check">
                                            <input class="form-check-input" name="emails_subscribe" type="checkbox"
                                                value="" id="subscribe_mail" checked>
                                            <label class="form-check-label" for="subscribe_mail">
                                                اشترك في القائمة البريدية لتصلك آخر العروض والخصومات
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="submit_buttons">
                                    <button class="btn global_button" type="submit" name="new_account"> إنشاء حساب
                                    </button>
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
unset($_SESSION['success_active_code']);
unset($_SESSION['error_active_code']);
include $tem . 'footer.php';
ob_end_flush();
?>


<script>
    function togglePasswordVisibility(inputId, iconElement) {
        var passwordInput = document.getElementById(inputId);
        var icon = iconElement.classList;
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            icon.remove("fa-eye-slash");
            icon.add("fa-eye");
        } else {
            passwordInput.type = "password";
            icon.remove("fa-eye");
            icon.add("fa-eye-slash");
        }
    }
</script>

<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>