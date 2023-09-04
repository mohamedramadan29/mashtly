<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> المقالات </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> المقالات </li>
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
                        <button type="button" class="btn btn-primary waves-effect btn-sm" data-toggle="modal" data-target="#add-Modal"> أضافة مقال جديد <i class="fa fa-plus"></i> </button>
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
                                        <th> القسم </th>
                                        <th> صورة المقال </th>

                                        <th> </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $connect->prepare("SELECT * FROM posts ORDER BY id DESC");
                                    $stmt->execute();
                                    $allposts = $stmt->fetchAll();
                                    $i = 0;
                                    foreach ($allposts as $post) {
                                        $i++;
                                    ?>
                                        <tr>
                                            <td>
                                                <?php echo $i; ?>
                                            </td>
                                            <td>
                                                <?php echo $post['name']; ?>
                                            </td>
                                            <td>
                                                <?php
                                                $stmt = $connect->prepare("SELECT * FROM category_posts WHERE id=?");
                                                $stmt->execute(array($post['cat_id']));
                                                $cat_data = $stmt->fetch();

                                                echo $cat_data['name']; ?>
                                            </td>
                                            <td> <img style="width: 60px; height:60px" src="posts/images/<?php echo $post['main_image']; ?> " alt=""></td>
                                            <td>
                                                <button type="button" class="btn btn-success btn-sm waves-effect" data-toggle="modal" data-target="#edit-Modal_<?php echo $post['id']; ?>"> تعديل <i class='fa fa-pen'></i> </button>
                                                <a href="main.php?dir=posts&page=delete&post_id=<?php echo $post['id']; ?>" class="confirm btn btn-danger btn-sm"> حذف <i class='fa fa-trash'></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <!-- EDIT NEW CATEGORY MODAL   -->
                                        <div class="modal fade" id="edit-Modal_<?php echo $post['id']; ?>" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title"> تعديل المقال </h4>
                                                    </div>
                                                    <form method="post" action="main.php?dir=posts&page=edit" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <input type='hidden' name="post_id" value="<?php echo $post['id']; ?>">
                                                                <label for="Company-2" class="block"> عنوان القال </label>
                                                                <input id="Company-2" required name="name" type="text" class="form-control required" value="<?php echo $post['name'] ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> القسم </label>
                                                                <select name="cat_id" class='form-control select2' id="">
                                                                    <option value=""> حدد القسم </option>
                                                                    <?php
                                                                    $stmt = $connect->prepare("SELECT * FROM category_posts");
                                                                    $stmt->execute();
                                                                    $allcat = $stmt->fetchAll();
                                                                    foreach ($allcat as $cat) { ?>
                                                                        <option <?php if ($post['cat_id'] == $cat['id'])
                                                                                    echo 'selected'; ?> value="<?php echo $cat['id']; ?>">
                                                                            <?php echo $cat['name']; ?> </option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> الوصف </label>
                                                                <textarea class="summernote" style="height: 150px;" id="summernote" name="description" class="form-control"><?php echo $post['description']; ?></textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> وصف مختصر </label>
                                                                <textarea style="height: 70px;" id="Company-2" name="short_desc" class="form-control"><?php echo $post['short_desc']; ?></textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="customFile"> تعديل صورة القسم </label>
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input" id="customFile" accept='image/*' name="main_image">
                                                                    <label class="custom-file-label" for="customFile">اختر
                                                                        الصورة</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> اضافة التاج <span class="badge badge-danger"> من فضلك افصل بين كل تاج والاخر (,) </span> </label>
                                                                <input required id="Company-2" name="tags" type="text" class="form-control" value="<?php echo $post['tags']; ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> نشر المقال </label>
                                                                <select name="publish" id="" class="form-control select2">
                                                                    <option value=""> اختر الحالة </option>
                                                                    <option <?php if ($post['publish'] == 1) echo 'selected'; ?> value="1"> نشر المقال </option>
                                                                    <option <?php if ($post['publish'] == 0) echo 'selected'; ?> value="0"> ارشيف </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" name="edit_cat" class="btn btn-primary waves-effect waves-light "> تعديل
                                                            </button>
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
                                <h4 class="modal-title"> اضافة مقال جديد </h4>
                            </div>
                            <form action="main.php?dir=posts&page=add" method="post" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> العنوان </label>
                                        <input required id="Company-2" name="name" type="text" class="form-control required">
                                    </div>
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> القسم </label>
                                        <select name="cat_id" class='form-control select2' id="">
                                            <option value=""> حدد القسم </option>
                                            <?php
                                            $stmt = $connect->prepare("SELECT * FROM category_posts");
                                            $stmt->execute();
                                            $allcat = $stmt->fetchAll();
                                            foreach ($allcat as $cat) { ?>
                                                <option value="<?php echo $cat['id']; ?>"> <?php echo $cat['name']; ?>
                                                </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> الوصف </label>
                                        <textarea class="summernote" style="height: 150px;" id="summernote" name="description" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> وصف مختصر </label>
                                        <textarea style="height: 70px;" id="Company-2" name="short_desc" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="customFile"> صورة المقال </label>
                                        <div class="custom-file">
                                            <input required type="file" class="dropify" id="customFile" accept='image/*' name="main_image">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> اضافة التاج <span class="badge badge-danger"> من فضلك افصل بين كل تاج والاخر (,) </span> </label>
                                        <input required id="Company-2" name="tags" type="text" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> نشر المقال </label>
                                        <select name="publish" id="" class="form-control select2">
                                            <option value=""> اختر الحالة </option>
                                            <option value="1"> نشر المقال </option>
                                            <option value="0"> ارشيف </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="add_cat" class="btn btn-primary waves-effect waves-light "> حفظ </button>
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