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
                    <li class="breadcrumb-item active"> المنتجات </li>
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
                        <a href="main.php?dir=products&page=add" class="btn btn-primary waves-effect btn-sm"> أضافة منتج جديد <i class="fa fa-plus"></i> </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="my_table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th> # </th>
                                        <th>الأسم </th>
                                        <th> القسم </th>
                                        <th> السعر </th>
                                        <th> سعر التخفيض </th>
                                        <th> الكمية </th>
                                        <th> صورة المنتج </th>
                                        <th> </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $connect->prepare("SELECT * FROM products");
                                    $stmt->execute();
                                    $allpro = $stmt->fetchAll();
                                    $i = 0;
                                    foreach ($allpro as $pro) {
                                        $i++;
                                    ?>
                                        <tr>
                                            <td> <?php echo $i; ?> </td>
                                            <td> <?php echo  $pro['name']; ?> </td>
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
                                                    }  ?>
                                            </td>
                                            <td> <?php echo  $pro['price']; ?> </td>
                                            <td> <?php echo  $pro['sale_price']; ?> </td>
                                            <td> <?php echo  $pro['av_num']; ?> </td>
                                            <td>
                                                <?php if (strpos($pro['main_image'], "https://www.mshtly.com") !== false) { ?>
                                                    <img style="width: 80px; height:80px;" src="<?php echo $pro['main_image']; ?>" alt="">
                                                <?php
                                                } else {
                                                ?>
                                                    <img style="width: 80px; height:80px;" src="product_images/<?php echo $pro['main_image']; ?>" alt="">
                                                <?php
                                                } ?>
                                            </td>
                                            <td>
                                                <a href="main.php?dir=products&page=edit&pro_id=<?php echo $pro['id']; ?>" class="btn btn-success waves-effect btn-sm"> مشاهدة التفاصيل <i class='fa fa-pen'></i></a>
                                                <a href="main.php?dir=products&page=delete&pro_id=<?php echo $pro['id']; ?>" class="confirm btn btn-danger btn-sm"> حذف <i class='fa fa-trash'></i> </a>
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