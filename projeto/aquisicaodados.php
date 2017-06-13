<?php
header("Content-type: text/json");
include "config/config.php";

session_start();

if($_SESSION['acesso'] != "true"){
    header('location:index.html');
}

$query = sprintf("SELECT id, sensor, temp, date FROM dados");

$result = $connect->query($query);

$data = array();
foreach ($result as $row) {
	$data[] = $row;
}

$result->close();

$connect->close();

print json_encode($data);
?>