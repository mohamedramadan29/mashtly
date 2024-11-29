<?php
$post_id = $_GET['post_id'];
$stmt = $connect->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->execute(array($post_id));
$post = $stmt->fetch();
if (isset($_POST['edit_cat'])) {
    $post_id = $_POST['post_id'];
    $cat_id = $_POST['cat_id'];
    $name = $_POST['name'];
    $slug = createSlug($name);
    $short_desc = $_POST['short_desc'];
    $description = $_POST['description'];
    $description2 = $_POST['description2'];
    $publish = $_POST['publish'];
    $tags = $_POST['tags'];
    /////////
    $image_name = $_POST['image_name'];
    $image_alt = $_POST['image_alt'];
    $image_desc = $_POST['image_desc'];
    $image_keys = $_POST['image_keys'];
    // get the  date
    date_default_timezone_set('Asia/Riyadh');
    $date = date('d/m/Y h:i a');
    $formerror = [];
    if (empty($name)) {
        $formerror[] = 'من فضلك ادخل اسم المقال';
    }
    // main image
    if (!empty($_FILES['main_image']['name'])) {
        $main_image_name = $_FILES['main_image']['name'];
        $main_image_name = str_replace(' ', '-', $main_image_name);
        $main_image_temp = $_FILES['main_image']['tmp_name'];
        $main_image_type = $_FILES['main_image']['type'];
        $main_image_size = $_FILES['main_image']['size'];
        // حصل على امتداد الصورة من اسم الملف المرفوع
        $image_extension = pathinfo($main_image_name, PATHINFO_EXTENSION);
        if (!empty($image_name)) {
            $image_name = str_replace(' ', '-', $image_name);
            $main_image_uploaded = $image_name . '.' . $image_extension;
            $upload_path = 'posts/images/' . $main_image_uploaded;
            // حفظ ملف الصورة المرفوع
            move_uploaded_file($main_image_temp, $upload_path);

            // تحقق من نوع الصورة وتحويلها إلى WebP إذا كان ذلك ممكنًا
            if (exif_imagetype($upload_path) === IMAGETYPE_JPEG) {
                $image = imagecreatefromjpeg($upload_path);
            } elseif (exif_imagetype($upload_path) === IMAGETYPE_PNG) {
                // افتح الصورة PNG
                $image = imagecreatefrompng($upload_path);

                // إنشاء نسخة Truecolor فارغة لتحويل الصورة إليها
                $truecolor_image = imagecreatetruecolor(imagesx($image), imagesy($image));

                // نسخ الصورة إلى النسخة Truecolor
                imagecopy($truecolor_image, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));

                // حدد مسار حفظ ملف الصورة بتنسيق WebP
                $webp_path = 'posts/images/' . pathinfo($main_image_uploaded, PATHINFO_FILENAME) . '.webp';

                // قم بحفظ الصورة كملف WebP
                imagewebp($truecolor_image, $webp_path);

                // حرر الذاكرة
                imagedestroy($image);
                imagedestroy($truecolor_image);

                // قم بتحديث المسار الذي تم تحميل الصورة إليه ليكون بامتداد .webp
                $main_image_uploaded = pathinfo($main_image_uploaded, PATHINFO_FILENAME) . '.webp';
            }
        } else {
            $main_image_uploaded = $main_image_name;
            $upload_path = 'posts/images/' . $main_image_uploaded;
            // حفظ ملف الصورة المرفوع
            move_uploaded_file($main_image_temp, $upload_path);

            // تحقق من نوع الصورة وتحويلها إلى WebP إذا كان ذلك ممكنًا
            if (exif_imagetype($upload_path) === IMAGETYPE_JPEG) {
                $image = imagecreatefromjpeg($upload_path);
            } elseif (exif_imagetype($upload_path) === IMAGETYPE_PNG) {
                // افتح الصورة PNG
                $image = imagecreatefrompng($upload_path);

                // إنشاء نسخة Truecolor فارغة لتحويل الصورة إليها
                $truecolor_image = imagecreatetruecolor(imagesx($image), imagesy($image));

                // نسخ الصورة إلى النسخة Truecolor
                imagecopy($truecolor_image, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));

                // حدد مسار حفظ ملف الصورة بتنسيق WebP
                $webp_path = 'posts/images/' . pathinfo($main_image_uploaded, PATHINFO_FILENAME) . '.webp';
                // قم بحفظ الصورة كملف WebP
                imagewebp($truecolor_image, $webp_path);
                // حرر الذاكرة
                imagedestroy($image);
                imagedestroy($truecolor_image);
                // قم بتحديث المسار الذي تم تحميل الصورة إليه ليكون بامتداد .webp
                $main_image_uploaded = pathinfo($main_image_uploaded, PATHINFO_FILENAME) . '.webp';
            }
        }
    } elseif ($image_name != '') {
    }

    $stmt = $connect->prepare("SELECT * FROM posts WHERE name=? AND id !=?");
    $stmt->execute(array($name, $post_id));
    $count = $stmt->rowCount();
    if ($count > 0) {
        $formerror[] = ' اسم المقال موجود من قبل من فضلك ادخل اسم اخر  ';
    }
    if (empty($formerror)) {
        // get the category name

        $stmt = $connect->prepare("SELECT * FROM category_posts WHERE id = ?");
        $stmt->execute(array($cat_id));
        $cat_data = $stmt->fetch();
        $cat_name = $cat_data['name'];
        try {
            $stmt = $connect->prepare("UPDATE posts SET name=?,cat_id=?,slug=?,short_desc=?,description=?,description2=?,tags=?,image_name=?,image_alt=?,image_desc=?,image_keys=?,category=?,date=?,publish=?,updated_at = NOW() WHERE id = ? ");
            $stmt->execute(array($name, $cat_id, $slug, $short_desc, $description, $description2, $tags, $image_name, $image_alt, $image_desc, $image_keys, $cat_name, $date, $publish, $post_id));
            if ($stmt) {
                // استدعاء رابط تحديث السايت ماب
                $sitemap_url = 'https://www.mshtly.com/admin/main.php?dir=sitemap&page=sitemap';
                file_get_contents($sitemap_url);

                // $_SESSION['success_message'] = "تم التعديل بنجاح ";
                // header('Location:main.php?dir=posts&page=edit&post_id=' . $post_id);
                // exit();


                $_SESSION['success_message'] = "تم التعديل بنجاح ";
                header('Location:main.php?dir=posts&page=edit&post_id=' . $post_id);
                exit();
            }
        } catch (\Exception $e) {
            echo $e;
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main.php?dir=posts&page=edit&post_id=' . $post_id);
        exit();
    }
}
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> تعديل المقال </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> تعديل المقال </li>
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
                            <form method="post" action="" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <input type='hidden' name="post_id" value="<?php echo $post['id']; ?>">
                                        <label for="Company-2" class="block"> عنوان القال </label>
                                        <input id="Company-2" required name="name" type="text" class="form-control required" value="<?php echo $post['name'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> القسم </label>
                                        <select required name="cat_id" class='form-control select2' id="">
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
                                        <textarea class="form-control tinymce" style="height: 150px;" name="description" class="form-control"><?php echo $post['description']; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> تكملة الوصف </label>
                                        <textarea class="tinymce form-control" style="height: 150px;" name="description2" class="form-control"><?php echo $post['description2']; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> وصف مختصر </label>
                                        <textarea style="height: 70px;" id="Company-2" name="short_desc" class="form-control"><?php echo $post['short_desc']; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="customFile"> تعديل صورة القسم </label>
                                        <div class="custom-file">
                                            <input value="<?php echo $post['main_image']; ?>" type="file" class="custom-file-input" id="customFile" accept='image/*' name="main_image">
                                            <label class="custom-file-label" for="customFile">اختر
                                                الصورة</label>
                                            <img width="80px" class="img-bordered img-thumbnail product-img" src="posts/images/<?php echo $post['main_image']; ?>" alt="">
                                            <br>
                                            <br>
                                        </div>
                                        <p class="btn btn-warning btn-sm" id="show_details_image"> تفاصيل اضافية <i class="fa fa-plus"></i> </p>
                                        <style>
                                            .image_details {
                                                display: none;
                                            }
                                        </style>
                                        <div class="image_details">
                                            <br>
                                            <input type="text" class="form-control" name="image_name" placeholder="اسم الصورة" value="<?php echo $post['image_name']; ?>">
                                            <br>
                                            <input type="text" class="form-control" name="image_alt" placeholder="الاسم البديل" value="<?php echo $post['image_alt']; ?>">
                                            <br>
                                            <input type="text" class="form-control" name="image_desc" placeholder="وصف مختصر " value="<?php echo $post['image_desc']; ?>">
                                            <br>
                                            <input type="text" class="form-control" name="image_keys" placeholder=" كلمات مفتاحية للصورة  " value="<?php echo $post['image_keys']; ?>">
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
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
</section>