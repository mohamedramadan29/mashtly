<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> تقارير عن المنتجات </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> تقارير عن المنتجات</li>
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
                            $(function () {
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
                    foreach ($formerror

                    as $error) {
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
                                    <th> #</th>
                                    <th> اسم المنتج</th>
                                    <th> القسم</th>
                                    <th> السعر</th>
                                    <th> الصورة</th>
                                    <th> عدد مرات البيع</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $stmt = $connect->prepare("SELECT * FROM products order by id DESC");
                                $stmt->execute();
                                $allpro = $stmt->fetchAll();
                                $i = 0;
                                foreach ($allpro as $pro) {
                                    $i++;
                                    ?>
                                    <tr>
                                        <td> <?php echo $i; ?> </td>
                                        <td>
                                            <a href="main.php?dir=products&page=edit&pro_id=<?php echo $pro['id']; ?>"> <?php echo $pro['name']; ?> </a>
                                        </td>
                                        <td> <?php
                                            if ($pro['cat_id'] != null) { ?>
                                                <?php
                                                $stmt = $connect->prepare("SELECT * FROM categories WHERE id = ? LIMIT 1");
                                                $stmt->execute(array($pro['cat_id']));
                                                $sub_data = $stmt->fetch();
                                                ?>
                                                <span class="badge badge-info"> <?php echo $sub_data['name']; ?> </span>
                                                <?php
                                                ?>
                                                <?php
                                            } else { ?>
                                                <span class="badge badge-danger"> لا يوجد </span>
                                                <?php
                                            } ?>
                                        </td>
                                        <td>  <?php echo $pro['price']; ?> ريال</td>

                                        <td>
                                            <?php
                                            $stmt = $connect->prepare("SELECT * FROM products_image WHERE product_id = ? LIMIT 1");
                                            $stmt->execute(array($pro['id']));
                                            $image_count = $stmt->rowCount();
                                            if ($image_count > 0) {
                                                $product_img_data = $stmt->fetch();
                                                ?>
                                                <img class="img-thumbnail" style="width: 80px; height:80px;"
                                                     src="product_images/<?php echo $product_img_data['main_image']; ?>"
                                                     alt="">
                                                <?php
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $stmt = $connect->prepare("SELECT * FROM order_details WHERE product_id = ?");
                                            $stmt->execute(array($pro['id']));
                                            $countbuy = $stmt->rowCount();
                                            echo $countbuy;
                                            ?>
                                        </td>
                                    </tr>
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