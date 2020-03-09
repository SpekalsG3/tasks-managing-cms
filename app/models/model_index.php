<?php

require_once "app/core/database.php";

class model_index extends Database {
  public function get_data() {
    if ($this->connect_db())
      return ["content_style" => $this->content_style, "title" => "Main", "admin" => $this->admin, "tasks" => $this->get_tasks()];
    else
      return ["content_style" => $this->content_style, "title" => "Main", "admin" => $this->admin, "error" => $this->response];
  }

  public function get_tasks() {
    $stmt = $this->conn->prepare("SELECT * from tasks");
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  public $content_style = "index.css";
}