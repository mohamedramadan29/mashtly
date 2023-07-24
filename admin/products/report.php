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
                                    $stmt = $connect->prepare("SELECT * FROM products ORDER BY id DESC");
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
                                                <?php
                                                $stmt = $connect->prepare("SELECT * FROM products_image WHERE product_id = ? LIMIT 1");
                                                $stmt->execute(array($pro['id']));
                                                $count = $stmt->rowCount();
                                                if ($count > 0) {
                                                    $product_img_data = $stmt->fetch();
                                                ?>
                                                    <img style="width: 80px; height:80px;" src="product_images/<?php echo $product_img_data['main_image']; ?>" alt="">
                                                <?php
                                                }

                                                ?>
                                                <?php if (!empty($pro['main_image']) && strpos($pro['main_image'], "https://www.mshtly.com") !== false) { ?>
                                                    <img style="width: 80px; height:80px;" src="<?php echo $pro['main_image']; ?>" alt="">
                                                <?php } elseif (!empty($pro['main_image'])) { ?>
                                                    <img style="width: 80px; height:80px;" src="product_images/<?php echo $pro['main_image']; ?>" alt="">
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <a href="main.php?dir=products&page=edit&pro_id=<?php echo $pro['id']; ?>" class="btn btn-success btn-sm"> مشاهدة التفاصيل <i class='fa fa-pen'></i></a>
                                                <button type="button" class="btn btn-info btn-sm waves-effect" data-toggle="modal" data-target="#edit-Modal_<?php echo $pro['id']; ?>"> تحرير سريع <i class='fa fa-pen'></i> </button>
                                                <a href="main.php?dir=products&page=delete&pro_id=<?php echo $pro['id']; ?>" class="confirm btn btn-danger btn-sm"> حذف <i class='fa fa-trash'></i> </a>
                                            </td>
                                        </tr>
                                        <!-- EDIT NEW CATEGORY MODAL   -->
                                        <div class="modal fade" id="edit-Modal_<?php echo $pro['id']; ?>" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title"> تحرير سريع للمنتج </h4>
                                                    </div>
                                                    <form method="post" action="main.php?dir=products&page=fast_edit" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <input type='hidden' name="pro_id" value="<?php echo $pro['id']; ?>">
                                                                <label for="Company-2" class="block">الأسم </label>
                                                                <input id="Company-2" required name="name" type="text" class="form-control required" value="<?php echo  $pro['name'] ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> السعر الأفتراضي </label>
                                                                <input id="Company-2" required name="price" type="text" class="form-control required" value="<?php echo $pro['price'] ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> سعر التخفيض </label>
                                                                <input id="Company-2" required name="sale_price" type="text" class="form-control required" value="<?php echo $pro['sale_price'] ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> حالة المخزون </label>
                                                                <select name="product_status_store" id="" class="form-control select2">
                                                                    <option value=""> حدد حالة المخزون </option>
                                                                    <option <?php if ($pro['product_status_store'] == 1) echo "selected"; ?> value="1"> متوفر </option>
                                                                    <option <?php if ($pro['product_status_store'] == 0) echo "selected"; ?> value="0"> غير متوفر </option>
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