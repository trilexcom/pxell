<?php // $Revision: 1.2 $
/* vim: set expandtab ts=4 sw=4 sts=4: */
/**
 * $Id: error_handler.php,v 1.2 2005/04/21 02:15:28 madbear Exp $
 *
 * Copyright (c) 2003 by the NetOffice developers
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 */

/**
 * Error Handling Function
 *
 * use: trigger_error(string $message, int $error_type);
 *      with $error_type being one of the following:
 *          E_USER_NOTICE
 *          E_USER_WARNING
 *          E_USER_ERROR
 *
 * @see http://us3.php.net/manual/en/ref.errorfunc.php#e-user-error
 * @see http://us3.php.net/manual/en/function.trigger-error.php
 * 
 * @internal 
 * @access private
 */
function __customErrorHandler($errNo, $errStr, $errFile, $errLine)
{
    // error reporting is silenced
    if (error_reporting() == 0) {
        return;
    }
    
    // ignoring E_NOTICE, due to lazy coding in <= 2.x
    if ($errNo == E_NOTICE) {
        return;
    }
    
    // ignore E_STRICT warnings (PHP5 only)
    if (defined('E_STRICT') && $errNo == E_STRICT) {
        return;
    }

    // what type of error was caught
    switch ($errNo) {
        case E_USER_NOTICE:
            $errMsg = 'PHP Notice [' . APP_NAME . ']:';
            break;
        case E_USER_WARNING:
            $errMsg = 'PHP Warning [' . APP_NAME . ']:';
            break;
        case E_USER_ERROR:
            $errMsg = 'PHP Error [' . APP_NAME . ']:';
            break;
        case E_NOTICE:
            $errMsg = 'PHP Notice [PHP]:';
            break;
        case E_WARNING:
            $errMsg = 'PHP Warning [PHP]:';
            break;
        default:
            $errMsg = 'Unknown PHP Condition [' . $errNo . ']:';
    }

    // message is displayed in browser
    printf("<li><b>%s:</b> <font color='red'>%s</font> in file <font color='red'>%s</font> line <font color='red'>%s</font></li>\n",
    $errMsg, $errStr, $errFile, $errLine);
    
    // message is sent to system logger
    #error_log("$body $errStr in file $errFile line $errLine");
}

// set the default PHP error handler to our own custom function
set_error_handler('__customErrorHandler');

?>