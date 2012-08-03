<?php

/**
 * @class APIFactory lib/APIFactory.php
 * 
 * API Factory for instantiating of API objects
 *
 * @author KC Reaney
 */
class APIFactory
{

    /**
     * init
     * Initializes a new object from a class path
     *
     * @param classPathName string The path of the class to attempt to instantiate
     *
     * @return a new object from the class path name
     */
    function init($classPathName) {

        $className = implode('', array_map("ucfirst", explode('_', $classPathName)));
        $classPath = './classes/' . $className . '/init.php';

        try {

            if (!file_exists($classPath)) {
                throw new Exception("Not Found");
            }

            include_once $classPath;
            $obj = new $className;

        } catch(Exception $e) {

             echo $e->getMessage();
            $obj = false;

        }

        return $obj;

    }
}
?>
