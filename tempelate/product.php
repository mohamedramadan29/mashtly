<div class="product_info">
    <span class="discount_value"> خصم 22 % </span>
    <!-- get the product image -->
    <?php
    $stmt = $connect->prepare("SELECT * FROM products_image WHERE product_id = ?");
    $stmt->execute(array($product['id']));
    //  getproductimage($connect,$product['id']);
    $count_image = $stmt->rowCount();
    $product_data_image = $stmt->fetch();
    if ($count_image > 0) {
        ?>
        <a href="http://localhost/mashtly/product/<?php echo $product['slug']; ?>">
            <img loading="lazy" class="main_image"
                src="http://localhost/mashtly/uploads/products/<?php echo $product_data_image['main_image']; ?>"
                alt="<?php echo $product['name']; ?>">
        </a>
        <?php
    } else {
        ?>
        <img loading="lazy" class="main_image" src="uploads/product.png" alt="صورة المنتج">
        <?php
    }
    ?>
    <div class="product_details">

        <?php
        // استخراج الاسم
        $name = $product['name'];

        // تحويل الاسم إلى مصفوفة من الكلمات
        $words = explode(' ', $name);

        // الحصول على الكلمات الأولى 15
        $shortened_name = implode(' ', array_slice($words, 0, 5));

        // إضافة نقطتين بعد الاسم المختصر
        if (count($words) > 5) {
            $shortened_name .= ' ...';
        }
        // عرض الاسم المختصر
        
        ?>
        <p> <a href="http://localhost/mashtly/product/<?php echo $product['slug']; ?>"> <?php echo $shortened_name; ?>
            </a> </p>
        <?php
        $maximumPrice = -INF; // قيمة أقصى سعر ممكنة
        $minimumPrice = INF; // قيمة أدنى سعر ممكنة
        $oldmaximumPrice = -INF; // قيمة أقصى سعر ممكنة
        $oldminimumPrice = INF; // قيمة أدنى سعر ممكنة
        // نشوف علي المنتج يحتوي علي متغيرات او لا
        $stmt = $connect->prepare("SELECT * FROM product_details2 WHERE product_id = ? AND price != ''");
        $stmt->execute(array($product['id']));
        $count_pro_attr = $stmt->rowCount();
        if ($count_pro_attr > 0) {
            $allproduct_data = $stmt->fetchAll();
            foreach ($allproduct_data as $product_data) {
                //$pro_price = $product_data['price'];
                $pro_price = $product_data['price'];

                // السعر بعد زيادة 10% وخصم 22%
                $pro_price = $pro_price + ($pro_price * 0.05);
                // تحديث القيم القصوى والدنيا
                $maximumPrice = max($maximumPrice, $pro_price);
                $minimumPrice = min($minimumPrice, $pro_price);
            }
            // عرض السعر
            if ($maximumPrice === $minimumPrice) {
                ?>
                <h4 class='price'>

                    <?php echo number_format($minimumPrice, 2); ?> <img src="https://www.localhost/mashtly/uploads/riyal.svg"
                        width="30px" height="30px">
                </h4>
                <?php
            } else {
                ?>
                <h4 class='price'>
                    <?php echo number_format($minimumPrice, 2); ?> -
                    <?php echo number_format($maximumPrice, 2); ?> <img src="https://www.localhost/mashtly/uploads/riyal.svg"
                        width="30px" height="30px">
                </h4>
                <?php
            }
            ?>
            <?php
        } else {
            ?>
            <h4 class='price'> <?php
            if ($product['sale_price'] != '' && $product['sale_price'] != 0) {
                ?>

                    <span style="font-weight: bold;">
                        <?php echo number_format($product['sale_price'] + ($product['sale_price'] * 0.05), 2); ?>
                    </span>
                    <?php

            } else {
                ?>
                    <span style="font-weight: bold;">
                        <?php echo number_format($product['price'] + ($product['price'] * 0.05), 2); ?>
                    </span>
                    <?php

            }
            ?> <img src="https://www.localhost/mashtly/uploads/riyal.svg" width="30px" height="30px">
            </h4>
            <?php
        }
        ?>
    </div>
</div>