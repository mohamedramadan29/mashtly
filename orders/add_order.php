<?php
if (isset($_POST['add_order'])) {
    $formerror = [];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $order_details = $_POST['order_details'];
    $notes = $_POST['notes'];
    //$pro_id = $_POST['pro_id'];
    //$product_qty = $_POST['product_qty'];
    $product_ids = $_POST['pro_id'];
    $product_quantities = $_POST['product_qty'];
    // get the order number 
    // first need random number
    $length = 5; // Set the length of the random string
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; // Set the characters to use
    $randomString = '';
    // Generate the random string
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    $randomString =  substr($randomString, 0, 5);

    $stmt = $connect->prepare("SELECT * FROM orders");
    $stmt->execute();
    $order_data = $stmt->fetch();
    $count = $stmt->rowCount();
    if ($count > 0) {
        $order_number = "mash_" . $order_data['id'] . $randomString;
    } else {
        $order_number = 'mash_' . "1" . $randomString;
    }
    // get the  date
    date_default_timezone_set('Asia/Riyadh'); // تحديد المنطقة الزمنية
    $date = date('d/m/Y h:i a'); // تنسيق التاريخ والوقت

    // product gallary 

    $file = '';
    $file_tmp = '';
    $location = "";
    $uploadplace = "order_attachments/";
    if (isset($_FILES['order_files']['name'])) {
        foreach ($_FILES['order_files']['name'] as $key => $val) {
            $file = $_FILES['order_files']['name'][$key];
            $file = str_replace(' ', '', $file);
            $file_tmp = $_FILES['order_files']['tmp_name'][$key];
            move_uploaded_file($file_tmp, $uploadplace . $file);
            $location .= $file . ",";
        }
    }
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
        $stmt = $connect->prepare("INSERT INTO orders (order_number , name, email , phone,address,order_details , notes,order_date)
    VALUES (:zorder_num,:zname,:zemail,:zphone,:zaddress,:zorder_details,:znotes,:zorder_date)");
        $stmt->execute(array(
            "zorder_num" => $order_number,
            "zname" => $name,
            "zemail" => $email,
            "zphone" => $phone,
            "zaddress" => $address,
            "zorder_details" => $order_details,
            "znotes" => $notes,
            "zorder_date" => $date,
        ));
        // insert into order details
        // get the last order data in the first 
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
        ));
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
