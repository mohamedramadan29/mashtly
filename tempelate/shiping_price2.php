<?php
ob_start();
session_start();
include "../admin/connect.php";
//include "../init2.php"; 
$shipping_value = 0;
// تهيئة متغير السيشن إذا لم يتم إنشاؤه بعد
$shpping_errors = [];
$user_id = $_SESSION['user_id'];
//echo $_SESSION['cookie_id'];
///////////////////////// get the products wheight /////////////////////
$ship_weights = 0;
$ship_type = [];

$stmt = $connect->prepare("SELECT * FROM cart WHERE cookie_id = ?");
$stmt->execute(array($_SESSION['cookie_id']));
$allitems = $stmt->fetchAll();
$count = $stmt->rowCount();
foreach ($allitems as $item) {
    $stmt = $connect->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute(array($item['product_id']));
    $product_data_ship = $stmt->fetch();
    // before all check if this product have varibales tails or not 
    if ($item['vartion_name'] != null) {
        $vartion_id = $item['vartion_name'];
        $stmt = $connect->prepare("SELECT * FROM product_details2 WHERE product_id=? AND id = ?");
        $stmt->execute(array($item['product_id'], $vartion_id));
        $varibales_data = $stmt->fetch();
        $count_variables = $stmt->rowCount();
        if ($count_variables > 0) {
            // check if this product varition have weight or not 
            $product_var_whiehgt = $varibales_data['vartions_weghit'];
            $product_tails = $varibales_data['vartions_name'];
            if ($product_var_whiehgt != null) {
                $product_weight = $product_var_whiehgt * $item['quantity'];
            } elseif (strpos($product_tails, 'طول النبتة:') !== false) {
                // check if this products have tail or not 
                // استخراج الطول من النص
                preg_match('/طول النبتة:\s*\(([\d.]+m)\)/u', $product_tails, $matches);
                // إذا وجدت قيمة للطول، قم بطباعتها
                if (!empty($matches[1])) {
                    $plant_length = $matches[1];
                    $plant_length = $matches[1];
                    $product_tail_ship = floatval(str_replace('m', '', $plant_length));
                    //echo $product_tail_ship;
                    $stmt = $connect->prepare("SELECT * FROM shipping_weight_tools WHERE tail = ? ORDER BY id DESC LIMIT 1");
                    $stmt->execute(array($product_tail_ship));
                    $product_weight_tail_data = $stmt->fetch();
                    $count_weight_tail = $stmt->rowCount();
                    if ($count_weight_tail > 0) {
                        $product_weight = $product_weight_tail_data['weight'] * $item['quantity'];
                    } else {
                        $product_weight = 0;
                        $shpping_errors[] = 'يوجد مشكلة في منتج  :' . $item['product_name'];

?>
                        <!-- <span class="badge badge-danger bg-danger"> هناك مشكلة في هذا المنتج من فضلك تواصل مع الادارة </span> -->

                    <?php
                    }
                }
            } elseif (!empty($product_data_ship['ship_weight'])) {
                $product_weight = $product_data_ship['ship_weight'] * $item['quantity'];
            } elseif (!empty($product_data_ship['ship_tail'])) {
                $product_tail_ship = $product_data_ship['ship_tail'];
                $stmt = $connect->prepare("SELECT * FROM shipping_weight_tools WHERE tail = ? ORDER BY id DESC LIMIT 1");
                $stmt->execute(array($product_tail_ship));
                $product_weight_tail_data = $stmt->fetch();
                $count_weight_tail = $stmt->rowCount();
                if ($count_weight_tail > 0) {
                    $product_weight = $product_weight_tail_data['weight'] * $item['quantity'];
                } else {
                    ?>
                    <!-- <span class="badge badge-danger bg-danger"> 11 هناك مشكلة في تحديد وزن الشحنة من فضلك تواصل مع الادارة </span> -->
                <?php
                }
            } else {
                ?>
                <!-- <span class="badge badge-danger bg-danger"> 22 هناك مشكلة في تحديد وزن الشحنة من فضلك تواصل مع الادارة </span> -->
            <?php
            }
        }
    } else {
        // check if this item have wheight or not 
        if (!empty($product_data_ship['ship_weight'])) {
            $product_weight = $product_data_ship['ship_weight'] * $item['quantity'];
            //echo $product_weight;
        } else {
            $product_tail_ship = $product_data_ship['ship_tail'];
            $stmt = $connect->prepare("SELECT * FROM shipping_weight_tools WHERE tail = ? ORDER BY id DESC LIMIT 1");
            $stmt->execute(array($product_tail_ship));
            $product_weight_tail_data = $stmt->fetch();
            $count_weight_tail = $stmt->rowCount();
            if ($count_weight_tail > 0) {
                $product_weight = $product_weight_tail_data['weight'] * $item['quantity'];
            } else {
                // $product_weight = 0;
                $shpping_errors[] = 'يوجد مشكلة في منتج  :' . $item['product_name'];
                //echo $_SESSION['shipping_problems'];
            ?>
                <!-- <span class="badge badge-danger bg-danger"> 33 هناك مشكلة في تحديد وزن الشحنة من فضلك تواصل مع الادارة </span> -->
<?php
            }
        }
    }
    $ship_weights += $product_weight;
    $ship_weights = number_format($ship_weights, 2);

    $stmt = $connect->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->execute(array($product_data_ship['cat_id']));
    $category_data = $stmt->fetch();
    $category_type = $category_data['main_category'];
    if ($category_type == 1) {
        $ship_type[] = 1;
    } elseif ($category_type == 2) {
        $ship_type[] = 2;
    }
}
?>
<?php
//   var_dump($ship_type);
// تحديد نوع الشحنة بناءً على فئة المنتج
if (in_array('1', $ship_type) && in_array('2', $ship_type)) {
    $ship_type_data = 'مختلطة نباتات ومستلزمات';

} elseif (in_array('1', $ship_type)) {
    $ship_type_data = 'نباتات';
} elseif (in_array('2', $ship_type)) {
    $ship_type_data = 'مستلزمات';
} else {
    echo 'نوع الفئة غير متوقع';
}
//echo $ship_type_data;
?>
<?php
// get user address

