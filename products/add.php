<?php
if (isset($_POST['add_pro'])) {
  $formerror = [];
  $cat_id = $_POST['cat_id'];
  $name = $_POST['name'];
  $slug = createSlug($name);
  $description = $_POST['description'];
  $short_desc = $_POST['short_desc'];
  $product_adv = $_POST['product_adv'];
  $price = $_POST['price'];
  $purchase_price = $_POST['purchase_price'];
  $sale_price = $_POST['sale_price'];
  $av_num = $_POST['av_num'];
  $pro_attribute = $_POST['pro_attribute'];
  $pro_variation = $_POST['pro_variation'];
  $pro_price = $_POST['pro_price'];
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
      $main_image_temp = $_FILES['main_image']['tmp_name'];
      $main_image_type = $_FILES['main_image']['type'];
      $main_image_size = $_FILES['main_image']['size'];
      $main_image_uploaded = time() . '_' . $main_image_name;
      move_uploaded_file(
        $main_image_temp,
        'product_images/' . $main_image_uploaded
      );
    } else {
      $formerror[] = ' من فضلك ادخل صورة  المنتج   ';
    }
  }
  // product gallary 
  $file = '';
  $file_tmp = '';
  $location = "";
  $uploadplace = "product_images/";
  if (isset($_FILES['more_images']['name'])) {
    foreach ($_FILES['more_images']['name'] as $key => $val) {
      $file = $_FILES['more_images']['name'][$key];
      $file = str_replace(' ', '', $file);
      $file_tmp = $_FILES['more_images']['tmp_name'][$key];
      move_uploaded_file($file_tmp, $uploadplace . $file);
      $location .= $file . ",";
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
    $stmt = $connect->prepare("INSERT INTO products (cat_id , name, slug , description,short_desc,product_adv,main_image , more_images,purchase_price,
    price, sale_price , av_num)
    VALUES (:zcat,:zname,:zslug,:zdesc,:zshort_desc,:zproduct_adv,:zmain_images,:zmore_images,:zpurchase_price,:zprice,:zsale_price,:zav_num)");
    $stmt->execute(array(
      "zcat" => $cat_id,
      "zname" => $name,
      "zslug" => $slug,
      "zdesc" => $description,
      "zshort_desc" => $short_desc,
      "zmain_images" => $main_image_uploaded,
      "zmore_images" => $location,
      "zproduct_adv" => $product_adv,
      "zprice" => $price,
      "zpurchase_price" => $purchase_price,
      "zsale_price" => $sale_price,
      "zav_num" => $av_num,
    ));
    if ($stmt) {
      $stmt = $connect->prepare("SELECT * FROM products ORDER BY id DESC LIMIT 1");
      $stmt->execute();
      $last_product = $stmt->fetch();
      $last_pro_id = $last_product['id'];
      $stmt = $connect->prepare("INSERT INTO product_details (pro_id,pro_attribute,pro_variation,pro_price) 
      VALUES(:zpro_id,:zpro_att,:zpro_var,:zpro_price)
      ");
      $stmt->execute(array(
        "zpro_id" => $last_pro_id,
        "zpro_att" => $pro_attribute,
        "zpro_var" => $pro_variation,
        "zpro_price" => $pro_price,
      ));
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
      header('refresh:2;url=main?dir=products&page=report');
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
                <label for="description"> الوصف </label>
                <textarea id="description" name="description" class="form-control" rows="4"><?php if (isset($_REQUEST['description'])) echo $_REQUEST['description'] ?></textarea>
              </div>
              <div class="form-group">
                <label for="description"> وصف مختصر </label>
                <textarea id="short_desc" name="short_desc" class="form-control" rows="2"><?php if (isset($_REQUEST['short_desc'])) echo $_REQUEST['short_desc'] ?></textarea>
              </div>
              <div class="form-group">
                <label for="inputStatus"> القسم </label>
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
                <label for="inputStatus"> سمات المنتج </label>
                <select id="pro_attribute" class="form-control custom-select select2" name="pro_attribute">
                  <option selected disabled> -- اختر -- </option>
                  <?php
                  $stmt = $connect->prepare("SELECT * FROM product_attribute");
                  $stmt->execute();
                  $allatt = $stmt->fetchAll();
                  foreach ($allatt as $att) {
                  ?>
                    <option <?php if (isset($_REQUEST['pro_attribute']) && $_REQUEST['pro_attribute'] == $att['id']) echo "selected"; ?> value="<?php echo $att['id']; ?>"> <?php echo $att['name'] ?> </option>
                  <?php
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="inputStatus"> المتغيرات </label>
                <select id="pro_variation" class="form-control custom-select select2" name="pro_variation[]" multiple>
                  <option disabled> -- اختر -- </option>

                </select>
              </div>
              <div class="form-group">
                <label for="inputName"> اضافة سعر جديد للمتغير </label>
                <input type="number" id="pro_price" name="pro_price" class="form-control" value="<?php if (isset($_REQUEST['pro_price'])) echo $_REQUEST['pro_price'] ?>">
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
              <div class="form-group">
                <label for="description"> مميزات المنتج <span style="color: #c0392b; font-size: 14px;"> [ افصل بين كل ميزة والاخري ب (,) ] </span> </label>
                <textarea id="product_adv" name="product_adv" class="form-control" rows="3"><?php if (isset($_REQUEST['product_adv'])) echo $_REQUEST['product_adv'] ?></textarea>
              </div>
              <div class="form-group">
                <label for="customFile"> صورة المنتج </label>
                <div class="custom-file">
                  <input required type="file" class="custom-file-input" id="customFile" accept='image/*' name="main_image" value="<?php if (isset($_REQUEST['main_image'])) echo $_REQUEST['main_image'] ?>">
                  <label class="custom-file-label" for="customFile">اختر الصورة</label>
                </div>
              </div>
              <div class="form-group">
                <label for="customFile"> معرض الصور </label>
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="customFile" multiple accept='image/*' name="more_images[]">
                  <label class="custom-file-label" for="customFile"> حدد المعرض </label>
                </div>
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