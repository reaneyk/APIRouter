<?php

class UndefinedRouteException extends Exception 
{
    public function __construct($message = 'Route not found', $code = 0) {
        parent::__construct($message, $code);
    }

    /*public function errorMessage() {
        return 'Action is undefined';
    }*/
}

