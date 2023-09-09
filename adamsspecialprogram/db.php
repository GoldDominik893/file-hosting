<?php
$hostname = "";
$username = "";
$password = "";
$database = "";

$mysqli = new mysqli($hostname, $username, $password, $database);

if ($mysqli->connect_error) {
  die("Connection failed: " . $mysqli->connect_error);
}
?>
