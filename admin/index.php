<?php
$pagetitle = 'مشتلي - تسجيل دخول ';
ob_start();
session_start();
$Nonavbar = '';
include 'connect.php';
if (isset($_POST['login']) == 'POST' && $_POST['permision'] == 'admin') {
  $username = $_POST['username'];
  $password = sha1($_POST['password']);
  $stmt = $connect->prepare(
    'SELECT * FROM admins WHERE username=? AND password=?'
  );
  $stmt->execute([$username, $password]);
  $data = $stmt->fetch();
  $count = $stmt->rowCount();
  if ($count > 0) {
    $_SESSION['admin_username'] = $data['username'];
    $_SESSION['admin_id'] = $data['id'];
    header('Location:main.php?dir=dashboard&page=dashboard');
    exit();
  }
} elseif (isset($_POST['login']) == 'POST' && $_POST['permision'] == 'emp') {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $stmt = $connect->prepare(
    'SELECT * FROM employes WHERE username=? AND password=?'
  );
  $stmt->execute([$username, $password]);
  $data = $stmt->fetch();
  $count = $stmt->rowCount();
  if ($count > 0) {
    $_SESSION['username'] = $data['username'];
    $_SESSION['id'] = $data['id'];
    header('Location:main.php?dir=dashboard&page=emp_dashboard');
    exit();
  }
} elseif (isset($_POST['login']) == 'POST' && $_POST['permision'] == 'mostlzamat') {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $stmt = $connect->prepare(
    'SELECT * FROM employes WHERE username=? AND password=?'
  );
  $stmt->execute([$username, $password]);
  $data = $stmt->fetch();
  $count = $stmt->rowCount();
  if ($count > 0) {
    //echo "Goood";
    $_SESSION['mos_username'] = $data['username'];
    $_SESSION['id'] = $data['id'];
    header('Location:main.php?dir=dashboard&page=mostlzamat');
    exit();
  }
} elseif (isset($_POST['login']) == 'POST' && $_POST['permision'] == 'marketer') {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $stmt = $connect->prepare(
    'SELECT * FROM employes WHERE username=? AND password=?'
  );
  $stmt->execute([$username, $password]);
  $data = $stmt->fetch();
  $count = $stmt->rowCount();
  if ($count > 0) {
    //echo "Goood";
    $_SESSION['marketer'] = $data['username'];
    $_SESSION['id'] = $data['id'];
    header('Location:main.php?dir=dashboard&page=marketer-dashboard');
    exit();
  }
} elseif (isset($_POST['login']) == 'POST' && $_POST['permision'] == 'writer') {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $stmt = $connect->prepare(
    'SELECT * FROM employes WHERE username=? AND password=?'
  );
  $stmt->execute([$username, $password]);
  $data = $stmt->fetch();
  $count = $stmt->rowCount();
  if ($count > 0) {
    //echo "Goood";
    $_SESSION['writer'] = $data['username'];
    $_SESSION['writer_id'] = $data['id'];
    header('Location:main.php?dir=dashboard&page=writer-dashboard');
    exit();
  }
}
?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="login_form/fonts/icomoon/style.css">

  <link rel="stylesheet" href="login_form/css/owl.carousel.min.css">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="login_form/css/bootstrap.min.css">

  <!-- Style -->
  <link rel="stylesheet" href="login_form/css/style.css">

  <title> مشتلي - تسجيل دخول </title>
</head>

<body>
  <div class="d-md-flex half text-right">
    <div class="bg" style="background-image: url('uploads/header1.jpg');"></div>
    <div class="contents">
      <div class="container">
        <div class="row align-items-center justify-content-center">
          <div class="col-md-12">
            <div class="form-block mx-auto">
              <div class="text-center mb-5">
                <h3 class="text-uppercase"> تسجيل دخول <strong> </strong></h3>
              </div>
              <form action="" method="POST">
                <div class="form-group first">
                  <label for="username"> اسم المستخدم </label>
                  <input name="username" type="text" class="form-control" placeholder=" اسم المستخدم  " id="username">
                </div>
                <div class="form-group last mb-3">
                  <label for="password">كلمة المرور</label>
                  <input name="password" type="password" class="form-control" placeholder=" كلمة المرور " id="password">
                </div>
                <div class="form-group last mb-3">
                  <label for="password"> اختر الصلاحية </label>
                  <select name="permision" id="" class="form-control custome_select">
                    <option value=""> -- اختر الصلاحية -- </option>
                    <option value="admin"> الأدمن </option>
                    <option value="emp"> موظف </option>
                    <option value="marketer"> مسوق </option>
                    <option value="mostlzamat"> خاص بالمستلزمات </option>
                    <option value="writer">كاتب</option>
                  </select>
                </div>
                <div class="d-sm-flex mb-5 align-items-center">
                  <span class="ml-auto"><a href="#" class="forgot-pass"> نسيت كلمة المرور
                    </a></span>
                </div>
                <input style="background-color: #2ecc71; border-color:#2ecc71" name="login" type="submit" value=" تسجيل دخول " class="btn btn-block py-2 btn-primary">
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="login_form/js/jquery-3.3.1.min.js"></script>
  <script src="login_form/js/popper.min.js"></script>
  <script src="login_form/js/bootstrap.min.js"></script>
  <script src="login_form/js/main.js"></script>
</body>

</html>