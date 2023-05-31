<?php
require __DIR__ . '/vendor/autoload.php';

use Automattic\WooCommerce\Client;

$woocommerce = new Client(
    'https://www.mshtly.com/',
    'ck_828ce4fa469b641005fc70f877ce88745c262310',
    'cs_070bb88b5b8f82c2eb5fe87488f6804fd30b8b44',
    [
        'wp_api' => true,
        'version' => 'wc/v3',
        'query_string_auth' => true // Force Basic Authentication as query string true and using under HTTPS
    ]
);
?>  
<?php /* echo json_encode($woocommerce->get('orders')); */  ?>

<?php print_r($woocommerce->get('orders/67682')); ?>