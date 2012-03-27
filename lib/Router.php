<?php
require_once './lib/APIFactory.php';
include_once './lib/Exceptions.php';

class Router
{

  public function route(){
    try {
      $p = $this->parsePath();
      $obj = APIFactory::init($p[0]);

      if($obj && count($p) > 1){
        echo $this->getAction($obj, $p);
      } else {
        echo (!$obj) ? $this->handleNotFound() : $this->handleMissingAction();
      }
    } catch(UndefinedActionException $e) { 
      echo $e->getMessage();
    } catch(Exception $e) {
      echo $e->getMessage();
    }
  }

  public function parsePath(){
    $parsed = array();
    $request_path = strtok($_SERVER['REQUEST_URI'], '?');
    $base_path_len = strlen(rtrim(dirname($_SERVER['SCRIPT_NAME']), '\/'));
    // Unescape and strip $base_path prefix, leaving q without a leading slash.
    $path = substr(urldecode($request_path), $base_path_len + 1);
    $parsed = filter_var_array(explode('/', trim($path, '/')), FILTER_SANITIZE_STRING);
    return $parsed;
  }

  private function getAction($obj, $p) {
    if(!is_callable(array($obj, $p[1]))){
      throw new UndefinedActionException('Action Undefined');
    }
    switch(count($p)) {
      case 2: $obj->{$p[1]}(); break;
      case 3: $obj->{$p[1]}($p[2]); break;
      case 4: $obj->{$p[1]}($p[2], $p[3]); break;
      case 5: $obj->{$p[1]}($p[2], $p[3], $p[4]); break;
      case 6: $obj->{$p[1]}($p[2], $p[3], $p[4], $p[5]); break;
      case 7: $obj->{$p[1]}($p[2], $p[3], $p[4], $p[5], $p[6]); break;
      default: call_user_func_array(array($obj, $p[1]), array_splice($p, -2));  break;
    }
  }

  private function handleNotFound() {
    header("HTTP/1.0 404 Not Found");
    return '404 Not Found';
  }

}
