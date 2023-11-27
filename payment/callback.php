<div class="section section-md contact_us login_page" style='background-color:#f1f1f1'>
    <div class="container">
        <?php
        ob_start();
        session_start();
        $pagetitle = '  حسابي  ';
        include '../admin/connect.php';
        if (isset($_GET['tap_id'])) {
            $tap_id = $_GET['tap_id'];
            $curl = curl_init();
            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => "https://api.tap.company/v2/charges/" . $tap_id,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_POSTFIELDS => "{}",
                    CURLOPT_HTTPHEADER => array(
                        "authorization: Bearer sk_test_XKokBfNWv6FIYuTMg5sLPjhJ" // مفتاح الواجهة السري
                    ),
                )
            );
            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            $responseTap = json_decode($response);
            // var_dump($response);

            if ($responseTap->status == 'CAPTURED') {
                // if ($responseTap->status == 'DECLINED') {
                // get all product from user cart
                $order_data = $_SESSION['order_data'];
                $stmt = $connect->prepare("SELECT * FROM cart WHERE cookie_id = ?");
                $stmt->execute(array($order_data['cookie_id']));
                $count = $stmt->rowCount();
                $allitems = $stmt->fetchAll();

                $payment_method = 'الدفع الالكتروني';
                // inset order into orders 
                $stmt = $connect->prepare("INSERT INTO orders (order_number, user_id, name, email,phone,
                  area, city, address, ship_price, order_date, status, status_value,total_price,
                  payment_method) 
                  VALUES (:zorder_number , :zuser_id , :zname , :zemail ,:zphone , :zarea , :zcity , :zaddress,
                  :zship_price, :zorder_date, :zstatus, :zstatus_value,:ztotal_price,:zpayment_method)");
                $stmt->execute(array(
                    "zorder_number" => $order_data['order_number'], "zuser_id" => $order_data['user_id'], "zname" => $order_data['name'],
                    "zemail" => $order_data['email'], "zphone" => $order_data['phone'], "zarea" => $order_data['area'], "zcity" => $order_data['city'],
                    "zaddress" => $order_data['address'], "zship_price" => $order_data['ship_price'], "zorder_date" => $order_data['order_date'],
                    "zstatus" => $order_data['status'], "zstatus_value" => $order_data['status_value'],
                    "ztotal_price" => $order_data['total_price'], "zpayment_method" => $payment_method
                ));

                // get the last order number  id and number 
                $stmt = $connect->prepare("SELECT * FROM orders ORDER BY id DESC LIMIT 1");
                $stmt->execute();
                $order_data = $stmt->fetch();
                $order_id = $order_data['id'];
                $order_number = $order_data['order_number'];
                $_SESSION['order_number'] = $order_number;
                foreach ($allitems as $item) {
                    $product_id = $item['product_id'];
                    $quantity  = $item['quantity'];
                    $price  = $item['price'];
                    $farm_service  = $item['farm_service'];
                    $as_present  = $item['gift_id'];
                    $more_details = $item['vartion_name'];
                    $total_price = $item['total_price'];
                    // Insert Order Details
                    $stmt = $connect->prepare("INSERT INTO order_details (order_id, order_number,product_id,
                    qty, product_price, total,farm_service, as_present,more_details)
                    VALUES (:zorder_id, :zorder_number,:zproduct_id,
                    :zqty, :zproduct_price, :ztotal,:zfarm_service, :zas_present,:zmore_details)
                    ");
                    $stmt->execute(array(
                        "zorder_id" => $order_id,
                        "zorder_number" => $order_number,
                        "zproduct_id" => $product_id,
                        "zqty" => $quantity,
                        "zproduct_price" => $price,
                        "ztotal" => $total_price,
                        "zfarm_service" => $farm_service,
                        "zas_present" => $as_present,
                        "zmore_details" => $more_details,
                    ));
                    // insert order steps 
                    // get the  date
                    date_default_timezone_set('Asia/Riyadh'); // تحديد المنطقة الزمنية
                    $date = date('d/m/Y h:i a'); // تنسيق التاريخ والوقت
                    // Add Order Steps 
                    $stmt = $connect->prepare("SELECT * FROM employes WHERE role_name='التواصل'");
                    $stmt->execute();
                    $emp_data = $stmt->fetch();
                    $stmt = $connect->prepare("INSERT INTO order_steps (order_id,order_number,username,date,step_name,description,step_status)
                        VALUES(:zorder_id,:zorder_number,:zusername,:zdate,:zstep_name,:zdescription,:zstep_status)
                        ");
                    $stmt->execute(array(
                        "zorder_id" => $order_id,
                        "zorder_number" => $order_number,
                        "zusername" => $emp_data['id'],
                        "zdate" => $date,
                        "zstep_name" => 'التواصل',
                        "zdescription" => ' التواصل مع العميل لبدء الطلب  ',
                        "zstep_status" => 'لم يبدا'
                    ));
                    if ($stmt) {
                        //delete session 
                        unset($_SESSION['total']);
                        unset($_SESSION['shipping_value']);
                        unset($_SESSION['farm_services']);
                        unset($_SESSION['vat_value']);
                        unset($_SESSION['last_total']);
                        unset($_SESSION['order_data']);
                        $stmt = $connect->prepare("DELETE FROM cart WHERE cookie_id = ? OR user_id = ?");
                        $stmt->execute(array($order_data['cookie_id'], $user_id));
                        header("Location:../profile/orders/compelete");
                    }
                }
        ?>
                <div class='alert alert-success'> تم الدفع وتسجيل الطلب الخاص بك بنجاح </div>
            <?php
            } else {
            ?>
                <div class='alert alert-danger'> حدث خطا !! من فضلك اعد المحااولة مرة اخري </div>
        <?php
                // header("refresh:2;URL=../profile");
            }
        } ?>
    </div>
</div>