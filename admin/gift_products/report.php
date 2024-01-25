<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> منتجات الهدايا </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> منتجات الهدايا </li>
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
                        <a href="main.php?dir=gift_products&page=add" class="btn btn-primary waves-effect btn-sm"> أضافة منتج جديد <i class="fa fa-plus"></i> </a>
                        <?php
                        if (isset($_POST['delete_selected'])) {
                            if (isset($_POST["products_id"]) && !empty($_POST["products_id"])) {
                                $selectedProducts = implode(",", $_POST["products_id"]);
                                $stmt = $connect->prepare("DELETE FROM products_gift WHERE id IN ($selectedProducts)");
                                $stmt->execute();
                                if ($stmt) {
                                    $_SESSION['success_message'] = " تم حذف المنتجات بنجاح ";
                                }
                            }
                        }
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
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <form action="" method="post">
                                <button type="submit" name="delete_selected" class="btn btn-danger btn-sm"> حذف المنتجات المحددة <i class="fa fa-trash"></i> </button>
                                <table id="my_table" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th> # </th>
                                            <th>الأسم </th>

                                            <th> السعر </th>
                                            <th> سعر التخفيض </th>
                                            <th> حالة المخزون </th>
                                            <th> مميز </th>
                                            <th> صورة المنتج </th>
                                            <th> العمليات </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $stmt = $connect->prepare("SELECT * FROM products_gift ORDER BY id DESC");
                                        $stmt->execute();
                                        $allpro = $stmt->fetchAll();
                                        $i = 0;
                                        foreach ($allpro as $pro) {
                                            $i++;
                                        ?>
                                            <tr>
                                                <td>
                                                    <input value="<?php echo $pro["id"]; ?>" style="cursor: pointer; box-shadow: none; width: 20px; height: 20px;" type="checkbox" name="products_id[]" class="form-control">
                                                </td>
                                                <td> <?php echo $i; ?> </td>
                                                <td> <?php echo  $pro['name']; ?> </td> 
                                                <td> <?php echo  $pro['price']; ?> </td>
                                                <td> <?php echo  $pro['sale_price']; ?> </td>
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
                                                <td> <?php
                                                        if ($pro['feature_product'] == 1) {
                                                        ?>
                                                        <span> <i class="fa fa-star"></i> </span>
                                                    <?php
                                                        }
                                                    ?>
                                                </td>

                                                <td>
                                                    <?php
                                                    $stmt = $connect->prepare("SELECT * FROM products_image_gifts WHERE product_id = ? LIMIT 1");
                                                    $stmt->execute(array($pro['id']));
                                                    $image_count = $stmt->rowCount();
                                                    if ($image_count > 0) {
                                                        $product_img_data = $stmt->fetch();
                                                    ?>
                                                        <img style="width: 80px; height:80px;" src="gift_products/images/<?php echo $product_img_data['main_image']; ?>" alt="">
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-success btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            العمليات
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <a class="dropdown-item" href="main.php?dir=gift_products&page=edit&pro_id=<?php echo $pro['id']; ?>"> تحرير </a>
                                                            <a href="" class="dropdown-item" data-toggle="modal" data-target="#edit-Modal_<?php echo $pro['id']; ?>"> تحرير سريع </a>
                                                            <a class="dropdown-item confirm" href="main.php?dir=gift_products&page=delete&pro_id=<?php echo $pro['id']; ?>"> حذف المنتج </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                            </form>
                            <!-- EDIT NEW CATEGORY MODAL   -->
                            <div class="modal fade" id="edit-Modal_<?php echo $pro['id']; ?>" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title"> تحرير سريع للمنتج </h4>
                                        </div>
                                        <form method="POST" action="main.php?dir=gift_products&page=fast_edit" enctype="multipart/form-data">
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="Company-2" class="block"> رابط منتج الهدية  </label>
                                                    <span class="badge badge-info"> / Website Name </span> <input id="Company-2" required name="slug" type="text" class="form-control required" value="<?php echo  $pro['slug'] ?>">
                                                </div>
                                                <div class="form-group">
                                                    <input type='hidden' name="pro_id" value="<?php echo $pro['id']; ?>">
                                                    <label for="Company-2" class="block">الأسم </label>
                                                    <input id="Company-2" required name="name" type="text" class="form-control required" value="<?php echo  $pro['name'] ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="Company-2" class="block"> السعر الأفتراضي </label>
                                                    <input id="Company-2" name="price" type="number" class="form-control required" value="<?php echo $pro['price'] ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="Company-2" class="block"> سعر التخفيض </label>
                                                    <input id="Company-2" name="sale_price" type="number" class="form-control required" value="<?php echo $pro['sale_price'] ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="Company-2" class="block"> حالة المخزون </label>
                                                    <select name="product_status_store" id="" class="form-control select2">
                                                        <option value=""> حدد حالة المخزون </option>
                                                        <option <?php if ($pro['product_status_store'] == 1) echo "selected"; ?> value="1"> متوفر </option>
                                                        <option <?php if ($pro['product_status_store'] == 0) echo "selected"; ?> value="0"> غير متوفر </option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="Company-2" class="block"> نشر المنتج </label>
                                                    <select name="publish" id="" class="form-control select2">
                                                        <option value="" disabled> اختر الحالة </option>
                                                        <option <?php if ($pro['publish'] == 1) echo 'selected'; ?> value="1"> نشر المنتج </option>
                                                        <option <?php if ($pro['publish'] == 0) echo 'selected'; ?> value="0"> ارشيف </option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="Company-2" class="block"> منتج مميز </label>
                                                    <select name="feature_product" id="" class="form-control select2">
                                                        <option value="" disabled> اختر الحالة </option>
                                                        <option <?php if ($pro['feature_product'] == 0) echo 'selected'; ?> value="0"> عادي </option>
                                                        <option <?php if ($pro['feature_product'] == 1) echo 'selected'; ?> value="1"> نعم </option>
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