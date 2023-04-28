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
    <div class="row">
      <div class="col-md-6">
        <div class="card card-primary">
          <div class="card-body">
            <div class="form-group">
              <label for="inputName"> الأسم </label>
              <input type="text" id="name" name="name" class="form-control">
            </div>
            <div class="form-group">
              <label for="description"> الوصف </label>
              <textarea id="description" name="description" class="form-control" rows="4"></textarea>
            </div>
            <div class="form-group">
              <label for="inputStatus"> القسم </label>
              <select id="select2" class="form-control custom-select">
                <option selected disabled> -- اختر -- </option>
                <?php
                $stmt = $connect->prepare("SELECT * FROM categories");
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
              <label for="inputEstimatedBudget"> السعر </label>
              <input type="number" id="price" name="price" class="form-control">
            </div>
            <div class="form-group">
              <label for="inputEstimatedBudget"> سعر التخفيض </label>
              <input type="number" id="sale_price" name="sale_price" class="form-control">
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
              <label for="inputEstimatedBudget"> العدد المتاح </label>
              <input type="number" id="av_num" name="av_num" class="form-control">
            </div>
            <div class="form-group">
                     <label for="customFile"> صورة المنتج  </label> 
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" id="customFile" accept='image/*'>
                      <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                  </div>
                  <div class="form-group">
                     <label for="customFile"> معرض  الصور    </label> 
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" id="customFile" multiple accept='image/*'>
                      <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                  </div>
           
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <a href="#" class="btn btn-secondary">Cancel</a>
        <input type="submit" value="Create new Project" class="btn btn-success float-right">
      </div>
    </div>
  </div>
  <!-- /.container-fluid -->
</section>