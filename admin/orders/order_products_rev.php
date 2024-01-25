<?php
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
}
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">منتجات الطلب بعد الجودة </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> منتجات الطلب </li>
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
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-body">
                        <div class="row">
                            <?php
                            $stmt = $connect->prepare("SELECT * FROM order_step_details WHERE order_id = ?");
                            $stmt->execute(array($order_id));
                            $order_details = $stmt->fetchAll();
                            foreach ($order_details as $detail) {
                            ?>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input type="hidden" name="order_step_detail_id[]" value="<?php echo $detail['id'] ?>">
                                        <label for=""> اسم المنتج </label>
                                        <input type="text" name="product_name[]" class="form-control" value="<?php echo $detail['product_name']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for=""> صورة المنتج </label>
                                        <a href="steps_images/<?php echo $detail['product_image']; ?>" target="_blank"><img style="width: 100px; height:100px" src="steps_images/<?php echo $detail['product_image']; ?>"></a>
                                    </div>
                                    <div class="form-group">
                                        <label for=""> تقيم الجودة : </label>
                                        <span class="badge badge-danger"> <?php echo $detail['product_image_rating']; ?> </span>
                                    </div>
                                    <hr>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <br>
        <br>
    </div>
    <!-- /.container-fluid -->
</section>

<style>

</style>