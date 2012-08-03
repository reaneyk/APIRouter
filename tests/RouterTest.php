<?php

require_once './lib/Router.php';

class RouterTest extends PHPUnit_Framework_TestCase 
{

    var $path = '/index.php';

    public function testGoodRoute() {

        $uri = '/test/test/';

        ob_start();

        $router = new Router($uri, $this->path);
        $router->route();

        $response = ob_get_clean();

        $this->assertEquals('test', $response);

    }

    public function testActionNotFound() {        

        $uri = '/test/notfound';

        ob_start();

        $router = new Router($uri, $this->path);
        $router->route();

        $response = ob_get_clean();

        $this->assertEquals('Action Undefined', $response);

    }

    public function testMissingAction() { 

        $uri = '/test/';

        ob_start();

        $router = new Router($uri, $this->path);
        $router->route();

        $response = ob_get_clean();

        $this->assertEquals('Action Missing', $response);

    }

    public function testManyActionParams() {

        $uri = '/test/test/param1/param2/param3/param4/param5/param6';

        ob_start();

        $router = new Router($uri, $this->path);
        $router->route();

        $response = ob_get_clean();

        $this->assertEquals('test', $response); 

    }
}
