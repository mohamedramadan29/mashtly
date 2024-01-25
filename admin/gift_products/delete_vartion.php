<?php 
// START Delete Vartion
if (isset($_POST['vartion_id'])) {
    $vartion_id = $_POST['vartion_id'];
    $stmt = $connect->prepare("DELETE FROM product_details2 WHERE id = ?");
    $stmt->execute(array($vartion_id));
}
?>