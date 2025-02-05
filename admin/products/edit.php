<?php
if (isset($_GET['pro_id']) && is_numeric($_GET['pro_id'])) {
    $pro_id = $_GET['pro_id'];
    if (isset($_POST['edit_pro'])) {
        try {
            $formerror = [];
            $cat_id = $_POST['cat_id'];
            $more_cat = $_POST['more_cat'];
            $more_cat_string = implode(',', (array) $more_cat);
            $name = $_POST['name'];
            //$slug = createSlug($name);
            $description = $_POST['description'];
            $short_desc = $_POST['short_desc'];
            $price = $_POST['price'];
            $purchase_price = $_POST['purchase_price'];
            $sale_price = $_POST['sale_price'];
            $av_num = $_POST['av_num'];
            $public_tail = $_POST['public_tail'];
            $tags = $_POST['tags'];
            $publish = $_POST['publish'];
            $related_product = $_POST['related_product'];
            $meta_title = $_POST['meta_title'];
            $new_description_status = $_POST['new_description_status'];
            $related_product_string = implode(',', (array) $related_product);
            if (isset($_POST['main_checked'])) {
                $main_checked = $_POST['main_checked'];
            } else {
                $main_checked = 'image';
            }
            $ship_weight = $_POST['ship_weight'];
            $ship_tail = $_POST['ship_tail'];
            $more_info = $_POST['more_info'];
            // plant options 
            $plants_options = $_POST['plants_options'];
            /**
             * More Attribute For Main Image
             */
            $image_name = $_POST['image_name'];
            $image_alt = $_POST['image_alt'];
            $image_desc = $_POST['image_desc'];
            $image_keys = $_POST['image_keys'];
            $stmt = $connect->prepare("SELECT * FROM products WHERE slug = ? AND id !=?");
            $stmt->execute(array($slug, $pro_id));
            $count = $stmt->rowCount();
            if ($count > 0) {
                $formerror[] = ' اسم المنتج موجود من قبل من فضلك ادخل اسم اخر  ';
            }
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
                    $upload_path = '../uploads/products/' . $main_image_uploaded;
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
                        $webp_path = '../uploads/products/' . pathinfo($main_image_uploaded, PATHINFO_FILENAME) . '.webp';

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
                    $upload_path = '../uploads/products/' . $main_image_uploaded;
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
                        $webp_path = '../uploads/products/' . pathinfo($main_image_uploaded, PATHINFO_FILENAME) . '.webp';

                        // قم بحفظ الصورة كملف WebP
                        imagewebp($truecolor_image, $webp_path);

                        // حرر الذاكرة
                        imagedestroy($image);
                        imagedestroy($truecolor_image);

                        // قم بتحديث المسار الذي تم تحميل الصورة إليه ليكون بامتداد .webp
                        $main_image_uploaded = pathinfo($main_image_uploaded, PATHINFO_FILENAME) . '.webp';
                    }
                }
            }


            // Insert Product Gallary
            if (!empty($_FILES['more_images']['name'])) {
                $image_names = $_POST['image_name_gallary'];
                $image_alts = $_POST['image_alt_gallary'];
                $image_descs = $_POST['image_desc_gallary'];
                $image_keyss = $_POST['image_keys_gallary'];
                $total_images = count($_FILES['more_images']['name']);
            } else {
                $total_images = 0;
            }
            // main video
            if (empty($formerror)) {
                if (!empty($_FILES['video']['name'])) {
                    $video_name = $_FILES['video']['name'];
                    $video_temp = $_FILES['video']['tmp_name'];
                    $video_type = $_FILES['video']['type'];
                    $video_size = $_FILES['video']['size'];
                    $video_uploaded = time() . '_' . $video_name;
                    move_uploaded_file(
                        $video_temp,
                        'product_videos/' . $video_uploaded
                    );
                } else {
                    $video_uploaded = '';
                }
            }
            if (empty($name)) {
                $formerror[] = ' من فضلك ادخل اسم المنتج   ';
            }

            if (empty($cat_id)) {
                $formerror[] = ' من فضلك ادخل قسم المنتج   ';
            }
            if (empty($formerror)) {
                $stmt = $connect->prepare("UPDATE products SET cat_id=?,more_cat=?,name=?, description=?,short_desc=?,main_checked=?,purchase_price=?,
        price=?,sale_price=?,av_num=?,tags=?,related_product=?,publish=?,public_tail=?,ship_weight=?,ship_tail=?,more_info=?,meta_title=?,new_description_status=? WHERE id = ? ");
                $stmt->execute(array(
                    $cat_id,
                    $more_cat_string,
                    $name,
                    $description,
                    $short_desc,
                    $main_checked,
                    $purchase_price,
                    $price,
                    $sale_price,
                    $av_num,
                    $tags,
                    $related_product_string,
                    $publish,
                    $public_tail,
                    $ship_weight,
                    $ship_tail,
                    $more_info,
                    $meta_title,
                    $new_description_status,
                    $pro_id
                ));
                // UPDATE Main Images To db 
                $stmt = $connect->prepare("SELECT * FROM products_image WHERE product_id = ?");
                $stmt->execute(array($pro_id));
                $count_pro = $stmt->rowCount();
                if ($count_pro > 0) {
                    $stmt = $connect->prepare("UPDATE products_image SET image_name=?, image_alt=? , image_desc=?,image_keys=? WHERE product_id = ? ");
                    $stmt->execute(array($image_name, $image_alt, $image_desc, $image_keys, $pro_id));
                    if (!empty($_FILES['main_image']['name'])) {
                        $stmt = $connect->prepare("UPDATE products_image SET main_image=? WHERE product_id = ? ");
                        $stmt->execute(array(
                            $main_image_uploaded,
                            $pro_id
                        ));
                    }
                } else {
                    // Insert Main Images To db 
                    $stmt = $connect->prepare("INSERT INTO products_image (product_id, main_image,image_name, image_alt , image_desc,image_keys)
                    VALUES(:zproduct_id,:zmain_image,:zimage_name,:zimage_alt, :zimage_desc,:zimage_keys)");
                    $stmt->execute(array(
                        "zproduct_id" => $pro_id,
                        "zmain_image" => $main_image_uploaded,
                        "zimage_name" => $image_name,
                        "zimage_alt" => $image_alt,
                        "zimage_desc" => $image_desc,
                        "zimage_keys" => $image_keys,
                    ));
                }
                
                // UPDATE Product Gallery To db 
                // DELETE all image Gallary AND make INSERT AGAIN
                if ($total_images > 0) {
                    for ($i = 0; $i < $total_images; $i++) {
                        $new_image_name = $image_names[$i];
                        $image_alt = $image_alts[$i];
                        $image_desc = $image_descs[$i];
                        $image_keys_gal = $image_keyss[$i];
                        $image_name = $_FILES['more_images']['name'][$i];
                        $image_name = str_replace(' ', '-', $image_name);
                        $image_temp = $_FILES['more_images']['tmp_name'][$i];
                        $image_type = $_FILES['more_images']['type'][$i];
                        $image_size = $_FILES['more_images']['size'][$i];
                        $image_extension = pathinfo($image_name, PATHINFO_EXTENSION);
                        if (!empty($new_image_name)) {
                            $new_image_name = str_replace(' ', '-', $new_image_name);
                            $main_image_uploaded = $new_image_name . '.' . $image_extension;
                            $upload_path = '../uploads/products/' . $main_image_uploaded;
                            move_uploaded_file($image_temp, $upload_path);
                            // تحقق من نوع الصورة وتحويلها إلى WebP إذا كان ذلك ممكنًا
                            if (exif_imagetype($upload_path) === IMAGETYPE_JPEG) {
                                $image = imagecreatefromjpeg($upload_path);
                            } elseif (exif_imagetype($upload_path) === IMAGETYPE_PNG) {
                                $image = imagecreatefrompng($upload_path);
                            }

                            if (isset($image)) {
                                // حدد مسار حفظ ملف الصورة بتنسيق WebP
                                $webp_path = '../uploads/products/' . pathinfo($main_image_uploaded, PATHINFO_FILENAME) . '.webp';

                                // قم بحفظ الصورة كملف WebP
                                imagewebp($image, $webp_path);

                                // حرر الذاكرة
                                imagedestroy($image);

                                // قم بتحديث المسار الذي تم تحميل الصورة إليه ليكون بامتداد .webp
                                $main_image_uploaded = pathinfo($main_image_uploaded, PATHINFO_FILENAME) . '.webp';
                            }
                        } else {
                            $main_image_uploaded = $image_name;
                            $upload_path = '../uploads/products/' . $main_image_uploaded;
                            move_uploaded_file($image_temp, $upload_path);
                            // تحقق من نوع الصورة وتحويلها إلى WebP إذا كان ذلك ممكنًا
                            if (exif_imagetype($upload_path) === IMAGETYPE_JPEG) {
                                $image = imagecreatefromjpeg($upload_path);
                            } elseif (exif_imagetype($upload_path) === IMAGETYPE_PNG) {
                                $image = imagecreatefrompng($upload_path);
                            }

                            if (isset($image)) {
                                // حدد مسار حفظ ملف الصورة بتنسيق WebP
                                $webp_path = '../uploads/products/' . pathinfo($main_image_uploaded, PATHINFO_FILENAME) . '.webp';

                                // قم بحفظ الصورة كملف WebP
                                imagewebp($image, $webp_path);

                                // حرر الذاكرة
                                imagedestroy($image);

                                // قم بتحديث المسار الذي تم تحميل الصورة إليه ليكون بامتداد .webp
                                $main_image_uploaded = pathinfo($main_image_uploaded, PATHINFO_FILENAME) . '.webp';
                            }
                        }
                        $stmt = $connect->prepare("INSERT INTO products_gallary (product_id,image,image_name, image_alt , image_desc,image_keys)
        VALUES(:zproduct_id,:zimage,:zimage_name,:zimage_alt, :zimage_desc,:zimage_keys_gal)");
                        $stmt->execute(array(
                            "zproduct_id" => $pro_id,
                            "zimage" => $main_image_uploaded,
                            "zimage_name" => $new_image_name,
                            "zimage_alt" => $image_alt,
                            "zimage_desc" => $image_desc,
                            "zimage_keys_gal" => $image_keys_gal,
                        ));
                    }
                }
                ////////////////////////////////
                // delete all old attribute and make insert agian

                // insert product plant options 
                // delete all old product_properties_plants and make insert agian
                $stmt = $connect->prepare("DELETE FROM product_properties_plants WHERE product_id = ?");
                $stmt->execute(array($pro_id));
                foreach ($plants_options as $option) {
                    $stmt = $connect->prepare("INSERT INTO product_properties_plants (product_id,option_id)
          VALUES(:zproduct_id,:zoption_id)
          ");
                    $stmt->execute(array(
                        "zproduct_id" => $pro_id,
                        "zoption_id" => $option
                    ));
                }
                if ($stmt) {
                    $_SESSION['success_message'] = " تمت التعديل  بنجاح  ";

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
                    }
                    header('Location:main?dir=products&page=edit&pro_id=' . $pro_id);
                }
            } else {
                $_SESSION['error_messages'] = $formerror;
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
        } catch (\Exception $e) {
            echo $e;
        }
    }
    ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"> تفاصيل وتعديل المنتج </h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                        <li class="breadcrumb-item active"> تفاصيل المنتج </li>
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
    <?php
    $pro_id = $_GET['pro_id'];
    $stmt = $connect->prepare("SELECT * FROM products WHERE id=?");
    $stmt->execute(array($pro_id));
    $pro_data = $stmt->fetch();
    ?>
    <section class="content">
        <div class="container-fluid">
            <form action="" method="post" enctype="multipart/form-data" autocomplete="off">
                <div class="row">
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="inputName"> الأسم </label>
                                    <input required type="text" id="name" name="name" class="form-control" value="<?php if (isset($_REQUEST['name'])) {
                                        echo $_REQUEST['name'];
                                    } else {
                                        echo $pro_data['name'];
                                    } ?>">
                                </div>
                                <div class="form-group">
                                    <label for="description"> الوصف </label>
                                    <textarea id="summernote" name="description" class="form-control" rows="4"><?php if (isset($_REQUEST['description'])) {
                                        echo $_REQUEST['description'];
                                    } else {
                                        echo $pro_data['description'];
                                    } ?></textarea>
                                </div>
                                <div class='form-group'>
                                    <label> الوصف المختصر </label>
                                    <textarea maxlength="160" name="short_desc" id="short_desc" class="form-control"
                                        rows="2" style="min-height: 120px;"><?php if (isset($_REQUEST['short_desc'])) {
                                            echo $_REQUEST['short_desc'];
                                        } else {
                                            echo $pro_data['short_desc'];
                                        } ?></textarea>
                                    <div class="badge badge-pill" id="charCount"> عدد الأحرف المتبقي: </div>
                                    <script>
                                        document.addEventListener("DOMContentLoaded", function () {
                                            var textarea = document.getElementById("short_desc");
                                            var charCountElement = document.getElementById("charCount");
                                            var maxLength = 160;
                                            textarea.addEventListener("input", function () {
                                                var currentLength = textarea.value.length;
                                                var remainingChars = maxLength - currentLength;
                                                charCountElement.textContent = "عدد الأحرف المتبقي: " + remainingChars;
                                            });
                                        });
                                    </script>
                                </div>
                                <div class="form-group">
                                    <label for="inputStatus"> القسم الرئيسي </label>
                                    <select required id="" class="form-control custom-select select2" name="cat_id">
                                        <option selected disabled> -- اختر -- </option>
                                        <?php
                                        $stmt = $connect->prepare("SELECT * FROM categories");
                                        $stmt->execute();
                                        $allcat = $stmt->fetchAll();
                                        foreach ($allcat as $cat) {
                                            ?>
                                            <option <?php if (isset($_REQUEST['cat_id']) && $_REQUEST['cat_id'] == $cat['id']) {
                                                echo "selected";
                                            } elseif ($cat['id'] == $pro_data['cat_id']) {
                                                echo 'selected';
                                            } ?> value="<?php echo $cat['id']; ?>"> <?php echo $cat['name'] ?> </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="inputStatus"> اضافة اقسام اخري </label>
                                    <?php
                                    if (!empty($pro_data['more_cat'])) {

                                        $pro_more_cat = $pro_data['more_cat'];
                                        $pro_more_cat = explode(',', $pro_more_cat);
                                        ?>
                                        <select id="" class="form-control custom-select select2" name="more_cat[]" multiple>
                                            <?php
                                            $stmt = $connect->prepare("SELECT * FROM categories");
                                            $stmt->execute();
                                            $allcat = $stmt->fetchAll();
                                            foreach ($allcat as $cat) {
                                                ?>
                                                <option <?php if (in_array($cat['id'], $pro_more_cat))
                                                    echo 'selected'; ?>
                                                    value="<?php echo $cat['id']; ?>"> <?php echo $cat['name'] ?> </option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <?php
                                    } else {
                                        ?>
                                        <select id="" class="form-control custom-select select2" name="more_cat[]" multiple>
                                            <?php
                                            $stmt = $connect->prepare("SELECT * FROM categories");
                                            $stmt->execute();
                                            $allcat = $stmt->fetchAll();
                                            foreach ($allcat as $cat) {
                                                ?>
                                                <option <?php if (isset($_REQUEST['more_cat']) && $_REQUEST['more_cat'] == $cat['id'])
                                                    echo "selected"; ?> value="<?php echo $cat['id']; ?>">
                                                    <?php echo $cat['name'] ?>
                                                </option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <?php
                                if (!empty($pro_data['related_product'])) {
                                    $related_product = $pro_data['related_product'];
                                    $related_product = explode(',', $related_product);
                                    ?>
                                    <div class="form-group">
                                        <label for="inputStatus"> المنتجات المرتبطة </label>
                                        <select id="" class="form-control custom-select select2" name="related_product[]"
                                            multiple>
                                            <?php
                                            $stmt = $connect->prepare("SELECT * FROM products");
                                            $stmt->execute();
                                            $allpro = $stmt->fetchAll();
                                            foreach ($allpro as $pro) {
                                                ?>
                                                <option <?php if (in_array($pro['id'], $related_product))
                                                    echo "selected"; ?>
                                                    value="<?php echo $pro['id']; ?>"> <?php echo $pro['name'] ?> </option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <div class="form-group">
                                        <label for="inputStatus"> المنتجات المرتبطة </label>
                                        <select id="" class="form-control custom-select select2" name="related_product[]"
                                            multiple>
                                            <?php
                                            $stmt = $connect->prepare("SELECT * FROM products");
                                            $stmt->execute();
                                            $allpro = $stmt->fetchAll();
                                            foreach ($allpro as $pro) {
                                                ?>
                                                <option <?php if (isset($_REQUEST['related_product']) && $_REQUEST['related_product'] == $pro['id'])
                                                    echo "selected"; ?>
                                                    value="<?php echo $pro['id']; ?>"> <?php echo $pro['name'] ?> </option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <?php
                                }
                                ?>
                                <div class="form-group">
                                    <label for="inputStatus"> خصائص المنتج </label>
                                    <select id="" class="form-control custom-select select2" name="plants_options[]"
                                        multiple>
                                        <?php
                                        $stmt = $connect->prepare("SELECT * FROM plant_properity_options");
                                        $stmt->execute();
                                        $alloptions = $stmt->fetchAll();
                                        foreach ($alloptions as $option) {
                                            $stmt = $connect->prepare("SELECT * FROM product_properties_plants WHERE product_id =?");
                                            $stmt->execute(array($pro_id));
                                            $count_pro = $stmt->rowCount();
                                            if ($count_pro > 0) {
                                                $product_props_plant = $stmt->fetchAll();
                                                foreach ($product_props_plant as $props_plant) {
                                                    ?>
                                                    <option <?php if ($props_plant['option_id'] == $option['id'])
                                                        echo "selected"; ?>
                                                        value="<?php echo $option['id']; ?>"> <?php echo $option['name'] ?> </option>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <option <?php if (isset($_REQUEST['plants_options']) && $_REQUEST['plants_options'] == $option['id'])
                                                    echo "selected"; ?>
                                                    value="<?php echo $option['id']; ?>"> <?php echo $option['name'] ?> </option>
                                                <?php
                                            }
                                            ?>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div>
                                    <label for="Company-2" class="block"> التاج <span class="badge badge-danger"> من فضلك
                                            افصل بين كل تاج والاخر (,) </span> </label>
                                    <input required id="Company-2" name="tags" type="text" class="form-control"
                                        value="<?php echo $pro_data['tags']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="Company-2" class="block"> meta title </label>
                                    <input required id="Company-2" name="meta_title" type="text" class="form-control"
                                        value="<?php echo $pro_data['meta_title']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="Company-2" class="block"> تفيل نظام الوصف الجديد </label>
                                    <select class="form-control" name="new_description_status">
                                        <option value="0" <?php if ($pro_data['new_description_status'] == 0)
                                            echo 'selected'; ?>> غير مفعل </option>
                                        <option value="1" <?php if ($pro_data['new_description_status'] == 1)
                                            echo 'selected'; ?>> مفعل </option>
                                    </select>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="inputEstimatedBudget"> سعر الشراء </label>
                                    <input type="number" id="purchase_price" name="purchase_price" class="form-control"
                                        value="<?php if (isset($_REQUEST['purchase_price'])) {
                                            echo $_REQUEST['purchase_price'];
                                        } else {
                                            echo $pro_data['purchase_price'];
                                        } ?>">
                                </div>
                                <div class="form-group">
                                    <label for="inputEstimatedBudget"> سعر البيع </label>
                                    <input type="number" id="price" name="price" class="form-control" value="<?php if (isset($_REQUEST['price'])) {
                                        echo $_REQUEST['price'];
                                    } else {
                                        echo $pro_data['price'];
                                    } ?>">
                                </div>
                                <div class="form-group">
                                    <label for="inputEstimatedBudget"> سعر التخفيض </label>
                                    <input type="number" id="sale_price" name="sale_price" class="form-control" value="<?php if (isset($_REQUEST['sale_price'])) {
                                        echo $_REQUEST['sale_price'];
                                    } else {
                                        echo $pro_data['sale_price'];
                                    } ?>">
                                </div>
                                <div class="form-group">
                                    <label for="inputEstimatedBudget"> العدد المتاح </label>
                                    <input type="number" id="av_num" name="av_num" class="form-control" value="<?php if (isset($_REQUEST['av_num'])) {
                                        echo $_REQUEST['av_num'];
                                    } else {
                                        echo $pro_data['av_num'];
                                    } ?>">
                                </div>
                                <div class="form-group">
                                    <label for="customFile">تعديل صورة المنتج </label>
                                    <div class="custom-file">
                                        <!-- Get Product Image -->
                                        <?php
                                        $stmt = $connect->prepare("SELECT * FROM products_image WHERE product_id = ?");
                                        $stmt->execute(array($pro_id));
                                        $product_image_data = $stmt->fetch();
                                        $count_image_data = $stmt->rowCount();
                                        ?>
                                        <input type="file" class="dropify" multiple data-height="150"
                                            data-allowed-file-extensions="jpg jpeg png svg webp" data-max-file-size="4M"
                                            name="main_image" data-show-loader="true" />
                                        <br>
                                        <p class="btn btn-warning btn-sm" id="show_details_image"> تفاصيل اضافية <i
                                                class="fa fa-plus"></i> </p>
                                        <style>
                                            .image_details {
                                                display: none;
                                            }
                                        </style>
                                        <?php
                                        if ($count_image_data > 0) {
                                            ?>
                                            <div class="image_details">
                                                <br>
                                                <input value="<?php echo $product_image_data['image_name']; ?>" type="text"
                                                    class="form-control" name="image_name" placeholder="اسم الصورة">
                                                <br>
                                                <input value="<?php echo $product_image_data['image_alt']; ?>" type="text"
                                                    class="form-control" name="image_alt" placeholder="الاسم البديل">
                                                <br>
                                                <input value="<?php echo $product_image_data['image_desc']; ?>" type="text"
                                                    class="form-control" name="image_desc" placeholder="وصف مختصر ">
                                                <br>
                                                <input value="<?php echo $product_image_data['image_keys']; ?>" type="text"
                                                    class="form-control" name="image_keys"
                                                    placeholder=" كلمات مفتاحية للصورة  ">
                                            </div>
                                            <?php
                                        } else {
                                            ?>
                                            <div class="image_details">
                                                <br>
                                                <input type="text" class="form-control" name="image_name"
                                                    placeholder="اسم الصورة">
                                                <br>
                                                <input type="text" class="form-control" name="image_alt"
                                                    placeholder="الاسم البديل">
                                                <br>
                                                <input type="text" class="form-control" name="image_desc"
                                                    placeholder="وصف مختصر ">
                                                <br>
                                                <input type="text" class="form-control" name="image_keys"
                                                    placeholder=" كلمات مفتاحية للصورة  ">
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="customFile"> تعديل فيديو المنتج </label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile" accept='video/*'
                                            name="video">
                                        <label class="custom-file-label" for="customFile"> حمل الفيديو </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for=""> الرئيسي </label>
                                    <div class="form-check">
                                        <input class="form-check-input" value="image" type="radio" name="main_checked"
                                            id="flexRadioDefault1" <?php if ($pro_data['main_checked'] == 'image')
                                                echo "checked"; ?>>
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            صورة المنتج
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" value="video" type="radio" name="main_checked"
                                            id="flexRadioDefault2" <?php if ($pro_data['main_checked'] == 'video')
                                                echo "checked"; ?>>
                                        <label class="form-check-label" for="flexRadioDefault2">
                                            الفيديو
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <p class="btn btn-primary btn-sm" id="add_to_gallary"> اضافة صورة جديدة للمعرض <i
                                            class="fa fa-plus"></i> </p>
                                </div>
                                <?php
                                // product product gallary
                                $stmt = $connect->prepare("SELECT * FROM products_gallary WHERE product_id=?");
                                $stmt->execute(array($pro_id));
                                $progallary = $stmt->fetchAll();
                                $count_gallary = count($progallary);
                                ?>
                                <div class="image_gallary">
                                </div>
                                <div class="form-group">
                                    <label for="Company-2" class="block"> نشر المنتج </label>
                                    <select name="publish" id="" class="form-control select2">
                                        <option value="" disabled> اختر الحالة </option>
                                        <option <?php if ($pro_data['publish'] == 1)
                                            echo 'selected'; ?> value="1"> نشر المنتج
                                        </option>
                                        <option <?php if ($pro_data['publish'] == 0)
                                            echo 'selected'; ?> value="0"> ارشيف
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="Company-2" class="block"> الطول لتحديد سعر الزراعه </label>
                                    <select name="public_tail" id="" class="form-control select2">
                                        <option value=""> اختر الطول </option>
                                        <?php
                                        $stmt = $connect->prepare("SELECT * FROM public_tails");
                                        $stmt->execute();
                                        $alltails = $stmt->fetchAll();
                                        foreach ($alltails as $tail) {
                                            ?>
                                            <option <?php if ($pro_data['public_tail'] == $tail['id'])
                                                echo 'selected'; ?>
                                                value="<?php echo $tail['id']; ?>"> <?php echo $tail['name']; ?> </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="ship_weight"> وزن المنتج للشحن </label>
                                    <input type="text" id="ship_weight" name="ship_weight" class="form-control" value="<?php if (isset($_REQUEST['ship_weight'])) {
                                        echo $_REQUEST['ship_weight'];
                                    } else {
                                        echo $pro_data['ship_weight'];
                                    } ?>">
                                </div>
                                <div class="form-group">
                                    <label for="ship_tail"> طول المنتج لتحديد الوزن [للشحن] </label>
                                    <input type="text" id="ship_tail" name="ship_tail" class="form-control" value="<?php if (isset($_REQUEST['ship_tail'])) {
                                        echo $_REQUEST['ship_tail'];
                                    } else {
                                        echo $pro_data['ship_tail'];
                                    } ?>">
                                </div>
                                <div class="form-group">
                                    <label for="ship_weight"> معلومات اضافية </label>
                                    <textarea name="more_info" class="form-control summernote" rows="2"><?php if (isset($_REQUEST['more_info'])) {
                                        echo $_REQUEST['more_info'];
                                    } else {
                                        echo $pro_data['more_info'];
                                    } ?></textarea>

                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.card -->
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary" name="edit_pro"> حفظ التعديلات <i
                                    class="fa fa-save"></i> </button>
                            <!--  <a href="main.php?dir=products&page=report" class="btn btn-secondary">رجوع <i class="fa fa-backward"></i> </a> -->
                        </div>
                    </div>
                </div>
            </form>
            <?php
            include "edit_vartions.php";
            ?>
            <br>
            <div class="card">
                <div class="card-header bg-primary">
                    صور المنتج
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <div class="info">
                                <h6> الرئيسية </h6>
                                <a target='_blank'
                                    href="../uploads/products/<?php echo $product_image_data['main_image']; ?>"
                                    data-toggle="lightbox" data-title="sample 2 - black">
                                    <img style="max-width: 100%;"
                                        src="../uploads/products/<?php echo $product_image_data['main_image']; ?>"
                                        class="img-fluid mb-2" alt="الرئيسية" />
                                </a>
                                <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#edit-main-image">
                                    <i class="fa fa-edit"> </i> </button>
                                <div class="modal fade" id="edit-main-image" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title"> تحرير سريع </h4>
                                            </div>
                                            <form method="POST" action="" enctype="multipart/form-data">
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <input type='hidden' name="gallary_id"
                                                            value="<?php echo $product_image_data['id']; ?>">
                                                        <input type="hidden" name="main_image_name"
                                                            value="<?php echo $product_image_data['main_image']; ?>">
                                                        <label for="Company-2" class="block"> اسم الصورة </label>
                                                        <input id="Company-2" name="image_name_gallary" type="text"
                                                            class="form-control"
                                                            value="<?php echo $product_image_data['image_name'] ?>">
                                                    </div>
                                                    <div class="form-group">

                                                        <label for="Company-2" class="block"> الأسم البديل </label>
                                                        <input id="Company-2" name="image_alt_gallary" type="text"
                                                            class="form-control"
                                                            value="<?php echo $product_image_data['image_alt'] ?>">
                                                    </div>
                                                    <div class="form-group">

                                                        <label for="Company-2" class="block"> وصف مختصر </label>
                                                        <input id="Company-2" name="image_desc_gallary" type="text"
                                                            class="form-control"
                                                            value="<?php echo $product_image_data['image_desc'] ?>">
                                                    </div>
                                                    <div class="form-group">

                                                        <label for="Company-2" class="block"> كلمات مفتاحية </label>
                                                        <input id="Company-2" name="image_keys_gallary" type="text"
                                                            class="form-control"
                                                            value="<?php echo $product_image_data['image_keys'] ?>">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" name="edit_main_image"
                                                        class="btn btn-primary waves-effect waves-light "> تعديل </button>
                                                    <button type="button" class="btn btn-default waves-effect "
                                                        data-dismiss="modal">رجوع</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="info">
                                <h6> المعرض </h6>
                                <div class="row">
                                    <?php
                                    foreach ($progallary as $gallary) {
                                        ?>
                                        <div class="col-4">
                                            <div class="">
                                                <a target='_blank' href="../uploads/products/<?= $gallary['image'] ?>"
                                                    data-toggle="lightbox" data-title="sample 2 - black">
                                                    <img style="max-width: 100%;"
                                                        src="../uploads/products/<?= $gallary['image'] ?>"
                                                        class="img-fluid mb-2" alt="المعرض" />
                                                </a>
                                                <div class="d-flex justify-content-around align-items-center">
                                                    <form action="" method="post">
                                                        <a href="main.php?dir=products&page=delete_image&image_gallary=<?php echo $gallary['id']; ?>&pro_id=<?php echo $pro_id; ?>"
                                                            style="text-align: center;margin: auto;display: block;width: 40px;height: 40px;border-radius: 50%;"
                                                            class="btn btn-danger" type="submit"> <i class="fa fa-trash"></i>
                                                        </a>
                                                    </form>
                                                    <button class="btn btn-success btn-sm" data-toggle="modal"
                                                        data-target="#edit-Modal_<?php echo $gallary['id']; ?>"> <i
                                                            class="fa fa-edit"> </i> </button>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- EDIT NEW CATEGORY MODAL   -->
                                        <div class="modal fade" id="edit-Modal_<?php echo $gallary['id']; ?>" tabindex="-1"
                                            role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title"> تحرير سريع </h4>
                                                    </div>
                                                    <form method="POST" action="" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <input type='hidden' name="gallary_id"
                                                                    value="<?php echo $gallary['id']; ?>">
                                                                <input type="hidden" name="main_image_name"
                                                                    value="<?php echo $gallary['image']; ?>">
                                                                <label for="Company-2" class="block"> اسم الصورة </label>
                                                                <input id="Company-2" name="image_name_gallary" type="text"
                                                                    class="form-control"
                                                                    value="<?php echo $gallary['image_name'] ?>">
                                                            </div>
                                                            <div class="form-group">

                                                                <label for="Company-2" class="block"> الأسم البديل </label>
                                                                <input id="Company-2" name="image_alt_gallary" type="text"
                                                                    class="form-control"
                                                                    value="<?php echo $gallary['image_alt'] ?>">
                                                            </div>
                                                            <div class="form-group">

                                                                <label for="Company-2" class="block"> وصف مختصر </label>
                                                                <input id="Company-2" name="image_desc_gallary" type="text"
                                                                    class="form-control"
                                                                    value="<?php echo $gallary['image_desc'] ?>">
                                                            </div>
                                                            <div class="form-group">

                                                                <label for="Company-2" class="block"> كلمات مفتاحية </label>
                                                                <input id="Company-2" name="image_keys_gallary" type="text"
                                                                    class="form-control"
                                                                    value="<?php echo $gallary['image_keys'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" name="edit_image_gallary"
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <br>
        <br>
        </div>
        <!-- /.container-fluid -->
    </section>
    <?php
} else {
    header('Location:main.php?dir=products&page=report');
    exit();
}
if (isset($_POST['edit_image_gallary'])) {
    $image_gal_id = $_POST['gallary_id'];
    $image_name_gallary = $_POST['image_name_gallary'];
    $new_image_name = str_replace(' ', '-', $image_name_gallary);
    $old_image_name = $_POST['main_image_name'];
    $path_info = pathinfo($old_image_name);
    // احفظ الجزء النصي من اسم الملف (بدون الامتداد)
    $file_name_without_extension = $path_info['filename'];
    // احفظ الامتداد
    $extension = $path_info['extension'];
    // قم بتشكيل الاسم الجديد مع الجزء النصي الجديد والامتداد القديم
    $new_file_name = $new_image_name . "." . $extension;


    // قم بتحديث اسم الملف في النظام الملفاتي
    $old_image_path = "../uploads/products/" . $old_image_name;
    $new_image_path = "../uploads/products/" . $new_file_name;

    if (rename($old_image_path, $new_image_path)) {
        $image_alt_gallary = $_POST['image_alt_gallary'];
        $image_desc_gallary = $_POST['image_desc_gallary'];
        $image_keys_gallary = $_POST['image_keys_gallary'];
        $stmt = $connect->prepare("UPDATE products_gallary SET image=?,image_name = ?,image_alt=?,image_desc=?,image_keys=? WHERE id =?");
        $stmt->execute(array($new_file_name, $image_name_gallary, $image_alt_gallary, $image_desc_gallary, $image_keys_gallary, $image_gal_id));
        if ($stmt) {
            header('Location:main?dir=products&page=edit&pro_id=' . $pro_id);
        }
    } else {
    }
}


//////////////////////////////////////////////

if (isset($_POST['edit_main_image'])) {
    $image_gal_id = $_POST['gallary_id'];
    $image_name_gallary = $_POST['image_name_gallary'];
    $new_image_name = str_replace(' ', '-', $image_name_gallary);
    $old_image_name = $_POST['main_image_name'];
    $path_info = pathinfo($old_image_name);
    // احفظ الجزء النصي من اسم الملف (بدون الامتداد)
    $file_name_without_extension = $path_info['filename'];
    // احفظ الامتداد
    $extension = $path_info['extension'];
    // قم بتشكيل الاسم الجديد مع الجزء النصي الجديد والامتداد القديم
    $new_file_name = $new_image_name . "." . $extension;
    // قم بتحديث اسم الملف في النظام الملفاتي
    $old_image_path = "../uploads/products/" . $old_image_name;
    $new_image_path = "../uploads/products/" . $new_file_name;
    if (rename($old_image_path, $new_image_path)) {
        $image_alt_gallary = $_POST['image_alt_gallary'];
        $image_desc_gallary = $_POST['image_desc_gallary'];
        $image_keys_gallary = $_POST['image_keys_gallary'];
        $stmt = $connect->prepare("UPDATE products_image SET main_image=?,image_name = ?,image_alt=?,image_desc=?,image_keys=? WHERE id =?");
        $stmt->execute(array($new_file_name, $image_name_gallary, $image_alt_gallary, $image_desc_gallary, $image_keys_gallary, $image_gal_id));
        if ($stmt) {
            header('Location:main?dir=products&page=edit&pro_id=' . $pro_id);
        }
    } else {
    }
}
?>
<style>
    .note-editor .note-toolbar .note-dropdown-menu,
    .note-popover .popover-content .note-dropdown-menu {
        right: 0 !important;
        left: auto !important;
        min-width: 200px !important;
    }
</style>