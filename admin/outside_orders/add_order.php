<?php
if (isset($_POST['add_new_outside_order'])) {

    try {
        $formerror = [];
        /////////////// Start User Data /////////////////////
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $city = $_POST['city'];
        $build_number = $_POST['build_number'];
        $street_name = $_POST['street_name'];
        $stmt = $connect->prepare("SELECT * FROM suadia_city WHERE name=?");
        $stmt->execute(array($city));
        $city_data = $stmt->fetch();
        $area = $city_data['region'];

        $area_code = $city_data['reg_id'];
        $address = $build_number . '-' . $street_name . '-' . $area . '-' . $city . '-' . $country;
        $email = $_POST['email'];
        $order_date = date("n/j/Y g:i A");
        $status = 0;
        $status_value = 'لم يبدا';
        $farm_service = 0;
        /////////////////// 
        /// المشاكل في 
        // 1 - الشحن 
        //////////
        ///////////////////////// End User Data ////////////////////////////////// 
        $order_details = sanitizeInput($_POST['order_details']);
        /////////// /
        ////////// Inside Products ///////////
        $pro_names_inside = $_POST['select_product_from_store'];
        $inside_vartions = $_POST['select_product_vartion_from_store'];
        $inside_qtys = $_POST['select_product_qty_from_store'];

        //////// Get The Product Inside Total /////////
        $total_product_inside = 0;
        foreach ($pro_names_inside as $index => $product_id) {
            if (!empty($product_id)) {
                $inside_vartion = $inside_vartions[$index];
                if ($inside_vartion != null) {
                    /// Get the Vartion 
                    $stmt = $connect->prepare("SELECT * FROM product_details2 WHERE id = ?");
                    $stmt->execute(array($inside_vartion));
                    $vartion_data = $stmt->fetch();
                    $vartion_price = $vartion_data['price'];
                    $vartion_price = $vartion_price * $inside_qtys[$index];
                    $total_product_inside = $total_product_inside + $vartion_price;
                } else {
                    $stmt = $connect->prepare("SELECT * FROM products WHERE id = ?");
                    $stmt->execute(array($product_id));
                    $product_data = $stmt->fetch();
                    $product_price = $product_data['price'];
                    $product_price = $product_price * $inside_qtys[$index];
                    $total_product_inside = $total_product_inside + $product_price;
                }
            }
        }
        // echo $total_product_inside;
        // var_dump($qtys);
        /// OutSide Products //////////
        $pro_names = $_POST['pro_name'];
        $pro_types = $_POST['pro_type'];
        $pro_qtys = $_POST['pro_qty'];

        $pro_tails = $_POST['pro_tail'];
        $pro_first_prices = $_POST['pro_first_price'];
        $pro_main_prices = $_POST['pro_main_price'];

        ////////////// Get The OutSide Products Price ///////////

        $outsideproduct_price = 0;
        foreach ($pro_names as $index => $pro_name) {
            if (!empty($pro_name)) {
                $pro_main_price = $pro_main_prices[$index] * $pro_qtys[$index];
                $outsideproduct_price = $pro_main_price + $outsideproduct_price;
            }
        }
        //echo $outsideproduct_price;

        ////////////// End OuTSide Products //////////
        /// /////////Start OutSide Services ///////
        $outside_services_price = 0;
        $serv_names = $_POST['serv_name'];
        $serv_first_prices = $_POST['serv_first_price'];
        $serv_main_prices = $_POST['serv_main_price'];
        ///////// Get The Serv Prices 
        foreach ($serv_names as $index => $serv_name) {
            if (!empty($serv_name)) {
                $serv_main_price = $serv_main_prices[$index];
                $outside_services_price = $outside_services_price + $serv_main_price;
            }
        }
        //echo $outside_services_price;
        //echo $total_prices;
        /////////// End OutSide Services ///////

        /// End OutSide Services //////////////
        // get the last order number  id and number
        $stmt = $connect->prepare("SELECT * FROM outside_orders ORDER BY id DESC LIMIT 1");
        $stmt->execute();
        $order_data = $stmt->fetch();
        $order_id = $order_data['id'];
        // Increment the count by 1 for the new order number
        $order_number = $order_data['order_number'] + 1;
        $user_id = 0;
        $country = 'SAR';
        $payment_method = 'الدفع عن الاستلام';
        if ($farm_service == '') {
            $farm_service = 0;
        }
        if (empty($area) || empty($city) || empty($name) || empty($phone) || empty($address)) {
            $formerror[] = ' من فضلك ادخل العنوان الخاص بك بشكل صحيح  ';
        }
        include "outside_orders/shipping_price.php";

        $total_prices = $total_product_inside + $outsideproduct_price + $outside_services_price + $shipping_value;

        if (empty($formerror)) {
            if ($payment_method === 'الدفع عن الاستلام') {
                // inset order into orders

                $stmt = $connect->prepare("INSERT INTO outside_orders (order_number, user_id, name, email,phone,
                                    area, city, address, ship_price,order_details, order_date, status,status_value,
                                    farm_service_price,total_price,
                                    payment_method)
                                    VALUES (:zorder_number , :zuser_id , :zname , :zemail ,:zphone , :zarea , :zcity ,
                                    :zaddress,
                                    :zship_price,:zorder_details, :zorder_date, :zstatus, :zstatus_value,
                                    :zfarm_service_price,:ztotal_price,:zpayment_method)");
                $stmt->execute(array(
                    "zorder_number" => $order_number, "zuser_id" => $user_id, "zname" => $name,
                    "zemail" => $email, "zphone" => $phone, "zarea" => $area, "zcity" => $city,
                    "zaddress" => $address, "zship_price" => $shipping_value, "zorder_details" => $order_details, "zorder_date" => $order_date,
                    "zstatus" => $status, "zstatus_value" => $status_value, "zfarm_service_price" => $farm_service,
                    "ztotal_price" => $total_prices, "zpayment_method" => $payment_method,

                ));
                // get the last order number  id and number
                $stmt = $connect->prepare("SELECT * FROM outside_orders ORDER BY id DESC LIMIT 1");
                $stmt->execute();
                $order_data = $stmt->fetch();
                $order_id = $order_data['id'];
                $order_number = $order_data['order_number'];
                // $_SESSION['order_number'] = $order_number;

                foreach ($pro_names_inside as $index => $name) {
                    if (!empty($name)) {
                        $product_id = $name;
                        $qty = $inside_qtys[$index];

                        //$pro_qty_inside = 1;
                        $price = 12;
                        $farm_service = null;
                        $as_present = null;
                        $more_details = $inside_vartions[$index];
                        $total_price = $price * $quantity;
                        // Insert Order Details
                        $stmt = $connect->prepare("INSERT INTO outside_order_details (order_id, order_number,product_id,
                                        qty, product_price, total,farm_service, as_present,more_details)
                                        VALUES (:zorder_id, :zorder_number,:zproduct_id,
                                        :zqty, :zproduct_price, :ztotal,:zfarm_service, :zas_present,:zmore_details)
                                        ");
                        $stmt->execute(array(
                            "zorder_id" => $order_id,
                            "zorder_number" => $order_number,
                            "zproduct_id" => $product_id,
                            "zqty" => $qty,
                            "zproduct_price" => $price,
                            "ztotal" => $total_price,
                            "zfarm_service" => $farm_service,
                            "zas_present" => $as_present,
                            "zmore_details" => $more_details,
                        ));
                    }

                    // insert order steps
                    // get the  date
                    date_default_timezone_set('Asia/Riyadh'); // تحديد المنطقة الزمنية
                    $date = date('d/m/Y h:i a'); // تنسيق التاريخ والوقت
                }


                //////////////////// Start  Insert OutSide Products ////////////////
                foreach ($pro_names as $index => $name) {
                    if (!empty($name)) {
                        $pro_type = $pro_types[$index];
                        $pro_qty = $pro_qtys[$index];
                        $pro_tail = $pro_tails[$index];
                        $pro_first_price = $pro_first_prices[$index];
                        $pro_main_price = $pro_main_prices[$index];
                        $stmt = $connect->prepare("INSERT INTO outside_products (order_id,order_number,product_name,product_qty,product_type,product_tail,first_price,main_price)
                                            VALUES (:zorder_id,:zorder_number,:zproduct_name,:zproduct_qty,:zproduct_type,:zproduct_tail,:zfirst_price,:zmain_price)
                                            ");

                        $stmt->execute(array(
                            'zorder_id' => $order_id,
                            "zorder_number" => $order_number,
                            'zproduct_name' => $name,
                            'zproduct_qty' => $pro_qty,
                            'zproduct_type' => $pro_type,
                            'zproduct_tail' => $pro_tail,
                            'zfirst_price' => $pro_first_price,
                            'zmain_price' => $pro_main_price,
                        ));
                        //////////// End  Insert Into OutSide Products //////////////////////
                    }
                }


                /////////////////////// Start Insert OutSide Services  ////////////////////////
                ///
                foreach ($serv_names as $index => $serv_name) {
                    if (!empty($serv_name)) {
                        $serv_first_price = $serv_first_prices[$index];
                        $serv_main_price = $serv_main_prices[$index];

                        $stmt = $connect->prepare("INSERT INTO outside_services (order_id,order_number,serv_name,first_price,main_price)
                                            VALUES (:zorder_id,:zorder_number,:zserv_name,:zfirst_price,:zmain_price)
                                            ");
                        $stmt->execute(array(
                            'zorder_id' => $order_id,
                            "zorder_number" => $order_number,
                            'zserv_name' => $serv_name,
                            'zfirst_price' => $serv_first_price,
                            'zmain_price' => $serv_main_price,
                        ));
                    }
                }
                /////////////////////// End Insert OutSide Services ///////////////////////////
                if ($stmt) {
                    header("Location:main.php?dir=outside_orders&page=add");
                }
            }
        } else {
            foreach ($formerror as $error) {



?>

                <div style="margin-top: 20px;" class="alert alert-danger"> <?php echo $error; ?> </div>
<?php
            }
        }
    } catch (\Exception $e) {
        echo $e;
    }
}
?>