<?php
include '../connect.php'; 
if (isset($_POST['pro_attribute'])) {
    $stmt = $connect->prepare("SELECT * FROM product_variations WHERE attribute_id =?");
    $stmt->execute(array($_POST['pro_attribute']));
    $allvar = $stmt->fetchAll();
    foreach ($allvar as $var) {
?>
        <option value="<?php echo $var['id']; ?>"> <?php echo $var['name']; ?> </option>
<?php
    }
}
?>