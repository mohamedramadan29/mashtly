<!--   -->
<?php
session_start();
$main_user_name = "mashtly";
$main_password = "123123";
if (isset($_POST['login_new'])) {
    $user_name = $_POST['username'];
    $password = $_POST['password'];
    if ($user_name  == $main_user_name && $password == $main_password) {
        $_SESSION['main_user_login'] = $main_user_name;
    } else {
        header("Location:new_login");
    }
}
?>
<div class="form">
    <form action="#" method="post">
        <input type="text" name="username" placeholder="اسم المستخدم" class="form-control">
        <input type="password" name="password" placeholder="كلمة المرور" class="form-control">
        <input name="login_new" type="submit" value="دخول" class="btn btn-primary">
    </form>
</div>