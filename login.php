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
            <?php
            /////////////////////////////////////////// login to account /////////////////////////////////
            if (isset($_POST['login'])) {
                $formerror = [];
                $username = sanitizeInput($_POST['user_name']);
                $password = sanitizeInput($_POST['password']);
                $rememberMe = isset($_POST['remember_me']);
                $stmt = $connect->prepare("SELECT * FROM users WHERE (user_name=? OR email = ?) AND password=?");
                $stmt->execute(array($username, $username, sha1($password)));
                $user_data = $stmt->fetch();
                $count = $stmt->rowCount();
                if ($count > 0) {
                    $_SESSION['user_name'] = $user_data['user_name'];
                    $_SESSION['user_id']  = $user_data['id'];
                    // إذا تم تحديد خانة "تذكرني"، قم بضبط الكوكيز
                    if (isset($_POST['remember_me'])) {
                        setcookie('email', $username, time() + (86400 * 30));
                        setcookie('pass', $password, time() + (86400 * 30));
                    }
                    header("Location:profile");
                } else {
                    $formerror[] = 'لا يوجد سجل بهذة البيانات';

                    foreach ($formerror as $error) {
            ?>
                        <div style="max-width: 400px; text-align:center;margin:auto;margin-top:15px;" class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo $error; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
            <?php
                    }
                }
            }

            ?>
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
                                        <input id="name" type="text" name="user_name" class='form-control' placeholder="اكتب…" value="<?php if (isset($_COOKIE['email'])) {
                                                                                                                                            echo $_COOKIE['email'];
                                                                                                                                        } ?>">
                                    </div>
                                </div>
                                <div class="input_box">
                                    <label for="password">كلمة المرور</label>
                                    <input id="password2" type="password" name="password" class="password form-control" placeholder="اكتب..." value="<?php if (isset($_COOKIE['pass'])) {
                                                                                                                                                            echo $_COOKIE['pass'];
                                                                                                                                                        } ?>">
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
                                <p> أنشئ حسابك مجاناً واحصل علي أفضل النباتات </p>
                                <?php
                                if (isset($_POST['new_account'])) {
                                    $formerror = [];
                                    $username = sanitizeInput($_POST['user_name']);
                                    $password = sanitizeInput($_POST['password']);
                                    $sha_password = sha1($_POST['password']);
                                    $email = sanitizeInput($_POST['email']);
                                    $agree_policy = isset($_POST['agree_policy']);
                                    $emails_subscribe = isset($_POST['emails_subscribe']);
                                    if ($emails_subscribe) {
                                        $emails_subscribe = 1;
                                    } else {
                                        $emails_subscribe = 0;
                                    }
                                    if (strlen($password) < 8 || !preg_match('/^[a-zA-Z0-9!@#$%^&*()_+]+$/', $password) || !preg_match('/\d/', $password)) {
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
                                    } elseif (!preg_match('/^[a-zA-Z0-9.@]+$/', $email)) {
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
                                ?>
                                            <div style="max-width: 500px; text-align:center;margin:auto;margin-top:15px;" class="alert alert-success alert-dismissible fade show" role="alert">
                                                تم تسجيل حسابك بنجاح من فضلك سجل دخولك الأن
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        <?php

                                        }
                                    } else {
                                        ?>
                                        <br><br>
                                        <?php
                                        foreach ($formerror as $error) {
                                        ?>
                                            <div style="max-width: 500px; text-align:center;margin:auto;margin-top:15px;" class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <?php echo $error; ?>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                <?php
                                        }
                                    }
                                } ?>
                            </div>
                        </div>
                        <form action="" method="post">
                            <div class='row'>
                                <div class='box'>
                                    <div class="input_box">
                                        <label for="user_name"> اسم المستخدم </label>
                                        <input required id="user_name" type="text" name="user_name" class='form-control' placeholder="اكتب…" value="<?php if (isset($_REQUEST['user_name'])) echo $_REQUEST['user_name']; ?>">
                                    </div>
                                </div>
                                <div class='box'>
                                    <div class="input_box">
                                        <label for="email"> البريد الألكتروني </label>
                                        <input value="<?php if (isset($_REQUEST['email'])) echo $_REQUEST['email']; ?>" required id="email" type="email" name="email" class='form-control' placeholder="اكتب…">
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
                                                أوافق علي <a href="terms" target="_blank" style="color: var(--second-color);"> الشروط والأحكام </a>
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

<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>