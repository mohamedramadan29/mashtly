<?php
session_start();
if (isset($_SESSION['admin_id'])) {
	unset($_SESSION['admin_id']);
}
if (isset($_SESSION['emp_id'])) {
	unset($_SESSION['emp_id']);
}
if (isset($_SESSION['supp_id'])) {
	unset($_SESSION['supp_id']);
}
if (isset($_SESSION['super_id'])) {
	unset($_SESSION['super_id']);
}
header("location:index.php");
session_destroy();
