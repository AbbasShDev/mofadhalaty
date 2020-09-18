<?php
session_start();

if (!isset($_SESSION['user_name'])){
    header('location:index.php');
    die();
}

require_once 'includes/config/database.php';

$userId = $_SESSION['user_id'];

include __DIR__.'/includes/libraries/vendor/autoload.php';

if (isset($_POST['data'])){
    $data = json_decode($_POST['data'], true);

    $favStatus  =  $data['favStatus'];
    $urlId      = $data['urlId'];

    if ($favStatus == 0){
        $query = "UPDATE urls SET url_favourite=1 WHERE url_id=$urlId AND user_id=$userId";
        if ($mysqli->query($query)){
            echo 1;
        }
    }else{
        $query = "UPDATE urls SET url_favourite=0 WHERE url_id=$urlId AND user_id=$userId";
        if ($mysqli->query($query)){
            echo 0;
        }
    }

}
