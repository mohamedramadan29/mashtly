<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> الموظفين </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> الموظفين </li>
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
                        <button type="button" class="btn btn-primary waves-effect btn-sm" data-toggle="modal" data-target="#add-Modal"> أضافة موظف جديد <i class="fa fa-plus"></i> </button>
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
                                        <th>اسم المستخدم </th>
                                        <th> البريد الألكتروني </th>
                                        <th> رقم الهاتف </th>
                                        <th> صلاحية الموظف </th>
                                        <th> </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $connect->prepare("SELECT * FROM employes");
                                    $stmt->execute();
                                    $allemp = $stmt->fetchAll();
                                    $i = 0;
                                    foreach ($allemp as $emp) {
                                        $i++;
                                    ?>
                                        <tr>
                                            <td> <?php echo $i; ?> </td>
                                            <td> <?php echo  $emp['username']; ?> </td>
                                            <td> <?php echo  $emp['email']; ?> </td>
                                            <td> <?php echo  $emp['phone']; ?> </td>
                                            <td> <span class="badge badge-warning"> <?php echo  $emp['role_name']; ?> </span> </td>
                                            <td>
                                                <button type="button" class="btn btn-success btn-sm waves-effect" data-toggle="modal" data-target="#edit-Modal_<?php echo $emp['id']; ?>"> تعديل صلاحية <i class='fa fa-pen'></i> </button>
                                                <a href="main.php?dir=employee&page=delete&emp_id=<?php echo $emp['id']; ?>" class="confirm btn btn-danger btn-sm"> حذف <i class='fa fa-trash'></i> </a>
                                            </td>
                                        </tr>
                                        <!-- EDIT NEW CATEGORY MODAL   -->
                                        <div class="modal fade" id="edit-Modal_<?php echo $emp['id']; ?>" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title"> تعديل صلاحية الموظف </h4>
                                                    </div>
                                                    <form method="post" action="main.php?dir=employee&page=edit">
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <input type="hidden" name="emp_id" value="<?php echo $emp['id']; ?>">
                                                                <label for="Company-2" class="block"> صلاحية الموظف </label>
                                                                <select required class='form-control select2' name='role_name'>
                                                                    <option value="0"> -- اختر -- </option>
                                                                    <option <?php if ($emp['role_name'] == 'التواصل') echo "selected"; ?> value="التواصل"> التواصل </option>
                                                                    <option <?php if ($emp['role_name'] == 'التجهيز') echo "selected"; ?> value="التجهيز"> التجهيز </option>
                                                                    <option <?php if ($emp['role_name'] == 'التوصيل') echo "selected"; ?> value="التوصيل"> التوصيل </option>
                                                                    <option <?php if ($emp['role_name'] == 'الجودة') echo "selected"; ?> value="الجودة"> الجودة </option>
                                                                    <option <?php if ($emp['role_name'] == 'المحاسبة') echo "selected"; ?> value="المحاسبة"> المحاسبة </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" name="edit_emp" class="btn btn-primary waves-effect waves-light "> حفظ </button>
                                                            <button type="button" class="btn btn-default waves-effect " data-dismiss="modal"> رجوع </button>
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
                <!-- ADD NEW CATEGORY MODAL   -->
                <div class="modal fade" id="add-Modal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">أضافة موظف </h4>
                            </div>
                            <form action="main.php?dir=employee&page=add" method="post" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> اسم المستخدم </label>
                                        <input required id="Company-2" name="user_name" type="text" class="form-control required">
                                    </div>

                                    <div class="form-group">
                                        <label for="Company-2" class="block"> البريد الألكتروني </label>
                                        <input required id="Company-2" name="email" type="email" class="form-control required">
                                    </div>

                                    <div class="form-group">
                                        <label for="Company-2" class="block">  كلمة المرور </label>
                                        <input required id="Company-2" name="password" type="text" class="form-control required">
                                    </div>


                                    <div class="form-group">
                                        <label for="Company-2" class="block"> صلاحية الموظف </label>
                                        <select required class='form-control select2' name='role_name'>
                                            <option value="0"> -- اختر -- </option>
                                            <option value="التواصل"> التواصل </option>
                                            <option value="التجهيز"> التجهيز </option>
                                            <option value="التوصيل"> التوصيل </option>
                                            <option value="الجودة"> الجودة </option>
                                            <option value="المحاسبة"> المحاسبة </option>
                                            <option value="كاتب"> كاتب </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="add_emp" class="btn btn-primary waves-effect waves-light "> حفظ </button>
                                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal"> رجوع </button>
                                </div>
                            </form>
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