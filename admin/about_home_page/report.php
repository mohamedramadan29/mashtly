<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> قسم من نحن </h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="main.php?dir=dashboard&page=dashboard">الرئيسية</a></li>
                    <li class="breadcrumb-item active"> قسم من نحن </li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
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
                                        <th> العنوان </th>
                                        <th> الوصف </th>
                                        <th> الصورة </th>
                                        <th> </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $connect->prepare("SELECT * FROM about_home_page");
                                    $stmt->execute();
                                    $allcat = $stmt->fetchAll();
                                    $i = 0;
                                    foreach ($allcat as $cat) {
                                        $i++;
                                    ?>
                                        <tr>
                                            <td> <?php echo $i; ?> </td>
                                            <td> <?php echo  $cat['head']; ?> </td>
                                            <td> <?php echo  $cat['description']; ?> </td>
                                            <td>
                                                <img style="width: 80px; height:80px;" src="about_home_page/images/<?php echo $cat['image']; ?>" alt="">
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-success btn-sm waves-effect" data-toggle="modal" data-target="#edit-Modal_<?php echo $cat['id']; ?>"> تعديل <i class='fa fa-pen'></i> </button>
                                            </td>
                                        </tr>
                                        <!-- EDIT NEW CATEGORY MODAL   -->
                                        <div class="modal fade" id="edit-Modal_<?php echo $cat['id']; ?>" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title"> تعديل من نحن </h4>
                                                    </div>
                                                    <form method="post" action="main.php?dir=about_home_page&page=edit" enctype="multipart/form-data">
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <input type='hidden' name="banner_id" value="<?php echo $cat['id']; ?>">
                                                                <label for="Company-2" class="block"> العنوان </label>
                                                                <input id="Company-2" required name="head_name" type="text" class="form-control required" value="<?php echo  $cat['head'] ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="Company-2" class="block"> الوصف </label>
                                                                <textarea id="Company-2" name="description" class="form-control"><?php echo  $cat['description'] ?></textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="customFile"> تعديل الصورة </label>
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input" id="customFile" accept='image/*' name="main_image">
                                                                    <label class="custom-file-label" for="customFile">اختر الصورة</label>
                                                                </div>
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
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>