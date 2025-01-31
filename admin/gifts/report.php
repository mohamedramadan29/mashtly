<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> الهدايا </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> الهدايا </li>
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
                        <button type="button" class="btn btn-primary waves-effect btn-sm" data-toggle="modal" data-target="#add-Modal"> أضافة هدية <i class="fa fa-plus"></i> </button>
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
                                        <th> الأسم </th>
                                        <th> السعر</th>
                                        <th> الصورة </th>
                                        <th> </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $connect->prepare("SELECT * FROM gifts ORDER BY id DESC");
                                    $stmt->execute();
                                    $allgift = $stmt->fetchAll();
                                    $i = 0;
                                    foreach ($allgift as $gift) {
                                        $i++;
                                    ?>
                                        <tr>
                                            <td> <?php echo $i; ?> </td>
                                            <td> <?php echo  $gift['name']; ?> </td>
                                            <td> <?php echo  $gift['price']; ?> </td>
                                            <td> <img style="width: 80px; height:80px;" src="../uploads/gifts/<?php echo  $gift['image']; ?>" alt=""> </td>
                                            <td>
                                                <button type="button" class="btn btn-success btn-sm waves-effect" data-toggle="modal" data-target="#edit-Modal_<?php echo $gift['id']; ?>"> تعديل <i class='fa fa-pen'></i> </button>
                                                <a href="main.php?dir=gifts&page=delete&gift_id=<?php echo $gift['id']; ?>" class="confirm btn btn-danger btn-sm"> حذف <i class='fa fa-trash'></i> </a>
                                            </td>
                                        </tr>
                                        <!-- EDIT NEW CATEGORY MODAL   -->
                                        <div class="modal fade" id="edit-Modal_<?php echo $gift['id']; ?>" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title"> تعديل الهدية </h4>
                                                    </div>
                                                    <form action="main.php?dir=gifts&page=edit" method="post" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <input type='hidden' name="gift_id" value="<?php echo $gift['id']; ?>">
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> الاسم </label>
                                                                <input id="Company-2" name="name" type="text" class="form-control required" value="<?php echo $gift['name']; ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> السعر </label>
                                                                <input required id="Company-2" name="price" type="text" class="form-control required" value="<?php echo $gift['price']; ?>">
                                                            </div> 
                                                            <div class="form-group">
                                                                <label for="customFile"> صورة الهدية </label>
                                                                <input name="main_image" type="file" class="form-control" data-height="150" data-allowed-file-extensions="jpg jpeg png svg" data-max-file-size="4M" data-show-loader="true" />
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
                                <h4 class="modal-title">أضافة هدية </h4>
                            </div>
                            <form action="main.php?dir=gifts&page=add" method="post" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> الاسم </label>
                                        <input id="Company-2" name="name" type="text" class="form-control required">
                                    </div>
                                    <div class="form-group">
                                        <label for="Company-2" class="block"> السعر </label>
                                        <input required id="Company-2" name="price" type="text" class="form-control required">
                                    </div>
                                    <div class="form-group">
                                        <label for="customFile"> صورة الهدية </label>
                                        <input required type="file" class="dropify" data-height="150" data-allowed-file-extensions="jpg jpeg png svg" data-max-file-size="4M" name="main_image" data-show-loader="true" />
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