<?php
session_start();

if (!isset($_SESSION['user_name'])){
    header('location:index.php');
    die();
}

require_once 'includes/config/database.php';

include __DIR__.'/includes/libraries/vendor/autoload.php';

if (isset($_POST['data'])){
    $data = json_decode($_POST['data'], true);

    $archiveStatus  =  $data['archiveStatus'];


    if ($archiveStatus == 0){

        $st = $mysqli->prepare("UPDATE urls SET url_archive=1 WHERE url_id=? AND user_id=?");
        $st->bind_param('ii', $urlId, $userId);

        $urlId      = $data['urlId'];
        $userId     = $_SESSION['user_id'];

        if ($st->execute()){
            echo 1;
        }

    }else{
        $st = $mysqli->prepare("UPDATE urls SET url_archive=0 WHERE url_id=? AND user_id=?");
        $st->bind_param('ii', $urlId, $userId);

        $urlId      = $data['urlId'];
        $userId = $_SESSION['user_id'];

        if ($st->execute()){
            echo 0;
        }

    }

}
