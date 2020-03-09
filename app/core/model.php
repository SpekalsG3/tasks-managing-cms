<?php

class Model {
  public function __construct() {
    if (session_status() === PHP_SESSION_NONE)
      session_start();

    if (isset($_SESSION["admin"]))
      $this->admin = true;
  }

  public function get_data() {}

  protected $admin = false;
}