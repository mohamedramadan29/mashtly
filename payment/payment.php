<?php
ob_start();
session_start();
$pagetitle = '  حسابي  ';

if (isset($_SESSION['username'])) {
    // Get the user's details (you can fetch these from your database)
    $name = "Mohamed";
    $email = "MR31@gmail.com";
    $phone = "010000000";

    // Define the products to be purchased
    $products = [
        [
            "name" => "Product 1",
            "description" => "Description of Product 1",
            "unit_price" => 50, // Price per unit
            "quantity" => 2,    // Quantity of Product 1
        ],
        [
            "name" => "Product 2",
            "description" => "Description of Product 2",
            "unit_price" => 30, // Price per unit
            "quantity" => 1,    // Quantity of Product 2
        ],
        // Add more products as needed
    ];

    require_once('vendor/autoload.php');
    $client = new \GuzzleHttp\Client();
    $response = $client->request('POST', 'https://api.tap.company/v2/charges', [
        'json' => [
            "amount" => 100, // Total amount to charge (in SAR)
            "currency" => "SAR",
            "threeDSecure" => false,
            "save_card" => true,
            "description" => "Purchase of Products", // Description of the purchase
            "receipt" => [
                "email" => true,
                "sms" => true
            ],
            "products" => $products, // Include the product information here
            "customer" => [
                "first_name" => $name,
                "email" => $email,
                "phone" => [
                    "number" => $phone
                ]
            ],
            "source" => [
                "id" => "src_all"
            ],
            "post" => [
                "url" => "http://localhost/mashtly/payment/payment"
            ],
            "redirect" => [
                "url" => "http://localhost/mashtly/payment/payment/callback"
            ],
            "metadata" => [ 
                
                "udf1" => "Metadata 1"
            ]
        ],
        'headers' => [
            'Authorization' => 'Bearer',
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ],
    ]);

    $output = $response->getBody();
    $output = json_decode($output);
    header("location:" . $output->transaction->url);
} else {
    header('Location:index');
}
