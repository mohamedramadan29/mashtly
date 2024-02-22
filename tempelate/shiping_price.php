<?php
$shipping_value = 0;
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    ///////////////////////// get the products wheight /////////////////////
    $ship_weights = 0;
    $ship_type = [];
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
                // check if this products have tail or not 
                $product_tails = $varibales_data['vartions_name'];
                // استخراج الطول من النص
                preg_match('/طول النبتة:\s*\(([\d.]+m)\)/u', $product_tails, $matches);
                // إذا وجدت قيمة للطول، قم بطباعتها
                if (!empty($matches[1])) {
                    $plant_length = $matches[1];
                    $plant_length = $matches[1];
                    $product_tail_ship = floatval(str_replace('m', '', $plant_length));
                    $stmt = $connect->prepare("SELECT * FROM shipping_weight_tools WHERE tail = ? ORDER BY id DESC LIMIT 1");
                    $stmt->execute(array($product_tail_ship));
                    $product_weight_tail_data = $stmt->fetch();
                    $count_weight_tail = $stmt->rowCount();
                    if ($count_weight_tail > 0) {
                        $product_weight = $product_weight_tail_data['weight'] * $item['quantity'];
                    } else {
                        ?>
                        <span class="badge badge-danger bg-danger"> هناك مشكلة في هذا المنتج من فضلك تواصل مع الادارة </span>
                        
                        <?php 
                    }
                }
            }
        } else {
            // check if this item have wheight or not 
            if (!empty($product_data_ship['ship_weight'])) {
                $product_weight = $product_data_ship['ship_weight'] * $item['quantity'];
                // echo $product_weight;
            } else {
                $product_tail_ship = $product_data_ship['ship_tail'];
                $stmt = $connect->prepare("SELECT * FROM shipping_weight_tools WHERE tail = ? ORDER BY id DESC LIMIT 1");
                $stmt->execute(array($product_tail_ship));
                $product_weight_tail_data = $stmt->fetch();
                $count_weight_tail = $stmt->rowCount();
                if ($count_weight_tail > 0) {
                    $product_weight = $product_weight_tail_data['weight'] * $item['quantity'];
                } else {

?>
                    <span class="badge badge-danger bg-danger"> هناك مشكلة في هذا المنتج من فضلك تواصل مع الادارة </span>
    <?php
                }
            }
        }

        $ship_weights += $product_weight;
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
    <?php
    // get user address
    $stmt = $connect->prepare("SELECT * FROM user_address WHERE user_id = ? AND default_address = 1");
    $stmt->execute(array($user_id));
    $address_data = $stmt->fetch();
    $count_address = $stmt->rowCount();
    if ($count_address > 0) {
        $user_area = $address_data['area'];
        $area_code = $address_data['area_code'];


        // get the companies contain all terms in this cart 
        // بناء الاستعلام
        $stmt = $connect->prepare("SELECT * FROM shipping_company WHERE FIND_IN_SET(?,ship_type) > 0 AND FIND_IN_SET(?, ship_area) > 0 AND whight_from <= ? AND whight_to >= ?");
        $stmt->execute(array($ship_type_data, $area_code, $ship_weights, $ship_weights));
        $shipping_company_data = $stmt->fetch();
        $count_shipping_company = $stmt->rowCount();

        if ($count_shipping_company > 0) {
            echo "</br>";
            $company_name = $shipping_company_data['company_name'];
            $start_from_price = $shipping_company_data['ship_start_from_price'];
            $end_to_price = $shipping_company_data['ship_end_to_price'];
            $ship_price = $shipping_company_data['default_whight_ship_price'];
            $more_kilo_price = $shipping_company_data['more_kilo_price'];
            if ($ship_weights >= $start_from_price && $ship_weights <= $end_to_price) {
                $ship_price = $ship_price;
            } else {
                // add more price for ship whight
                $overweight = $ship_weights - $end_to_price;
                $over_price =  $overweight * $more_kilo_price;
                $ship_price = $ship_price + $over_price;
            }
            $shipping_value =  $ship_price;
        } else {
    ?>
            <span class="badge badge-danger bg-danger"> لا يوجد شركات متاحة من فضلك تواصل مع الاداره </span>
        <?php

        }
    } else {
        ?>
        <div class="alert alert-danger"> <a href="profile/address/index"> اضف عنوانك او اجلعه اساسي لتتمكن من الشحن </a> </div>
    <?php
    }


    ?>
    <h2 class="total"><?php echo number_format($shipping_value, 2); ?> ر.س </h2>
<?php
} else {
    $shipping_value = 0;
?>
    <h2 class="total"> لم يحدد بعد </h2>
<?php
}
?>