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

            echo 1;

        }else{

            $stat = $mysqli->prepare("INSERT INTO sections (user_id, section_name) VALUES($dbUserId, ?)");
            $stat->bind_param('s', $dbSectionName);
            $dbSectionName  = $_POST['addSection'];
            $stat->execute();

            $dbSectionId = $mysqli->insert_id;

            $stat       = $mysqli->query("SELECT * FROM sections WHERE section_id=$dbSectionId");
            $newSection = $stat->fetch_assoc();



        $output = '';
        $output .= '<li class="sections pr-3 pr-lg-0" data-sectionId="';
        $output .= $newSection['section_id'];
        $output .= '" data-sectionname="';
        $output .= $newSection['section_name'];
        $output .= '">';
        $output .= '<a class="nav-link text-left my-3" href="section.php?section_id="';
        $output .= $newSection['section_id'];
        $output .= '">';
        $output .= '<i class="fas fa-th-list fa-fw pr-1"></i>';
        $output .= $newSection['section_name'];
        $output .= '<form action="app.php" class="float-right" method="post">';
        $output .= '<input type="hidden" name="sectionId" value="';
        $output .= $newSection['section_id'];
        $output .= '">';
        $output .= '<button type="submit" name="delete-section" onclick="return confirm(';
        $output .= "'هل تريد حذف القائمة؟'";
        $output .= ')">';
        $output .= '<i class="fas fa-times"></i></button></form></a></li>';

        echo $output;
        }






}