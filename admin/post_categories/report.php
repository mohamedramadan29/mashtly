<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> اقسام المدونة </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> اقسام المدونة </li>
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
                        <button type="button" class="btn btn-primary waves-effect btn-sm" data-toggle="modal" data-target="#add-Modal"> أضافة قسم جديد <i class="fa fa-plus"></i> </button>
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

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="my_table" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th> # </th>
                                        <th>الأسم </th>
                                        <th> القسم الرئيسي </th>
                                        <th> صورة القسم </th>
                                        <th> </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $connect->prepare("SELECT * FROM category_posts ORDER BY id DESC");
                                    $stmt->execute();
                                    $allcat = $stmt->fetchAll();
                                    $i = 0;
                                    foreach ($allcat as $cat) {
                                        $i++;
                                    ?>
                                        <tr>
                                            <td> <?php echo $i; ?> </td>
                                            <td> <?php echo  $cat['name']; ?> </td>
                                            <td> <?php
                                                    if ($cat['parent_id'] != null) {
                                                        $stmt = $connect->prepare("SELECT * FROM category_posts WHERE id = ?");
                                                        $stmt->execute(array($cat['parent_id']));
                                                        $parent_data = $stmt->fetch();
                                                    ?>
                                                    <span class="badge badge-info"> <?php echo $parent_data['name']; ?> </span>
                                                <?php
                                                    }else{
                                                        ?>
                                                        <span class="badge badge-warning"> رئيسي </span>
                                                        <?php 
                                                    }
                                                ?>
                                            </td>
                                            <td> <img style="width: 60px; height:60px" src="../uploads/post_categories/<?php echo $cat['main_image']; ?> " alt=""></td>
                                            <td>
                                                <button type="button" class="btn btn-success btn-sm waves-effect" data-toggle="modal" data-target="#edit-Modal_<?php echo $cat['id']; ?>"> تعديل <i class='fa fa-pen'></i> </button>
                                                <a href="main.php?dir=post_categories&page=delete&cat_id=<?php echo $cat['id']; ?>" class="confirm btn btn-danger btn-sm"> حذف <i class='fa fa-trash'></i> </a>
                                            </td>
                                        </tr>
                                        <!-- EDIT NEW CATEGORY MODAL   -->
                                        <div class="modal fade" id="edit-Modal_<?php echo $cat['id']; ?>" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title"> تعديل القسم </h4>
                                                    </div>
                                                    <form method="post" action="main.php?dir=post_categories&page=edit" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <input type='hidden' name="cat_id" value="<?php echo $cat['id']; ?>">
                                                                <label for="Company-2" class="block">الأسم </label>
                                                                <input id="Company-2" required name="name" type="text" class="form-control required" value="<?php echo  $cat['name'] ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> القسم الرئيسي </label>
                                                                <select required class='form-control select2' name='parent_id'>
                                                                    <option value="0"> -- اختر -- </option>
                                                                    <option <?php if ($cat['parent_id'] == 0) echo "selected"; ?> value="0"> بدون </option>
                                                                    <?php
                                                                    $stmt = $connect->prepare("SELECT * FROM category_posts");
                                                                    $stmt->execute();
                                                                    $allcats = $stmt->fetchAll();
                                                                    foreach ($allcats as $cat_post) {
                                                                    ?>
                                                                        <option <?php if ($cat_post['id'] == $cat['parent_id']) echo "selected"; ?> value="<?php echo $cat_post['id']; ?>"> <?php echo $cat_post['name'] ?> </option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> الوصف </label>
                                                                <textarea style="height: 150px;" id="Company-2" name="description" class="form-control"><?php echo  $cat['description'] ?></textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="customFile"> تعديل صورة القسم </label>
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input" id="customFile" accept='image/*' name="main_image">
                                                                    <label class="custom-file-label" for="customFile">اختر الصورة</label>
                                                                </div>
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

                <!-- ADD NEW CATEGORY MODAL   -->
                <div class="modal fade" id="add-Modal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">أضافة قسم رئيسي </h4>
                            </div>
                            <form action="main.php?dir=post_categories&page=add" method="post" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> الأسم </label>
                                        <input required id="Company-2" name="name" type="text" class="form-control required">
                                    </div>
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> القسم الرئيسي </label>
                                        <select required class='form-control select2' name='parent_id'>
                                            <option value="0"> -- اختر -- </option>
                                            <option value="0"> بدون </option>
                                            <?php
                                            $stmt = $connect->prepare("SELECT * FROM category_posts");
                                            $stmt->execute();
                                            $allcat = $stmt->fetchAll();
                                            foreach ($allcat as $cat) {
                                            ?>
                                                <option value="<?php echo $cat['id']; ?>"> <?php echo $cat['name'] ?> </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> الوصف </label>
                                        <textarea style="height: 150px;" id="Company-2" name="description" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="customFile"> صورة القسم </label>
                                        <div class="custom-file">
                                            <input required type="file" class="dropify" id="customFile" accept='image/*' name="main_image">

                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="add_cat" class="btn btn-primary waves-effect waves-light "> حفظ </button>
                                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal"> رجوع </button>
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