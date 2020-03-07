<?php

if (session_status() === PHP_SESSION_NONE)
  session_start();

function error($title, $msg) {
  echo json_encode(["error", $title, $msg]);
  exit();
}

$host = "localhost";
$username = "root";
$dbpass = "";
$dbname = "testingtask";

try {
  $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=UTF8", $username, $dbpass);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo '<div class="msg msg--error"><div class="msg__title">Failed to connect to database</div><div class="msg__text">'.$e->getMessage().'</div></div>';
  exit();
}