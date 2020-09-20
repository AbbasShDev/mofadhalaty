<?php
session_start();

if (!isset($_SESSION['user_name'])){
    header('location:index.php');
    die();
}

require_once 'includes/config/database.php';

if (isset($_POST['addSection'])){

        $dbUserId       = $_SESSION['user_id'];

        $findSection = $mysqli->prepare("SELECT * FROM sections WHERE user_id=$dbUserId AND section_name=?");
        $findSection->bind_param('s', $dbFindName);
        $dbFindName  = $_POST['addSection'];
        $findSection->execute();
        $result = $findSection ->get_result();



        if ($result->num_rows > 0){

            echo '<div class="alert alert-danger alert-ajax">
                <p class="m-0">'.'اسم القائمة مكرر'.'</p>
              </div>';

        }else{

            $stat = $mysqli->prepare("INSERT INTO sections (user_id, section_name) VALUES($dbUserId, ?)");
            $stat->bind_param('s', $dbSectionName);
            $dbSectionName  = $_POST['addSection'];
            $stat->execute();

            $dbSectionId = $mysqli->insert_id;

            $stat       = $mysqli->query("SELECT * FROM sections WHERE section_id=$dbSectionId");
            $newSection = $stat->fetch_assoc();



        $output = '';
        $output .= '<li class="pr-3 pr-lg-0" data-sectionId="';
        $output .= $newSection['section_id'];
        $output .= '">';
        $output .= '<a class="nav-link text-left my-3" href="#">';
        $output .= '<i class="fas fa-th-list fa-fw pr-1"></i>';
        $output .= $newSection['section_name'];
        $output .= '</a></li>';

        echo $output;
        }






}