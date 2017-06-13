<?php

include "config/config.php";

$temp = $_POST['field1'];

$sql = "INSERT INTO dados (sensor, temp) VALUES ('sensor1', '$temp')";

if ($connect->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $connect->error;
}

$connect->close();
?>