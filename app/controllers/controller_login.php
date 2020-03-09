<?php

class controller_login extends Controller {
  public function __construct() {
    $this->model = new model_login();
    $this->view = new View();
  }

  public function action_index() {
    $data = $this->model->get_data();
    $this->view->generate("view_login.php", $data);
  }
}