<?php
ob_start();
session_start();
$page_title = ' تعديل بياناتي ';
include 'init.php';
if (isset($_SESSION['user_id'])) {
    $formerror = [];
    $user_id = $_SESSION['user_id'];
    // check all users 
    $stmt = $connect->prepare("SELECT * FROM users WHERE id != ?");
    $stmt->execute(array($user_id));
    $allusers = $stmt->fetchAll();
    ///////////////////
    $stmt = $connect->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute(array($user_id));
    $user_data = $stmt->fetch();
    $name = $user_data['name'];
    $user_name = $user_data['user_name'];
    $email = $user_data['email'];
    $phone = $user_data['phone'];
    if (isset($_POST['edit_data'])) {
        $user_name = sanitizeInput($_POST['user_name']);
        $name = sanitizeInput($_POST['name']);
        $email = sanitizeInput($_POST['email']);
        $phone = sanitizeInput($_POST['phone']);
        // foreach ($allusers as $user) {
        //     if ($user['user_name'] == $user_name) {
        //         $formerror[] = 'اسم المستخدم موجود بالفعل من فضلك ادخل اسم مستخدم جديد';
        //     } elseif ($user['email']) {
        //         $formerror[] = 'البريد الألكتروني مستخدم بالفعل';
        //     }
        // }
        $stmt = $connect->prepare("SELECT * FROM users WHERE email=? AND  id != ?");
        $stmt->execute(array($email,$user_id));
        $check_mail_count = $stmt->rowCount();
        if($check_mail_count > 0){
            $formerror[] = 'البريد الالكتروني مستخدم بالفعل ';
        } 
        $stmt = $connect->prepare("SELECT * FROM users WHERE user_name =? AND  id != ?");
        $stmt->execute(array($user_name,$user_id));
        $check_mail_count = $stmt->rowCount();
        if($check_mail_count > 0){
            $formerror[] = ' اسم المستخدم متواجد بالفعل  ';
        } 

        $stmt = $connect->prepare("SELECT * FROM users WHERE phone =? AND  id != ?");
        $stmt->execute(array($phone,$user_id));
        $check_mail_count = $stmt->rowCount();
        if($check_mail_count > 0){
            $formerror[] = ' رقم الهاتف متواجد بالفعل ';
        } 
        if (empty($user_name) || empty($name) || empty($email) || empty($phone)) {
            $formerror[] = 'من فضلك ادخل المعلومات كاملة ';
        }
        if (empty($formerror)) {
            $stmt  = $connect->prepare("UPDATE users SET name=?, user_name = ? , email=?,phone=? WHERE id = ? ");
            $stmt->execute(array($name, $user_name, $email, $phone, $user_id));
            if ($stmt) {?>
            <div class="alert alert-danger"> تم اعاده تعين كلمه المرور بنجاح  </div>
            <?php  
            }
        } else {
            $_SESSION['error'] = $formerror;
        }
    }
?>
    <div class="profile_page new_address_page">
        <div class='container'>
            <div class="data">
                <div class="breadcrump">
                    <p> <a href="../index"> الرئيسية </a> \ <a href="index"> حسابي </a> \
                        <span> تعديل بياناتي </span>
                    </p>
                </div>
                <div class="purches_header">
                    <div class="data_header_name">
                        <h2 class='header2'> تعديل بياناتي </h2>
                        <p> تعديل البيانات الشخصية </p>
                    </div>
                </div>
                <div class="add_new_address">
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
                                    <label for="name"> الأسم </label>
                                    <input id="name" type="text" name="name" class='form-control' placeholder="اكتب…" value="<?php echo $name ?>">
                                </div>
                                <div class="input_box">
                                    <label for="user_name"> اسم المستخدم </label>
                                    <input id="user_name" type="text" name="user_name" class='form-control' placeholder="اكتب…" value="<?php echo $user_name ?>">
                                </div>
                            </div>
                            <div class="box">
                                <div class="input_box">
                                    <label for="email"> البريد الألكتروني </label>
                                    <input id="email" type="email" name="email" class='form-control' placeholder="mashtly@gmail.com" value="<?php echo $email ?>">
                                </div>
                                <div class="input_box">
                                    <label for="phone"> رقم الجوال </label>
                                    <input id="phone" type="text" name="phone" class='form-control' placeholder="اكتب…" value="<?php echo $phone ?>">
                                </div>
                            </div>
                            <div class="input_box">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                    <label class="form-check-label" for="flexCheckChecked">
                                        اشترك في القائمة البريدية لتصلك آخر العروض والخصومات
                                    </label>
                                </div>
                            </div>
                            <div class="submit_buttons">
                                <button class="btn global_button" type="reset"> إعادة تعيين </button>
                                <button class="btn global_button" type="submit" name="edit_data"> تعديل البيانات </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
<?php
} else {
    header("location:../index");
}
include $tem . 'footer.php';
ob_end_flush();
?>


<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>