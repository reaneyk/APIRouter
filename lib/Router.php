<?php

require_once './lib/APIFactory.php';
require_once './lib/Exceptions.php';

class Router
{

    var $uri = NULL;

    var $script_name = NULL;

    var $parsed_path = NULL;

    public function __construct($uri, $script_name) {
        $this->uri = $uri;
        $this->script_name = $script_name;

        $this->parsePath();
    }

    public function route(){
        try {
    
            $obj = APIFactory::init($this->parsed_path[0]);
            echo $this->getAction($obj, $this->parsed_path);
      
        } catch(UndefinedActionException $e) { 
            echo $e->getMessage();
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }

    private function parsePath(){
        $parsed = array();
        $request_path = strtok($this->uri, '?');
        $base_path_len = strlen(rtrim(dirname($this->script_name), '\/'));
        // Unescape and strip $base_path prefix, leaving q without a leading slash.
        $path = substr(urldecode($request_path), $base_path_len + 1);
        $parsed = filter_var_array(explode('/', trim($path, '/')), FILTER_SANITIZE_STRING);
        $this->parsed_path = $parsed; 
    }

    private function getAction($obj, $p) {
        if (count($p) < 2) {
            throw new UndefinedActionException('Action Missing');
        } else if (!is_callable(array($obj, $p[1]))) {
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

    private function handelMissingAction() {
        header("HTTP/1.0 500 Server Error");
        return '500 Error';
    }
}
