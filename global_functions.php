<?php
include 'admin/connect.php';
// Function to sanitize input
function sanitizeInput($input)
{
    // Use appropriate sanitization or validation techniques based on your requirements
    $sanitizedInput = htmlspecialchars(trim($input));
    return $sanitizedInput;
}

////////////////////////////////////////////
/**
 * function to checked user is exist or not in db  
 */
function checkIfExists($connect, $table, $column, $value, &$formerror, $errorMessage)
{
    $stmt = $connect->prepare("SELECT * FROM $table WHERE $column = ?");
    $stmt->execute(array($value));
    $count = $stmt->rowCount();
    if ($count > 0) {
        $formerror[] = $errorMessage;
    }
}

/**
 * fucntion to  make insert data into db  
 * 
 */
function insertData($connect, $table, $data)
{
    $fields = array_keys($data);
    $placeholders = array_map(function ($field) {
        return ":" . $field;
    }, $fields);
    $sql = "INSERT INTO $table (" . implode(", ", $fields) . ") VALUES (" . implode(", ", $placeholders) . ")";
    $stmt = $connect->prepare($sql);
    $stmt->execute($data);
    return $stmt;
}

// get all product from fav
 
    function checkIfProductIsFavourite($connect, $user_id, $product_id)
    {
        $stmt = $connect->prepare("SELECT * FROM user_favourite WHERE user_id=? AND product_id=?");
        $stmt->execute(array($user_id, $product_id));
        $count = $stmt->rowCount();
        if ($count > 0) {
            return true;
        }
        return false;
    }
 

// get all product from cart 
function checkIfProductInCart($connect, $cookie_id, $product_id)
{
    $stmt = $connect->prepare("SELECT * FROM cart WHERE cookie_id=? AND product_id=?");
    $stmt->execute(array($cookie_id, $product_id));
    $count = $stmt->rowCount();
    if ($count > 0) {
        return true;
    }
    return false;
}