///////// Check If This User Have Address Or Not 

if (isset($_POST['city'])) {
    $stmt = $connect->prepare("SELECT * FROM suadia_city WHERE name = ?");
    $stmt->execute(array($_POST['city']));
    $address_data = $stmt->fetch();
    $user_area = $address_data['region'];
    $area_code = $address_data['reg_id'];
    $user_city = $address_data['name'];
   // echo $user_city;
} else {
    $stmt = $connect->prepare("SELECT * FROM user_address WHERE user_id = ?");
    $stmt->execute(array($user_id));
    $address_data = $stmt->fetch();
    $count_address = $stmt->rowCount();
    $user_area = $address_data['area'];
    $area_code = $address_data['area_code'];
    $user_city = $address_data['city'];
}

// get the companies contain all terms in this cart 
// بناء الاستعلام الجديد الخاص بشركات الشحن 
// اول شي هشوف المناطق 
$stmt = $connect->prepare("SELECT * FROM company_areas WHERE FIND_IN_SET(?,ship_area) > 0 AND FIND_IN_SET(?,ship_type) > 0 AND whight_from <= ? AND whight_to >= ? ");
$stmt->execute(array($area_code, $ship_type_data, $ship_weights, $ship_weights));
// get the area data 
$area_data = $stmt->fetch();
$count_available_area_company = $stmt->rowCount();
if ($count_available_area_company > 0) {
    // echo "Area :: company_id " . $area_data['company_id'];
    //     echo "</br>";
    // echo "هناك شركة شحن متاحة ";
    $start_from_price = $area_data['ship_start_from_price'];
    $end_to_price = $area_data['ship_end_to_price'];
    $ship_price = $area_data['default_whight_ship_price'];
    $more_kilo_price = $area_data['more_kilo_price'];
    if ($ship_weights >= $start_from_price && $ship_weights <= $end_to_price) {
        $ship_price = $ship_price;
    } else {
        // add more price for ship whight
        $overweight = $ship_weights - $end_to_price;
        $over_price =  $overweight * $more_kilo_price;
        $ship_price = $ship_price + $over_price;
    }
} else {
   // echo "</br>";
  //  echo "لا يوجد شركات شحن متاحة في المناطق هشوف النطاقات";
    $stmt = $connect->prepare("SELECT * FROM company_trips WHERE  FIND_IN_SET(?,ship_type) > 0 AND FIND_IN_SET(?,ship_city) > 0 AND whight_from <= ? AND whight_to >= ?");
    $stmt->execute(array($ship_type_data, $user_city, $ship_weights, $ship_weights));
    // get the Trip data 
    $trip_data = $stmt->fetch();
    $count_available_trip_company = $stmt->rowCount();
    if ($count_available_trip_company > 0) {
        // echo "Trip :: company_id " . $trip_data['company_id'];

        $start_from_price = $trip_data['ship_start_from_price'];
        $end_to_price = $trip_data['ship_end_to_price'];
        $ship_price = $trip_data['default_whight_ship_price'];
        $more_kilo_price = $trip_data['more_kilo_price'];
        if ($ship_weights >= $start_from_price && $ship_weights <= $end_to_price) {
            $ship_price = $ship_price;
        } else {
            // add more price for ship whight
            $overweight = $ship_weights - $end_to_price;
            $over_price =  $overweight * $more_kilo_price;
            $ship_price = $ship_price + $over_price;
        }
    } else {
        //$company_shipping2 = 0;
        $shipping_value = 0;
        $_SESSION['shipping_area_error'] = ' نعتذر لك عميلنا العزيز، حالياً لا تتوفر خدمة التوصيل للمنطقة التي اخترتها، وسنوافيكم بمجرد توفرها لاحقاً بإذن الله.';
        echo $_SESSION['shipping_area_error'];
    }
}
$shipping_value =  $ship_price;
// if ($shipping_value == 0) {
//     $shipping_value = 45;
// } 
if ($company_shipping2 == 0) {
    // $shipping_value = 0;
    //$_SESSION['shipping_area_error'] = ' نعتذر لك عميلنا العزيز، حالياً لا تتوفر خدمة التوصيل للمنطقة التي اخترتها، وسنوافيكم بمجرد توفرها لاحقاً بإذن الله.';
    // echo $_SESSION['shipping_area_error'];
    //unset($_SESSION['shipping_area_error']);
}
?>
<?php // echo number_format($shipping_value, 2); ?>
<?php $_SESSION['shipping_value'] = number_format($shipping_value,2);
echo $shipping_value;

?>

<?php

$shipping_errors_string = implode(', ', $shpping_errors);
$_SESSION['shipping_problem'] = $shipping_errors_string;
