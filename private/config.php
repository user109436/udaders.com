<?php
$servername = "localhost";
$user = "root";
$password = ""; //QwertY1234567890@
$db_name = "udaders";

$conn = new mysqli($servername, $user, $password, $db_name);
if (!$conn) {
    die("Connection Failed--DATABASE");
}
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_errno);
}
