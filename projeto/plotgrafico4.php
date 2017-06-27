<?php
header("Content-type: text/json");
date_default_timezone_set('America/Sao_Paulo');
            
include "config/config.php";

$date1 = $_POST['date1'];
$date2 = $_POST['date2'];


$sql = "SELECT UNIX_TIMESTAMP(date) AS date, temp FROM dados WHERE date BETWEEN '$date1' AND '$date2'";
/*
$result = mysqli_query($connect,$sql);

$data = array();
foreach ($result as $row) {
	$data[] = $row;
}


echo json_encode($data, JSON_NUMERIC_CHECK);
 
 */

$result = mysqli_query($connect,$sql);

while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
    extract($row);
    $date *= 1000;
    $data[] = [$date, $temp];    
}

//echo join($data, ',');
echo json_encode($data,JSON_NUMERIC_CHECK);