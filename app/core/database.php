<?php

class Database extends Model {
  public function error($title, $msg) {
    $this->response = ["error", $title, $msg];
  }

  public function connect_db() {
    try {
      $this->conn = new PDO("mysql:host=".$this->host.";dbname=".$this->dbname.";charset=UTF8", $this->username, $this->dbpass);
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return true;
    } catch (PDOException $e) {
      $this->error("Failed to connect to database", $e->getMessage());
      return false;
    }
  }

  private $host = "localhost";
  private $username = "recorder";
  // private $dbpass = "ae4CfvBUArbB4@u";
  // private $dbname = "spekals";
  private $dbpass = "M2ld06hm7Um6mz62";
  private $dbname = "testingtask";
  protected $response = [];
  protected $conn;
}