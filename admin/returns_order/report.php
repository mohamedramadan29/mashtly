<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> طلبات الأرجاع </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> طلبات الأرجاع </li>
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
                                        <th> رقم الطلب </th>
                                        <th> المنتج </th>
                                        <th> سبب الارجاع </th>
                                        <th> التفاصيل </th>
                                        <th> تاريخ طلب الارجاع </th>
                                        <th> الحالة </th>
                                        <th> </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $connect->prepare("SELECT * FROM return_products ORDER BY id DESC");
                                    $stmt->execute();
                                    $allreturn = $stmt->fetchAll();
                                    $i = 0;
                                    foreach ($allreturn as $return) {
                                        $i++;
                                    ?>
                                        <tr>
                                            <td> <?php echo $i; ?> </td>
                                            <td> <?php
                                                    $stmt = $connect->prepare("SELECT * FROM orders WHERE order_number = ?");
                                                    $stmt->execute(array($return['order_number']));
                                                    $order_data = $stmt->fetch();
                                                    ?>
                                                <a href="main.php?dir=orders&page=order_details&order_id=<?php echo $order_data['id']; ?> ">
                                                    <?php echo $return['order_number']; ?>
                                                </a>
                                            </td>
                                            <td>
                                                <?php
                                                $stmt = $connect->prepare("SELECT * FROM products WHERE id = ?");
                                                $stmt->execute(array($return['product_id']));
                                                $product_data = $stmt->fetch();
                                                ?>
                                                <a href="main.php?dir=products&page=edit&pro_id=<?php echo $return["product_id"]; ?>">
                                                    <?php
                                                    echo $product_data['name']; ?>
                                                </a>
                                            </td>
                                            <td> <?php echo  $return['return_reason']; ?> </td>
                                            <td> <?php echo  $return['return_description']; ?> </td>
                                            <td> <?php echo  $return['return_date']; ?> </td>
                                            <td> <?php
                                                    if ($return['status'] == 0) {
                                                    ?>
                                                    <span class="badge badge-danger"> لم يتم </span>
                                                <?php
                                                    } elseif ($return['status'] == 1) {
                                                ?>
                                                    <span class="badge badge-success"> تم الارجاع </span>
                                                <?php
                                                    } else {
                                                ?>
                                                    <span class="badge badge-danger"> ملغية </span>

                                                <?php
                                                    }  ?>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-success btn-sm waves-effect" data-toggle="modal" data-target="#edit-Modal_<?php echo $return['id']; ?>"> تعديل <i class='fa fa-pen'></i> </button>
                                            </td>
                                        </tr>
                                        <!-- EDIT NEW CATEGORY MODAL   -->
                                        <div class="modal fade" id="edit-Modal_<?php echo $return['id']; ?>" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title"> تعديل الطلب </h4>
                                                    </div>
                                                    <form method="post" action="main.php?dir=returns_order&page=edit" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <input type="hidden" name="return_id" value="<?php echo $return['id']; ?>">
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> حالة الطلب </label>
                                                                <select required class='form-control select2' name='status'>
                                                                    <option> -- اختر -- </option>
                                                                    <option <?php if ($return['status'] == 0) echo "selected"; ?> value="0"> تحت التنفيذ </option>
                                                                    <option <?php if ($return['status'] == 1) echo "selected"; ?> value="1"> تم الارجاع</option>

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
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>