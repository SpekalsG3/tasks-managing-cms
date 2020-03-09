<?php

class View {
  function generate($content_view, $data = null, $template_view = "template_index.php") {
    if(is_array($data))
      extract($data);

    require_once 'app/templates/'.$template_view;
  }
}