<?php

class Route {
  public static function start() {
    $controller_name = "index";
    $action_name = "index";
    
    $routes = explode('/', parse_url(strtolower($_SERVER['REQUEST_URI']))["path"]);

    if (!empty($routes[1]))
      $controller_name = $routes[1];

    if (!empty($routes[2]))
      $action_name = $routes[2];

    $model_name = "model_".$controller_name;
    $controller_name = "controller_".$controller_name;
    $action = "action_".$action_name;

    $model_path = "app/models/".$model_name.".php";
    if(file_exists($model_path))
      include $model_path;

    $controller_path = "app/controllers/".$controller_name.".php";
    if(file_exists($controller_path))
      include $controller_path;
    else
      Route::ErrorPage404();

    $controller = new $controller_name;
    if(method_exists($controller, $action))
      $controller->$action();
    else
      Route::ErrorPage404();
  }

  public static function ErrorPage404() {
    $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
    header('HTTP/1.1 404 Not Found');
    header("Status: 404 Not Found");
    header('Location:'.$host.'404');
  }
}