<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> طلبات الاستيراد </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <?php if (!isset($_SESSION['admin_username'])) { ?>
                        <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=emp_dashboard">الرئيسية</a></li>
                    <?php
                    } else {
                    ?>
                        <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <?php
                    } ?>

                    <li class="breadcrumb-item active"> طلبات الاستيراد </li>
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
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="my_table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th> # </th>
                                        <th> رقم الطلب </th>
                                        <th> اسم العميل </th>
                                        <th> البريد الالكتروني </th>
                                        <th> رقم الهاتف </th>
                                        <th> تاريخ الطلب </th>
                                        <th> حالة الطلب </th>
                                        <th> </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($_SESSION['admin_username'])) {
                                        $stmt = $connect->prepare("SELECT * FROM import_services ORDER By id DESC");
                                        $stmt->execute();
                                        $allorders = $stmt->fetchAll();
                                        $i = 0;
                                        foreach ($allorders as $order) {
                                            $i++;
                                    ?>
                                            <tr>
                                                <td> <?php echo $i; ?> </td>
                                                <td> <?php echo  $order['id']; ?> </td>
                                                <td> <?php echo  $order['name']; ?> </td>
                                                <td> <?php echo  $order['phone']; ?> </td>
                                                <td> <?php echo  $order['email']; ?> </td>
                                                <td> <?php echo  $order['order_date']; ?> </td>
                                                <td> <span class="badge badge-info">
                                                        <?php
                                                        if ($order['status'] == 0) {
                                                            echo "تحت المراجعه";
                                                        } else {
                                                            echo "تم التنفيذ";
                                                        } ?> </span>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-success btn-sm waves-effect" data-toggle="modal" data-target="#edit-Modal_<?php echo $order['id']; ?>"> تفاصيل الطلب <i class='fa fa-pen'></i> </button>
                                                    <a href="main.php?dir=import_services&page=delete&order_id=<?php echo $order['id']; ?>" class="confirm btn btn-danger btn-sm"> حذف <i class='fa fa-trash'></i> </a>
                                                </td>
                                            </tr>
                                            <!-- EDIT NEW CATEGORY MODAL   -->
                                            <div class="modal fade" id="edit-Modal_<?php echo $order['id']; ?>" tabindex="-1" role="dialog">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title"> تفاصيل الطلب </h4>
                                                        </div>
                                                        <form method="post" action="main.php?dir=import_services&page=edit" enctype="multipart/form-data">
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <input type='hidden' name="order_id" value="<?php echo $order['id']; ?>">
                                                                    <label for="Company-2" class="block">الأسم </label>
                                                                    <input disabled id="Company-2" required name="name" type="text" class="form-control required" value="<?php echo  $order['name'] ?>">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="Company-2" class="block"> رقم الهاتف </label>
                                                                    <input disabled id="Company-2" required name="phone" type="text" class="form-control required" value="<?php echo  $order['phone'] ?>">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="Company-2" class="block"> البريد الألكتروني </label>
                                                                    <input disabled id="Company-2" required name="phone" type="text" class="form-control required" value="<?php echo  $order['email'] ?>">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="Company-2" class="block"> المنتجات </label>
                                                                    <input disabled id="Company-2" required name="phone" type="text" class="form-control required" value="<?php echo  $order['products'] ?>">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="Company-2" class="block"> تاريخ الطلب </label>
                                                                    <input disabled id="Company-2" required name="phone" type="text" class="form-control required" value="<?php echo  $order['order_date'] ?>">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="Company-2" class="block"> حالة الطلب </label>
                                                                    <select name="status" id="" class="form-control select2">
                                                                        <option value=""> حالة الطلب </option>
                                                                        <option <?php if ($order['status'] == 1) echo 'selected'; ?> value="1"> تم التنفيذ </option>
                                                                        <option <?php if ($order['status'] == 0) echo 'selected'; ?> value="0"> تحت المراجعه </option>
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