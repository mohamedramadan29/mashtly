<?php
if (isset($_POST['edit_info'])) {
    $emp_id = $_SESSION['writer_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $writer_info = $_POST['writer_info'];
    $formerror = [];
    $stmt = $connect->prepare("SELECT * FROM employes WHERE username = ? AND id !=?");
    $stmt->execute(array($username, $emp_id));
    $count = $stmt->rowCount();
    if ($count > 0) {
        $formerror[] = ' اسم المستخدم موجود من قبل من فضلك ادخل اسم اخر  ';
    }

    $stmt = $connect->prepare("SELECT * FROM employes WHERE email = ? AND id !=?");
    $stmt->execute(array($email, $emp_id));
    $count = $stmt->rowCount();
    if ($count > 0) {
        $formerror[] = ' البريد الالكتروني مسجل من قبل ادخل بريد الكتروني جديد ';
    }

    if (empty($formerror)) {
        $stmt = $connect->prepare("UPDATE  employes SET username=? , email=?,writer_info = ? WHERE id = ?");
        $stmt->execute(array(
            $username,
            $email,
            $writer_info,
            $emp_id
        ));
        if (isset($password) && $password != "") {
            $stmt = $connect->prepare("UPDATE employes SET password = ? WHERE id = ?");
            $stmt->execute(array($password, $emp_id));
        }
        if ($stmt) {
            ?>
            <div class="alert alert-success"> تم التعديل بنجاح  </div>
            <?php 
          //  header('Location:main?dir=account&page=index');
        }
    } else {
        foreach ($formerror as $error) {
           
        }
        $_SESSION['error_messages'] = $formerror;
       // header('Location:main?dir=account&page=index');
      //  exit();
    }
}
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> حسابي </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> حسابي </li>
                </ol>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content-header -->
<?php


if (isset($_SESSION['writer_id'])) {
    $stmt  = $connect->prepare('SELECT * FROM employes WHERE id = ?');
    $stmt->execute(array($_SESSION['writer_id']));
    $emp = $stmt->fetch();
}


?>

<!-- DOM/Jquery table start -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <?php
                    if (isset($_SESSION['success_message'])) {
                        echo "edittee";
                        $message = $_SESSION['success_message'];
                        unset($_SESSION['success_message']);
                    ?>
                        <?php
                        ?>
                        <script src="plugins/jquery/jquery.min.js"></script>
                        <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
                        <script>
                            $(function() {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: '<?php echo $message; ?>',
                                    showConfirmButton: false,
                                    timer: 2000
                                })
                            })
                        </script>
                        <?php
                    } elseif (isset($_SESSION['error_messages'])) {
                        $formerror = $_SESSION['error_messages'];
                        foreach ($formerror as $error) {
                        ?>
                            <div class="alert alert-danger alert-dismissible" style="max-width: 800px; margin:20px">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <?php echo $error; ?>
                            </div>
                    <?php
                        }
                        unset($_SESSION['error_messages']);
                    }
                    ?>

                    <div class="card-body">
                        <form action="" method="post" enctype="multipart/form-data" autocomplete="off">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="Company-2" class="block"> اسم المستخدم </label>
                                    <input required id="Company-2" name="username" type="text" class="form-control required" value="<?php echo $emp['username'] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="Company-2" class="block"> البريد الالكتروني </label>
                                    <input required id="Company-2" name="email" type="email" class="form-control required" value="<?php echo $emp['email'] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="Company-2" class="block"> نبذة عني </label>
                                    <textarea required style="height: 70px;" id="Company-2" name="writer_info" class="form-control"><?php echo $emp['writer_info'] ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="Company-2" class="block"> تعديل كلمة المرور </label>
                                    <input id="Company-2" name="password" type="password" class="form-control required">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="edit_info" class="btn btn-primary waves-effect waves-light "> حفظ </button>
                                <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">
                                    رجوع </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>