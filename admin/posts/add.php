<?php
if (isset($_POST['add_cat'])) {
    $name = $_POST['name'];
    $cat_id = $_POST['cat_id'];
    $slug = createSlug($name);
    $short_desc = $_POST['short_desc'];
    $description = $_POST['description'];
    $description2 = $_POST['description2'];
    $publish = $_POST['publish'];
    $tags = $_POST['tags'];
    $image_name = $_POST['image_name'];
    $image_alt = $_POST['image_alt'];
    $image_desc = $_POST['image_desc'];
    $image_keys = $_POST['image_keys'];
    if (isset($_SESSION['writer'])) {
        $writer_id = $_SESSION['writer'];
    } else {
        $writer_id = '';
    }
    // get the  date
    date_default_timezone_set('Asia/Riyadh');
    $date = date('d/m/Y h:i a');
    $formerror = [];
    if (empty($name)) {
        $formerror[] = 'من فضلك ادخل اسم المقال ';
    }
    ////////////////////////////////////// Insert Main Image 

    // main image
    if (empty($formerror)) {
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
        } else {
            $formerror[] = ' من فضلك ادخل صورة  المنتج   ';
        }
    }


    $stmt = $connect->prepare("SELECT * FROM posts WHERE name = ?");
    $stmt->execute(array($name));
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

        $stmt = $connect->prepare("INSERT INTO posts (cat_id,name,slug,main_image,image_name,image_alt,image_desc,image_keys,category,short_desc,description,description2,tags,date,publish,writer_id,updated_at)
        VALUES (:zcat_id,:zname,:zslug,:zimage,:zimage_name,:zimage_alt,:zimage_desc,:zimage_keys,:zcategory,:zshort_desc,:zdesc,:zdesc2,:ztags,:zdate,:zpublish,:zwriter_id,NOW())");
        $stmt->execute(array(
            "zcat_id" => $cat_id,
            "zname" => $name,
            "zslug" => $slug,
            "zimage" => $main_image_uploaded,
            "zimage_name" => $image_name,
            "zimage_alt" => $image_alt,
            "zimage_desc" => $image_desc,
            "zimage_keys" => $image_keys,
            "zcategory" => $cat_name,
            "zshort_desc" => $short_desc,
            "zdesc" => $description,
            'zdesc2' => $description2,
            "ztags" => $tags,
            "zdate" => $date,
            "zpublish" => $publish,
            'zwriter_id' => $writer_id,
        ));
        if ($stmt) {
            // استدعاء رابط تحديث السايت ماب
            $sitemap_url = 'https://www.mshtly.com/admin/main.php?dir=sitemap&page=sitemap';
            file_get_contents($sitemap_url);
            $_SESSION['success_message'] = " تمت الأضافة بنجاح  ";
            header('Location:main?dir=posts&page=add');
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=posts&page=add');
        exit();
    }
} ?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> أضافة مقال جديد </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> أضافة مقال جديد </li>
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
                                    <textarea style="height: 150px;" name="description" class="form-control tinymce"></textarea>
                                </div>



                                <div class="form-group">
                                    <label for="Company-2" class="block"> تكلمة الوصف </label>
                                    <textarea class="tinymce form-control" style="height: 150px;" name="description2" class="form-control"></textarea>
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
                                <p class="btn btn-warning btn-sm" id="show_details_image"> تفاصيل اضافية <i class="fa fa-plus"></i> </p>
                                <style>
                                    .image_details {
                                        display: none;
                                    }
                                </style>
                                <div class="image_details">
                                    <br>
                                    <input type="text" class="form-control" name="image_name" placeholder="اسم الصورة">
                                    <br>
                                    <input type="text" class="form-control" name="image_alt" placeholder="الاسم البديل">
                                    <br>
                                    <input type="text" class="form-control" name="image_desc" placeholder="وصف مختصر ">
                                    <br>
                                    <input type="text" class="form-control" name="image_keys" placeholder=" كلمات مفتاحية للصورة  ">
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
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>