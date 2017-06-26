<?php
header("Content-type: text/json");

include "config/config.php";

$sql = "SELECT id, sensor, temp, date FROM dados";
$result = mysqli_query($connect,$sql);

while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
    $id = $row["id"];
    $sensor =$row["sensor"];
    $temp = $row["temp"];
    $date = $row["date"];
}
       

$x = time()*1000;
$y = floatval($temp);

$z = array($x, $y);

echo json_encode($z);

?>
