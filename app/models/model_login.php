<?php

require_once "app/core/database.php";

class model_login extends Database {
  public function get_data() {
    if ($this->admin) {
      $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
      header('Location:'.$host);
    }

    if (isset($_GET["popup"]) && $_GET["popup"] == "error" && isset($_GET["title"]) && isset($_GET["msg"]))
      return ["content_style" => $this->content_style, "title" => "Login", "error" => [$_GET["title"], $_GET["msg"]]];
    else
      return ["content_style" => $this->content_style, "title" => "Login"];
  }

  public $content_style = "login.css";
}