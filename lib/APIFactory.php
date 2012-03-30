<?php
class APIFactory
{
    function init($className) {

        $className = ucfirst($className);
        $classPath = './classes/' . $className . '.php';

        try {

            if (!file_exists($classPath)) {
                throw new Exception("Not Found");
            }

            include_once $classPath;
            return new $className;

        } catch(Exception $e) {

            echo $e->getMessage();
            return False;

    }
  }
}
?>
