<?php

if (!isset($_GET["action"])) {
  echo "error\nQuery error\nInvalid query";
  exit();
}

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$correctLogin = "admin";
$correctPass = md5("123");

if ($_GET["action"] == "login") {
  $login = $_POST["login"];
  $pass = $_POST["password"];

  if ($login === $correctLogin && md5($pass) === $correctPass) {
    $_SESSION["admin"] = "true";
    echo "result\ntrue";
  } else
    echo "error\nLogin error\nInvalid username or password";
} else if ($_GET["action"] == "logout") {
  session_unset();
  echo isset($_SESSION["admin"]) ? "error\nUnrecognized error\nUnable to logout" : "result\ntrue";
}