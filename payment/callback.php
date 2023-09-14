<div class="section section-md contact_us login_page" style='background-color:#f1f1f1'>
    <div class="container">
        <?php
        ob_start();
        session_start();
        $pagetitle = '  حسابي  ';
        include '../../connect.php';
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
                        "authorization: Bearer sk_live_bhFLinpP5X2jNCc7dZM0ytqY" // مفتاح الواجهة السري
                    ),
                )
            );
            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            $responseTap = json_decode($response);

            if ($responseTap->status == 'CAPTURED') {
                $ind_id = $_SESSION['ind_id'];
                $stmt = $connect->prepare("UPDATE ind_register SET ind_payment_charge = 'CAPTURED' WHERE ind_id=?");
                $stmt->execute(array($ind_id));
                ?>
                <div class='alert alert-success'> تم الدفع والاشتراك بنجاح في منصة انتقاء </div>
                <?php
                header("refresh:2;URL=../profile");
            } else {
                ?>
                <div class='alert alert-danger'> حدث خطا !! من فضلك اعد المحااولة مرة اخري </div>

                <?php
                header("refresh:2;URL=../profile");
            }

        } ?>
    </div>
</div>