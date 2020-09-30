<?php
session_start();
require_once 'includes/config/app.php';
if (isset($_SESSION['admin']['name'])) {
    $_SESSION['admin'] = [];
    $_SESSION['error_message'] = 'تم تسجيل خروجك من لوحة التحكم';
    header("location:$config[app_url]app.php");
    die();

}