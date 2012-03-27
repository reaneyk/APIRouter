<?php

class APIFactory
{
  function init($className) {
    try {
      if(@include_once './classes/' . $className . '.php') {
        return new $className;
      } else {
        return False;
      }
    } catch(Exception $e) {
      return False;
    }
  }
}

?>
