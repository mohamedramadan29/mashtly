<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> اضافة طلب خارجي </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> اضافة طلب خارجي </li>
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
        <form action="main?dir=outside_orders&page=add_order" method="post" enctype="multipart/form-data" autocomplete="off">
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
                                        <label for="inputName"> الاسم بالكامل </label>
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
                                        <label for="inputName"> رقم الجوال </label>
                                        <input required type="text" id="phone" name="phone" class="form-control" value="<?php if (isset($_REQUEST['phone'])) echo $_REQUEST['phone'] ?>">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="inputName"> المدينة </label>
                                        <select required name="city" id="city" class='select2 form-control'>
                                            <option value=""> حدد المدينة</option>
                                            <?php
                                            $stmt = $connect->prepare("SELECT * FROM suadia_city");
                                            $stmt->execute();
                                            $allsaucountry = $stmt->fetchAll();
                                            foreach ($allsaucountry as $city) {
                                            ?>
                                                <option <?php if (isset($_REQUEST['city']) && $_REQUEST['city'] == $city['name']) echo "selected"; ?> value="<?php echo $city['name']; ?>"> <?php echo $city['name']; ?> </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="normal_ship_price"> سعر الشحن الافتراضي </label>
                                        <input type="text" id="normal_ship_price" name="normal_ship_price" class="form-control" value="<?php
                                                                                                                                        if (isset($_REQUEST['normal_ship_price'])) {
                                                                                                                                            echo $_REQUEST['normal_ship_price'];
                                                                                                                                        } else {
                                                                                                                                            echo "35";
                                                                                                                                        } ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="inputName"> الحي  </label>
                                        <input required type="text" id="city" name="street_name" class="form-control" value="<?php if (isset($_REQUEST['street_name'])) echo $_REQUEST['street_name'] ?>">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="inputName"> رقم المبني </label>
                                        <input required type="text" id="build_number" name="build_number" class="form-control" value="<?php if (isset($_REQUEST['build_number'])) echo $_REQUEST['build_number'] ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="order_details"> ملاحظات </label>
                                        <textarea id="order_details" name="order_details" class="form-control" rows="3"><?php if (isset($_REQUEST['order_details'])) echo $_REQUEST['order_details'] ?></textarea>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <div class="card card-info">
                        <div class="card-header">
                            اضافة منتجات من المتجر
                        </div>
                        <div class="card-body">
                            <!-- START USER ORDER  -->
                            <div class="row">
                                <div id='add_new_product_inside'>
                                    <div class="col-12 addinsideproducts" style="border-bottom: 3px solid #6c757d; padding-bottom:15px;padding-top:15px">
                                        <div class="form-group">
                                            <label for="inputName">حدد المنتج</label>
                                            <!-- قائمة المنتجات -->
                                            <select class="form-control select_products select2" name="select_product_from_store[]">
                                                <option value="" disabled selected> - حدد المنتجات - </option>
                                                <?php
                                                $stmt = $connect->prepare("SELECT * FROM products WHERE publish = 1");
                                                $stmt->execute();
                                                $allproducts = $stmt->fetchAll();
                                                // استعلام لاسترجاع المنتجات
                                                foreach ($allproducts as $product) {
                                                ?>
                                                    <option value="<?php echo $product['id'] ?>"><?php echo $product['name']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div>
                                            <label>حدد المتغيرات</label>
                                            <!-- قائمة المتغيرات -->
                                            <select class="form-control select_product_vartions" name="select_product_vartion_from_store[]">
                                                <option> -- حدد -- </option>
                                            </select>
                                        </div>
                                        <div>
                                            <label>العدد</label>
                                            <input type="number" name="select_product_qty_from_store[]" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <!-- Add button to add new inputs -->
                                <button style="margin-top: 10px;" id="add_new_inside_product" class="btn btn-danger btn-sm"> اضافة منتج جديد <i class="fa fa-plus-circle"></i> </button>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-secondary">
                        <div class="card-header">
                            اضافة منتجات خارجية
                        </div>
                        <div class="card-body">
                            <!-- ----------------------- اضافة منتجات غير متاحة في المتجر   --------------------------->
                            <div class="outside_products">
                                <?php
                                $total_outside_product = 0;
                                ?>

                                <button class="btn btn-primary btn-sm" id="add_new_outside_product"> اضافة المزيد من
                                    المنتجات الغير متاحة في
                                    المتجر <i class="fa fa-plus"></i></button>
                                <div id="add_new_product">
                                    <div class="add_products" style="border-bottom: 3px solid #6c757d; padding-bottom:15px;padding-top:15px">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="input_box" style="min-width: 160px">
                                                    <label for="pro_name"> اسم المنتج </label>
                                                    <input id="pro_name" type="text" name="pro_name[]" class='form-control' placeholder="اكتب…">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="input_box">
                                                    <label for="pro_type"> نوع المنتج </label>
                                                    <select name="pro_type[]" id="pro_type" class='form-control'>
                                                        <option value=""> نوع المنتج</option>
                                                        <option value="نباتات"> نباتات</option>
                                                        <option value="مستلزمات"> مستلزمات</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="input_box">
                                                    <label for="pro_qty"> الكمية </label>
                                                    <input id="pro_qty" type="number" name="pro_qty[]" class='form-control'>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="input_box">
                                                    <label for="product_tail"> طول المنتج <span class="badge badge-danger bg-danger"> متر </span>
                                                    </label>
                                                    <select name="pro_tail[]" id="product_tail" class='form-control'>
                                                        <option value=""> حدد الطول</option>
                                                        <?php
                                                        $stmt = $connect->prepare("SELECT * FROM shipping_weight_tools");
                                                        $stmt->execute();
                                                        $alltails = $stmt->fetchAll();
                                                        foreach ($alltails as $tail) {
                                                        ?>
                                                            <option value="<?php echo $tail['tail']; ?>"> <?php echo $tail['tail']; ?> </option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="input_box">
                                                    <label for="first_price"> سعر التكلفة </label>
                                                    <input min="0" id="first_price" type="number" name="pro_first_price[]" class='form-control'>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="input_box">
                                                    <label for="main_price"> سعر التنفيذ </label>
                                                    <input id="main_price" type="number" name="pro_main_price[]" class='form-control' min="0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!------------------------------------------- Add New Product ----------------------->
                            <script>
                                document.getElementById('add_new_outside_product').addEventListener('click', function($e) {
                                    $e.preventDefault();
                                    // Clone the add_services section
                                    var original = document.querySelector('.add_products');
                                    var clone = original.cloneNode(true);
                                    // Clear the input values in the cloned section
                                    var inputs = clone.querySelectorAll('input');
                                    inputs.forEach(function(input) {
                                        input.value = '';
                                    });
                                    // Append the cloned section to the container
                                    document.getElementById('add_new_product').appendChild(clone);
                                });
                                document.getElementById('services_container').addEventListener('click', function(event) {
                                    if (event.target && event.target.classList.contains('remove_service')) {
                                        // Remove the corresponding add_services section
                                        var serviceSection = event.target.closest('.add_services');
                                        serviceSection.remove();
                                    }
                                });
                            </script>
                        </div>
                    </div>


                    <!------------------------------------------- اضافة خدمات خارجية ------------------>

                    <div class="card card-secondary">
                        <div class="card-header">
                            اضافة خدمات خارجية
                        </div>
                        <div class="card-body">



                            <div class="outside_products">
                                <?php
                                $total_outside_services = 0;
                                ?>

                                <button id="add_new_outside_serve" class="btn btn-warning btn-sm">
                                    اضافة المزيد من الخدمات <i class="fa fa-plus"></i>
                                </button>

                                <div id="services_container">
                                    <div class="add_services" style="border-bottom: 3px solid #6c757d; padding-bottom:15px;padding-top:15px">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="input_box">
                                                    <label for="pro_name">اسم الخدمة</label>
                                                    <input id="pro_name" type="text" name="serv_name[]" class="form-control" placeholder="اكتب…">
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="input_box">
                                                    <label for="first_price">سعر التكلفة</label>
                                                    <input id="first_price" type="number" name="serv_first_price[]" class="form-control" min="0">
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="input_box">
                                                    <label for="main_price">سعر التنفيذ</label>
                                                    <input id="main_price" type="number" name="serv_main_price[]" class="form-control" min="0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!----------------------- Add New Services  ----------------->
                                <script>
                                    document.getElementById('add_new_outside_serve').addEventListener('click', function($e) {
                                        $e.preventDefault();
                                        // Clone the add_services section
                                        var original = document.querySelector('.add_services');
                                        var clone = original.cloneNode(true);
                                        // Clear the input values in the cloned section
                                        var inputs = clone.querySelectorAll('input');
                                        inputs.forEach(function(input) {
                                            input.value = '';
                                        });
                                        // Append the cloned section to the container
                                        document.getElementById('services_container').appendChild(clone);
                                    });
                                    document.getElementById('services_container').addEventListener('click', function(event) {
                                        if (event.target && event.target.classList.contains('remove_service')) {
                                            // Remove the corresponding add_services section
                                            var serviceSection = event.target.closest('.add_services');
                                            serviceSection.remove();
                                        }
                                    });
                                </script>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <div class="row" style="display: flex;justify-content: space-between;">
                <button type="submit" class="btn btn-primary" name="add_new_outside_order"> <i class="fa fa-save"></i> حفظ </button>
                <a href="main.php?dir=products&page=report" class="btn btn-secondary">رجوع <i class="fa fa-backward"></i> </a>
            </div>
        </form>
        <br>
        <br>
    </div>
    <!-- /.container-fluid -->
</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        // Function to load variations for a specific select element
        function loadVariations(productSelect) {
            var product_id = productSelect.val(); // قيمة المنتج المحدد
            var vartionsSelect = productSelect.closest('.addinsideproducts').find('.select_product_vartions');
            $.ajax({
                url: 'orders/load_variations.php', // المسار إلى ملف PHP الذي يحمل المتغيرات
                type: 'post',
                data: {
                    product_id: product_id
                },
                success: function(response) {
                    vartionsSelect.html(response);
                }
            });
        }

        // Handle change event for initial product select
        $(document).on('change', '.select_products', function() {
            loadVariations($(this));
        });

        // Add new product section
        // $('#add_new_inside_product').click(function($e) {
        //     $e.preventDefault();
        //     // Clone the addinsideproducts section
        //     var original = $('.addinsideproducts').first();
        //     var clone = original.clone(true);

        //     // Clear the input values in the cloned section
        //     clone.find('input').val('');
        //     clone.find('.select_product_vartions').html('<option> -- حدد -- </option>');

        //     // Append the cloned section to the container
        //     $('#add_new_product_inside').append(clone);
        // });
    });
</script>


<script>
    $(document).ready(function() {
        // Initialize select2 for the first select elements
        $('.select2').select2();

        // Add new product section
        $('#add_new_inside_product').click(function($e) {
            $e.preventDefault();
            // Clone the addinsideproducts section
            var original = $('.addinsideproducts').first();
            var clone = original.clone(true);

            // Clear the input values in the cloned section
            clone.find('input').val('');
            clone.find('.select2').val(null).trigger('change'); // Clear select2
            clone.find('.select_product_vartions').html('<option> -- حدد -- </option>');

            // Append the cloned section to the container
            $('#add_new_product_inside').append(clone);

            // Re-initialize select2 for the new select elements
            clone.find('.select2').select2();
        });
    });
</script>