<?php
require_once 'database.php';

$settings = $mysqli->query('SELECT * FROM settings')->fetch_assoc();



$config = [

    'app_name' => $settings['app_name'],
    'app_url' => $settings['app_url'],
    'admin_email' => $settings['admin_email'],
    'root_dir'      => $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.$settings['app_main_dir'],

];