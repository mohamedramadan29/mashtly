<?php
ob_start();
session_start();
$page_title = 'مشتلي - الرئيسية';
include 'init.php';

include $tem . 'footer.php';

ob_end_flush();
?>