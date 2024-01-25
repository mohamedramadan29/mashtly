<?php
include '../../admin/connect.php';

$stmt = $connect->prepare("SELECT * FROM eg_city");
$stmt->execute();
$allsaucountry = $stmt->fetchAll();

foreach ($allsaucountry as $city) {
?>
    <option value="<?php echo $city['name']; ?>"> <?php echo $city['name']; ?> </option>
<?php
}
