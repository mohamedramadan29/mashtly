<?php
ob_start();
session_start();
$page_title = 'الرئيسية';
include "init.php";
if (isset($_SESSION['user_id'])) {
    header("location:profile");
}
if (isset($_POST['new_account'])) {
    $formerror = [];
    $username = sanitizeInput($_POST['user_name']);
    $password = $_POST['password'];
    $sha_password = sha1($_POST['password']);
    $email = sanitizeInput($_POST['email']);
    $agree_policy = isset($_POST['agree_policy']);
    $emails_subscribe = isset($_POST['emails_subscribe']);
    if ($emails_subscribe) {
        $emails_subscribe = 1;
    } else {
        $emails_subscribe = 0;
    }
    if (strlen($password) < 8) {
        $formerror[] = 'كلمة المرور يجب ان تكون اكثر من 8 احرف ';
    }
    if (!$agree_policy) {
        $formerror[] = 'يجب الموافقة علي الشروط والأحكام';
    }
    // استخدام الوظيفة للتحقق من وجود البريد الإلكتروني
    checkIfExists($connect, 'users', 'email', $email, $formerror, 'البريد الإلكتروني مستخدم بالفعل');
    // استخدام الوظيفة للتحقق من وجود اسم المستخدم
    checkIfExists($connect, 'users', 'user_name', $username, $formerror, 'اسم المستخدم مستخدم بالفعل');
    if (empty($formerror)) {
        $table = 'users';
        $data = array(
            "user_name" => $username,
            "email" => $email,
            "password" => $sha_password,
            "emails_subscribe" => $emails_subscribe,
        );
        $stmt =  insertData($connect, $table, $data);
        if ($stmt) {
            $_SESSION['success'] = ' تم تسجيل حسابك بنجاح من فضلك سجل دخولك الأن ';
            if (isset($_SESSION['new_user_name'])) {
                unset($_SESSION['new_user_name']);
            } elseif (isset($_SESSION['new_email'])) {
                unset($_SESSION['new_email']);
            }
            header('location:login');
        }
    } else {
        $_SESSION['error'] = $formerror;
        header('Location:login');
        $_SESSION['new_user_name'] = $_POST['user_name'];
        $_SESSION['new_email'] = $_POST['email'];
    }
}
/////////////////////////////////////////// login to account /////////////////////////////////
if (isset($_POST['login'])) {
    $formerror = [];
    $username = sanitizeInput($_POST['user_name']);
    $password = sanitizeInput($_POST['password']);
    $rememberMe = isset($_POST['remember_me']);
    $stmt = $connect->prepare("SELECT * FROM users WHERE (user_name=? OR email = ?) AND password=?");
    $stmt->execute(array($username, $username, $password));
    $user_data = $stmt->fetch();
    $count = $stmt->rowCount();
    if ($count > 0) {
        $_SESSION['user_name'] = $user_data['user_name'];
        $_SESSION['user_id']  = $user_data['id'];
        // if click rember me 
        if ($rememberMe) {
            // إنشاء معرّف رمز تذكر كلمة المرور وتخزينه في ملف تعريف الارتباط
            $rememberToken = generateRememberToken();
            $expire_date = time() + (30 * 24 * 60 * 60); // انتهاء المدة بعد 30 يومًا
            setcookie('remember_token', $rememberToken, time() + $expire_date, '/');
            // قم بتخزين معرف المستخدم ورمز تذكر كلمة المرور في قاعدة البيانات أو أي مكان آخر يناسب تطبيقك
            saveRememberTokenToDatabase($connect, $user_data['id'], $rememberToken);
        } else {
            // حذف ملف تعريف الارتباط المرتبط بتذكر كلمة المرور (إن وجد)
            if (isset($_COOKIE['remember_token'])) {
                setcookie('remember_token', '', time() - 3600, '/');
            }
            // قم بحذف معرف رمز تذكر كلمة المرور من قاعدة البيانات أو أي مكان آخر يناسب تطبيقك
            deleteRememberTokenFromDatabase($connect, $user_data['id']);
        }
        header("Location:profile");
    } else {
        $formerror[] = 'لا يوجد سجل بهذة البيانات';
        $_SESSION['error'] = $formerror;
        header('Location:login');
    }
}

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
                        <form action="" method="post">
                            <div class='row'>
                                <div class='box'>
                                    <div class="input_box">
                                        <label for="name"> البريد الألكتروني او اسم المستخدم </label>
                                        <input id="name" type="text" name="user_name" class='form-control' placeholder="اكتب…">
                                    </div>
                                </div>
                                <div class="input_box">
                                    <label for="password">كلمة المرور</label>
                                    <input id="password2" type="password" name="password" class="password form-control" placeholder="اكتب...">
                                    <span onclick="togglePasswordVisibility('password2', this)" class="fa fa-eye-slash show_eye password_show_icon"></span>
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
                        <form action="" method="post">
                            <div class='row'>
                                <div class='box'>
                                    <div class="input_box">
                                        <label for="user_name"> اسم المستخدم </label>
                                        <input value="<?php if (isset($_SESSION['new_user_name'])) echo $_SESSION['new_user_name']; ?>" required id="user_name" type="text" name="user_name" class='form-control' placeholder="اكتب…" value="<?php if (isset($_REQUEST['user_name'])) echo $_REQUEST['user_name']; ?>">
                                    </div>
                                </div>
                                <div class='box'>
                                    <div class="input_box">
                                        <label for="email"> البريد الألكتروني </label>
                                        <input value="<?php if (isset($_SESSION['new_email'])) echo $_SESSION['new_email']; ?>" required id="email" type="email" name="email" class='form-control' placeholder="اكتب…">
                                    </div>
                                </div>
                                <div class='box'>
                                    <div class="input_box">
                                        <label for="password"> كلمة المرور </label>
                                        <input required id="password" type="password" name="password" class='password form-control' placeholder="اكتب…">
                                        <span onclick="togglePasswordVisibility('password', this)" class="fa fa-eye-slash show_eye password_show_icon"></span>

                                    </div>
                                </div>
                                <div class="box">
                                    <div class="input_box">
                                        <div class="form-check">
                                            <input required class="form-check-input" type="checkbox" value="" name="agree_policy" id="agree_terms" checked>
                                            <label class="form-check-label" for="agree_terms">
                                                أوفق علي <a href="terms" target="_blank" style="color: var(--second-color);"> الشروط والأحكام </a>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="box">
                                    <div class="input_box">
                                        <div class="form-check">
                                            <input class="form-check-input" name="emails_subscribe" type="checkbox" value="" id="subscribe_mail" checked>
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