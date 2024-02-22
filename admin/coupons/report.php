<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> كوبونات الخصم </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> الكوبونات </li>
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
                        <button type="button" class="btn btn-primary waves-effect btn-sm" data-toggle="modal" data-target="#add-Modal"> أضافة كوبون <i class="fa fa-plus"></i> </button>
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
                                        <th> الكود </th>
                                        <th> قيمة الخصم </th>
                                        <th> تاريخ البداية </th>
                                        <th> تاريخ النهاية </th>
                                       
                                        <th> </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $connect->prepare("SELECT * FROM coupons ORDER BY id DESC");
                                    $stmt->execute();
                                    $allcoupon = $stmt->fetchAll();
                                    $i = 0;
                                    foreach ($allcoupon as $coupon) {
                                        $i++;
                                    ?>
                                        <tr>
                                            <td> <?php echo $i; ?> </td>
                                            <td> <?php echo  $coupon['name']; ?> </td>
                                            <td> <?php echo  $coupon['coupon_value']; ?> </td>
                                            <td> <?php echo  $coupon['start_date']; ?> </td>
                                            <td> <?php echo  $coupon['end_date']; ?> </td>
                                            <!-- <td> <?php echo  $coupon['available_number']; ?> </td>  -->
                                            <td>
                                                <button type="button" class="btn btn-success btn-sm waves-effect" data-toggle="modal" data-target="#edit-Modal_<?php echo $coupon['id']; ?>"> تعديل <i class='fa fa-pen'></i> </button>
                                                <a href="main.php?dir=coupons&page=delete&coupon_id=<?php echo $coupon['id']; ?>" class="confirm btn btn-danger btn-sm"> حذف <i class='fa fa-trash'></i> </a>
                                            </td>
                                        </tr>
                                        <!-- EDIT NEW CATEGORY MODAL   -->
                                        <div class="modal fade" id="edit-Modal_<?php echo $coupon['id']; ?>" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title"> تعديل الكوبون </h4>
                                                    </div>
                                                    <form method="post" action="main.php?dir=coupons&page=edit" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <input type='hidden' name="coupon_id" value="<?php echo $coupon['id']; ?>">
                                                                <label for="Company-2" class="block"> الكود </label>
                                                                <input id="Company-2" required name="name" type="text" class="form-control required" value="<?php echo  $coupon['name'] ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> قيمة الكوبون </label> <span class="badge badge-danger"> % </span>
                                                                <input required id="Company-2" name="coupon_value" type="number" class="form-control required" value="<?php echo $coupon['coupon_value'] ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> تاريخ البداية </label>
                                                                <input id="Company-2" name="start_date" type="date" class="form-control required"  value="<?php echo $coupon['start_date'] ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> تاريخ النهاية </label>
                                                                <input id="Company-2" name="end_date" type="date" class="form-control required"  value="<?php echo $coupon['end_date'] ?>">
                                                            </div>
                                                            <!-- <div class="form-group">
                                                                <label for="Company-2" class="block"> عدد المرات </label>
                                                                <input id="Company-2" name="available_number" type="number" class="form-control required"  value="<?php echo $coupon['available_number'] ?>">
                                                            </div> -->
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
                                <h4 class="modal-title">أضافة كوبون </h4>
                            </div>
                            <form action="main.php?dir=coupons&page=add" method="post" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> الكود </label>
                                        <input required id="Company-2" name="name" type="text" class="form-control required">
                                    </div>
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> قيمة الكوبون </label> <span class="badge badge-danger"> % </span>
                                        <input required id="Company-2" name="coupon_value" type="number" class="form-control required">
                                    </div>
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> تاريخ البداية </label>
                                        <input id="Company-2" name="start_date" type="date" class="form-control required">
                                    </div>
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> تاريخ النهاية </label>
                                        <input id="Company-2" name="end_date" type="date" class="form-control required">
                                    </div>
                                    <!-- <div class="form-group">
                                        <label for="Company-2" class="block"> عدد المرات </label>
                                        <input id="Company-2" name="available_number" type="number" class="form-control required">
                                    </div> -->
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