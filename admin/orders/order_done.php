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
                <h1 class="m-0 text-dark"> صور اثباتات تسليم الطلب </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> اثبات تسليم الطلب </li>
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
                            $stmt = $connect->prepare("SELECT * FROM order_steps WHERE order_id = ? AND step_name = 'التوصيل' AND step_status='تمت عملية التوصيل واستلام الطلب بنجاح' LIMIT 1");
                            $stmt->execute(array($order_id));
                            $order_details = $stmt->fetchAll();
                            foreach ($order_details as $detail) {
                                $images = $detail['delivery_com_images'];
                                $images = rtrim($images, ','); // Remove trailing comma
                                $image = explode(',',$images);
                                foreach($image as $img){
                                    ?>
                                    <div class="col-lg-6">
                                    <div class="form-group">
                                        <a href="delivery_compelete_images/<?php echo $img ?>" target="_blank"><img style="max-width:100%" src="delivery_compelete_images/<?php echo $img; ?>"></a>
                                    </div>
                                </div>
                                    <?php
                                }
                            ?>
                                
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