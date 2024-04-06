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
                    <div class="card-header">
                        <a href="main.php?dir=products&page=add" class="btn btn-primary waves-effect btn-sm"> أضافة منتج
                            جديد <i class="fa fa-plus"></i> </a>
                        <?php
                        if (isset($_POST['delete_selected'])) {
                            if (isset($_POST["products_id"]) && !empty($_POST["products_id"])) {
                                $selectedProducts = implode(",", $_POST["products_id"]);
                                $stmt = $connect->prepare("DELETE FROM products WHERE id IN ($selectedProducts)");
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
                            foreach ($formerror
                                as $error) {
                            ?>
                                <div class="alert alert-danger alert-dismissible" style="max-width: 800px; margin:20px">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <?php echo $error;
                                    ?>
                                </div>
                        <?php
                            }
                            unset($_SESSION['error_messages']);
                        }
                        ?>
                    </div>
                    <div class="card-body product_table">
                        <div class="table-responsive">
                            <div class="form_new_search">
                                <form method="post" action="">
                                    <div class="d-flex justify-content-center align-items-center flex-wrap">
                                        <div class="form-group">
                                            <select id="" class="form-control custom-select select2" name="cat_id">
                                                <option value=""> -- حدد القسم --</option>
                                                <?php
                                                $stmt = $connect->prepare("SELECT * FROM categories");
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
                                        <div class="form-group">
                                            <select id="" class="form-control custom-select select2" name="product_store">
                                                <option value=""> -- حالة المخزون --</option>
                                                <option <?php if (isset($_POST['product_store']) && $_POST['product_store'] == 1) echo "selected"; ?> value="1"> متوفر </option>
                                                <option <?php if (isset($_POST['product_store']) && $_POST['product_store'] == 0) echo "selected"; ?> value="0"> غير متوفر </option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <select id="" class="form-control custom-select select2" name="ship_weight">
                                                <option value=""> -- الفرز حسب الوزن --</option>
                                                <option <?php if (isset($_POST['ship_weight']) && $_POST['ship_weight'] == 1) echo "selected"; ?> value="1"> وزن </option>
                                                <option <?php if (isset($_POST['ship_weight']) && $_POST['ship_weight'] == 0) echo "selected"; ?> value="0"> بدون وزن </option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <select id="" class="form-control custom-select select2" name="feature_product">
                                                <option value=""> -- منتج مميز --</option>
                                                <option <?php if (isset($_POST['feature_product']) && $_POST['feature_product'] == 1) echo "selected"; ?> value="1"> مميز </option>

                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <select id="" class="form-control custom-select select2" name="product_as_gift">
                                                <option value=""> -- منتج هدية --</option>
                                                <option <?php if (isset($_POST['product_as_gift']) && $_POST['product_as_gift'] == 1) echo "selected"; ?> value="1"> هدية </option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" type="text" name="product_name" placeholder="اكتب اسم المنتج" value="<?php if (isset($_POST['product_name'])) echo $_POST['product_name'] ?>">
                                        </div>
                                        <div>
                                            <button name="search" class="btn btn-dark btn-sm"> بحث <i class="fa fa-search"></i> </button>
                                        </div>
                                    </div>
                                </form>
                                <br>
                                <?php
                                $stmt = $connect->prepare("SELECT * FROM products");
                                $stmt->execute();
                                $totalRecords = count($stmt->fetchAll());
                                // تحديد عدد السجلات في كل صفحة والصفحة الحالية
                                $recordsPerPage = 30;
                                $report_page = isset($_GET['report_page']) ? (int)$_GET['report_page'] : 1; // Cast to integer
                                $report_page = max(1, $report_page); // Ensure $page is at least 1
                                // حساب الإزاحة
                                $offset = ($report_page - 1) * $recordsPerPage;
                                if (isset($_POST['search'])) {
                                    $conditions = array();
                                    $values = array();
                                    if (!empty($_POST['cat_id'])) {
                                        $category_id = $_POST['cat_id'];
                                        $conditions[] = "cat_id = ?";
                                        $values[] = $category_id;
                                    }
                                    if (!empty($_POST['product_store'])) {
                                        $product_store = $_POST['product_store'];
                                        $conditions[] = "product_status_store = :product_store";
                                        $values[':product_store'] = $product_store;
                                    }
                                    if (!empty($_POST['ship_weight'])) {
                                        $ship_weight = $_POST['ship_weight'];
                                        if ($ship_weight == 1) {
                                            // إذا كان $ship_weight يساوي 1، يجب أن تكون القيم غير مساوية للصفر (0) أو null
                                            $conditions[] = "(ship_weight != 0 AND ship_weight IS NOT NULL)";
                                        } elseif ($ship_weight == 0) {
                                            // إذا كان $ship_weight يساوي 0، يجب أن تكون القيم مساوية للصفر (0) أو null
                                            $conditions[] = "(ship_weight = 0 OR ship_weight IS NULL)";
                                        }
                                    }
                                    if (!empty($_POST['feature_product'])) {
                                        $feature_product = $_POST['feature_product'];
                                        $conditions[] = "feature_product = ?";
                                        $values[] = $feature_product;
                                    }
                                    if (!empty($_POST['product_as_gift'])) {
                                        $product_as_gift = $_POST['product_as_gift'];
                                        $conditions[] = "product_as_gift = ?";
                                        $values[] = $product_as_gift;
                                    }
                                    if (!empty($_POST['product_name'])) {
                                        $product_name = $_POST['product_name'];
                                        $conditions[] = 'name LIKE ?';
                                        $values[] = '%' . $product_name . '%';
                                    }
                                    $query = "SELECT * FROM products";
                                    if (!empty($conditions)) {
                                        $query .= " WHERE " . implode(" AND ", $conditions);
                                    }

                                    $query .= " ORDER BY id DESC";
                                    $stmt = $connect->prepare($query);
                                    $stmt->execute($values);
                                    $allpro = $stmt->fetchAll();
                                    $count = count($allpro);

                                ?>
                                    <form action="" method="post">
                                        <button type="submit" name="delete_selected" class="btn btn-danger btn-sm"> حذف المنتجات
                                            المحددة <i class="fa fa-trash"></i></button>
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th> #</th>
                                                    <th>الأسم</th>
                                                    <th> القسم</th>
                                                    <th> السعر</th>
                                                    <th> سعر التخفيض</th>
                                                    <th> المخزون</th>
                                                    <th> نشر المنتج</th>
                                                    <th> مميز</th>
                                                    <th> هدية</th>
                                                    <th> صورة</th>
                                                    <th> العمليات</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 0;
                                                foreach ($allpro as $pro) {
                                                    $i++;
                                                ?>
                                                    <tr>
                                                        <td>
                                                            <input value="<?php echo $pro["id"]; ?>" style="cursor: pointer; box-shadow: none; width: 20px; height: 20px;" type="checkbox" name="products_id[]" class="form-control">
                                                        </td>
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
                                                        <td> <?php
                                                                if ($pro['feature_product'] == 1) {
                                                                ?>
                                                                <span> <i class="fa fa-star"></i> </span>
                                                            <?php
                                                                }
                                                            ?>
                                                        </td>
                                                        <td> <?php
                                                                if ($pro['product_as_gift'] == 1) {
                                                                ?>
                                                                <span> <i style="color: green;" class="fa fa-gift"></i> </span>
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
                                                                <img class="img-thumbnail" style="width: 80px; height:80px;" src="product_images/<?php echo $product_img_data['main_image']; ?>" alt="">
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
                                                                    <a class="dropdown-item" href="main.php?dir=products&page=edit&pro_id=<?php echo $pro['id']; ?>">
                                                                        تحرير </a>
                                                                    <a href="" class="dropdown-item" data-toggle="modal" data-target="#edit-Modal_<?php echo $pro['id']; ?>"> تحرير
                                                                        سريع </a>
                                                                    <a href="main.php?dir=products/faqs&page=report&pro_id=<?php echo $pro['id']; ?>" class="dropdown-item">اسئلة المنتج </a>
                                                                    <a class="dropdown-item confirm" href="main.php?dir=products&page=delete&pro_id=<?php echo $pro['id']; ?>">
                                                                        حذف المنتج </a>
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
                                                <form method="POST" action="main.php?dir=products&page=fast_edit" enctype="multipart/form-data">
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="Company-2" class="block"> رابط المنتج </label>
                                                            <span class="badge badge-info"> / Website Name </span> <input id="Company-2" required name="slug" type="text" class="form-control required" value="<?php echo $pro['slug'] ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="hidden" name="report_page" value="<?php echo $report_page; ?>">
                                                            <input type='hidden' name="pro_id" value="<?php echo $pro['id']; ?>">
                                                            <label for="Company-2" class="block">الأسم </label>
                                                            <input id="Company-2" required name="name" type="text" class="form-control required" value="<?php echo $pro['name'] ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputStatus"> القسم الرئيسي </label>
                                                            <select required id="" class="form-control custom-select select2" name="cat_id">
                                                                <option selected disabled> -- اختر --</option>
                                                                <?php
                                                                $stmt = $connect->prepare("SELECT * FROM categories");
                                                                $stmt->execute();
                                                                $allcat = $stmt->fetchAll();
                                                                foreach ($allcat as $cat) {
                                                                ?>
                                                                    <option <?php if (isset($_REQUEST['cat_id']) && $_REQUEST['cat_id'] == $cat['id']) {
                                                                                echo "selected";
                                                                            } elseif ($cat['id'] == $pro['cat_id']) {
                                                                                echo 'selected';
                                                                            } ?> value="<?php echo $cat['id']; ?>"> <?php echo $cat['name'] ?> </option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
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
                                                                <option value=""> حدد حالة المخزون</option>
                                                                <option <?php if ($pro['product_status_store'] == 1) echo "selected"; ?> value="1"> متوفر
                                                                </option>
                                                                <option <?php if ($pro['product_status_store'] == 0) echo "selected"; ?> value="0"> غير متوفر
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="Company-2" class="block"> نشر المنتج </label>
                                                            <select name="publish" id="" class="form-control select2">
                                                                <option value="" disabled> اختر الحالة</option>
                                                                <option <?php if ($pro['publish'] == 1) echo 'selected'; ?> value="1"> نشر المنتج
                                                                </option>
                                                                <option <?php if ($pro['publish'] == 0) echo 'selected'; ?> value="0"> ارشيف
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="Company-2" class="block"> منتج مميز </label>
                                                            <select name="feature_product" id="" class="form-control select2">
                                                                <option value="" disabled> اختر الحالة</option>
                                                                <option <?php if ($pro['feature_product'] == 0) echo 'selected'; ?> value="0"> عادي
                                                                </option>
                                                                <option <?php if ($pro['feature_product'] == 1) echo 'selected'; ?> value="1"> نعم
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="Company-2" class="block"> الطول لتحديد سعر
                                                                الزراعه </label>
                                                            <select name="public_tail" id="" class="form-control select2">
                                                                <option value=""> اختر الطول</option>
                                                                <?php
                                                                $stmt = $connect->prepare("SELECT * FROM public_tails");
                                                                $stmt->execute();
                                                                $alltails = $stmt->fetchAll();
                                                                foreach ($alltails as $tail) {
                                                                ?>
                                                                    <option <?php if ($pro['public_tail'] == $tail['id']) echo 'selected'; ?> value="<?php echo $tail['id']; ?>"> <?php echo $tail['name']; ?> </option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="Company-2" class="block"> تعين المنتج كهدية </label>
                                                            <select name="product_as_gift" id="" class="form-control select2">
                                                                <option value="" disabled> اختر</option>
                                                                <option <?php if ($pro['product_as_gift'] == 1) echo 'selected'; ?> value="1"> نعم
                                                                </option>
                                                                <option <?php if ($pro['product_as_gift'] == 0) echo 'selected'; ?> value="0"> لا
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" name="edit_cat" class="btn btn-primary waves-effect waves-light "> تعديل
                                                        </button>
                                                        <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">رجوع
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                                }
                                            } else {

                                                // استعلام SQL لاسترداد البيانات للصفحة الحالية
                                                $query = "SELECT * FROM products  ORDER BY id DESC LIMIT :offset, :limit";
                                                $statement = $connect->prepare($query);
                                                $statement->bindParam(':offset', $offset, PDO::PARAM_INT);
                                                $statement->bindParam(':limit', $recordsPerPage, PDO::PARAM_INT);
                                                $statement->execute();
                                                $allpro = $statement->fetchAll(PDO::FETCH_ASSOC);
                                ?>
                                <form action="" method="post">
                                    <button type="submit" name="delete_selected" class="btn btn-danger btn-sm"> حذف المنتجات
                                        المحددة <i class="fa fa-trash"></i></button>
                                    <table id="my_table" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th> #</th>
                                                <th>الأسم</th>
                                                <th> القسم</th>
                                                <th> نباتات / مستلزمات </th>
                                                <th> نوع المنتج </th>
                                                <th> السعر</th>
                                                <th> سعر التخفيض</th>
                                                <th> المخزون</th>
                                                <th> نشر المنتج</th>
                                                <th> مميز</th>
                                                <th> هدية</th>
                                                <th> الوزن </th>
                                                <th> الطول لتحديد الوزن </th>


                                                <th> صورة</th>
                                                <th> العمليات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $i = 0;
                                                foreach ($allpro as $pro) {
                                                    $i++;
                                            ?>
                                                <tr>
                                                    <td>
                                                        <input value="<?php echo $pro["id"]; ?>" style="cursor: pointer; box-shadow: none; width: 20px; height: 20px;" type="checkbox" name="products_id[]" class="form-control">
                                                    </td>
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
                                                    <td>
                                                        <?php
                                                        $stmt = $connect->prepare("SELECT * FROM product_details2 WHERE product_id = ?");
                                                        $stmt->execute(array($pro['id']));
                                                        $details2 = $stmt->fetchAll();
                                                        $count_var = $stmt->rowCount();
                                                        if ($count_var > 0) {
                                                            foreach ($details2 as $detil) {
                                                                echo $detil['vartions_name'] . "</br>";
                                                            }
                                                        } else {
                                                            echo "منتج بسيط";
                                                        }
                                                        ?>
                                                    </td>
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
                                                    <td> <?php
                                                            if ($pro['feature_product'] == 1) {
                                                            ?>
                                                            <span> <i class="fa fa-star"></i> </span>
                                                        <?php
                                                            }
                                                        ?>
                                                    </td>
                                                    <td> <?php
                                                            if ($pro['product_as_gift'] == 1) {
                                                            ?>
                                                            <span> <i style="color: green;" class="fa fa-gift"></i> </span>
                                                        <?php
                                                            }
                                                        ?>
                                                    </td>
                                                    <th> <?php
                                                            if ($pro['ship_weight'] != '' && $pro['ship_weight'] != 0) {
                                                                echo $pro['ship_weight'];
                                                                echo "كجم ";
                                                            } else {
                                                            ?>
                                                            <span style="color: red;"> لا يوجد وزن </span>
                                                        <?php
                                                            }
                                                        ?>
                                                    </th>
                                                    <th> <?php
                                                            if ($pro['ship_tail'] != '' && $pro['ship_tail'] != 0) {
                                                                echo $pro['ship_tail'];
                                                                echo "متر";
                                                            } else {
                                                            ?>
                                                            <span style="color: red;"> لا يوجد طول </span>
                                                        <?php
                                                            }
                                                        ?>
                                                    </th>
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
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-success btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                العمليات
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                <a class="dropdown-item" href="main.php?dir=products&page=edit&pro_id=<?php echo $pro['id']; ?>">
                                                                    تحرير </a>
                                                                <a href="" class="dropdown-item" data-toggle="modal" data-target="#edit-Modal_<?php echo $pro['id']; ?>"> تحرير
                                                                    سريع </a>
                                                                <a href="main.php?dir=products/faqs&page=report&pro_id=<?php echo $pro['id']; ?>" class="dropdown-item">اسئلة المنتج </a>
                                                                <a class="dropdown-item confirm" href="main.php?dir=products&page=delete&pro_id=<?php echo $pro['id']; ?>">
                                                                    حذف المنتج </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                </form>
                                <?php

                                ?>
                            </div>

                            <!-- EDIT NEW CATEGORY MODAL   -->
                            <div class="modal fade" id="edit-Modal_<?php echo $pro['id']; ?>" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title"> تحرير سريع للمنتج </h4>
                                        </div>
                                        <form method="POST" action="main.php?dir=products&page=fast_edit" enctype="multipart/form-data">
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="Company-2" class="block"> رابط المنتج </label>
                                                    <span class="badge badge-info"> / Website Name </span> <input id="Company-2" required name="slug" type="text" class="form-control required" value="<?php echo $pro['slug'] ?>">
                                                </div>
                                                <div class="form-group">
                                                    <input type="hidden" name="report_page" value="<?php echo $report_page; ?>">
                                                    <input type='hidden' name="pro_id" value="<?php echo $pro['id']; ?>">
                                                    <label for="Company-2" class="block">الأسم </label>
                                                    <input id="Company-2" required name="name" type="text" class="form-control required" value="<?php echo $pro['name'] ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputStatus"> القسم الرئيسي </label>
                                                    <select required id="" class="form-control custom-select select2" name="cat_id">
                                                        <option selected disabled> -- اختر --</option>
                                                        <?php
                                                        $stmt = $connect->prepare("SELECT * FROM categories");
                                                        $stmt->execute();
                                                        $allcat = $stmt->fetchAll();
                                                        foreach ($allcat as $cat) {
                                                        ?>
                                                            <option <?php if (isset($_REQUEST['cat_id']) && $_REQUEST['cat_id'] == $cat['id']) {
                                                                        echo "selected";
                                                                    } elseif ($cat['id'] == $pro['cat_id']) {
                                                                        echo 'selected';
                                                                    } ?> value="<?php echo $cat['id']; ?>"> <?php echo $cat['name'] ?> </option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
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
                                                        <option value=""> حدد حالة المخزون</option>
                                                        <option <?php if ($pro['product_status_store'] == 1) echo "selected"; ?> value="1"> متوفر
                                                        </option>
                                                        <option <?php if ($pro['product_status_store'] == 0) echo "selected"; ?> value="0"> غير متوفر
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="Company-2" class="block"> نشر المنتج </label>
                                                    <select name="publish" id="" class="form-control select2">
                                                        <option value="" disabled> اختر الحالة</option>
                                                        <option <?php if ($pro['publish'] == 1) echo 'selected'; ?> value="1"> نشر المنتج
                                                        </option>
                                                        <option <?php if ($pro['publish'] == 0) echo 'selected'; ?> value="0"> ارشيف
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="Company-2" class="block"> منتج مميز </label>
                                                    <select name="feature_product" id="" class="form-control select2">
                                                        <option value="" disabled> اختر الحالة</option>
                                                        <option <?php if ($pro['feature_product'] == 0) echo 'selected'; ?> value="0"> عادي
                                                        </option>
                                                        <option <?php if ($pro['feature_product'] == 1) echo 'selected'; ?> value="1"> نعم
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="Company-2" class="block"> الطول لتحديد سعر
                                                        الزراعه </label>
                                                    <select name="public_tail" id="" class="form-control select2">
                                                        <option value=""> اختر الطول</option>
                                                        <?php
                                                        $stmt = $connect->prepare("SELECT * FROM public_tails");
                                                        $stmt->execute();
                                                        $alltails = $stmt->fetchAll();
                                                        foreach ($alltails as $tail) {
                                                        ?>
                                                            <option <?php if ($pro['public_tail'] == $tail['id']) echo 'selected'; ?> value="<?php echo $tail['id']; ?>"> <?php echo $tail['name']; ?> </option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="Company-2" class="block"> تعين المنتج كهدية </label>
                                                    <select name="product_as_gift" id="" class="form-control select2">
                                                        <option value="" disabled> اختر</option>
                                                        <option <?php if ($pro['product_as_gift'] == 1) echo 'selected'; ?> value="1"> نعم
                                                        </option>
                                                        <option <?php if ($pro['product_as_gift'] == 0) echo 'selected'; ?> value="0"> لا
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" name="edit_cat" class="btn btn-primary waves-effect waves-light "> تعديل
                                                </button>
                                                <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">رجوع
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                    <?php }
                                            }
                    ?>
                    </table>
                    <?php
                    if (!isset($_POST['search'])) {
                    ?>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <?php
                                $totalPages = ceil($totalRecords / $recordsPerPage);
                                for ($i = 1; $i <= $totalPages; $i++) {
                                ?>
                                    <li class="page-item"><a class="page-link" href="main.php?dir=products&page=report&report_page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php
                                }
                                ?>
                            </ul>
                        </nav>
                    <?php
                    }

                    ?>

                        </div>
                    </div>
                </div>
                <style>
                    .dataTables_paginate {
                        display: none;
                    }

                    .dataTables_length {
                        display: none;
                    }
                </style>
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