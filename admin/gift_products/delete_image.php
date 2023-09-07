<?php 
$gallar_id = $_GET['image_gallary'];
$pro_id = $_GET['pro_id'];
$stmt = $connect->prepare("DELETE from products_gallary WHERE id = ?");
$stmt->execute(array($gallar_id));
if($stmt){
    echo "good";
}else{
    echo "bad";
}
 header('Location:main.php?dir=products&page=edit&pro_id='.$pro_id);
