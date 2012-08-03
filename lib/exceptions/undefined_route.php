<?php

/**
 * @class UndefinedRouteException lib/exceptions/undefined_route.php
 *
 * Extends base exception to provide custom handling
 *
 * @author KC Reaney
 */
class UndefinedRouteException extends Exception 
{

    /**
     * Constructor
     *
     * @param string message Message to display to user
     *
     * @param int exception code
     *
     */
    public function __construct($message = 'Route not found', $code = 0) {

        parent::__construct($message, $code);

    }
}

