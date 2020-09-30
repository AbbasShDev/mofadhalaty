<?php

$connection = [
    'dbHost' => 'localhost',
    'dbUsername' => 'root',
    'dbPassword' => '',
    'dbName' => 'mofadhalaty'
];

$mysqli = new mysqli(

    $connection['dbHost'],
    $connection['dbUsername'],
    $connection['dbPassword'],
    $connection['dbName']

);

if ($mysqli->connect_error){
    die('Connection fail to mysql '.$mysqli->connect_error);
}