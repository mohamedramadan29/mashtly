<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> معرض الصور </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> معرض الصور </li>
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
                        <button type="button" class="btn btn-primary waves-effect btn-sm" data-toggle="modal"
                            data-target="#add-Modal"> ااضافة قسم جديد <i class="fa fa-plus"></i> </button>
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

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="my_table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th> # </th>
                                        <th> اسم القسم </th>
                                        <th> صورة القسم </th>
                                        <th> alt </th>
                                        <th> وصف الصورة </th>
                                        <th> العمليات </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $connect->prepare("SELECT * FROM categories_gallary ORDER BY id DESC");
                                    $stmt->execute();
                                    $categories = $stmt->fetchAll();
                                    $i = 0;
                                    foreach ($categories as $category) {
                                        $i++;
                                        ?>
                                        <tr>
                                            <td> <?php echo $i; ?> </td>
                                            <td> <?php echo $category['name']; ?> </td>
                                            <td>
                                                <img width="80" class="img-thumbnail img-fluid"
                                                    src="../uploads/gallary/<?php echo $category['image'] ?>" alt="">
                                            </td>
                                            <td> <?php echo $category['image_alt']; ?> </td>
                                            <td> <?php echo $category['image_desc']; ?> </td>
                                            <td>
                                            <a href="main.php?dir=product_gallary/products&page=index&category_id=<?php echo $category['id']; ?>"
                                                    class="btn btn-primary btn-sm"> تفاصيل  <i class='fa fa-eye'></i>
                                                </a>
                                                <button type="button" class="btn btn-success btn-sm waves-effect"
                                                    data-toggle="modal"
                                                    data-target="#edit-Modal_<?php echo $category['id']; ?>"> تعديل <i
                                                        class='fa fa-pen'></i> </button>
                                                <a href="main.php?dir=product_gallary/categories&page=delete&category_id=<?php echo $category['id']; ?>"
                                                    class="confirm btn btn-danger btn-sm"> حذف <i class='fa fa-trash'></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <!-- EDIT NEW CATEGORY MODAL   -->
                                        <div class="modal fade" id="edit-Modal_<?php echo $category['id']; ?>" tabindex="-1"
                                            role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title"> تعديل قسم الصور </h4>
                                                    </div>
                                                    <form action="main.php?dir=product_gallary/categories&page=edit"
                                                        method="post" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <input type='hidden' name="category_id"
                                                                value="<?php echo $category['id']; ?>">
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> الاسم </label>
                                                                <input required id="Company-2" name="name" type="text"
                                                                    class="form-control required"
                                                                    value="<?php echo $category['name'] ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> حدد الصورة </label>
                                                                <input id="Company-2" name="main_image" type="file"
                                                                    class="form-control required">
                                                                <img width="80" class="img-thumbnail img-fluid"
                                                                    src="../uploads/gallary/<?php echo $category['image'] ?>"
                                                                    alt="">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> Alt للصورة </label>
                                                                <input required id="Company-2" name="image_alt" type="text"
                                                                    class="form-control required" value="<?php echo $category['image_alt'] ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> وصف مختصر عن القسم
                                                                </label>
                                                                <textarea name="desc" id="" class="form-control"
                                                                    required><?php echo $category['cat_desc'] ?></textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> حدد حالة الظهور
                                                                </label>
                                                                <select name="status" class="form-control" id="">
                                                                    <option value="" selected disabled> -- حدد الحالة --
                                                                    </option>
                                                                    <option <?php if($category['status'] == 1) echo 'selected'; ?> value="1"> مفعل </option>
                                                                    <option <?php if($category['status'] == 0) echo 'selected'; ?> value="0"> غير مفعل </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" name="edit_cat"
                                                                class="btn btn-primary waves-effect waves-light "> تعديل
                                                            </button>
                                                            <button type="button" class="btn btn-default waves-effect "
                                                                data-dismiss="modal">رجوع</button>
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

                <!-- ADD NEW CATEGORY MODAL   -->
                <div class="modal fade" id="add-Modal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"> ااضافة قسم </h4>
                            </div>
                            <form action="main.php?dir=product_gallary/categories&page=add" method="post"
                                enctype="multipart/form-data">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> الاسم </label>
                                        <input required id="Company-2" name="name" type="text"
                                            class="form-control required">
                                    </div>
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> حدد الصورة </label>
                                        <input required id="Company-2" name="main_image" type="file"
                                            class="form-control required">
                                    </div>
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> Alt للصورة </label>
                                        <input required id="Company-2" name="image_alt" type="text"
                                            class="form-control required">
                                    </div>
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> وصف مختصر عن القسم </label>
                                        <textarea name="desc" id="" class="form-control" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> حدد حالة الظهور </label>
                                        <select name="status" class="form-control" id="">
                                            <option value="" selected disabled> -- حدد الحالة -- </option>
                                            <option value="1"> مفعل </option>
                                            <option value="0"> غير مفعل </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="add_cat"
                                        class="btn btn-primary waves-effect waves-light "> حفظ </button>
                                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">
                                        رجوع </button>
                                </div>
                            </form>
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