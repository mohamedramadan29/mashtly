<?php
ob_start();
session_start();
$page_title = ' اضافة عنوان ';
include '../init.php';
?>
<!-- END  CUSTOMER TESTMON -->
<?php
include $tem . 'footer.php';
ob_end_flush();
?>