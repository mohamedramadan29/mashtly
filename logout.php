<?php
session_start();
if (isset($_SESSION['user_name'])) {
    unset($_SESSION['user_name']);
}
if (isset($_SESSION['user_id'])) {
    unset($_SESSION['user_id']);
}
header("location:index");
session_destroy();
