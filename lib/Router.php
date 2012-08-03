<?php

require_once './lib/APIFactory.php';
require_once './lib/Exceptions.php';

/**
 * @class Router lib/Router.php
 * 
 * Routes requests to their controller class and action
 *
 * @author KC Reaney
 *
 */
class Router
{

    /**
     * @var string uri The URI for the class
     */
    var $uri = NULL;

    /**
     * @var string script_name The name of the script calling the router
     */
    var $script_name = NULL;

    /**
     * @var array parsed_path Parsed URI path
     */
    var $parsed_path = NULL;

    /**
     * Constructor function
     *
     * @param string uri The URI of the request
     *
     * @param string script_name The name & path of the script to be parsed 
     * from the path
     *
     */
    public function __construct($uri, $script_name) {

        $this->uri = $uri;
        $this->script_name = $script_name;

        $this->parsePath();

    }

    /**
     * parse and sanitise the URI path
     */
    private function parsePath() {

        $parsed = array();
        $request_path = strtok($this->uri, '?');
        $base_path_len = strlen(rtrim(dirname($this->script_name), '\/'));

        // Unescape and strip $base_path prefix, leaving q without a leading slash.
        $path = substr(urldecode($request_path), $base_path_len + 1);
        
        //make it clean
        $parsed = filter_var_array(explode('/', trim($path, '/')), FILTER_SANITIZE_STRING);

        $this->parsed_path = $parsed; 

    }

    /**
     * Route the request and display the value
     */
    public function route() {

        try {
    
            $obj = APIFactory::init($this->parsed_path[0]);
            echo $this->getAction($obj, $this->parsed_path);
      
        } catch(UndefinedActionException $e) { 

            echo $e->getMessage();

        } catch(Exception $e) {

            echo $e->getMessage();

        }
    }

    /**
     * get the action from the given object
     *
     * @param Object obj The object to execute the action
     *
     * @param Array p The parsed URI path
     * 
     */
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
}
