<?php
include 'database.php';

$pdo = Database::connect();
if($_GET['id'])
	$sql= "SELECT * FROM rooms WHERE room_id=".$_GET['id'];
else
	$sql = "SELECT * FROM rooms";

$arr = array();
foreach ($pdo->query($sql) as $row){
	array_push($arr, '{"rooms":[{"room_id":"'.$row['room_id'].'", "room_number":"'.$row['room_number'].'", "beds":"'.$row['beds'].'", "roomType":"'.$row['roomType'].'", "floor":"'.$row['floor'].'"}]}');
}
Database::disconnect();
//print_r($arr);
echo json_encode($arr, JSON_UNESCAPED_SLASHES);
?>