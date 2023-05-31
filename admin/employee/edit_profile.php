<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> تحديث البيانات </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> تحديث البيانات </li>
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
if (isset($_POST['save_data'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $passwword = $_POST['password'];
    $stmt = $connect->prepare("SELECT * FROM employes WHERE email = ? AND id != ?");
    $stmt->execute(array($email, $_SESSION['id']));
    $count = $stmt->rowCount();
    $formerror = [];
    if ($count > 0) {
        $formerror[] = 'البريد الالكتروني مستخدم بالفعل من فضلك ادخل بريد الكتروني اخر ';
    }
    if (empty($email)) {
        $formerror[] = 'من فضلك ادخل البريد الالكتروني ';
    }
    if (empty($formerror)) {
        $stmt = $connect->prepare("UPDATE employes SET username=?, email=?, phone=?,address = ? , password = ? WHERE id = ?");
        $stmt->execute(array($username, $email, $phone, $address, $passwword, $_SESSION['id']));
        if ($stmt) {
            $_SESSION['success_message'] = "   تم تعديل البيانات  بنجاح  ";
          //  header('Location:main?dir=employee&page=edit_profile');
        } else {
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=employee&page=edit_profile');
        exit();
    }
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
                    <?php
                    $stmt = $connect->prepare("SELECT * FROM employes WHERE id = ?");
                    $stmt->execute(array($_SESSION['id']));
                    $employee_data = $stmt->fetch();

                    ?>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="inputName"> اسم المستخدم </label>
                                <input type="text" id="username" name="username" class="form-control" value="<?php echo $employee_data['username'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="inputName"> البريد الألكتروني </label>
                                <input type="text" id="email" name="email" class="form-control" value="<?php echo $employee_data['email'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="inputName"> رقم الهاتف </label>
                                <input type="text" id="phone" name="phone" class="form-control" value="<?php echo $employee_data['phone'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="inputName"> العنوان </label>
                                <input type="text" id="address" name="address" class="form-control" value="<?php echo $employee_data['address'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="inputName"> كلمة المرور </label>
                                <input type="text" id="password" name="password" class="form-control" value="<?php echo $employee_data['password'] ?>">
                            </div>
                            <div class="form-group">
                                <button type="submit" name="save_data" class="btn btn-primary"> تديث البيانات <i class="fa fa-save"></i> </button>
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