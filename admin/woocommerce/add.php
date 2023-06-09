<?php
if (isset($_POST['add_order'])) {
    $formerror = [];
    $name = $_POST['name'];
    $ship_name = $_POST['ship_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone']; 
    $area = $_POST['area'];
    $ship_area = $_POST['ship_area'];
    $city = $_POST['city'];
    $ship_city = $_POST['ship_city'];
    $address = $_POST['address'];
    $ship_address = $_POST['ship_address'];
    $order_details = $_POST['order_details'];
    $ship_price = $_POST['ship_price'];
    $order_number = $_POST['order_number'];
    $date = $_POST['order_date'];
    $total = $_POST['total_price'];
    $status = $_POST['status'];
    $status_value = $_POST['status'];

    if (empty($name)) {
        $formerror[] = ' من فضلك ادخل  اسم المستخدم ';
    }
    if (empty($email)) {
        $formerror[] = ' من فضلك ادخل  البريد الألكتروني ';
    }
    if (empty($phone)) {
        $formerror[] = ' من فضلك ادخل رقم الهاتف ';
    }
    if (empty($address)) {
        $formerror[] = ' من فضلك ادخل العنوان ';
    }

    if (empty($formerror)) {
        // insert into  main order table
        $stmt = $connect->prepare("INSERT INTO orders (order_number , name, email , phone,area,city,address,
        ship_name,ship_area,ship_city,ship_address,ship_price,
        order_details ,order_date,status,status_value,total_price)
    VALUES (:zorder_num,:zname,:zemail,:zphone,:zarea,:zcity,:zaddress,:zship_name,:zship_area,
    :zship_city,:zship_address,:zship_price,:zorder_details,:zorder_date,:zstatus,:zstatus_value,:ztotal)");
        $stmt->execute(array(
            "zorder_num" => $order_number,
            "zname" => $name,
            "zemail" => $email,
            "zphone" => $phone,
            "zarea" => $area,
            "zcity" => $city,
            "zaddress" => $address,
            "zship_name" => $ship_name, 
            "zship_area" => $ship_area,
            "zship_city" => $ship_city,
            "zship_address" => $ship_address,
            "zship_price" => $ship_price,
            "zorder_details" => $order_details,
            "zorder_date" => $date,
            "zstatus" => $status,
            "zstatus_value" => $status_value,
            "ztotal" => $total,
        ));
        // insert into order details
        // get the last order data in the first 
        /*
        $stmt = $connect->prepare("SELECT * FROM orders ORDER BY id DESC LIMIT 1");
        $stmt->execute();
        $last_order = $stmt->fetch();
        $last_order_id = $last_order['id'];
        $last_order_number = $last_order['order_number'];
        ////////////////////////////////
        for ($i = 0; $i < count($product_ids); $i++) {
            $pro_id = $product_ids[$i];
            $product_qty = $product_quantities[$i];
            // get the product price 
            $stmt = $connect->prepare("SELECT * FROM products WHERE id = ? LIMIT 1");
            $stmt->execute(array($pro_id));
            $product_details = $stmt->fetch();
            $product_price = $product_details['price'];
            $sale_price = $product_details['sale_price'];
            $stmt = $connect->prepare("INSERT INTO order_details (order_id, order_number, product_id, qty , product_price,sale_price) VALUES 
      (:zorder_id, :zorder_num, :zproduct_id, :zqty ,:zpro_price,:zsale_price)");
            $stmt->execute(array(
                "zorder_id" => $last_order_id,
                "zorder_num" => $last_order_number,
                "zproduct_id" => $pro_id,
                "zqty" => $product_qty,
                "zpro_price" => $product_price,
                "zsale_price" => $sale_price,
            ));
        }
        // insert order attachment 
        $stmt = $connect->prepare("INSERT INTO order_attachments (order_id, order_number, file_name) VALUES 
    (:zorder_id, :zorder_num, :zfiles)");
        $stmt->execute(array(
            "zorder_id" => $last_order_id,
            "zorder_num" => $last_order_number,
            "zfiles" => $location
        ));*/
        if ($stmt) {
            $_SESSION['success_message'] = " تمت الأضافة بنجاح  ";
            header('Location:main?dir=orders&page=add');
        }
    } else {
        $_SESSION['error_messages'] = $formerror;
        header('Location:main?dir=orders&page=add');
        exit();
    }
}
