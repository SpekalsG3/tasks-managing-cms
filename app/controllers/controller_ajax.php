<?php

class controller_ajax extends Controller {
  public function __construct() {
    $this->model = new model_ajax();
  }

  public function action_index() {
    echo $this->model->get_data();
  }
}