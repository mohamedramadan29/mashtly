<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> المناطق والمدن في المملكة </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> المناطق والمدن </li>
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
                        <button type="button" class="btn btn-primary waves-effect btn-sm" data-toggle="modal" data-target="#add-Modal"> أضافة منطقة جديدة <i class="fa fa-plus"></i> </button>
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
                                        <th> المنطقة </th>
                                        <th> المدن </th>
                                        <th> العمليات </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $connect->prepare("SELECT MAX(id) AS id, region FROM suadia_city GROUP BY region ORDER BY id DESC");
                                    $stmt->execute();
                                    $allarea = $stmt->fetchAll();
                                    $i = 0;
                                    foreach ($allarea as $area) {
                                        $i++;
                                    ?>
                                        <tr>
                                            <td> <?php echo $i; ?> </td>
                                            <td> <?php echo $area['region']; ?> </td>
                                            <td>
                                                <?php
                                                $stmt = $connect->prepare("SELECT id,name FROM suadia_city WHERE region = ?");
                                                $stmt->execute(array($area['region']));
                                                $allcity = $stmt->fetchAll();
                                                foreach ($allcity as $city) {
                                                ?>
                                                    <span class="badge badge-info"> <?php echo $city['name']; ?> </span>
                                                <?php
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-success btn-sm waves-effect" data-toggle="modal" data-target="#edit-Modal_<?php echo $area['id']; ?>"> <i class='fa fa-pen'></i> </button>
                                                <a href="main.php?dir=area_city&page=delete&area_id=<?php echo $area['id']; ?>" class="confirm btn btn-danger btn-sm"> <i class='fa fa-trash'></i> </a>
                                            </td>
                                        </tr>
                                        <!-- EDIT NEW CATEGORY MODAL   -->
                                        <div class="modal fade" id="edit-Modal_<?php echo $area['id']; ?>" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title"> تعديل المنطقة والمدن </h4>
                                                    </div>
                                                    <form action="main.php?dir=area_city&page=edit" method="post" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <input type='hidden' name="area_id" value="<?php echo $area['id']; ?>">
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> المنطقة </label>
                                                                <input id="Company-2" name="area" type="text" class="form-control required" value="<?php echo $area['region']; ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <input type="hidden" name="cities_id" value="<?php foreach ($allcity as $city) {
                                                                                                                    echo $city['id'] . ',';
                                                                                                                }
                                                                                                                ?>">
                                                                <label for="Company-2" class="block"> المدن <span class="badge badge-danger"> افصل بين كل مدينة واخري ب (,) </span> </label>
                                                                <textarea name="cities" class="form-control"><?php foreach ($allcity as $city) {
                                                                                                                    echo $city['name'] . ',';
                                                                                                                }
                                                                                                                ?></textarea>
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
                                <h4 class="modal-title">أضافة منطقة </h4>
                            </div>
                            <form action="main.php?dir=area_city&page=add" method="post" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> اسم المنطقة </label>
                                        <input required id="Company-2" name="area" type="text" class="form-control required">
                                    </div>
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> المدن <span class="badge badge-danger"> افصل بين كل مدينة واخري ب (,) </span> </label>
                                        <textarea required name="cities" class="form-control"></textarea>
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