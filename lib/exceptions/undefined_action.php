<?php

/**
 * @class UndefinedActionException lib/exceptions/undefined_action.php
 *
 * Extends base exception to provide custom handling
 *
 * @author KC Reaney
 */
class UndefinedActionException extends Exception 
{
    
    /**
     * Constructor
     *
     * @param string message Message to display to user
     *
     * @param int exception code
     *
     */
    public function __construct($message = 'Action is undefined', $code = 0) {

        parent::__construct($message, $code);

    }
}
