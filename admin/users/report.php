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

                        <!------------------------------------------------- ///////////////////////////////// -- ------------->

                        <div class="form_new_search" style="box-shadow: 0px 0px 10px 2px #ebebeb;padding: 14px;margin-bottom: 10px; border-radius: 10px;">
                            <span class="badeg badge-info" style="border-radius: 10px;font-size: 15px"> حدد الفترة الزمنية للبحث </span>
                            <br>
                            <br>
                            <form method="post" action="">
                                <div class="d-flex justify-content-around align-items-center">
                                    <div class="form-group">
                                        <label> حدد بداية الفترة </label>
                                        <input style="width: 300px;" class="form-control" required type="date" name="start_date" value="<?php if (isset($_REQUEST['start_date'])) echo $_REQUEST['start_date']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label> حدد نهاية الفترة </label>
                                        <input style="width: 300px" class="form-control" required type="date" name="end_date" value="<?php if (isset($_REQUEST['end_date'])) echo $_REQUEST['end_date']; ?>">
                                    </div>
                                    <div>
                                        <button style="margin-top: 25px;" name="pro_search" class="btn btn-primary btn-sm"> بحث <i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <?php
                        if (isset($_POST['pro_search'])) {
                            $start_date = $_POST['start_date'];
                            $end_date = $_POST['end_date'];

                            $start_date_formatted = date('Y-m-d H:i:s', strtotime($start_date));
                            $end_date_formatted = date('Y-m-d H:i:s', strtotime($end_date));


                            $stmt = $connect->prepare("SELECT * FROM users WHERE STR_TO_DATE(created_at, '%m/%d/%Y %h:%i %p') BETWEEN STR_TO_DATE(?, '%Y-%m-%d %H:%i:%s') AND STR_TO_DATE(?, '%Y-%m-%d %H:%i:%s')");
                            $stmt->execute(array($start_date_formatted, $end_date_formatted));

                            $allusers = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            $count_users = $stmt->rowCount();
                        } else {
                            $stmt = $connect->prepare("SELECT * FROM users ORDER BY id DESC");
                            $stmt->execute();
                            $allusers = $stmt->fetchAll();
                            $count_users = $stmt->rowCount();
                        }
                        ?>
                        <div class="table-responsive">
                            <table id="my_table" class="table table-striped table-bordered">
                                <span class="badge bagde-danger bg-danger"> عدد العملاء :: <?php echo $count_users; ?> </span>
                              <br>
                                <thead>
                                    <tr>
                                        <th> # </th>
                                        <th> الأسم </th>
                                        <th> البريد الألكتروني </th>
                                        <th> رقم الهاتف </th>
                                        <th> عدد الطلبات </th>
                                        <th> حالة المستخدم </th>
                                        <th> حالة تفعيل الايميل </th>
                                        <th> تاريخ التسجيل </th>
                                        <?php
                                            if (isset($_SESSION['admin_username'])) {
                                            ?>
                                        <th> العمليات </th>
                                        <?php 
                                            }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

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
                                            <td> <?php echo  $user['created_at']; ?> </td>
                                            <?php
                                            if (isset($_SESSION['admin_username'])) {
                                            ?>
                                            <td>
                                                <button type="button" class="btn btn-success btn-sm waves-effect" data-toggle="modal" data-target="#edit-Modal_<?php echo $user['id']; ?>"> تعديل الحالة <i class='fa fa-pen'></i> </button>
                                                <button type="button" class="btn btn-primary btn-sm waves-effect" data-toggle="modal" data-target="#edit-data-Modal_<?php echo $user['id']; ?>"> تعديل <i class='fa fa-pen'></i> </button>

                                            </td>
                                            <?php 
                                            }
                                            ?>
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
                                                                    <option <?php if ($user['status'] == 1) echo 'selected'; ?> value="1"> مفعل </option>
                                                                    <option <?php if ($user['status'] == 0) echo 'selected'; ?> value="0"> غير مفعل </option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> حالة تفعيل الايميل </label>
                                                                <select required class='form-control select2' name='active_status'>
                                                                    <option> -- اختر -- </option>
                                                                    <option <?php if ($user['active_status'] == 1) echo 'selected'; ?> value="1"> مفعل </option>
                                                                    <option <?php if ($user['active_status'] == 0) echo 'selected'; ?> value="0"> غير مفعل </option>
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