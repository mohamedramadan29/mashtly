<?php
/*
Created by mohamed ramadan
Email:mr319242@gmail.com
Phone:01011642731

*/
if (isset($_SESSION['main_user_login'])){
include '../../admin/connect.php';
$tem = "../../include/";
$css = "../../themes/css/";
$js = "../../themes/js/";
$uploads = "../../uploads/";
include $tem . "header.php";
include $tem . "navbar.php";
include '../../global_functions.php';
}else{
    header("Location:../new_login");
}
?>