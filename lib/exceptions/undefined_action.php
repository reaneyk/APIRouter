<?php

class UndefinedActionException extends Exception 
{
    public function __construct($message = 'Action is undefined', $code = 0) {
        parent::__construct($message, $code);
    }

    /*public function errorMessage() {
        return 'Action is undefined';
    }*/
}
