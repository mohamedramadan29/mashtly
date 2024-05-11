<?php
if (isset($_GET['report_page'])) {
    $report_page = $_GET['report_page'];
} else {
    $report_page = 1;
}

?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> المنتجات </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> المنتجات</li>
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

                    <div class="card-body product_table">
                        <div class="table-responsive">
                         
                                <?php
                                $stmt = $connect->prepare("SELECT * FROM products");
                                $stmt->execute();
                                $allpro = $stmt->fetchAll();
                                //$totalRecords = count($stmt->fetchAll());
                                // تحديد عدد السجلات في كل صفحة والصفحة الحالية
                                // $recordsPerPage = 300;
                                // $report_page = isset($_GET['report_page']) ? (int)$_GET['report_page'] : 1; // Cast to integer
                                // $report_page = max(1, $report_page); // Ensure $page is at least 1
                                // // حساب الإزاحة
                                // $offset = ($report_page - 1) * $recordsPerPage;
                                // // استعلام SQL لاسترداد البيانات للصفحة الحالية
                                // $query = "SELECT * FROM products  ORDER BY id DESC LIMIT :offset, :limit";
                                // $statement = $connect->prepare($query);
                                // $statement->bindParam(':offset', $offset, PDO::PARAM_INT);
                                // $statement->bindParam(':limit', $recordsPerPage, PDO::PARAM_INT);
                                // $statement->execute();
                                // $allpro = $statement->fetchAll(PDO::FETCH_ASSOC);
                                ?> 

                                    <table id="my_table" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>

                                                <th> id </th>
                                                <th> العنوان </th>
                                                <th> الوصف </th>
                                                <th> السعر </th>
                                                <th> الحالة </th>
                                                <th> الرابط </th>
                                                <th> مدى التوفّر </th>
                                                <th> رابط الصورة </th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 0;
                                            foreach ($allpro as $pro) {
                                                $i++;
                                            ?>
                                                <tr>
                                                    <td> <?php echo $pro["id"]; ?> </td>
                                                    <td> <?php echo $pro['name']; ?> </td>
                                                    <td> <?php echo $pro['description']; 
                                                            ?> </td>
                                                    <td> <?php
                                                    if($pro['price'] != null || $pro['price'] != ''){
                                                        echo number_format($pro['price'], 2);
                                                    }else{
                                                        echo $pro['price'];
                                                    }
                                                    ?> 
                                                    </td>
                                                    <td> new </td>
                                                    <td> https://www.mshtly.com/product/<?php echo $pro['slug'] ?> </td>
                                                    <td>
                                                        <?php
                                                        if ($pro['product_status_store'] == 1) {
                                                        ?>
                                                            in_stock
                                                        <?php
                                                        } elseif ($pro['product_status_store'] == 0) {
                                                        ?>
                                                            out_stock
                                                        <?php
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $stmt = $connect->prepare("SELECT * FROM products_image WHERE product_id = ? LIMIT 1");
                                                        $stmt->execute(array($pro['id']));
                                                        $image_count = $stmt->rowCount();
                                                        if ($image_count > 0) {
                                                            $product_img_data = $stmt->fetch();
                                                        ?>
                                                            https://www.mshtly.com/admin/product_images/<?php echo $product_img_data['main_image']; ?>

                                                        <?php
                                                        }
                                                        ?>
                                                    </td>

                                                </tr>
                        <?php }

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

<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>