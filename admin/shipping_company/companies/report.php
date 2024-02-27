<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> شركات الشحن </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> شركات الشحن </li>
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
                        <button type="button" class="btn btn-primary waves-effect btn-sm" data-toggle="modal" data-target="#add-Modal"> اضافة شركة شحن <i class="fa fa-plus"></i> </button>
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
                                        <th> اسم الشركة </th>
                                        <th> العنوان </th>
                                        <th> الهاتف </th>
                                        <th> اعتماد الشركه </th>
                                        <th> الحالة </th>
                                        <th> العمليات </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $connect->prepare("SELECT * FROM new_shipping_company ORDER BY id DESC");
                                    $stmt->execute();
                                    $allshpping_company = $stmt->fetchAll();
                                    $i = 0;
                                    foreach ($allshpping_company as $area) {
                                        $i++;
                                    ?>
                                        <tr>
                                            <td> <?php echo $i; ?> </td>
                                            <td>
                                                <?php echo $area['name']; ?>
                                            </td>
                                            <td>
                                                <?php echo $area['address']; ?>
                                            </td>
                                            <td>
                                                <?php echo $area['phone']; ?>
                                            </td>
                                            <td>
                                                <span class="badge badge-danger">
                                                    <?php echo $area['company_type']; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php if ($area['status'] == 1) {
                                                ?>
                                                    <span class="badge badge-success"> فعالة </span>
                                                <?php
                                                } else {
                                                ?>
                                                    <span class="badge badge-warning"> غير فعالة </span>
                                                <?php
                                                } ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($area['company_type'] == 'نطاقات') {
                                                ?>
                                                    <a href="main.php?dir=shipping_company/trips&page=report&company_id=<?php echo $area['id']; ?>" class="btn btn-warning btn-sm"> نطاقات الشركه </a>
                                                <?php
                                                } elseif ($area['company_type'] == 'مناطق') {
                                                ?>
                                                    <a href="main.php?dir=shipping_company/areas&page=report&company_id=<?php echo $area['id']; ?>" class="btn btn-primary btn-sm"> مناطق الشركه </a>
                                                <?php
                                                }
                                                ?>
                                                <button type="button" class="btn btn-success btn-sm waves-effect" data-toggle="modal" data-target="#edit-Modal_<?php echo $area['id']; ?>"> <i class='fa fa-pen'></i> </button>
                                                <a href="main.php?dir=shipping_company/companies&page=delete&area_id=<?php echo $area['id']; ?>" class="confirm btn btn-danger btn-sm"> <i class='fa fa-trash'></i> </a>
                                            </td>
                                        </tr>
                                        <!-- EDIT NEW CATEGORY MODAL   -->
                                        <div class="modal fade" id="edit-Modal_<?php echo $area['id']; ?>" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title"> تعديل شركة الشحن </h4>
                                                    </div>
                                                    <form action="main.php?dir=shipping_company/companies&page=edit" method="post" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <input type='hidden' name="company_id" value="<?php echo $area['id']; ?>">
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> اسم الشركة </label>
                                                                <input required id="Company-2" name="company_name" type="text" class="form-control required" value="<?php echo $area['name']; ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> العنوان </label>
                                                                <input required id="Company-2" name="address" type="text" class="form-control required" value="<?php echo $area['address']; ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> البريد الألكتروني </label>
                                                                <input required id="Company-2" name="email" type="email" class="form-control required" value="<?php echo $area['email']; ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> رقم الهاتف </label>
                                                                <input required id="Company-2" name="phone" type="text" class="form-control required" value="<?php echo $area['phone']; ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> حدد الشركه تعتمد علي مناطق / نطاقات </label>
                                                                <select required name="company_type" class="select2 form-control" id="">
                                                                    <option value=""> -- حدد اعتماد الشركه -- </option>
                                                                    <option <?php if ($area['company_type'] == 'مناطق') echo "selected"; ?> value="مناطق"> مناطق </option>
                                                                    <option <?php if ($area['company_type'] == 'نطاقات') echo 'selected'; ?> value="نطاقات"> نطاقات </option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> الحالة </label>
                                                                <select required name="status" class="select2 form-control" id="">
                                                                    <option value=""> -- حدد الحالة -- </option>
                                                                    <option <?php if ($area['status'] == 1) echo 'selected'; ?> value="1"> فعاله </option>
                                                                    <option <?php if ($area['status'] == 0) echo 'selected'; ?> value="0"> غير فعاله </option>
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
                                <h4 class="modal-title"> اضافة شركة شحن </h4>
                            </div>
                            <form action="main.php?dir=shipping_company/companies&page=add" method="post" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> اسم الشركة </label>
                                        <input required id="Company-2" name="company_name" type="text" class="form-control required">
                                    </div>
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> العنوان </label>
                                        <input required id="Company-2" name="address" type="text" class="form-control required">
                                    </div>
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> البريد الألكتروني </label>
                                        <input required id="Company-2" name="email" type="email" class="form-control required">
                                    </div>
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> رقم الهاتف </label>
                                        <input required id="Company-2" name="phone" type="text" class="form-control required">
                                    </div>
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> حدد الشركه تعتمد علي مناطق / نطاقات </label>
                                        <select required name="company_type" class="select2 form-control" id="">
                                            <option value=""> -- حدد اعتماد الشركه -- </option>
                                            <option value="مناطق"> مناطق </option>
                                            <option value="نطاقات"> نطاقات </option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> الحالة </label>
                                        <select required name="status" class="select2 form-control" id="">
                                            <option value=""> -- حدد الحالة -- </option>
                                            <option value="1"> فعاله </option>
                                            <option value="0"> غير فعاله </option>
                                        </select>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="add_cat" class="btn btn-primary waves-effect waves-light "> حفظ </button>
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