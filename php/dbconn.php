<?php

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

function error($title, $msg) {
  echo "error\n" . $title . "\n" . $msg;
  exit();
}

$host = "localhost";
$username = "root";
$dbpass = "";
$dbname = "testingtask";
$port = "3308";

try {
  $conn = new PDO("mysql:host=$host;dbname=$dbname;port=$port", $username, $dbpass);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo '<div class="msg msg--error"><div class="msg__title">SQL Error</div><div class="msg__text">Failed to connect to database</div></div>';
  exit();
}
