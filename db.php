<?php
$host = getenv("MYSQLHOST");
$user = getenv("MYSQLUSER");
$pass = getenv("MYSQLPASSWORD");
$db   = getenv("MYSQLDATABASE");

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    echo "DB Error: " . $conn->connect_error;
    exit();
}
?>
