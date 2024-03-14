<?php
/*
Created by mohamed ramadan
Email:mr319242@gmail.com
Phone:01011642731

*/
include "connect.php";
//include "config.php";
$tem  = "include/";
$css = "themes/css/";
$js  = "themes/js/";
$fonts  = "themes/fonts/";
include $tem . "header.php";
date_default_timezone_set('Asia/Riyadh');
// global functions 
function createSlug($name)
{
    $slug = strtolower($name);
    $slug = preg_replace('/[^a-z0-9\x{0621}-\x{064A}]+/iu', '-', $slug);
    $slug = trim($slug, '-');
    return $slug;
}

// Function to sanitize input
function sanitizeInput($input)
{
    // Use appropriate sanitization or validation techniques based on your requirements
    $sanitizedInput = htmlspecialchars(trim($input));
    return $sanitizedInput;
}
