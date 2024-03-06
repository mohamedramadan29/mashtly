<?php
include "admin/connect.php";
$cookie_id = isset($_GET['cookie_id']) ? $_GET['cookie_id'] : '';
// Include database connection code if needed
// require_once 'db_connection.php';
 
// Assume $connect is your database connection object

// Prepare and execute the query to get the count of carts
$stmt = $connect->prepare("SELECT COUNT(*) FROM cart WHERE cookie_id = ?");
$stmt->execute(array($cookie_id));
$count_carts = $stmt->fetchColumn();

// Return the count of carts as a response

if($count_carts > 0){
    echo $count_carts;
}
?>
