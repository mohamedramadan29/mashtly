<?php
ob_start();
session_start();
$page_title = ' اضافة عنوان جديد  ';
include 'init.php';
$user_id = $_SESSION['user_id'];
if (isset($_SESSION['user_id'])) {
    if (isset($_POST['add_address'])) {
        $formerror = [];
        $name = sanitizeInput($_POST['name']);
        $phone = sanitizeInput($_POST['phone']);
        $country = sanitizeInput($_POST['country']);
        $city = sanitizeInput($_POST['city']);
        $street_name = sanitizeInput($_POST['street_name']);
        $build_number = sanitizeInput($_POST['build_number']);
        if (isset($_POST['default_address'])) {
            $default_address = 1;
        } else {
            $default_address = 0;
        }

        if (empty($name) || empty($phone) || empty($country) || empty($city) || empty($street_name) || empty($build_number)) {
            $formerror[] = 'من فضلك ادخل المعلومات كاملة';
        }
        if (empty($formerror)) {
            $table = "user_address";
            $data = array(
                "user_id" => $user_id,
                "country" => $country,
                "city" => $city,
                "street_name" => $street_name,
                "build_number" => $build_number,
                "name" => $name,
                "phone" => $phone,
                "default_address" => $default_address,
            );
            $stmt = insertData($connect, $table, $data);
            if ($stmt) {
                $_SESSION['success'] = 'تم تسجيل عنوان جديد بنجاح ';
                header('Location:address');
            }
        } else {
            $_SESSION['error'] = $formerror;
        }
    }

?>
    <div class="profile_page new_address_page">
        <div class='container'>
            <div class="data">
                <div class="breadcrump">
                    <p> <a href="../index"> الرئيسية </a> \ <a href="index"> حسابي </a> \ <a href="address"> عناويني </a> \
                        <span> أضف عنوان جديد </span>
                    </p>
                </div>
                <div class="purches_header">
                    <div class="data_header_name">
                        <h2 class='header2'> أضف عنوان جديد </h2>
                        <p> تحكم في عناوين الشحن الخاصه بك </p>
                    </div>
                </div>
                <div class="add_new_address">
                    <?php
                    include "../success_error_msg.php";
                    if (isset($_SESSION['error'])) {
                        unset($_SESSION['error']);
                    }
                    if (isset($_SESSION['success'])) {
                        unset($_SESSION['success']);
                    }
                    ?>
                    <form action="#" method="post">
                        <div class='row'>
                            <div class="box">
                                <div class="input_box">
                                    <label for="country"> البلد / الدولة </label>
                                    <select required name="country" id="" class='form-control select2'>
                                        <option value="SAR"> المملكة العربية السعودية </option>
                                        <option value="EG"> مصر </option>
                                    </select>
                                </div>
                                <div class="input_box">
                                    <label for="country"> المدينة </label>
                                    <select required name="city" id="" class='form-control'>
                                        <option value="cairo"> القاهرة </option>
                                        <option value="riyad"> الرياض </option>
                                    </select>
                                </div>
                            </div>
                            <div class='box'>
                                <div class="input_box">
                                    <label for="name"> الاسم بالكامل </label>
                                    <input required id="name" type="text" name="name" class='form-control' placeholder="اكتب…">
                                </div>
                                <div class="input_box">
                                    <label for="phone"> رقم الجوال </label>
                                    <input required id="phone" type="text" name="phone" class='form-control' placeholder="اكتب…">
                                </div>
                            </div>
                            <div class="box">
                                <div class="input_box">
                                    <label for="street_name"> اسم الشارع </label>
                                    <input required id="street_name" type="text" name="street_name" class='form-control' placeholder="اكتب…">
                                </div>
                                <div class="input_box">
                                    <label for="build_number"> رقم المبني </label>
                                    <input required id="build_number" type="text" name="build_number" class='form-control' placeholder="اكتب…">
                                </div>
                            </div>
                            <div class="input_box">
                                <div class="form-check">
                                    <input name="default_address" class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                    <label class="form-check-label" for="flexCheckChecked">
                                        تعيين كعنوان رئيسي
                                    </label>
                                </div>
                            </div>
                            <div class="submit_buttons">
                                <button class="btn global_button" type="reset"> إعادة تعيين </button>
                                <button class="btn global_button" name="add_address" type="submit"> إضافة عنوان جديد </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
    include $tem . 'footer.php';
    ob_end_flush();
} else {
    header("Location:../index");
    exit();
}
?>