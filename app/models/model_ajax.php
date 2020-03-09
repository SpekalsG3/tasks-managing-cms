<?php

require_once "app/core/database.php";

class model_ajax extends Database {
  public function __construct() {
    parent::__construct();
    $this->adminPass = md5($this->adminPass);
  }

  public function get_data() {
    $this->connect_db();

    if (isset($_GET["action"])) {

      if ($_GET["action"] == "add") {

        if (isset($_GET["author"]) && isset($_GET["email"]) && isset($_GET["task"]) && isset($_GET["done"])) {
          $this->error("Form Error", "Invalid query");

          if ($_GET["author"] == "")
            $this->error("Form Error", "author must be specified");
          else if (!filter_var($_GET["email"], FILTER_VALIDATE_EMAIL))
            $this->error("Form Error", "Email must be valid");
          else if ($_GET["task"] == "")
            $this->error("Form error", "Task must be specified");
          else if (!($_GET["done"] == "true" || $_GET["done"] == "false"))
            $this->error("Form error", "Status must be specified correctly");
          else
            $this->add_task();
        } else
          $this->error("Query error", "Invalid query");

      } else if ($_GET["action"] == "edit") {

        if (isset($_GET["query"]))
          $this->edit_task();
        else
          $this->error("Query error", "Invalid query");

      } else if ($_GET["action"] == "delete") {

        if (isset($_GET["query"]))
          $this->delete_task();
        else
          $this->error("Query error", "Invalid query");

      } else if ($_GET["action"] == "login") {

        if (isset($_POST["login"]) && isset($_POST["password"]))
          $this->login();
        else
          $this->error("Query error", "Invalid query");

      } else if ($_GET["action"] == "logout")
        $this->logout();
      else
        $this->error("Query error", "Invalid query");

    } else
      $this->error("Query error", "Invalid query");

    return json_encode($this->response);
  }

  public function login() {
    $login = $_POST["login"];
    $pass = $_POST["password"];

    if ($login === $this->adminLogin && md5($pass) === $this->adminPass) {
      $_SESSION["admin"] = "true";
      $this->admin = true;
      $this->response = ["result", "true"];
    } else
      $this->error("Login error", "Invalid username or password");
  }

  public function logout() {
    session_unset();
    if (isset($_SESSION["admin"]))
      $this->error("Unrecognized error", "Unable to logout");
    else {
      $this->admin = false;
      $this->response = ["result", "true"];
    }
  }

  public function add_task() {
    $stmt = $this->conn->prepare("INSERT into tasks (author, email, task, done, edited) values(:author, :email, :task, :done, false)");

    try {
      $stmt->execute([
        "author" => htmlspecialchars($_GET["author"], ENT_QUOTES, 'UTF-8'),
        "email" => htmlspecialchars($_GET["email"], ENT_QUOTES, 'UTF-8'),
        "task" => htmlspecialchars($_GET["task"], ENT_QUOTES, 'UTF-8'),
        "done" => ($_GET["done"] === "true" ? 1 : 0)
      ]);

      $this->response = ["result", "true"];
    } catch (PDOException $e) {
      $this->error("SQL Error", "Insertion failed: " . $e->getMessage());
    }
  }

  public function edit_task() {
    if (!$this->admin) {
      $this->response = ["redirect", "login"];
      return;
    }

    if (isset($_GET["taskedited"]))
      $stmt = $this->conn->prepare("UPDATE tasks set author = :author, email = :email, task = :task, done = :done, edited = true where id = :id");
    else
      $stmt = $this->conn->prepare("UPDATE tasks set author = :author, email = :email, task = :task, done = :done where id = :id");

    try {
      $stmt->execute([
        "author" => htmlspecialchars($_GET["author"], ENT_QUOTES, 'UTF-8'),
        "email" => htmlspecialchars($_GET["email"], ENT_QUOTES, 'UTF-8'),
        "task" => htmlspecialchars($_GET["task"], ENT_QUOTES, 'UTF-8'),
        "done" => ($_GET["done"] === "true" ? true : false),
        "id" => $_GET["query"]
      ]);

      $this->response = ["result", "true"];
    } catch (PDOException $e) {
      $this->error("SQL Error", "Insertion failed: " . $e->getMessage());
    }
  }

  public function delete_task() {
    if (!$this->admin) {
      $this->response = ["redirect", "login"];
      return;
    }

    $stmt = $this->conn->prepare("DELETE from tasks where id = :id");
    $stmt->execute(["id" => $_GET["query"]]);

    if ($stmt->rowCount() == 1)
      $this->response = ["result", "true"];
    else
      $this->error("Deleting failed", "No rows were affected");
  }

  private $adminLogin = "admin";
  private $adminPass = "123";
}