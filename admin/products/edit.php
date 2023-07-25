<?php
if (isset($_GET['pro_id']) && is_numeric($_GET['pro_id'])) {
    $pro_id = $_GET['pro_id'];
    if (isset($_POST['edit_pro'])) {
        $formerror = [];
        $cat_id = $_POST['cat_id'];
        $more_cat = $_POST['more_cat'];
        $more_cat_string = implode(',', (array) $more_cat);
        $name = $_POST['name'];
        $slug = createSlug($name);
        $description = $_POST['description'];
        $short_desc = $_POST['short_desc'];
        $product_adv = $_POST['product_adv'];
        $price = $_POST['price'];
        $purchase_price = $_POST['purchase_price'];
        $sale_price = $_POST['sale_price'];
        $av_num = $_POST['av_num'];
        $pro_attributes = $_POST['pro_attribute'];
        $pro_variations = $_POST['pro_variations'];
        $pro_prices = $_POST['pro_price'];
        $tags = $_POST['tags'];
        $publish = $_POST['publish'];
        $related_product = $_POST['related_product'];
        $related_product_string = implode(',', (array) $related_product);
        if (isset($_POST['main_checked'])) {
            $main_checked = $_POST['main_checked'];
        } else {
            $main_checked = 'image';
        }


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
                    move_uploaded_file(
                        $main_image_temp,
                        'product_images/' . $main_image_uploaded
                    );
                } else {
                    $main_image_uploaded = $main_image_name;
                    move_uploaded_file(
                        $main_image_temp,
                        'product_images/' . $main_image_uploaded
                    );
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
        if (empty($price)) {
            $formerror[] = ' من فضلك ادخل سعر المنتج   ';
        }
        if (empty($cat_id)) {
            $formerror[] = ' من فضلك ادخل قسم المنتج   ';
        }
        if (empty($formerror)) {
            $stmt = $connect->prepare("UPDATE products SET cat_id=?,more_cat=?,name=?, slug=? , description=?,short_desc=?,product_adv=?,main_checked=?,purchase_price=?,
        price=?,sale_price=?,av_num=?,tags=?,related_product=?,publish=? WHERE id = ? ");
            $stmt->execute(array(
                $cat_id, $more_cat_string,  $name, $slug, $description, $short_desc,
                $product_adv,  $main_checked, $purchase_price, $price,
                $sale_price,  $av_num,  $tags, $related_product_string, $publish, $pro_id
            ));
            // UPDATE Main Images To db 

            $stmt = $connect->prepare("UPDATE products_image SET  image_name=?, image_alt=? , image_desc=?,image_keys=? WHERE product_id = ? ");
            $stmt->execute(array($image_name, $image_alt, $image_desc, $image_keys, $pro_id));
            if (!empty($_FILES['main_image']['name'])) {
                $stmt = $connect->prepare("UPDATE products_image SET main_image=? WHERE product_id = ? ");
                $stmt->execute(array(
                    $main_image_uploaded, $pro_id
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
                        move_uploaded_file(
                            $image_temp,
                            'product_images/' . $main_image_uploaded
                        );
                    } else {
                        $main_image_uploaded = $image_name;
                        move_uploaded_file(
                            $image_temp,
                            'product_images/' . $main_image_uploaded
                        );
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
            $stmt = $connect->prepare("DELETE FROM product_details WHERE pro_id = ?");
            $stmt->execute(array($pro_id));
            if (isset($pro_attributes)) {

                for ($i = 0; $i < count($pro_attributes); $i++) {
                    $pro_attribute =   $pro_attributes[$i];
                    $pro_price =  $pro_prices[$i];
                    $var_id = $pro_variations[$i];
                    $stmt = $connect->prepare("INSERT INTO product_details (pro_id,pro_attribute,pro_variation,pro_price) VALUES 
            (:zpro_id,:zpro_att,:zpro_var,:zpro_price)");
                    $stmt->execute(array(
                        "zpro_id" => $pro_id,
                        "zpro_att" => $pro_attribute,
                        "zpro_var" => $var_id,
                        "zpro_price" => $pro_price,
                    ));
                }
            }
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
                }
                header('Location:main?dir=products&page=report');
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
                    <div class="col-md-6">
                        <div class="card card-primary">
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
                                    <label for="description"> وصف مختصر </label>
                                    <textarea id="short_desc" name="short_desc" class="form-control" rows="2"><?php if (isset($_REQUEST['short_desc'])) {
                                                                                                                    echo $_REQUEST['short_desc'];
                                                                                                                } else {
                                                                                                                    echo $pro_data['short_desc'];
                                                                                                                } ?></textarea>
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
                                                    }  ?> value="<?php echo $cat['id']; ?>"> <?php echo $cat['name'] ?> </option>
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
                                        <label for="inputStatus"> اقسام اخري </label>
                                        <select id="" class="form-control custom-select select2" name="more_cat[]" multiple>
                                            <?php
                                            $stmt = $connect->prepare("SELECT * FROM categories");
                                            $stmt->execute();
                                            $allcat = $stmt->fetchAll();
                                            foreach ($allcat as $cat) {
                                            ?>
                                                <option <?php if (in_array($cat['id'], $pro_more_cat)) echo 'selected'; ?> value="<?php echo $cat['id']; ?>"> <?php echo $cat['name'] ?> </option>
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
                                                <option <?php if (isset($_REQUEST['more_cat']) && $_REQUEST['more_cat'] == $cat['id']) echo "selected"; ?> value="<?php echo $cat['id']; ?>"> <?php echo $cat['name'] ?> </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    <?php
                                    }
                                    ?>
                                </div>

                                <div id="attributes-containerxx">
                                    <?php
                                    $uniqueId = uniqid();
                                    ?>
                                    <div class="attribute-group">
                                        <div class="form-group">
                                            <br>
                                            <label for="inputStatus">اختر السمة</label>
                                            <?php
                                            $stmt = $connect->prepare("SELECT * FROM product_details WHERE pro_id = ?");
                                            $stmt->execute(array($pro_id));
                                            $allattributs = $stmt->fetchAll();
                                            $count_attribute = count($allattributs);
                                            if ($count_attribute > 0) {
                                                foreach ($allattributs as $pro_attribute_detail) { ?>
                                                    <select class="form-control custom-select select2 pro-attribute" name="pro_attribute[]" data-new=<?php echo $uniqueId; ?> data-uniqueId="<?php echo $uniqueId; ?>">
                                                        <option selected disabled>-- اختر --</option>
                                                        <?php
                                                        $stmt = $connect->prepare("SELECT * FROM product_attribute");
                                                        $stmt->execute();
                                                        $allatt = $stmt->fetchAll();
                                                        foreach ($allatt as $index => $att) {
                                                            $selected = (isset($_REQUEST['pro_attribute']) && in_array($att['id'], $_REQUEST['pro_attribute'])) ? 'selected' : '';
                                                        ?>
                                                            <option <?php if ($pro_attribute_detail['pro_attribute'] == $att['id']) echo "selected"; ?> value="<?php echo $att['id']; ?> <?php echo $selected ?>"> <?php echo $att['name'] ?> </option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputStatus">المتغيرات</label>
                                            <select class="form-control custom-select select2 pro-variation" name="pro_variations[]" data-uniqueId="<?php echo $uniqueId; ?>">
                                                <option disabled>-- اختر --</option>
                                                <option value="<?php echo $pro_attribute_detail['pro_variation']; ?>">
                                                    <?php
                                                    $stmt = $connect->prepare("SELECT * FROM product_variations WHERE id = ?");
                                                    $stmt->execute(array($pro_attribute_detail['pro_variation']));
                                                    $pro_vartion_details = $stmt->fetch();
                                                    echo $pro_vartion_details['name']; ?></option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputName">سعر جديد </label>
                                            <input type="number" id="pro_price" name="pro_price[]" class="form-control" value="<?php echo $pro_attribute_detail['pro_price'] ?>">
                                        </div>
                                    <?php
                                                }
                                            } else {
                                    ?>
                                    <select class="form-control custom-select select2 pro-attribute" name="pro_attribute[]" data-new=<?php echo $uniqueId; ?> data-uniqueId="<?php echo $uniqueId; ?>">
                                        <option selected disabled>-- اختر --</option>
                                        <?php
                                                $stmt = $connect->prepare("SELECT * FROM product_attribute");
                                                $stmt->execute();
                                                $allatt = $stmt->fetchAll();
                                                foreach ($allatt as $index => $att) {
                                                    $selected = (isset($_REQUEST['pro_attribute']) && in_array($att['id'], $_REQUEST['pro_attribute'])) ? 'selected' : '';
                                                    echo '<option value="' . $att['id'] . '" ' . $selected . '>' . $att['name'] . '</option>';
                                                }
                                        ?>
                                    </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputStatus">المتغيرات</label>
                                        <select class="form-control custom-select select2 pro-variation" name="pro_variations[]" data-uniqueId="<?php echo $uniqueId; ?>">
                                            <option disabled>-- اختر --</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputName">سعر جديد </label>
                                        <input type="number" id="pro_price" name="pro_price[]" class="form-control" value="<?php if (isset($_REQUEST['pro_price'])) echo $_REQUEST['pro_price'] ?>">
                                    </div>
                                <?php
                                            }
                                ?>

                                </div>
                            </div>
                            <p class="btn btn-warning btn-sm" id="add_attribute_btn"> اضافة سمه جديد <i class="fa fa-plus"></i> </p>
                            <script src="plugins/jquery/jquery.js"></script>
                            <script>
                                jQuery(function($) {
                                    // استهداف زر "اضافة سمة جديدة"
                                    $(document).on('click', '#add_attribute_btn', function() {
                                        var uniqueId = Date.now(); // إنشاء معرف فريد جديد
                                        var newAttributeItem = `
                                        <div class="attribute-group">
                                        <div class="form-group">
                                            <br>
                                            <label for="inputStatus">اختر السمة</label>
                                            <select class="form-control custom-select select2 pro-attribute" name="pro_attribute[]" data-new="${uniqueId}" data-uniqueId="${uniqueId}">
                                            <option selected disabled>-- اختر --</option>
                                            <?php
                                            $stmt = $connect->prepare("SELECT * FROM product_attribute");
                                            $stmt->execute();
                                            $allatt = $stmt->fetchAll();
                                            foreach ($allatt as $index => $att) {
                                                $selected = (isset($_REQUEST['pro_attribute']) && in_array($att['id'], $_REQUEST['pro_attribute'])) ? 'selected' : '';
                                                echo '<option value="' . $att['id'] . '" ' . $selected . '>' . $att['name'] . '</option>';
                                            }
                                            ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputStatus">المتغيرات</label>
                                            <select class="form-control custom-select select2 pro-variation" name="pro_variations[]" data-uniqueId="${uniqueId}">
                                            <option disabled>-- اختر --</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputName">سعر جديد </label>
                                            <input type="number" id="pro_price" name="pro_price[]" class="form-control" value="<?php if (isset($_REQUEST['pro_price'])) echo $_REQUEST['pro_price'] ?>">
                                        </div>
                                        <button class="btn btn-sm btn-danger delete_attribute_btn"> حذف العنصر <i class='fa fa-trash'></i> </button>
                                        </div>
                                    `;
                                        $('#attributes-container').append(newAttributeItem); // إضافة العنصر الجديد إلى الصفحة
                                    });

                                    // استهداف زر "حذف العنصر"
                                    $(document).on('click', '.delete_attribute_btn', function() {
                                        $(this).closest('.attribute-group').remove(); // حذف العنصر
                                    });
                                });
                            </script>
                            <div class="new_attributes" id="attributes-container"></div>
                            <br>
                            <br>
                            <div class="form-group">
                                <label for="inputStatus"> المنتجات المرتبطة </label>
                                <?php
                                if (!empty($pro_data['related_product'])) {
                                    $related_product = $pro_data['related_product'];
                                    $related_product = explode(',', $related_product);
                                ?>
                                    <select id="" class="form-control custom-select select2" name="related_product[]" multiple>
                                        <?php
                                        $stmt = $connect->prepare("SELECT * FROM products");
                                        $stmt->execute();
                                        $allpro = $stmt->fetchAll();
                                        foreach ($allpro as $pro) {
                                        ?>
                                            <option <?php if (in_array($pro['id'], $related_product)) echo "selected"; ?> value="<?php echo $pro['id']; ?>"> <?php echo $pro['name'] ?> </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                <?php
                                } else {
                                ?>
                                    <select id="" class="form-control custom-select select2" name="related_product[]" multiple>
                                        <?php
                                        $stmt = $connect->prepare("SELECT * FROM products");
                                        $stmt->execute();
                                        $allpro = $stmt->fetchAll();
                                        foreach ($allpro as $pro) {
                                        ?>
                                            <option <?php if (isset($_REQUEST['related_product']) && $_REQUEST['related_product'] == $pro['id']) echo "selected"; ?> value="<?php echo $pro['id']; ?>"> <?php echo $pro['name'] ?> </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                <?php
                                }
                                ?>
                            </div>
                            <div class="form-group">
                                <label for="inputStatus"> خصائص المنتج </label>
                                <select id="" class="form-control custom-select select2" name="plants_options[]" multiple>
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
                                                <option <?php if ($props_plant['option_id'] == $option['id']) echo "selected"; ?> value="<?php echo $option['id']; ?>"> <?php echo $option['name'] ?> </option>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <option <?php if (isset($_REQUEST['plants_options']) && $_REQUEST['plants_options'] == $option['id']) echo "selected"; ?> value="<?php echo $option['id']; ?>"> <?php echo $option['name'] ?> </option>

                                        <?php
                                        }
                                        ?>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-md-6">
                    <div class="card card-secondary">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="inputEstimatedBudget"> سعر الشراء </label>
                                <input required type="number" id="purchase_price" name="purchase_price" class="form-control" value="<?php if (isset($_REQUEST['purchase_price'])) {
                                                                                                                                        echo $_REQUEST['purchase_price'];
                                                                                                                                    } else {
                                                                                                                                        echo $pro_data['purchase_price'];
                                                                                                                                    } ?>">
                            </div>
                            <div class="form-group">
                                <label for="inputEstimatedBudget"> سعر البيع </label>
                                <input required type="number" id="price" name="price" class="form-control" value="<?php if (isset($_REQUEST['price'])) {
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
                                                                                                                    }  ?>">
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
                                <label for="description"> الوصف </label>
                                <textarea id="summernote" name="description" class="form-control" rows="4"><?php if (isset($_REQUEST['description'])) {
                                                                                                                echo $_REQUEST['description'];
                                                                                                            } else {
                                                                                                                echo $pro_data['description'];
                                                                                                            }  ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="product_adv"> مميزات المنتج <span style="color: #c0392b; font-size: 14px;"> [ افصل بين كل ميزة والاخري ب (,) ] </span> </label>
                                <textarea id="product_adv" name="product_adv" class="form-control" rows="4"><?php if (isset($_REQUEST['product_adv'])) {
                                                                                                                echo $_REQUEST['product_adv'];
                                                                                                            } else {
                                                                                                                echo $pro_data['product_adv'];
                                                                                                            }  ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="customFile">تعديل صورة المنتج </label>
                                <div class="custom-file">
                                    <!-- Get Product Image -->
                                    <?php
                                    $stmt = $connect->prepare("SELECT * FROM products_image WHERE product_id = ?");
                                    $stmt->execute(array($pro_id));
                                    $product_image_data = $stmt->fetch();
                                    ?>
                                    <input type="file" class="dropify" multiple data-height="150" data-allowed-file-extensions="jpg jpeg png svg webp" data-max-file-size="4M" name="main_image" data-show-loader="true" />
                                    <br>
                                    <p class="btn btn-warning btn-sm" id="show_details_image"> تفاصيل اضافية <i class="fa fa-plus"></i> </p>
                                    <style>
                                        .image_details {
                                            display: none;
                                        }
                                    </style>
                                    <div class="image_details">
                                        <br>
                                        <input value="<?php echo $product_image_data['image_name']; ?>" type="text" class="form-control" name="image_name" placeholder="اسم الصورة">
                                        <br>
                                        <input value="<?php echo $product_image_data['image_alt']; ?>" type="text" class="form-control" name="image_alt" placeholder="الاسم البديل">
                                        <br>
                                        <input value="<?php echo $product_image_data['image_desc']; ?>" type="text" class="form-control" name="image_desc" placeholder="وصف مختصر ">
                                        <br>
                                        <input value="<?php echo $product_image_data['image_keys']; ?>" type="text" class="form-control" name="image_keys" placeholder=" كلمات مفتاحية للصورة  ">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="customFile"> تعديل فيديو المنتج </label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="customFile" accept='video/*' name="video">
                                    <label class="custom-file-label" for="customFile"> حمل الفيديو </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for=""> الرئيسي </label>
                                <div class="form-check">
                                    <input class="form-check-input" value="image" type="radio" name="main_checked" id="flexRadioDefault1" <?php if ($pro_data['main_checked'] == 'image') echo "checked"; ?>>
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        صورة المنتج
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" value="video" type="radio" name="main_checked" id="flexRadioDefault2" <?php if ($pro_data['main_checked'] == 'video') echo "checked"; ?>>
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        الفيديو
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <p class="btn btn-primary btn-sm" id="add_to_gallary"> اضافة صورة جديدة للمعرض <i class="fa fa-plus"></i> </p>
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
                            <div></div>
                            <div class="form-group">
                                <label for="Company-2" class="block"> التاج <span class="badge badge-danger"> من فضلك افصل بين كل تاج والاخر (,) </span> </label>
                                <input required id="Company-2" name="tags" type="text" class="form-control" value="<?php echo $pro_data['tags']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="Company-2" class="block"> نشر المنتج </label>
                                <select name="publish" id="" class="form-control select2">
                                    <option value="" disabled> اختر الحالة </option>
                                    <option <?php if ($pro_data['publish'] == 1) echo 'selected'; ?> value="1"> نشر المنتج </option>
                                    <option <?php if ($pro_data['publish'] == 0) echo 'selected'; ?> value="0"> ارشيف </option>
                                </select>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
        </div>

        <div class="row" style="display: flex;justify-content: space-between;">
            <button type="submit" class="btn btn-primary" name="edit_pro"> <i class="fa fa-save"></i> حفظ التعديلات </button>
            <a href="main.php?dir=products&page=report" class="btn btn-secondary">رجوع <i class="fa fa-backward"></i> </a>
        </div>
        </form>
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
                            <a target='_blank' href="product_images/<?php echo $product_image_data['main_image']; ?>" data-toggle="lightbox" data-title="sample 2 - black">
                                <img style="max-width: 100%;" src="product_images/<?php echo $product_image_data['main_image'];  ?>" class="img-fluid mb-2" alt="الرئيسية" />
                            </a>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="info">
                            <h6> المعرض </h6>
                            <div class="row">
                                <?php
                                foreach ($progallary as $gallary) {
                                ?>
                                    <div class="col-3">
                                        <div class="">
                                            <a target='_blank' href="product_images/<?= $gallary['image'] ?>" data-toggle="lightbox" data-title="sample 2 - black">
                                                <img style="max-width: 100%;" src="product_images/<?= $gallary['image'] ?>" class="img-fluid mb-2" alt="المعرض" />
                                            </a>
                                            <form action="" method="post">
                                                <a href="main.php?dir=products&page=delete_image&image_gallary=<?php echo $gallary['id']; ?>&pro_id=<?php echo $pro_id; ?>" style="text-align: center;margin: auto;display: block;width: 25px;height: 25px;border-radius: 50%;" class="btn btn-danger" type="submit"> <i class="fa fa-close"></i> </a>
                                            </form>
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
        <br>
        </div>
        <!-- /.container-fluid -->
    </section>
<?php
} else {
    header('Location:main.php?dir=products&page=report');
    exit();
}
