<?php
ob_start();
session_start();
$pagetitle = ' تفعيل الحساب  ';
include 'init.php';
if (isset($_GET['active_code'])) {
    $active_code = $_GET['active_code'];
} else {
    header("Location:../index");
}
?>
<?php
if (isset($_GET['active_code'])) {
    $active_code = $_GET['active_code'];
    $stmt = $connect->prepare("SELECT * FROM users WHERE active_status_code =? ");
    $stmt->execute(array($active_code));
    $count = $stmt->rowCount();
    if ($count > 0) {
        $stmt = $connect->prepare("UPDATE users SET active_status = 1 WHERE active_status_code=?");
        $stmt->execute(array($active_code));
        $_SESSION['success_active_code'] = ' تم تفعيل الحساب بنجاح سجل دخول الان ';
?>
        <div class="section section-md contact_us login_page" style='background-color:#f1f1f1'>
            <div class="container">
                <div class="register_form">
                    <div class="alert alert-success"> تم تفعيل الحساب بنجاح سجل دخول الان </div>
                </div>
            </div>
        </div>
    <?php
        //header("refresh:1;url=login");
        header("Location:login");
    } else {
        $_SESSION['error_active_code'] = ' كود التفعيل الخاص بك خطأ  ';
        header("Location:login");
    ?>
        <div class="alert alert-danger"> كود التفعيل الخاص بك خطأ </div>
<?php
    }
}


?>