<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark"> اضافة طلب </h1>
      </div>
      <!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-left">
          <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
          <li class="breadcrumb-item active"> اضافة طلب </li>
        </ol>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</section>
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
<!-- /.content-header -->
<!-- DOM/Jquery table start -->
<section class="content">
  <div class="container-fluid">
    <form action="main?dir=orders&page=add_order" method="post" enctype="multipart/form-data" autocomplete="off">
      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              معلومات العميل
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="inputName"> الأسم </label>
                    <input required type="text" id="name" name="name" class="form-control" value="<?php if (isset($_REQUEST['name'])) echo $_REQUEST['name'] ?>">
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="inputName"> البريد الألكتروني </label>
                    <input required type="text" id="email" name="email" class="form-control" value="<?php if (isset($_REQUEST['email'])) echo $_REQUEST['email'] ?>">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="inputName"> رقم الهاتف </label>
                    <input required type="text" id="phone" name="phone" class="form-control" value="<?php if (isset($_REQUEST['phone'])) echo $_REQUEST['phone'] ?>">
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="inputName"> المنطقة </label>
                    <select id="" class="form-control select2" name="area">
                      <option value=""> - حدد المنطقة - </option>
                      <?php
                      $stmt = $connect->prepare("SELECT * FROM area");
                      $stmt->execute();
                      $allarea = $stmt->fetchAll();
                      foreach ($allarea as $area) {
                      ?>
                        <option value="<?php echo $area['id']; ?>"> <?php echo $area['name']; ?> </option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6" style="display: none;">
                  <div class="form-group">
                    <label for="inputName"> المدينة </label>
                    <input required type="text" id="city" name="city" class="form-control" value="<?php echo "1"; ?>">
                  </div>
                </div>

                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="inputName"> عنوان الشارع / الحي </label>
                    <input required type="text" id="address" name="address" class="form-control" value="<?php if (isset($_REQUEST['address'])) echo $_REQUEST['address'] ?>">
                  </div>
                </div>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <div class="card card-info">
            <div class="card-header">
              هل تودّ الشحن لعنوان مختلف
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="inputName"> الأسم </label>
                    <input type="text" id="ship_name" name="ship_name" class="form-control" value="<?php if (isset($_REQUEST['ship_name'])) echo $_REQUEST['ship_name'] ?>">
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="inputName"> رقم الهاتف </label>
                    <input type="text" id="ship_phone" name="ship_phone" class="form-control" value="<?php if (isset($_REQUEST['ship_phone'])) echo $_REQUEST['ship_phone'] ?>">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="inputName"> المنطقة </label>
                    <select id="" class="form-control select2" name="ship_area">
                      <option value=""> - حدد المنطقة - </option>
                      <?php
                      $stmt = $connect->prepare("SELECT * FROM area");
                      $stmt->execute();
                      $allarea = $stmt->fetchAll();
                      foreach ($allarea as $area) {
                      ?>
                        <option value="<?php echo $area['id']; ?>"> <?php echo $area['name']; ?> </option>
                      <?php
                      }
                      ?>
                    </select>

                  </div>
                </div>
                <div class="col-lg-6" style="display: none;">
                  <div class="form-group">
                    <label for="inputName"> المدينة </label>
                    <input type="text" id="ship_city" name="ship_city" class="form-control" value="<?php if (isset($_REQUEST['ship_city'])) echo $_REQUEST['ship_city'] ?>">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label for="inputName"> عنوان الشارع / الحي </label>
                    <input type="text" id="ship_address" name="ship_address" class="form-control" value="<?php if (isset($_REQUEST['ship_address'])) echo $_REQUEST['ship_address'] ?>">
                  </div>
                </div>
              </div>
              <!--
              <div class="form-group">
                <label for="description"> ملاحظات </label>
                <textarea id="ship_notes" name="ship_notes" class="form-control" rows="2"><?php if (isset($_REQUEST['ship_notes'])) echo $_REQUEST['ship_notes'] ?></textarea>
              </div>
                    -->
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <div class="col-md-6">
          <div class="card card-secondary">
            <div class="card-header">
              تفاصيل الطلب
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="inputStatus"> اختر المنتج </label>
                <select required class="form-control custom-select select2" name="pro_id[]">
                  <option selected disabled> -- اختر -- </option>
                  <?php
                  $stmt = $connect->prepare("SELECT * FROM products");
                  $stmt->execute();
                  $allpro = $stmt->fetchAll();
                  foreach ($allpro as $pro) {
                  ?>
                    <option <?php if (isset($_REQUEST['pro_id']) && $_REQUEST['pro_id'] == $pro['id']) echo "selected"; ?> value="<?php echo $pro['id']; ?>"> <?php echo $pro['name'] ?> </option>
                  <?php
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="inputName"> العدد </label>
                <input required type="number" id="product_qty" name="product_qty[]" class="form-control" value="<?php if (isset($_REQUEST['product_qty'])) echo $_REQUEST['product_qty'] ?>">
              </div>
              <!-- Add button to add new inputs -->
              <button id="add-inputs-btn" class="btn btn-danger btn-sm"> اضافة منتج جديد <i class="fa fa-plus-circle"></i> </button>
              <!-- Add button to delete last input 
              <button id="delete-inputs-btn" class="btn btn-secondary btn-sm"> حذف الخطوة الأخيرة <i class="fa fa-minus-circle"></i> </button>
-->
              <!-- Placeholder for new inputs -->
              <div id="new-inputs"></div>

              <!-- JavaScript code to add new inputs -->
              <script>
                var addInputsBtn = document.getElementById('add-inputs-btn');
                var newInputsContainer = document.getElementById('new-inputs');

                addInputsBtn.addEventListener('click', function() {
                  // Create new inputs and append to container
                  var newInputs = document.createElement('div');
                  newInputs.innerHTML = `
                      <div class="form-group">
                        <label for="inputStatus"> اسم المنتج </label>
                        <select required id="" class="form-control custom-select select2" name="pro_id[]">
                          <option selected disabled> -- اختر -- </option>
                          <?php
                          $stmt = $connect->prepare("SELECT * FROM products");
                          $stmt->execute();
                          $allcat = $stmt->fetchAll();
                          foreach ($allcat as $cat) {
                          ?>
                            <option <?php if (isset($_REQUEST['pro_id']) && $_REQUEST['pro_id'] == $cat['id']) echo "selected"; ?> value="<?php echo $cat['id']; ?>"> <?php echo $cat['name'] ?> </option>
                          <?php
                          }
                          ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="inputName"> العدد </label>
                        <input required type="number" id="product_qty" name="product_qty[]" class="form-control" value="<?php if (isset($_REQUEST['product_qty'])) echo $_REQUEST['product_qty'] ?>">
                      </div>
                    `;
                  newInputsContainer.appendChild(newInputs);
                });
              </script>

              <script>
                var deleteInputsBtn = document.getElementById('delete-inputs-btn');
                deleteInputsBtn.addEventListener('click', function() {
                  // Get all new inputs
                  var newInputs = document.querySelectorAll('#new-inputs div');
                  // Remove the last input
                  var lastInput = newInputs[newInputs.length - 1];
                  lastInput.parentNode.removeChild(lastInput);
                });
              </script>

              <label for=""></label>
              <div class="form-group">
                <br>
                <label for="description"> ملاحظات </label>
                <textarea id="order_details" name="order_details" class="form-control" rows="3"><?php if (isset($_REQUEST['order_details'])) echo $_REQUEST['order_details'] ?></textarea>
              </div>

              <p class="badge badge-info"> اضافة مرفقات اضافية للطلب </p>
              <div class="form-group">
                <label for="customFile"> المرفقات </label>
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="customFile" name="order_files[]" multiple>
                  <label class="custom-file-label" for="customFile">اختر </label>
                </div>
              </div>
              <div class="form-group">
                <label for="inputName"> سعر التوصيل والشحن </label>
                <input type="number" id="ship_price" name="ship_price" class="form-control" value="<?php if (isset($_REQUEST['ship_price'])) echo $_REQUEST['ship_price'] ?>">
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <div class="row" style="display: flex;justify-content: space-between;">
        <button type="submit" class="btn btn-primary" name="add_order"> <i class="fa fa-save"></i> حفظ </button>
        <a href="main.php?dir=products&page=report" class="btn btn-secondary">رجوع <i class="fa fa-backward"></i> </a>
      </div>
    </form>
    <br>
    <br>
  </div>
  <!-- /.container-fluid -->
</section>