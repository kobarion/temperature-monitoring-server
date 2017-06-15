<?php

include "config/config.php";

$temp = $_POST['field1'];
$tempMin = $_POST['field2'];
$tempMax = $_POST['field3'];

$sql = "INSERT INTO dados (sensor, temp, tempMin, tempMax) VALUES ('sensor1', '$temp', '$tempMin', '$tempMax')";

if ($connect->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $connect->error;
}

$connect->close();
?>