<?php
ob_start();
session_start();
$page_title = 'تعديل العنوان ';
include 'init.php';
$user_id = $_SESSION['user_id'];
if (isset($_SESSION['user_id'])) {
    $address_id = $_GET['address'];
    $stmt = $connect->prepare("SELECT * FROM user_address WHERE id = ? AND user_id=?");
    $stmt->execute(array($address_id, $user_id));
    $address = $stmt->fetch();
    $city = $address['city'];
    $build_number = $address['build_number'];
    $street_name = $address['street_name'];
    $area = $address['area'];
    $country = $address['country'];
    $phone = $address['phone'];
    $name = $address['name'];
    $default_address = $address['default_address'];
    if ($country == 'EG') {
        $country = 'مصر';
    } elseif ($country == 'SAR') {
        $country = 'المملكة العربية السعودية';
    }
    $count = $stmt->rowCount();
    if ($count > 0) {

        if (isset($_POST['add_address'])) {
            $formerror = [];
            $name = sanitizeInput($_POST['name']);
            $phone = sanitizeInput($_POST['phone']);
            $country = sanitizeInput($_POST['country']);
            $city = sanitizeInput($_POST['city']);
            $street_name = sanitizeInput($_POST['street_name']);
            $build_number = sanitizeInput($_POST['build_number']);
             
            if (empty($name) || empty($phone) || empty($country) || empty($city) || empty($street_name) || empty($build_number)) {
                $formerror[] = 'من فضلك ادخل المعلومات كاملة';
            }
            // تحقق من أن الرقم يتبع إحدى الصيغ التالية:
            // 1. مفتاح الدولة معرّف مع الرقم (مفتاح الدولة غير الزامي)
            // 2. الرقم بدون مفتاح الدولة
            // if (!preg_match('/^(?:\+966|00966)?05[0-9]{8}$|^05[0-9]{8}$/', $phone)) {
            //     $formerror[] = 'من فضلك، أدخل رقم هاتف صحيح بصيغة سعودية.';
            // }

            if (empty($formerror)) {
                //$table = "user_address";
                // $data = array(
                //     "user_id" => $user_id,
                //     "country" => $country,
                //     "city" => $city,
                //     "street_name" => $street_name,
                //     "build_number" => $build_number,
                //     "name" => $name,
                //     "phone" => $phone,
                //     "default_address" => 1,
                // );
                $stmt = $connect->prepare("SELECT * FROM suadia_city WHERE name=?");
                $stmt->execute(array($city));
                $city_data = $stmt->fetch();
                $new_area = $city_data['region'];
                $new_area_code = $city_data['reg_id'];
                $stmt = $connect->prepare("UPDATE user_address SET country=? , city = ? ,area = ?,area_code = ? ,street_name=?,
                build_number=?,name=?, phone=?,default_address=? WHERE id = ?
                ");
                $stmt->execute(array($country, $city, $new_area,$new_area_code, $street_name, $build_number,
                $name, $phone, $default_address, $address_id));
                if ($stmt) {
                    $_SESSION['success'] = 'تم تعديل العنوان  بنجاح ';
                    header('Location:index');
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
                        <p> <a href="../index"> الرئيسية </a> \ <a href="../index"> حسابي </a> \ <a href="index"> عناويني </a> \
                            <span> تعديل العنوان </span>
                        </p>
                    </div>
                    <div class="purches_header">
                        <div class="data_header_name">
                            <h2 class='header2'> تعديل العنوان </h2>
                            <p> تحكم في عناوين الشحن الخاصه بك </p>
                        </div>
                    </div>
                    <div class="add_new_address">
                        <?php
                        include "../../success_error_msg.php";
                        if (isset($_SESSION['error'])) {
                            unset($_SESSION['error']);
                        }
                        if (isset($_SESSION['success'])) {
                            unset($_SESSION['success']);
                        }
                        ?>
                        <form action="#" method="post">
                            <input type="hidden" name="address_id" value="<?php $address_id ?>">
                            <div class='row'>
                                <div class="box">
                                    <div class="input_box">
                                        <label for="country"> البلد / الدولة </label>
                                        <select required id="country" name="country" class='form-control select2'>
                                            <option value=""> -- اختر الدولة -- </option>
                                            <option <?php if ($address['country'] == "SAR") echo "selected"; ?> value="SAR"> المملكة العربية السعودية </option>
                                            <!-- <option <?php if ($address['country'] == "EG") echo "selected"; ?> value="EG"> مصر </option> -->
                                        </select>
                                    </div>
                                    <div class="input_box">
                                        <label for="country"> المدينة </label>
                                        <select required name="city" id="city" class='select2 form-control'>
                                            <option value=""> حدد المدينة </option>
                                            <?php
                                            $stmt = $connect->prepare("SELECT * FROM suadia_city");
                                            $stmt->execute();
                                            $allsaucountry = $stmt->fetchAll();
                                            foreach ($allsaucountry as $city) {
                                            ?>
                                                <option <?php if ($city['name'] == $address['city']) echo 'selected'; ?> value="<?php echo $city['name']; ?>"> <?php echo $city['name']; ?> </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class='box'>
                                    <div class="input_box">
                                        <label for="name"> الاسم بالكامل </label>
                                        <input required id="name" type="text" name="name" class='form-control' placeholder="اكتب…" value="<?php echo $name; ?>">
                                    </div>
                                    <div class="input_box">
                                        <label for="phone"> رقم الجوال </label>
                                        <input required id="phone" type="text" name="phone" class='form-control' placeholder="اكتب…" value="<?php echo $phone; ?>">
                                    </div>
                                </div>
                                <div class="box">
                                    <div class="input_box">
                                        <label for="street_name"> اسم الشارع </label>
                                        <input required id="street_name" type="text" name="street_name" class='form-control' placeholder="اكتب…" value="<?php echo $street_name; ?>">
                                    </div>
                                    <div class="input_box">
                                        <label for="build_number"> رقم المبني </label>
                                        <input required id="build_number" type="text" name="build_number" class='form-control' placeholder="اكتب…" value="<?php echo $build_number; ?>">
                                    </div>
                                </div>
                                <div class="input_box">
                                    <div class="form-check">
                                        <input name="default_address" class="form-check-input" type="checkbox" value="" id="flexCheckChecked" <?php if ($default_address == 1) echo "checked"; ?>>
                                        <label class="form-check-label" for="flexCheckChecked">
                                            تعيين كعنوان رئيسي
                                        </label>
                                    </div>
                                </div>
                                <div class="submit_buttons">
                                    <button class="btn global_button" type="reset"> إعادة تعيين </button>
                                    <button class="btn global_button" name="add_address" type="submit"> تعديل العنوان</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
<?php

    } else {
        header('Location:index');
    }
} else {
    header("location:../../login");
    exit();
}
?>

<?php
include $tem . 'footer.php';
ob_end_flush();
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        // مكان المغادرة 
        $('#country').change(function() {
            var country_id = $(this).val();
            if (country_id != '' && country_id == 'SAR') {
                $.ajax({
                    url: "../load_city/load_saudi_cities.php",
                    method: "POST",
                    data: {
                        country_id: country_id
                    },
                    success: function(data) {
                        $('#city').html(data);
                    }
                });
            } else if (country_id != '' && country_id == 'EG') {
                $.ajax({
                    url: "../load_city/load_egypt_cities.php",
                    method: "POST",
                    data: {
                        country_id: country_id
                    },
                    success: function(data) {
                        $('#city').html(data);
                    }
                });
            } else {
                $('#city').html('<option value="">-- اختر المدينة --</option>');
            }
        });
    });
</script>


<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>