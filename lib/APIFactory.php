<?php
class APIFactory
{
    function init($classPathName) {

        //$className =  $name = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $className));
        $className = implode('', array_map("ucfirst", explode('_', $classPathName)));
        $classPath = './classes/' . $className . '/init.php';

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
