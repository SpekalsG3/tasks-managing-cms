<?php

class controller_404 extends Controller {
  public function __construct() {
    $this->view = new View();
  }

  public function action_index() {
    $this->view->generate("view_404.php", null, "template_404.php");
  }
}