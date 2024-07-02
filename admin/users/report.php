<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> المستخدمين </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> المستخدمين </li>
                </ol>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content-header -->
<!-- DOM/Jquery table start -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                    </div>
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
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="my_table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th> # </th>
                                        <th> الأسم </th>
                                        <th> البريد الألكتروني </th>
                                        <th> رقم الهاتف </th>
                                        <th> عدد الطلبات </th>
                                        <th> حالة المستخدم </th>
                                        <th> حالة تفعيل الايميل  </th>
                                        <th> العمليات </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $connect->prepare("SELECT * FROM users ORDER BY id DESC");
                                    $stmt->execute();
                                    $allusers = $stmt->fetchAll();
                                    $i = 0;
                                    foreach ($allusers as $user) {
                                        $i++;
                                    ?>
                                        <tr>
                                            <td> <?php echo $i; ?> </td>
                                            <td> <?php echo  $user['name']; ?> </td>
                                            <td> <?php echo  $user['email']; ?> </td>
                                            <td> <?php echo  $user['phone']; ?> </td>
                                            <td> <?php
                                                    $stmt = $connect->prepare("SELECT * FROM orders WHERE user_id = ?");
                                                    $stmt->execute(array($user['id']));
                                                    $count = $stmt->rowCount();
                                                    ?>
                                                <span class="badge badge-warning"> <?php echo $count; ?> </span>
                                            </td>
                                            <td> <?php if ($user['status'] == 1) {
                                                    ?>
                                                    <span class="badge badge-info"> مفعل </span>
                                                <?php
                                                    } else {
                                                ?>
                                                    <span class="badge badge-danger"> غير مفعل </span>
                                                <?php
                                                    } ?>
                                            </td>
                                            <td>
                                            <?php if ($user['active_status'] == 1) {
                                                    ?>
                                                    <span class="badge badge-info"> مفعل </span>
                                                <?php
                                                    } else {
                                                ?>
                                                    <span class="badge badge-danger"> غير مفعل </span>
                                                <?php
                                                    } ?>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-success btn-sm waves-effect" data-toggle="modal" data-target="#edit-Modal_<?php echo $user['id']; ?>"> تعديل الحالة <i class='fa fa-pen'></i> </button>
                                                <button type="button" class="btn btn-primary btn-sm waves-effect" data-toggle="modal" data-target="#edit-data-Modal_<?php echo $user['id']; ?>"> تعديل <i class='fa fa-pen'></i> </button>

                                            </td>
                                        </tr>
                                        <!-- EDIT NEW CATEGORY MODAL   -->
                                        <div class="modal fade" id="edit-Modal_<?php echo $user['id']; ?>" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title"> تعديل حالة المستخدم </h4>
                                                    </div>
                                                    <form method="post" action="main.php?dir=users&page=edit" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <input type='hidden' name="user_id" value="<?php echo $user['id']; ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> حالة المستخدم </label>
                                                                <select required class='form-control select2' name='status'>
                                                                    <option> -- اختر -- </option>
                                                                    <option <?php if($user['status'] == 1) echo 'selected'; ?> value="1"> مفعل </option>
                                                                    <option <?php if($user['status'] == 0) echo 'selected'; ?> value="0"> غير مفعل </option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> حالة تفعيل الايميل  </label>
                                                                <select required class='form-control select2' name='active_status'>
                                                                    <option> -- اختر -- </option>
                                                                    <option <?php if($user['active_status'] == 1) echo 'selected'; ?> value="1"> مفعل </option>
                                                                    <option <?php if($user['active_status'] == 0) echo 'selected'; ?> value="0"> غير مفعل </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" name="edit_cat" class="btn btn-primary waves-effect waves-light "> تعديل </button>
                                                            <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">رجوع</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- EDIT User Data Model  -->
                                        <div class="modal fade" id="edit-data-Modal_<?php echo $user['id']; ?>" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title"> بيانات المستخدم </h4>
                                                    </div>
                                                    <form method="post" action="main.php?dir=users&page=edit_data" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <input type='hidden' name="user_id" value="<?php echo $user['id']; ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> الأسم </label>
                                                                <input disabled id="Company-2" name="name" type="text" class="form-control required" value="<?php echo $user['name'] ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> اسم المستخدم </label>
                                                                <input disabled id="Company-2" name="user_name" type="text" class="form-control required" value="<?php echo $user['user_name'] ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> البريد الالكتروني </label>
                                                                <input id="Company-2" name="email" type="email" class="form-control required" value="<?php echo $user['email'] ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> تعديل كلمة المرور </label>
                                                                <input id="Company-2" name="password" type="text" class="form-control required">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" name="edit_user" class="btn btn-primary waves-effect waves-light "> تعديل </button>
                                                            <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">رجوع</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>