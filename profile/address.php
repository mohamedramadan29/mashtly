<?php
ob_start();
session_start();
$page_title = ' عناويني  ';
include 'init.php';
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
?>
    <div class="profile_page adress_page">
        <div class='container'>
            <div class="data">
                <div class="breadcrump">
                    <p> <a href="../index"> الرئيسية </a> \ <a href="index"> حسابي </a> \ <span> عناويني </span> </p>
                </div>
                <div class="purches_header">
                    <div class="data_header_name">
                        <h2 class='header2'> عناويني</h2>
                        <p> تحكم في عناوين الشحن الخاصه بك </p>
                    </div>
                </div>
                <div class="addresses">
                    <?php
                    include "../success_error_msg.php";
                    unset($_SESSION['success']);
                    ?>
                    <div class="row">
                        <?php
                        $stmt = $connect->prepare("SELECT * FROM user_address WHERE user_id=?");
                        $stmt->execute(array($user_id));
                        $alladdress = $stmt->fetchAll();
                        foreach ($alladdress as $address) {
                            $city = $address['city'];
                            $build_number = $address['build_number'];
                            $street_name = $address['street_name'];
                            $area = $address['area'];
                            $country = $address['country'];
                            $phone = $address['phone'];
                            $default_address = $address['default_address'];
                            if ($country == 'EG') {
                                $country = 'مصر';
                            } elseif ($country == 'SAR') {
                                $country = 'المملكة العربية السعودية';
                            }
                        ?>
                            <div class="col-lg-4">
                                <div class="address active">
                                    <form action="#" method="post">
                                        <div class='add_head'>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" checked>
                                                <label class="form-check-label" for="flexRadioDefault1" class='active'>
                                                    تعيين كعنوان رئيسي
                                                </label>
                                            </div>
                                            <div class='remove_add'>
                                                <button> <i class='fa fa-close'></i> حذف العنوان </button>
                                            </div>
                                        </div>
                                        <div class='add_content'>
                                            <h2> <?php echo $city; ?> </h2>
                                            <p class="add_title">
                                                <?php echo $build_number . '-' . $street_name . '-' . $area . '-' . $city . '-' . $country ?>
                                            </p>
                                            <p class='add_phone'>
                                                <span> رقم الهاتف </span> <?php echo $phone; ?>
                                            </p>
                                        </div>
                                        <div class='edit'>
                                            <a href="#"> تعديل <img src="<?php echo $uploads ?>edit_button.svg" alt=""> </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <?php
                        }
                        ?>

                        <div class="col-lg-4">
                            <div class="address">
                                <form action="#" method="post">
                                    <div class='add_head'>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                                            <label class="form-check-label" for="flexRadioDefault2">
                                                تعيين كعنوان رئيسي
                                            </label>
                                        </div>
                                        <div class='remove_add'>
                                            <button> <i class='fa fa-close'></i> حذف العنوان </button>
                                        </div>
                                    </div>
                                    <div class='add_content'>
                                        <h2> منزل أحمد سمير عبد السلام </h2>
                                        <p class="add_title">
                                            223 طريق الإمام سعود - حي المصيف - الرياض- المملكة العربية السعودية
                                        </p>
                                        <p class='add_phone'>
                                            <span> رقم الهاتف </span> +201092508803
                                        </p>
                                    </div>
                                    <div class='edit'>
                                        <a href="#"> تعديل <img src="<?php echo $uploads ?>edit_button.svg" alt=""> </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="add_new_address">
                                <a href="add_address">
                                    <i class="fa fa-plus"></i>
                                    <h3> أضف عنوان جديد </h3>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
    include $tem . 'footer.php';
    ob_end_flush();
} else {
    header("location:../index");
}
?>