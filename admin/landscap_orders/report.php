<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> طلبات التنسيق </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> طلبات التنسيق </li>
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
                                        <th> التنسيق </th>
                                        <th> الأسم </th>
                                        <th> رقم الهاتف </th>
                                        <th> المساحة </th>
                                        <th> المرفق </th>
                                        <th> تاريخ الطلب </th>
                                        <th> حالة الطلب </th>
                                        <th> </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $connect->prepare("SELECT * FROM landscap_request ORDER BY id DESC");
                                    $stmt->execute();
                                    $allcat = $stmt->fetchAll();
                                    $i = 0;
                                    foreach ($allcat as $cat) {
                                        $i++;
                                    ?>
                                        <tr>
                                            <td> <?php echo $i; ?> </td>
                                            <td> <?php
                                                    $stmt = $connect->prepare("SELECT * FROM landscap WHERE id = ?");
                                                    $stmt->execute(array($cat['design_id']));
                                                    $land_data = $stmt->fetch();
                                                    echo $land_data['name']; ?> </td>
                                            <td> <?php echo  $cat['name']; ?> </td>
                                            <td> <?php echo  $cat['phone']; ?> </td>
                                            <td> <?php echo  $cat['area']; ?> </td>
                                            <td> <a target="_blank" href="landscap_orders/attachments/<?php echo  $cat['attachment']; ?>"> شاهد المرفق </a> </td>
                                            <td> <?php echo  $cat['order_date']; ?> </td>
                                            <td> <?php
                                                    if ($cat['status'] == 1) {
                                                    ?>
                                                    <span class="badge badge-info"> تم التنفيذ </span>
                                                <?php
                                                    } else {
                                                ?>
                                                    <span class="badge badge-danger"> تحت المراجعه </span>
                                                <?php
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-success btn-sm waves-effect" data-toggle="modal" data-target="#edit-Modal_<?php echo $cat['id']; ?>"> تعديل الحالة  <i class='fa fa-pen'></i> </button>
                                                <a href="main.php?dir=landscap_orders&page=delete&cat_id=<?php echo $cat['id']; ?>" class="confirm btn btn-danger btn-sm"> حذف <i class='fa fa-trash'></i> </a>
                                            </td>
                                        </tr>
                                        <!-- EDIT NEW CATEGORY MODAL   -->
                                        <div class="modal fade" id="edit-Modal_<?php echo $cat['id']; ?>" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title"> تعديل حالة الطلب  </h4>
                                                    </div>
                                                    <form method="post" action="main.php?dir=landscap_orders&page=edit" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <input type='hidden' name="order_id" value="<?php echo $cat['id']; ?>">
                                                                <label for="Company-2" class="block"> تعديل حالة الطلب  </label>
                                                                <select name="status" class="form-control select2" id="">
                                                                    <option value=""> حالة الطلب  </option>
                                                                    <option <?php if($cat['status'] == 1) echo 'selected'; ?> value="1"> تم التنفيذ </option>
                                                                    <option <?php if($cat['status'] == 0) echo 'selected'; ?> value="0"> تحت المراجعه </option>
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
                                <h4 class="modal-title">أضافة تنسيق </h4>
                            </div>
                            <form action="main.php?dir=landscap&page=add" method="post" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> الأسم </label>
                                        <input required id="Company-2" name="name" type="text" class="form-control required">
                                    </div>

                                    <div class="form-group">
                                        <label for="Company-2" class="block"> الوصف </label>
                                        <textarea id="Company-2" name="description" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="customFile"> صورة التنسيق </label>
                                        <div class="custom-file">
                                            <input type="file" class="dropify" multiple data-height="150" data-allowed-file-extensions="jpg jpeg png svg webp" data-max-file-size="4M" name="main_image" data-show-loader="true" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> اضافة التاج <span class="badge badge-danger"> من فضلك افصل بين كل تاج والاخر (,) </span> </label>
                                        <input required id="Company-2" name="tags" type="text" class="form-control">
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