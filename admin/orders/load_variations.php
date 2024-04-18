<?php
include "../connect.php";
$product_id = $_POST['product_id'];
$stmt = $connect->prepare("SELECT * FROM product_details2 WHERE product_id = ?");
$stmt->execute(array($product_id));
$all_attributes = $stmt->fetchAll();
$count_attribute = $stmt->rowCount();
if($count_attribute > 0){
    foreach($all_attributes as $attribute){
        ?>
        <option data-price="<?php echo $attribute['price']; ?>" value="<?php echo $attribute['id'] ?>"> <?php echo $attribute['vartions_name'] ?> </option>
        <?php 
    }
}else{
    ?>
    <option value=""> لا يوجد  </option>
    <?php 
}


?>