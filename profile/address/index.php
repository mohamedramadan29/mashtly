<?php 
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
                    include "success_error_msg.php";
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
                                <div class="address <?php if ($default_address == 1) echo "active"; ?> ">
                                    <div class='add_head'>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault<?php echo $address['id'] ?>" <?php if ($default_address == 1) echo "checked"; ?>>
                                            <label class="form-check-label" for="flexRadioDefault<?php echo $address['id'] ?>" class=' <?php if ($default_address == 1) echo "active"; ?> '>
                                                تعيين كعنوان رئيسي
                                            </label>
                                        </div>
                                        <form action="address/delete" method="post">
                                            <input type="hidden" name="address_id" value="<?php echo $address['id']; ?>">
                                            <div class='remove_add'>
                                                <button id="confirm_delete" name="delete_address" type="submit" onclick="return confirm('هل أنت متأكد من رغبتك في حذف العنوان؟')"> <i class='fa fa-close'></i> حذف العنوان </button>
                                            </div>
                                        </form>
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
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                        <div class="col-lg-4">
                            <div class="add_new_address">
                                <a href="address/add">
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
} else {
    header("location:../index");
}
?>