<?php

class controller_index extends Controller {
  public function __construct() {
    $this->model = new model_index();
    $this->view = new View();
  }

  public function action_index() {
    $data = $this->model->get_data();
    $this->view->generate("view_index.php", $data);
  }
}