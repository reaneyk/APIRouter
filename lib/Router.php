<?php
require_once './APIFactory.php';

class Router
{
  function __construct(){
  
  }

  function route($route){
    try {
      $p = $this->parseUrl($route);
      $obj = APIFactory::init($parsed);
      switch(count($url_components)) { 
      case 0: $obj->{$p[1]}(); break;
      case 1: $obj->{$p[1]}($p[2]); break;
      case 2: $obj->{$p[1]}($p[2], $p[3]); break;
      case 3: $obj->{$p[1]}($p[2], $p[3], $p[4]); break;
      case 4: $obj->{$p[1]}($p[2], $p[3], $p[4], $p[5]); break;
      case 5: $obj->{$p[1]}($p[2], $p[3], $p[4], $p[5], $p[6]); break;
      default: call_user_func_array(array($obj, $p[1]), array_splice($p, -2));  break;
    } catch {
      //@todo a nice graceful fail message
    }
  }

  function parseUrl($url){
    $parsed = array();
    if($url){
      $request_path = strtok($_SERVER['REQUEST_URI'], '?');
      $base_path_len = strlen(rtrim(dirname($_SERVER['SCRIPT_NAME']), '\/'));
      // Unescape and strip $base_path prefix, leaving q without a leading slash.
      $path = substr(urldecode($request_path), $base_path_len + 1);
      $parsed = filter_var_array(explode('/', trim($path, '/')), FILTER_SANITIZE_STRING);
    }
    return $parsed;
  }
}
