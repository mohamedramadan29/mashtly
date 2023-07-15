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

// generate token to use in rember me
function generateRememberToken()
{
    return uniqid();
}


// update token into db 

function saveRememberTokenToDatabase($connect, $user_id, $token)
{
    $stmt = $connect->prepare("UPDATE users SET remeber_token = ? WHERE id=?");
    $stmt->execute(array($token, $user_id));
}
// delete remeber token from db

function deleteRememberTokenFromDatabase($connect, $user_id)
{
    $stmt = $connect->prepare("UPDATE users SET remeber_token='' WHERE id = ?");
    $stmt->execute(array($user_id));
}

////////////////////////// Default Message ////////////////////

function alertdefaultedit()
{
?>
    <script src='themes/js/jquery.min.js'></script>
    <script>
        $(document).ready(function() {
            swal({
                position: 'center',
                icon: 'success',
                title: 'تمت التحديث بنجاح',
                buttons: false,
                timer: 2000000000000000000000000, 
            });
        });
    </script>

<?php

}


//////////////////////////////// Function Add To Cart Message ////////////////////////////  
function alertcart()
{
?>
    <script src='themes/js/jquery.min.js'></script>
    <script>
        $(document).ready(function() {
            swal({
                title: "تمت الاضافة بنجاح",
                icon: "success",
                buttons: {
                    cancel: "الاستمرار ! ",
                    catch: {
                        text: " مشاهدة السلة  ",
                        value: "catch",
                    },
                    defeat: false,
                },
            }).then((value) => {
                switch (value) {
                    case "catch":
                        window.location.href = "cart";
                        break;
                }
            });
        });
    </script>
<?php
}

//////////////////////////////// Function Add To Fav Message ////////////////////////////  
function alertfavorite()
{
?>
    <script src='themes/js/jquery.min.js'></script>
    <script>
        $(document).ready(function() {
            swal({
                title: "تمت الاضافة بنجاح",
                icon: "success",
                buttons: {
                    cancel: "الاستمرار ! ",
                    catch: {
                        text: " مشاهدة المفضلة   ",
                        value: "catch",
                    },
                    defeat: false,
                },
            }).then((value) => {
                switch (value) {
                    case "catch":
                        window.location.href = "profile/favorite/";
                        break;
                }
            });
        });
    </script>
<?php
}
