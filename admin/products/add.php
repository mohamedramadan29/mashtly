<?php

if (isset($_POST['add_pro'])) {
  $pro_attributes = $_POST['pro_attribute'];
  $pro_prices = $_POST['pro_price'];
  $pro_variations = $_POST['pro_variations'];

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
  $main_checked = $_POST['main_checked'];
  /**
   * More Attribute For Main Image
   */

  $image_name = $_POST['image_name'];
  $image_alt = $_POST['image_alt'];
  $image_desc = $_POST['image_desc'];
  $stmt = $connect->prepare("SELECT * FROM products WHERE slug = ?");
  $stmt->execute(array($slug));
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
    } else {
      $formerror[] = ' من فضلك ادخل صورة  المنتج   ';
    }
  }
  // Insert Product Gallary

  if (!empty($_FILES['more_images']['name'])) {
    $image_names = $_POST['image_name_gallary'];
    $image_alts = $_POST['image_alt_gallary'];
    $image_descs = $_POST['image_desc_gallary'];

    $total_images = count($_FILES['more_images']['name']);
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
    $stmt = $connect->prepare("INSERT INTO products (cat_id,more_cat,name, slug , description,short_desc,product_adv,video,main_checked,purchase_price,
    price, sale_price , av_num,tags,related_product,publish)
    VALUES (:zcat,:zmore_cat,:zname,:zslug,:zdesc,:zshort_desc,:zproduct_adv,:zvideo,:zmain_checked,:zpurchase_price,:zprice,:zsale_price,:zav_num,:ztags,:zrelated_product,:zpublish)");
    $stmt->execute(array(
      "zcat" => $cat_id,
      "zmore_cat" => $more_cat_string,
      "zname" => $name,
      "zslug" => $slug,
      "zdesc" => $description,
      "zshort_desc" => $short_desc,
      "zvideo" => $video_uploaded,
      "zmain_checked" => $main_checked,
      "zproduct_adv" => $product_adv,
      "zprice" => $price,
      "zpurchase_price" => $purchase_price,
      "zsale_price" => $sale_price,
      "zav_num" => $av_num,
      "ztags" => $tags,
      "zrelated_product" => $related_product_string,
      "zpublish" => $publish
    ));
    // get the last product
    $stmt = $connect->prepare("SELECT * FROM products ORDER BY id DESC LIMIT 1");
    $stmt->execute();
    $last_product = $stmt->fetch();
    $last_pro_id = $last_product['id'];
    // Insert Main Images To db 
    $stmt = $connect->prepare("INSERT INTO products_image (product_id, main_image,image_name, image_alt , image_desc)
    VALUES(:zproduct_id,:zmain_image,:zimage_name,:zimage_alt, :zimage_desc)");
    $stmt->execute(array(
      "zproduct_id" => $last_pro_id,
      "zmain_image" => $main_image_uploaded,
      "zimage_name" => $image_name,
      "zimage_alt" => $image_alt,
      "zimage_desc" => $image_desc,
    ));
    // Insert Product Gallery To db 
    for ($i = 0; $i < $total_images; $i++) {
      $new_image_name = $image_names[$i];
      $image_alt = $image_alts[$i];
      $image_desc = $image_descs[$i];
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
      $stmt = $connect->prepare("INSERT INTO products_gallary (product_id,image,image_name, image_alt , image_desc)
    VALUES(:zproduct_id,:zimage,:zimage_name,:zimage_alt, :zimage_desc)");
      $stmt->execute(array(
        "zproduct_id" => $last_pro_id,
        "zimage" => $main_image_uploaded,
        "zimage_name" => $new_image_name,
        "zimage_alt" => $image_alt,
        "zimage_desc" => $image_desc,
      ));
    }
    ////////////////////////////////
    for ($i = 0; $i < count($pro_attributes); $i++) {
      $pro_attribute =   $pro_attributes[$i];
      $pro_price =  $pro_prices[$i];
      $var_id = $pro_variations[$i];

      $stmt = $connect->prepare("INSERT INTO product_details (pro_id,pro_attribute,pro_variation,pro_price) VALUES 
    (:zpro_id,:zpro_att,:zpro_var,:zpro_price)");
      $stmt->execute(array(
        "zpro_id" => $last_pro_id,
        "zpro_att" => $pro_attribute,
        "zpro_var" => $var_id,
        "zpro_price" => $pro_price,
      ));
    }

    if ($stmt) {
      $_SESSION['success_message'] = " تمت الأضافة بنجاح  ";

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
        <h1 class="m-0 text-dark"> اضافة منتج </h1>
      </div>
      <!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-left">
          <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
          <li class="breadcrumb-item active"> اضافة منتج </li>
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
    <form action="" method="post" enctype="multipart/form-data" autocomplete="off">
      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-body">
              <div class="form-group">
                <label for="inputName"> الأسم </label>
                <input required type="text" id="name" name="name" class="form-control" value="<?php if (isset($_REQUEST['name'])) echo $_REQUEST['name'] ?>">
              </div>
              <div class="form-group">
                <label for="description"> وصف مختصر </label>
                <textarea id="short_desc" name="short_desc" class="form-control" rows="2"><?php if (isset($_REQUEST['short_desc'])) echo $_REQUEST['short_desc'] ?></textarea>
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
                    <option <?php if (isset($_REQUEST['cat_id']) && $_REQUEST['cat_id'] == $cat['id']) echo "selected"; ?> value="<?php echo $cat['id']; ?>"> <?php echo $cat['name'] ?> </option>
                  <?php
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="inputStatus"> اضافة اقسام اخري </label>
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
              </div>

              <div id="attributes-containerxx">
                <?php
                $uniqueId = uniqid();
                ?>
                <div class="attribute-group">
                  <div class="form-group">
                    <br>
                    <label for="inputStatus">اختر السمة</label>
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
                </div>
              </div>
              <p class="btn btn-warning btn-sm" id="add_attribute_btn"> اضافة سمه جديد <i class="fa fa-plus"></i> </p>
              <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
              <div class="form-group">
                <label for="inputStatus"> المنتجات المرتبطة </label>
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
                <input type="number" id="purchase_price" name="purchase_price" class="form-control" value="<?php if (isset($_REQUEST['purchase_price'])) echo $_REQUEST['purchase_price'] ?>">
              </div>
              <div class="form-group">
                <label for="inputEstimatedBudget"> سعر البيع </label>
                <input required type="number" id="price" name="price" class="form-control" value="<?php if (isset($_REQUEST['price'])) echo $_REQUEST['price'] ?>">
              </div>
              <div class="form-group">
                <label for="inputEstimatedBudget"> سعر التخفيض </label>
                <input type="number" id="sale_price" name="sale_price" class="form-control" value="<?php if (isset($_REQUEST['sale_price'])) echo $_REQUEST['sale_price'] ?>">
              </div>
              <div class="form-group">
                <label for="inputEstimatedBudget"> العدد المتاح </label>
                <input type="number" id="av_num" name="av_num" class="form-control" value="<?php if (isset($_REQUEST['av_num'])) echo $_REQUEST['av_num'] ?>">
              </div>
              <div class='form-group'>
                <label> الوصف </label>
                <textarea name="description" class="form-control" id="summernote" rows="4" style="min-height: 200px;"> <?php if (isset($_REQUEST['description'])) echo $_REQUEST['description'] ?> </textarea>
              </div>
              <div class="form-group">
                <label for="description"> مميزات المنتج <span style="color: #c0392b; font-size: 14px;"> [ افصل بين كل ميزة والاخري ب (,) ] </span> </label>
                <textarea id="product_adv" name="product_adv" class="form-control" rows="4"><?php if (isset($_REQUEST['product_adv'])) echo $_REQUEST['product_adv'] ?></textarea>
              </div>
              <div class="form-group">
                <label for="customFile"> صورة المنتج </label>
                <input type="file" class="dropify" multiple data-height="150" data-allowed-file-extensions="jpg jpeg png svg" data-max-file-size="4M" name="main_image" data-show-loader="true" />
                <br>
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
                </div>
                <!--
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="customFile" accept='image/*' name="" value="<?php if (isset($_REQUEST['main_image'])) echo $_REQUEST['main_image'] ?>">
                  <label class="custom-file-label" for="customFile">اختر الصورة</label>
                </div>
                -->
              </div>
              <div class="form-group">
                <label for="customFile"> فيديو المنتج </label>
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="customFile" accept='video/*' name="video">
                  <label class="custom-file-label" for="customFile"> حمل الفيديو </label>
                </div>
              </div>
              <div class="form-group">
                <label for=""> الرئيسي </label>
                <div class="form-check">
                  <input class="form-check-input" value="image" type="radio" name="main_checked" id="flexRadioDefault1" checked>
                  <label class="form-check-label" for="flexRadioDefault1">
                    صورة المنتج
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" value="video" type="radio" name="main_checked" id="flexRadioDefault2">
                  <label class="form-check-label" for="flexRadioDefault2">
                    الفيديو
                  </label>
                </div>
              </div>
              <div class="form-group">
                <p class="btn btn-primary btn-sm" id="add_to_gallary"> اضافة الي المعرض <i class="fa fa-plus"></i> </p>
              </div>
              <div class="image_gallary">
              </div>
              <div></div>
              <div class="form-group">
                <label for="Company-2" class="block"> اضافة التاج <span class="badge badge-danger"> من فضلك افصل بين كل تاج والاخر (,) </span> </label>
                <input required id="Company-2" name="tags" type="text" class="form-control">
              </div>
              <div class="form-group">
                <label for="Company-2" class="block"> نشر المنتج </label>
                <select name="publish" id="" class="form-control select2">
                  <option value="" disabled> اختر الحالة </option>
                  <option value="1"> نشر المنتج </option>
                  <option value="0"> ارشيف </option>
                </select>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row" style="display: flex;justify-content: space-between;">
        <button type="submit" class="btn btn-primary" name="add_pro"> <i class="fa fa-save"></i> حفظ </button>
        <a href="main.php?dir=products&page=report" class="btn btn-secondary">رجوع <i class="fa fa-backward"></i> </a>
      </div>
    </form>
    <br>
    <br>
  </div>
  <!-- /.container-fluid -->
</section>