<?php
// MySQL 연결 정보
$mysql_host = "localhost";
$mysql_user = "goorm";
$mysql_password = "rladbsgk2010";
$mysql_database = "loginphp";


$conn = new mysqli($mysql_host, $mysql_user, $mysql_password, $mysql_database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->select_db($mysql_database);

?>

