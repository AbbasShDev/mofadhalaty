<?php
session_start();

if (!isset($_SESSION['user_name'])){
    header('location:index.php');
    die();
}

require_once 'includes/config/database.php';
require_once 'includes/config/app.php';

$userName = $_SESSION['user_name'];
$userId = $_SESSION['user_id'];

$st = $mysqli->query("SELECT url_name FROM urls WHERE user_id=$userId AND url_archive=0");
$urls = $st->fetch_all(MYSQLI_ASSOC);

$st2 = $mysqli->query("SELECT url_name FROM urls WHERE user_id=$userId AND url_archive=1");
$urlsArch = $st2->fetch_all(MYSQLI_ASSOC);

$file = "exported_urls.txt";
$txt = fopen($file, "w") or die("Unable to open file!");
fwrite($txt, ">>>روابط $userName<<<\n");
fwrite($txt, "\n");
fwrite($txt, "\n");
fwrite($txt, "#الكل#\n");
fwrite($txt, "\n");
foreach ($urls as $url){
    fwrite($txt, "$url[url_name]\n");
}

fwrite($txt, "\n");
fwrite($txt, "#الأرشيف#\n");
fwrite($txt, "\n");
foreach ($urlsArch as $urlArch){
    fwrite($txt, "$urlArch[url_name]\n");
}

fwrite($txt, "\n");
fwrite($txt, "\n");
fwrite($txt, "\n");
fwrite($txt, "$config[app_name]");
fwrite($txt, "<<<");
fwrite($txt, "\n");
fwrite($txt, ">>>");
fwrite($txt, "$config[app_url]");

fclose($txt);

header('Content-Description: File Transfer');
header('Content-Disposition: attachment; filename='.basename($file));
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($file));
header("Content-Type: text/plain");

if (readfile($file)){
    $txt = fopen($file, "w");
    fwrite($txt, "");
    fclose($txt);
}


