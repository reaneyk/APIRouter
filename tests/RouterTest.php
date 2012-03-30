<?php

require_once './lib/Router.php';

class RouterTest extends PHPUnit_Framework_TestCase 
{

    public function testGoodRoute() {
        $uri = '/dev/kcreaney/mgcapi/test/test';
        $path = '/dev/kcreaney/mgcapi/index.php';

        ob_start();
        $router = new Router($uri, $path);
        $router->route();

        $response = ob_get_clean();

        $this->assertEquals('test', $response);
    }

    public function testActionNotFound() {        
        $uri = '/dev/kcreaney/mgcapi/test/notfound';
        $path = '/dev/kcreaney/mgcapi/index.php';

        ob_start();
        $router = new Router($uri, $path);
        $router->route();
        $response = ob_get_clean();
        $this->assertEquals('Action Undefined', $response);
    }

    public function testMissingAction() { 
        $uri = '/dev/kcreaney/mgcapi/test/';
        $path = '/dev/kcreaney/mgcapi/index.php';

        ob_start();
        $router = new Router($uri, $path);
        $router->route();
        $response = ob_get_clean();
        $this->assertEquals('Action Missing', $response);
    }

    public function testManyActionParams() {
        $uri = '/dev/kcreaney/mgcapi/test/test/param1/param2/param3/param4/param5/param6';
        $path = '/dev/kcreaney/mgcapi/index.php';

        ob_start(); 
        $router = new Router($uri, $path);
        $router->route();
        $response = ob_get_clean();
        $this->assertEquals('test', $response); 
    }
}
