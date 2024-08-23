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
                <h1 class="m-0 text-dark"> المستلزمات الزراعية </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> المستلزمات الزراعية </li>
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
                            <div class="form_new_search">
                                <form method="post" action="">
                                    <div class="d-flex justify-content-center align-items-center flex-wrap">
                                        <div class="form-group">
                                            <select id="" class="form-control custom-select select2" name="cat_id">
                                                <option value=""> -- حدد القسم --</option>
                                                <?php
                                                $stmt = $connect->prepare("SELECT * FROM categories WHERE main_category = 2");
                                                $stmt->execute();
                                                $allcat = $stmt->fetchAll();
                                                foreach ($allcat as $cat) {
                                                ?>
                                                    <option <?php if (isset($_POST['cat_id']) && $_POST['cat_id'] == $cat['id']) echo 'selected'; ?> value="<?php echo $cat['id'] ?>"> <?php echo $cat['name']; ?> </option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div>
                                            <button name="search" class="btn btn-dark btn-sm"> بحث <i class="fa fa-search"></i> </button>
                                        </div>
                                    </div>
                                </form>
                                <br>
                                <?php
                                if (isset($_POST['search'])) {
                                    $cat_id = $_POST['cat_id'];
                                    // استعلام للحصول على جميع المنتجات المرتبطة بالقسم الرئيسي أو الأقسام الفرعية
                                    $query = "
                                        SELECT p.*
                                        FROM products p
                                        JOIN categories c_main ON p.cat_id = c_main.id
                                        LEFT JOIN categories c_sub ON FIND_IN_SET(c_sub.id, p.more_cat)
                                        WHERE c_main.id = :cat_id 
                                        OR FIND_IN_SET(:cat_id, p.more_cat)
                                    ";

                                    // تحضير وتنفيذ الاستعلام
                                    $stmt = $connect->prepare($query);
                                    $stmt->bindParam(':cat_id', $cat_id, PDO::PARAM_INT);
                                    $stmt->execute();
                                    $allpro = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    $count = count($allpro);

                                ?>
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th> # </th>
                                                <th>الأسم</th>
                                                <th> القسم</th>
                                                <th> نباتات / مستلزمات </th>
                                                <th> سعر الشراء </th>
                                                <th> سعر البيع </th>
                                                <th> سعر التخفيض</th>
                                                <th> المخزون</th>
                                                <th> نشر المنتج</th>
                                                <th> صورة</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 0;
                                            foreach ($allpro as $pro) {
                                                $i++;
                                            ?>
                                                <tr>

                                                    <td> <?php echo $i; ?> </td>
                                                    <td> <?php echo $pro['name']; ?> </td>
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
                                                    <td> <?php
                                                            if ($sub_data['main_category'] == 1) {
                                                                echo "نباتات";
                                                            } else {
                                                                echo "مستلزمات";
                                                            }
                                                            ?> </td>

                                                    <td> <?php echo $pro['purchase_price']; ?> </td>
                                                    <td> <?php echo $pro['price']; ?> </td>
                                                    <td> <?php echo $pro['sale_price']; ?> </td>
                                                    <td> <?php
                                                            if ($pro['product_status_store'] == 1) {
                                                            ?>
                                                            <span class="badge badge-success"> متوفر </span>
                                                        <?php
                                                            } elseif ($pro['product_status_store'] == 0) {
                                                        ?>
                                                            <span class="badge badge-danger"> غير متوفر </span>
                                                        <?php
                                                            }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($pro['publish'] == 1) {
                                                        ?>
                                                            <span class="badge badge-success"> منشور </span>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <span class="badge badge-danger"> ارشيف </span>
                                                        <?php
                                                        } ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $stmt = $connect->prepare("SELECT * FROM products_image WHERE product_id = ? LIMIT 1");
                                                        $stmt->execute(array($pro['id']));
                                                        $image_count = $stmt->rowCount();
                                                        if ($image_count > 0) {
                                                            $product_img_data = $stmt->fetch();
                                                        ?>
                                                            <img class="img-thumbnail" style="width: 80px; height:80px;" src="product_images/<?php echo $product_img_data['main_image']; ?>" alt="">
                                                        <?php
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>

                                            <?php
                                            }
                                        } else {
                                            $query = "
                                                    SELECT p.* 
                                                    FROM products p
                                                    JOIN categories c_main ON p.cat_id = c_main.id
                                                    LEFT JOIN categories c_sub ON FIND_IN_SET(c_sub.id, p.more_cat)
                                                    WHERE (c_main.main_category = 2 OR c_sub.main_category = 2)
                                                    ORDER BY p.id DESC
                                                ";
                                            $statement = $connect->prepare($query);
                                            $statement->execute();
                                            $allpro = $statement->fetchAll(PDO::FETCH_ASSOC);
                                            ?>
                                            <form action="" method="post">
                                                <table id="my_table" class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th> # </th>
                                                            <th>الأسم</th>
                                                            <th> القسم</th>
                                                            <th> نباتات / مستلزمات </th>
                                                            <th> سعر الشراء </th>
                                                            <th> سعر البيع </th>
                                                            <th> سعر التخفيض</th>
                                                            <th> المخزون</th>
                                                            <th> نشر المنتج</th>
                                                            <th> صورة</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $i = 0;
                                                        foreach ($allpro as $pro) {
                                                            $i++;
                                                        ?>
                                                            <tr>

                                                                <td> <?php echo $i; ?> </td>
                                                                <td> <a href="main.php?dir=products&page=edit&pro_id=<?php echo $pro['id']; ?>"> <?php echo $pro['name']; ?> </a> </td>
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
                                                                <td> <?php
                                                                        if ($sub_data['main_category'] == 1) {
                                                                            echo "نباتات";
                                                                        } else {
                                                                            echo "مستلزمات";
                                                                        }
                                                                        ?> </td>
                                                                <td> <?php echo $pro['purchase_price']; ?> </td>
                                                                <td> <?php echo $pro['price']; ?> </td>
                                                                <td> <?php echo $pro['sale_price']; ?> </td>
                                                                <td> <?php
                                                                        if ($pro['product_status_store'] == 1) {
                                                                        ?>
                                                                        <span class="badge badge-success"> متوفر </span>
                                                                    <?php
                                                                        } elseif ($pro['product_status_store'] == 0) {
                                                                    ?>
                                                                        <span class="badge badge-danger"> غير متوفر </span>
                                                                    <?php
                                                                        }
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <?php if ($pro['publish'] == 1) {
                                                                    ?>
                                                                        <span class="badge badge-success"> منشور </span>
                                                                    <?php
                                                                    } else {
                                                                    ?>
                                                                        <span class="badge badge-danger"> ارشيف </span>
                                                                    <?php
                                                                    } ?>
                                                                </td>

                                                                <td>
                                                                    <?php
                                                                    $stmt = $connect->prepare("SELECT * FROM products_image WHERE product_id = ? LIMIT 1");
                                                                    $stmt->execute(array($pro['id']));
                                                                    $image_count = $stmt->rowCount();
                                                                    if ($image_count > 0) {
                                                                        $product_img_data = $stmt->fetch();
                                                                    ?>
                                                                        <img class="img-thumbnail" style="width: 80px; height:80px;" src="product_images/<?php echo $product_img_data['main_image']; ?>" alt="">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </td>
                                                            </tr>
                                            </form>
                                            <?php

                                            ?>
                            </div>
                    <?php }
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

<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>