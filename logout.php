<?php
session_start();

if (isset($_SESSION['user_name'])){
    $_SESSION = [];
    $_SESSION['notify_message'] = 'تم تسجيل خروجك، نراك قريباً';
    header('location:index.php');
    die();

}