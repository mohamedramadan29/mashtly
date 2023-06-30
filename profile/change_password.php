<?php
ob_start();
session_start();
$page_title = ' تغيير كلمة المرور  ';
include 'init.php';
if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
    $stmt = $connect->prepare("SELECT * FROM users WHERE id=?");
    $stmt->execute(array($user_id));
    $user_data = $stmt->fetch();
    $old_password = $user_data['password'];
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
            <form action="" method="post">
                <div class='row'>
                    <div class='box'>
                        <div class="input_box">
                            <label for="old_password"> كلمة المرور القديمة </label>
                            <input id="old_password" type="password" name="old_password" class='form-control' placeholder=" اكتب ... ">
                            <span class="fa fa-eye show_eye"></span>
                        </div>
                    </div>
                    <div class='box'>
                        <div class="input_box">
                            <label for="old_password"> كلمة مرور جديدة </label>
                            <input id="old_password" type="password" name="old_password" class='form-control' placeholder=" اكتب ... ">
                            <span class="fa fa-eye show_eye"></span>
                        </div>
                    </div>
                    <div class='box'>
                        <div class="input_box">
                            <label for="old_password"> تأكيد كلمة المرور الجديدة </label>
                            <input id="old_password" type="password" name="old_password" class='form-control' placeholder=" اكتب ... ">
                            <span class="fa fa-eye show_eye"></span>
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

}else{
    header("Location:../index");
}
include $tem . 'footer.php';
ob_end_flush();
?>