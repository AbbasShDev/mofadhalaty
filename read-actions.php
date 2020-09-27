<?php
session_start();

if (!isset($_SESSION['user_name'])){
    header('location:index.php');
    die();
}

require_once 'includes/config/database.php';
require_once 'includes/config/app.php';

if (isset($_POST['urlId'])){

    $urlId  = mysqli_real_escape_string($mysqli, $_POST['urlId']);
    $userId = mysqli_real_escape_string($mysqli, $_SESSION['user_id']);


    $query = "DELETE FROM urls WHERE url_id='$urlId' AND user_id='$userId'";
    if ($mysqli->query($query)){

        $_SESSION['error_message'] = "تم الحذف";

    }else{
        $_SESSION['error_message'] = "حدث خطآ";
    }
}elseif (isset($_POST['data'])){

    $data = json_decode($_POST['data'], true);

    $foundSection = $mysqli->prepare('SELECT * FROM urls WHERE section_id=? AND url_id =?');
    $foundSection->bind_param('ii',$sectionId, $urlId );
    $urlId      = $data['urlid'];
    $sectionId  = $data['selected-section'];
    $foundSection->execute();
    $result = $foundSection->get_result();


    if ($result->num_rows == 0){

        $upSection = $mysqli->prepare("UPDATE urls SET section_id=? WHERE url_id =?");
        $upSection->bind_param('ii',$sectionId, $urlId );
        $urlId      = $data['urlid'];
        $sectionId  = $data['selected-section'];

        if ($upSection->execute()){
            echo "تمت الاضافة الى القائمة";
        }
    }else{
        echo "مضاف في نفس القائمة مسباقاً";

    }


}else{
    header('location:app.php');
    die();
}