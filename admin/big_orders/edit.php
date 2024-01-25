<?php

$order_id = $_GET['order_id'];
if (isset($_POST['edit_pro'])) {
    $formerror = [];
    $status = $_POST['status'];
    if (empty($formerror)) {
        $stmt = $connect->prepare("UPDATE big_orders SET status = ? WHERE id = ?");
        $stmt->execute(array($status, $order_id));
        if ($stmt) {
            $_SESSION['success_message'] = " تمت التعديل  بنجاح  ";

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
            }
            header('Location:main?dir=big_orders&page=edit&order_id=' . $order_id);
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
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
}

?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> تفاصيل الطلب </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> تفاصيل الطلب </li>
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
<?php
$order_id = $_GET['order_id'];
$stmt = $connect->prepare("SELECT * FROM big_orders WHERE id=?");
$stmt->execute(array($order_id));
$pro_data = $stmt->fetch();
?>
<section class="content">
    <div class="container-fluid">
        <form action="" method="post" enctype="multipart/form-data" autocomplete="off">
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="inputName"> اسم (المؤسسة - الشركة) </label>
                                <input disabled required type="text" id="name" name="company_name" class="form-control" value="<?php if (isset($_REQUEST['company_name'])) {
                                                                                                                                    echo $_REQUEST['company_name'];
                                                                                                                                } else {
                                                                                                                                    echo $pro_data['company_name'];
                                                                                                                                } ?>">
                            </div>
                            <div class="form-group">
                                <label for="inputName"> اسم ممثل الشركة </label>
                                <input disabled required type="text" id="name" name="company_person_name" class="form-control" value="<?php if (isset($_REQUEST['company_person_name'])) {
                                                                                                                                            echo $_REQUEST['company_person_name'];
                                                                                                                                        } else {
                                                                                                                                            echo $pro_data['company_person_name'];
                                                                                                                                        } ?>">
                            </div>
                            <div class="form-group">
                                <label for="inputName"> رقم الجوال </label>
                                <input disabled required type="text" id="name" name="phone" class="form-control" value="<?php if (isset($_REQUEST['phone'])) {
                                                                                                                            echo $_REQUEST['phone'];
                                                                                                                        } else {
                                                                                                                            echo $pro_data['phone'];
                                                                                                                        } ?>">
                            </div>
                            <div class="form-group">
                                <label for="inputName"> البريد الألكتروني </label>
                                <input disabled required type="text" id="name" name="email" class="form-control" value="<?php if (isset($_REQUEST['email'])) {
                                                                                                                            echo $_REQUEST['email'];
                                                                                                                        } else {
                                                                                                                            echo $pro_data['email'];
                                                                                                                        } ?>">
                            </div>
                            <div class="form-group">
                                <label for="inputName"> المدينة </label>
                                <input disabled required type="text" id="name" name="city" class="form-control" value="<?php if (isset($_REQUEST['city'])) {
                                                                                                                            echo $_REQUEST['city'];
                                                                                                                        } else {
                                                                                                                            echo $pro_data['city'];
                                                                                                                        } ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="inputEstimatedBudget"> نوع الطلبية </label>
                                <input disabled type="text" id="purchase_price" name="request_type" class="form-control" value="<?php if (isset($_REQUEST['request_type'])) {
                                                                                                                                    echo $_REQUEST['request_type'];
                                                                                                                                } else {
                                                                                                                                    echo $pro_data['request_type'];
                                                                                                                                } ?>">
                            </div>
                            <div class="form-group">
                                <label for="inputEstimatedBudget"> وصف الطلبية </label>
                                <textarea disabled id="purchase_price" name="order_details" class="form-control"><?php if (isset($_REQUEST['order_details'])) {
                                                                                                                        echo $_REQUEST['order_details'];
                                                                                                                    } else {
                                                                                                                        echo $pro_data['order_details'];
                                                                                                                    } ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="inputEstimatedBudget"> المرفقات </label>
                                <br>
                                <a target="_blank" href="big_orders/attachments/<?php echo $pro_data['order_attachments'] ?>"> شاهد المرفق </a>
                            </div>
                            <div class="form-group">
                                <label for="inputEstimatedBudget"> تاريخ الطلب </label>
                                <input disabled id="purchase_price" name="order_date" class="form-control" value="<?php if (isset($_REQUEST['order_date'])) {
                                                                                                                        echo $_REQUEST['order_date'];
                                                                                                                    } else {
                                                                                                                        echo $pro_data['order_date'];
                                                                                                                    } ?>">
                            </div>
                            <div class="form-group">
                                <label for="inputEstimatedBudget"> حالة الطلب </label>
                                <select name="status" id="" class="form-control select2">
                                    <option value=""> -- حدد حالة الطلب -- </option>
                                    <option <?php if ($pro_data['status'] == 0) echo 'selected'; ?> value="0"> تحت المراجعه </option>
                                    <option <?php if ($pro_data['status'] == 1) echo 'selected'; ?> value="1"> تمت </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.card -->
            </div>
            <div class=" card">
                <div class="card-body">
                    <div class="row d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary" name="edit_pro"> حفظ التعديلات <i class="fa fa-save"></i> </button>
                        <!--  <a href="main.php?dir=products&page=report" class="btn btn-secondary">رجوع <i class="fa fa-backward"></i> </a> -->
                    </div>
                </div>
            </div>
        </form>
    </div>
    </div>
    <br>

    <br>
    </div>
    <!-- /.container-fluid -->
</section>
<?php
