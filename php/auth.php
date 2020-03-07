<?php

$response = [];

if (isset($_GET["action"])) {
  if (session_status() === PHP_SESSION_NONE)
    session_start();

  $correctLogin = "admin";
  $correctPass = md5("123");

  if ($_GET["action"] == "login") {
    $login = $_POST["login"];
    $pass = $_POST["password"];

    if ($login === $correctLogin && md5($pass) === $correctPass) {
      $_SESSION["admin"] = "true";
      $response = ["result", "true"];
    } else
      $response = ["error", "Login error", "Invalid username or password"];
  } else if ($_GET["action"] == "logout") {
    session_unset();
    $response = isset($_SESSION["admin"]) ? ["error", "Unrecognized error", "Unable to logout"] : ["result", "true"];
  }
} else
  $response = ["error", "Query error", "Invalid query"];

echo json_encode($response);