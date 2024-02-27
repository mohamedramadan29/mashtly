<!-- Content Header (Page header) -->
<?php
// get the company data 
if (isset($_GET['company_id'])) {
    $company_id = $_GET['company_id'];
    $stmt = $connect->prepare("SELECT * FROM new_shipping_company WHERE id = ?");
    $stmt->execute(array($company_id));
    $company_data = $stmt->fetch();
}

?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> مناطق الشحن الخاص ب [ <?php echo $company_data['name'] ?> ] </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> مناطق الشحن </li>
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
                        <button type="button" class="btn btn-primary waves-effect btn-sm" data-toggle="modal" data-target="#add-Modal"> اضافه منطقه جديده <i class="fa fa-plus"></i> </button>
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
                                        <th> المناطق </th>
                                        <th> نوع الشحن </th>
                                        <th> اوزان الشحن </th>
                                        <th> تكلفه الشحن </th>
                                        <th> سعر الكيلو الزائد </th>
                                        <th> العمليات </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $connect->prepare("SELECT * FROM company_areas ORDER BY id DESC");
                                    $stmt->execute();
                                    $allshpping_company = $stmt->fetchAll();
                                    $i = 0;
                                    foreach ($allshpping_company as $area) {
                                        $i++;
                                    ?>
                                        <tr>
                                            <td> <?php echo $i; ?> </td>
                                             
                                            <td> <?php
                                                    $shipping_area = explode(',', $area['ship_area']);
                                                    foreach ($shipping_area as $ship_area) {
                                                        $stmt = $connect->prepare("SELECT * FROM suadia_city WHERE reg_id = ? LIMIT 1");
                                                        $stmt->execute(array($ship_area));
                                                        $city_data = $stmt->fetch();
                                                        $area_name = $city_data['region'];
                                                    ?>
                                                    <span class="badge badge-info"> <?php echo $area_name; ?> </span>
                                                <?php
                                                    }
                                                ?>
                                            </td>
                                            <td> <?php
                                                    $ship_types = explode(',', $area['ship_type']);
                                                    foreach ($ship_types as $ship_type) {
                                                    ?>
                                                    <span class="badge badge-info"> <?php echo $ship_type; ?> </span>
                                                <?php
                                                    } ?>
                                            </td>
                                            <td>
                                                <?php echo $area['whight_from']; ?> - <?php echo $area['whight_to'] ?> <span class="badge badge-danger"> كجم </span>
                                            </td>

                                            <td>
                                                [ <?php echo $area['ship_start_from_price']; ?> - <?php echo $area['ship_end_to_price'] ?> <span class="badge badge-danger"> كجم </span> ] => <?php echo $area['default_whight_ship_price'] ?> <span class="badge badge-danger"> ريال </span>
                                            </td>
                                            <td>
                                                <?php echo $area['more_kilo_price']; ?> <span class="badge badge-danger"> ريال </span>
                                            </td>

                                            <td>
                                                <button type="button" class="btn btn-success btn-sm waves-effect" data-toggle="modal" data-target="#edit-Modal_<?php echo $area['id']; ?>"> <i class='fa fa-pen'></i> </button>
                                                <a href="main.php?dir=shipping_company/areas&page=delete&area_id=<?php echo $area['id']; ?>" class="confirm btn btn-danger btn-sm"> <i class='fa fa-trash'></i> </a>
                                            </td>
                                        </tr>
                                        <!-- EDIT NEW CATEGORY MODAL   -->
                                        <div class="modal fade" id="edit-Modal_<?php echo $area['id']; ?>" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title"> تعديل منطقه الشحن </h4>
                                                    </div>
                                                    <form action="main.php?dir=shipping_company/areas&page=edit" method="post" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <input type='hidden' name="area_id" value="<?php echo $area['id']; ?>">
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> اسم الشركة </label>
                                                                <input disabled readonly required id="Company-2" name="company_name" type="text" class="form-control required" value="<?php echo $company_data['name'] ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> نوع الشحن </label>
                                                                <?php $ship_types = explode(',', $area['ship_type']); ?>
                                                                <select required name="ship_type[]" multiple class="select2 form-control" id="">
                                                                    <option value=""> -- حدد نوع الشحن -- </option>
                                                                    <option <?php if (in_array('نباتات', $ship_types)) echo 'selected'; ?> value="نباتات"> نباتات </option>
                                                                    <option <?php if (in_array('مستلزمات', $ship_types)) echo 'selected'; ?> value="مستلزمات"> مستلزمات </option>
                                                                    <option <?php if (in_array('مختلطة نباتات ومستلزمات', $ship_types)) echo 'selected'; ?> value="مختلطة نباتات ومستلزمات"> مختلطة نباتات ومستلزمات </option>
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> منطقه الشحن </label>
                                                                <?php $shipping_areas = explode(',', $area['ship_area']); ?>
                                                                <select required name="ship_area[]" multiple class="select2 form-control" id="">

                                                                    <?php
                                                                    $stmt = $connect->prepare("SELECT MAX(reg_id) AS id, region  FROM suadia_city GROUP BY region ORDER BY id DESC");
                                                                    $stmt->execute();
                                                                    $all_areas = $stmt->fetchAll();
                                                                    foreach ($all_areas as $area_data) {
                                                                        $selected = (in_array($area_data['id'], $shipping_areas)) ? 'selected' : '';
                                                                    ?>
                                                                        <option <?php echo $selected; ?> value="<?php echo $area_data['id'] ?>"><?php echo $area_data['region']; ?></option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> اوزان الشحن المناسبة للشركة <span class="badge badge-danger"> كجم </span> </label>
                                                                <input required id="Company-2" name="whight_from" type="number" class="form-control" value="<?php echo $area['whight_from']; ?>" placeholder="بداية الوزن ">
                                                                <br>
                                                                <input required id="Company-2" name="whight_to" type="number" class="form-control" value="<?php echo $area['whight_to']; ?>" placeholder="نهاية الوزن">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> تكلفه الشحنة </label>
                                                                <input required id="Company-2" name="ship_start_from_price" type="number" class="form-control" value="<?php echo $area['ship_start_from_price']; ?>" placeholder="  مثال : 1 كجم   ">
                                                                <br>
                                                                <input required id="Company-2" name="ship_end_to_price" type="number" class="form-control" value="<?php echo $area['ship_end_to_price']; ?>" placeholder="  الي 10 كجم  ">
                                                                <br>
                                                                <input required id="Company-2" name="default_whight_ship_price" type="number" class="form-control" value="<?php echo $area['default_whight_ship_price']; ?>" placeholder=" السعر ">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> سعر الكيلو الزائد <span class="badge badge-danger"> ريال </span> </label>
                                                                <input required id="Company-2" name="more_kilo_price" type="number" class="form-control" value="<?php echo $area['more_kilo_price']; ?>">
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
                                <h4 class="modal-title"> اضافه منطقه شحن </h4>
                            </div>
                            <form action="main.php?dir=shipping_company/areas&page=add" method="post" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> اسم الشركة </label>
                                        <input readonly disabled id="Company-2" name="company_name" type="text" class="form-control required" value="<?php echo $company_data['name']; ?>">
                                        <input required id="Company-2" name="company_id" type="hidden" class="form-control required" value="<?php echo $company_id; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> نوع الشحن </label>
                                        <select required multiple name="ship_type[]" class="select2 form-control" id="">

                                            <option value="نباتات"> نباتات </option>
                                            <option value="مستلزمات"> مستلزمات </option>
                                            <option value="مختلطة نباتات ومستلزمات"> مختلطة نباتات ومستلزمات </option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> منطقه الشحن </label>
                                        <select required multiple name="ship_area[]" class="select2 form-control" id="">

                                            <?php
                                            $stmt = $connect->prepare("SELECT MAX(reg_id) AS id, region  FROM suadia_city GROUP BY region ORDER BY id DESC");
                                            $stmt->execute();
                                            $allarea = $stmt->fetchAll();
                                            foreach ($allarea as $area) {
                                            ?>
                                                <option value="<?php echo $area['id'] ?>"><?php echo $area['region']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> اوزان الشحن المناسبة للشركة <span class="badge badge-danger"> كجم </span> </label>
                                        <input required id="Company-2" name="whight_from" type="number" class="form-control" placeholder="بداية الوزن ">
                                        <br>
                                        <input required id="Company-2" name="whight_to" type="number" class="form-control" placeholder="نهاية الوزن">
                                    </div>
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> تكلفه الشحنة </label>
                                        <input required id="Company-2" name="ship_start_from_price" type="number" class="form-control" placeholder="  مثال : 1 كجم   ">
                                        <br>
                                        <input required id="Company-2" name="ship_end_to_price" type="number" class="form-control" placeholder="  الي 10 كجم  ">
                                        <br>
                                        <input required id="Company-2" name="default_whight_ship_price" type="number" class="form-control" placeholder=" السعر ">
                                    </div>
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> سعر الكيلو الزائد <span class="badge badge-danger"> ريال </span> </label>
                                        <input required id="Company-2" name="more_kilo_price" type="text" class="form-control">
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