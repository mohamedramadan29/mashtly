<?php
ob_start();
$page_title = 'Home';
session_start();
include 'init.php';
$currentURL = $_SERVER['REQUEST_URI'];
if (strpos($currentURL, "address/add") !== false) {
    // Redirect to add.php
    include "address/add.php";
}
include $tem . 'footer.php';
ob_end_flush();
?>


<script>
    $(document).ready(function() {
        // مكان المغادرة 
        $('#country').change(function() {
            var country_id = $(this).val();
            if (country_id != '' && country_id == 'SAR') {
                $.ajax({
                    url: "load_city/load_saudi_cities.php",
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
                    url: "load_city/load_egypt_cities.php",
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