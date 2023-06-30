<?php
include "../../admin/connect.php"; 
if(isset($_POST['delete_address'])){
    $address_id = $_POST['address_id'];
    $stmt = $connect->prepare("SELECT * FROM user_address WHERE id = ?");
    $stmt->execute(array($address_id));
    $count = $stmt->rowCount();
    if($count > 0){
        $stmt = $connect->prepare('DELETE FROM user_address WHERE id=?');
    $stmt->execute([$address_id]);
    if ($stmt) {
        $_SESSION['success'] = " تم حذف العنوان بنجاح  ";
        header('Location:index');
        exit(); // Terminate the script after redirecting
    }
    }else{
        header("Location:index");
    }
}
