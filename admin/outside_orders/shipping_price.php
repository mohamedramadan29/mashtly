<?php
$shipping_value = 0;
// تهيئة متغير السيشن إذا لم يتم إنشاؤه بعد

$shpping_errors = [];
$user_id = $_SESSION['user_id'];
///////////////////////// get the products wheight /////////////////////
$ship_weights = 0;
$ship_type = [];

//////////////// Get The Products Weight And Ship Inside Shop 
foreach ($pro_names_inside as $index => $product_id) {
    $inside_vartion = $inside_vartions[$index];
    $inside_qty =  $inside_qtys[$index];
    //foreach ($allitems as $item) {
    $stmt = $connect->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute(array($product_id));
    $product_data_ship = $stmt->fetch();
    // before all check if this product have varibales tails or not 
    if ($inside_vartion != null) {
        $vartion_id = $inside_vartion;
        $stmt = $connect->prepare("SELECT * FROM product_details2 WHERE product_id=? AND id = ?");
        $stmt->execute(array($product_id, $vartion_id));
        $varibales_data = $stmt->fetch();
        $count_variables = $stmt->rowCount();
        if ($count_variables > 0) {
            // check if this product varition have weight or not 
            $product_var_whiehgt = $varibales_data['vartions_weghit'];
            $product_tails = $varibales_data['vartions_name'];
            if ($product_var_whiehgt != null) {
                $product_weight = $product_var_whiehgt * $inside_qty;
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
                        $product_weight = $product_weight_tail_data['weight'] * $inside_qty;
                    } else {
                        $product_weight = 0;
                        $shpping_errors[] = 'يوجد مشكلة في منتج  :' . $product_id;
?>
                        <!-- <span class="badge badge-danger bg-danger"> هناك مشكلة في هذا المنتج من فضلك تواصل مع الادارة </span> -->

                    <?php
                    }
                }
            } elseif (!empty($product_data_ship['ship_weight'])) {
                $product_weight = $product_data_ship['ship_weight'] * $inside_qty;
            } elseif (!empty($product_data_ship['ship_tail'])) {
                $product_tail_ship = $product_data_ship['ship_tail'];
                $stmt = $connect->prepare("SELECT * FROM shipping_weight_tools WHERE tail = ? ORDER BY id DESC LIMIT 1");
                $stmt->execute(array($product_tail_ship));
                $product_weight_tail_data = $stmt->fetch();
                $count_weight_tail = $stmt->rowCount();
                if ($count_weight_tail > 0) {
                    $product_weight = $product_weight_tail_data['weight'] * $inside_qty;
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
            $product_weight = $product_data_ship['ship_weight'] * $inside_qty;
            //echo $product_weight;
        } else {
            $product_tail_ship = $product_data_ship['ship_tail'];
            $stmt = $connect->prepare("SELECT * FROM shipping_weight_tools WHERE tail = ? ORDER BY id DESC LIMIT 1");
            $stmt->execute(array($product_tail_ship));
            $product_weight_tail_data = $stmt->fetch();
            $count_weight_tail = $stmt->rowCount();
            if ($count_weight_tail > 0) {
                $product_weight = $product_weight_tail_data['weight'] * $inside_qty;
            } else {
                // $product_weight = 0;
                $shpping_errors[] = 'يوجد مشكلة في منتج  :' . $product_id;
                //echo $_SESSION['shipping_problems'];
            ?>
                <!-- <span class="badge badge-danger bg-danger"> 33 هناك مشكلة في تحديد وزن الشحنة من فضلك تواصل مع الادارة </span> -->
<?php
            }
        }
    }
    $ship_weights += $product_weight;
    $ship_weights = number_format($ship_weights, 2);

    echo "</br>";
    // check this products category type [ نباتات , مستلزمات  ]
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
////////////////////////////////////////////////////////// Get The Product Weight ///////////////////////////
//////////////
//////////////////
//////////////

$outside_ship_weights = 0;
foreach ($pro_names as $index => $outside_product_id) {
    $outside_tail = $pro_tails[$index];
    $outside_qty = $pro_qtys[$index];
    $outside_type = $pro_types[$index];
    //foreach ($allitems as $item) {
    $stmt = $connect->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute(array($product_id));
    $product_data_ship = $stmt->fetch();
    // before all check if this product have varibales tails or not 
    if ($outside_tail != null) {

        $stmt = $connect->prepare("SELECT * FROM shipping_weight_tools WHERE tail = ? ORDER BY id DESC LIMIT 1");
        $stmt->execute(array($outside_tail));
        $product_weight_tail_data = $stmt->fetch();
        $count_weight_tail = $stmt->rowCount();
        if ($count_weight_tail > 0) {
            $product_weight = $product_weight_tail_data['weight'] * $outside_qty;
        }
    }

    $outside_ship_weights += $product_weight;
    $outside_ship_weights = number_format($outside_ship_weights, 2);
    if ($outside_type == 'نباتات') {
        $ship_type[] = 1;
    } elseif ($outside_type == 'مستلزمات') {
        $ship_type[] = 2;
    }
}

////////////////////////////////////////////////////////// Get The Product Weight ///////////////////////////
//////////////
//////////////////
//////////////

$last_ship_weight = $ship_weights + $outside_ship_weights;
?>
<!-- <h2> وزن المنتجات في السلة :: <?php echo $ship_weights; ?> كيلو جرام </h2> -->
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
?>
<!-- <h2> نوع المنتجات في السلة :: <?php echo $ship_type_data; ?> </h2> -->
<?php
// get user address

$user_area = $city_data['region'];
$area_code = $area_code;
$user_city = $city;
// get the companies contain all terms in this cart 
// بناء الاستعلام الجديد الخاص بشركات الشحن 
// اول شي هشوف المناطق 
$stmt = $connect->prepare("SELECT * FROM company_areas WHERE FIND_IN_SET(?,ship_area) > 0 AND FIND_IN_SET(?,ship_type) > 0 AND whight_from <= ? AND whight_to >= ? ");
$stmt->execute(array($area_code, $ship_type_data, $last_ship_weight, $last_ship_weight));
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
    if ($last_ship_weight >= $start_from_price && $last_ship_weight <= $end_to_price) {
        $ship_price = $ship_price;
    } else {
        // add more price for ship whight
        $overweight = $last_ship_weight - $end_to_price;
        $over_price =  $overweight * $more_kilo_price;
        $ship_price = $ship_price + $over_price;
    }
} else {
    echo "</br>";
    echo "لا يوجد شركات شحن متاحة في المناطق هشوف النطاقات";
    $stmt = $connect->prepare("SELECT * FROM company_trips WHERE  FIND_IN_SET(?,ship_type) > 0 AND FIND_IN_SET(?,ship_city) > 0 AND whight_from <= ? AND whight_to >= ?");
    $stmt->execute(array($ship_type_data, $user_city, $last_ship_weight, $last_ship_weight));
    // get the Trip data 
    $trip_data = $stmt->fetch();
    $count_available_trip_company = $stmt->rowCount();
    if ($count_available_trip_company > 0) {
        // echo "Trip :: company_id " . $trip_data['company_id'];
        echo "</br>";
        echo "هناك شركة شحن متاحة ";
        $start_from_price = $trip_data['ship_start_from_price'];
        $end_to_price = $trip_data['ship_end_to_price'];
        $ship_price = $trip_data['default_whight_ship_price'];
        $more_kilo_price = $trip_data['more_kilo_price'];
        if ($last_ship_weight >= $start_from_price && $last_ship_weight <= $end_to_price) {
            $ship_price = $ship_price;
        } else {
            // add more price for ship whight
            $overweight = $last_ship_weight - $end_to_price;
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

echo "</br>";

?>
<h2 class="total"><?php echo number_format($shipping_value, 2); ?> ر.س </h2>
<?php $_SESSION['shipping_value'] = $shipping_value; ?>
<?php

$shipping_errors_string = implode(', ', $shpping_errors);
$_SESSION['shipping_problem'] = $shipping_errors_string;

?>

<?php
