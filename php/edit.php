<?php

$response = [];

if (isset($_GET["action"])) {
  if (session_status() === PHP_SESSION_NONE)
    session_start();

  include_once "dbconn.php";

  function checkParameters() {
    if (!(isset($_GET["author"]) && isset($_GET["email"]) && isset($_GET["task"]) && isset($_GET["done"])))
      error("Form Error", "Invalid query");

    if ($_GET["author"] == "")
      error("Form Error", "author must be specified");
    else if (!filter_var($_GET["email"], FILTER_VALIDATE_EMAIL))
      error("Form Error", "Email must be valid");
    else if ($_GET["task"] == "")
      error("Form error", "Task must be specified");
    else if (!($_GET["done"] == "true" || $_GET["done"] == "false"))
      error("Form error", "Status must be specified correctly");
  }

  if ($_GET["action"] == "add") {

    checkParameters();

    $stmt = $conn->prepare("INSERT into tasks (author, email, task, done) values(:author, :email, :task, :done)");

    try {
      $stmt->execute([
        "author" => htmlspecialchars($_GET["author"], ENT_QUOTES, 'UTF-8'),
        "email" => htmlspecialchars($_GET["email"], ENT_QUOTES, 'UTF-8'),
        "task" => htmlspecialchars($_GET["task"], ENT_QUOTES, 'UTF-8'),
        "done" => ($_GET["done"] === "true" ? true : false)
      ]);

      $response = ["result", "true"];
    } catch (PDOException $e) {
      error("SQL Error", "Insertion failed: " . $e->getMessage());
    }

  } else {

    if (isset($_SESSION["admin"])) {
      if ($_GET["action"] == "edit" && isset($_GET["query"])) {
        if (isset($_GET["taskedited"]))
          $stmt = $conn->prepare("UPDATE tasks set author = :author, email = :email, task = :task, done = :done, edited = true where id = :id");
        else
          $stmt = $conn->prepare("UPDATE tasks set author = :author, email = :email, task = :task, done = :done where id = :id");

        try {
          $stmt->execute([
            "author" => htmlspecialchars($_GET["author"], ENT_QUOTES, 'UTF-8'),
            "email" => htmlspecialchars($_GET["email"], ENT_QUOTES, 'UTF-8'),
            "task" => htmlspecialchars($_GET["task"], ENT_QUOTES, 'UTF-8'),
            "done" => ($_GET["done"] === "true" ? true : false),
            "id" => $_GET["query"]
          ]);

          $response = ["result", "true"];
        } catch (PDOException $e) {
          error("SQL Error", "Insertion failed: " . $e->getMessage());
        }

      } else if ($_GET["action"] == "delete" && isset($_GET["query"])) {
        $stmt = $conn->prepare("DELETE from tasks where id = :id");

        $stmt->execute(["id" => $_GET["query"]]);

        if ($stmt->rowCount() == 1)
          $response = ["result", "true"];
        else
          error("Deleting failed", "No rows were affected");
      } else
        error("Query error", "Invalid query");

    } else
      $response = ["redirect", "login"];
  }
} else
  $response = ["error", "Query error", "Invalid query"];

echo json_encode($response);