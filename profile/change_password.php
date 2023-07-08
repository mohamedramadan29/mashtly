<?php
ob_start();
session_start();
$page_title = ' تغيير كلمة المرور  ';
include 'init.php';
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $stmt = $connect->prepare("SELECT * FROM users WHERE id=?");
    $stmt->execute(array($user_id));
    $user_data = $stmt->fetch();
    $old_password = $user_data['password'];
    if (isset($_POST['change_password'])) {
        $formerror = [];
        $form_old_password = $_POST['old_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        if (sha1($form_old_password) !== $old_password) {
            $formerror[] = 'كلمة المرور غير صحيحة ';
        } elseif ($new_password !== $confirm_password) {
            $formerror[] = ' يجب تأكيد كلمة المرور بشكل صحيح  ';
        } elseif (strlen($new_password) < 8) {
            $formerror[] = ' كلمة المرور يجب ان تكون اكثر من 8 احرف وارقام ';
        }
        if (empty($formerror)) {
            $stmt = $connect->prepare("UPDATE users SET password = ? WHERE id = ?");
            $stmt->execute(array(sha1($new_password), $user_id));
            if ($stmt) {
                $_SESSION['success'] = ' تم تغير كلمة المرور بنجاح ';
                header("Location:index");
            }
        } else {
            $_SESSION['error'] = $formerror;
        }
    }
?>
    <div class="profile_page adress_page">

        <div class='container'>
            <div class="data">
                <div class="breadcrump">
                    <p> <a href="../index"> الرئيسية </a> \ <a href="index"> حسابي </a> \ <span> تغيير كلمة المرور </span> </p>
                </div>
                <div class="purches_header">
                    <div class="data_header_name">
                        <h2 class='header2'> تغيير كلمة المرور </h2>
                        <p> قم بتغيير كلمة المرور الخاصة بك </p>
                    </div>
                </div>
            </div>
            <div class="add_new_address add_new_payment">
                <?php
                include "../success_error_msg.php";
                if (isset($_SESSION['error'])) {
                    unset($_SESSION['error']);
                }
                if (isset($_SESSION['success'])) {
                    unset($_SESSION['success']);
                }
                ?>
                <form action="" method="post">
                    <div class='row'>
                        <div class='box'>
                            <div class="input_box">
                                <label for="password1"> كلمة المرور القديمة </label>
                                <input id="password1" type="password" name="old_password" class='password form-control' placeholder=" اكتب ... ">
                                <span onclick="togglePasswordVisibility('password1', this)" class="fa fa-eye-slash show_eye password_show_icon"></span>
                            </div>
                        </div>
                        <div class='box'>
                            <div class="input_box">
                                <label for="password2"> كلمة مرور جديدة </label>
                                <input id="password2" type="password" name="new_password" class='password form-control' placeholder=" اكتب ... ">
                                <span onclick="togglePasswordVisibility('password2', this)" class="fa fa-eye-slash show_eye password_show_icon"></span>
                            </div>
                        </div>
                        <div class='box'>
                            <div class="input_box">
                                <label for="password3"> تأكيد كلمة المرور الجديدة </label>
                                <input id="password3" type="password" name="confirm_password" class='password form-control' placeholder=" اكتب ... ">
                                <span onclick="togglePasswordVisibility('password3', this )" class="fa fa-eye-slash show_eye password_show_icon"></span>
                            </div>
                        </div>
                        <div class="box">
                            <ul class="list-unstyled">
                                <li> <img src="<?php echo $uploads ?>check.svg" alt=""> يجب أن تكون على الأقل 8 أحرف على الأقل.</li>
                                <li> <img src="<?php echo $uploads ?>check.svg" alt=""> يجب أن تحتوي علي مزيج من الأحرف الكبيرة والصغيرة والأرقام والرموز الخاصة. </li>
                                <li> <img src="<?php echo $uploads ?>check.svg" alt=""> يجب تطابق كلمتي المرور </li>
                            </ul>
                        </div>
                        <div class="submit_buttons">
                            <button class="btn global_button" type="reset"> إعادة تعيين </button>
                            <button type="submit" name="change_password" class="btn global_button"> حفظ </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
<?php

} else {
    header("Location:../index");
}
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